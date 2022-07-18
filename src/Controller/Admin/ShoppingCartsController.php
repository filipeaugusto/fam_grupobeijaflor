<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\ShoppingCart;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Utility\Hash;

/**
 * ShoppingCarts Controller
 *
 * @property \App\Model\Table\ShoppingCartsTable $ShoppingCarts
 * @property \App\Model\Table\PartnersTable $Partners
 * @property \App\Model\Table\OrdersTable $Orders
 * @method \App\Model\Entity\ShoppingCart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShoppingCartsController extends AdminController
{
    /**
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Partners');
        $this->loadModel('Orders');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ShoppingCarts
            ->find('search', [
                'contain' => ['Companies', 'Partners', 'Users', 'Addresses'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
                    'user_id' => $this->getAuthentication('id')
                ]
            ]);

        $shoppingCarts = $this->paginate($query);

        $this->set(compact('shoppingCarts'));
    }

    /**
     * View method
     *
     * @param string|null $id Shopping Cart id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $shoppingCart = $this->ShoppingCarts->get($id, [
            'contain' => [
                'Companies',
                'Users',
                'Addresses',
                'Partners' => ['Categories'],
                'ShoppingCartItems' => ['Products']
            ],
            'conditions' => [
                'ShoppingCarts.company_id IN' => $this->getRelatedCompaniesIDs()
            ]
        ]);

        $this->setCompanyID($shoppingCart->company_id);

        $categories = $shoppingCart->partner->categories;

        $this->set(compact('shoppingCart',  'categories'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(?string $partnerID = null)
    {
        if (!$partnerID) {
            return $this->getRedirectPartners();
        }

        $partner = $this->Partners->get($partnerID, ['contain' => 'Categories']);

        try {

            $categories = $partner->categories;

            if (is_null($this->request->getQuery('category_id'))) {
                $categoriesIDS = Hash::extract($categories, '{n}.id');
                $query = $this->Partners->Categories->Products
                    ->find('all')
                    ->where(['category_id IN' => $categoriesIDS]);
            } else {
                $query = $this->Partners->Categories->Products
                    ->find('search', ['search' => $this->request->getQueryParams()]);
            }

            $products = $this->paginate($query);

            $shoppingCart = $this->getShoppingCart($partnerID);

            $this->set(compact('partner', 'shoppingCart', 'categories', 'products'));

        } catch (PersistenceFailedException $e) {
            $this->Flash->error(__('You must select a {0} to initiate the order.', __('company')));
            $this->redirect($this->referer());
        } catch (\Exception $e) {
            $this->Flash->error(__('{0} without registered products.', __('Supplier')));
            $this->redirect($this->referer());
        }
    }

    /**
     * @param string $partnerID
     * @param string $productID
     * @return \Cake\Http\Response|void|null
     */
    public function addItem(string $partnerID, string $productID)
    {
        $shoppingCart = $this->getShoppingCart($partnerID);

        try {
            $shoppingCartItem = $this->ShoppingCarts->ShoppingCartItems
                ->find()
                ->where([
                    'product_id' => $productID,
                    'shopping_cart_id' => $shoppingCart->id
                ])
                ->firstOrFail()
            ;
        } catch (RecordNotFoundException $e) {
            $shoppingCartItem = $this->ShoppingCarts->ShoppingCartItems->newEmptyEntity();
            $shoppingCartItem->product_id = $productID;
            $shoppingCartItem->sale_price = $this->ShoppingCarts->ShoppingCartItems->Products->get($productID)->history_price;
            $shoppingCartItem->shopping_cart_id = $shoppingCart->id;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $shoppingCartItem = $this->ShoppingCarts->ShoppingCartItems->patchEntity($shoppingCartItem, $this->request->getData());
            if ($this->ShoppingCarts->ShoppingCartItems->save($shoppingCartItem)) {
                $this->Flash->success(__('The {0} has been saved.', __('shopping cart item')));
            } else {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('shopping cart item')));
            }
            return $this->redirect($this->referer());
        }

        $this->set(compact('shoppingCart', 'shoppingCartItem', 'partnerID', 'productID'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Shopping Cart id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $shoppingCart = $this->ShoppingCarts->get($id, []);

        $this->setCompanyID($shoppingCart->company_id);

        $this->redirect(['action' => 'add', $shoppingCart->partner_id]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Shopping Cart id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shoppingCart = $this->ShoppingCarts->get($id);
        try {
            if ($this->ShoppingCarts->delete($shoppingCart)) {
                $this->Flash->success(__('The {0} has been deleted.', __('shopping cart')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('shopping cart')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('shopping cart')));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function createOrder(string $id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            $shoppingCart = $this->ShoppingCarts->get($id, [
                'contain' => [
                    'ShoppingCartItems'
                ],
            ]);

            $shoppingCart = $this->ShoppingCarts->patchEntity($shoppingCart, $this->request->getData());

            try {

                $this->ShoppingCarts->saveOrFail($shoppingCart);

                $order = $this->Orders->newEntity($shoppingCart->toArray());

                $order_products = array_map(function($item) {
                    $this->Orders->OrderProducts->Products->updateAll(['history_price' => $item->sale_price], ['id' => $item->product_id]);
                    return $item->toArray();
                }, $shoppingCart->shopping_cart_items);

                $order->order_products = $this->Orders->OrderProducts->newEntities($order_products);

                if ($this->Orders->saveOrFail($order)) {
                    $this->Flash->success(__('The {0} has been saved.', __('order')));
                    $this->ShoppingCarts->delete($shoppingCart);
                    return $this->redirect(['controller' => 'orders', 'action' => 'view', $order->id]);
//                    return $this->redirect(['controller' => 'orders', 'action' => 'index', '?' => ['id' => $order->id]]);
                }

            } catch (\Exception $e) {
                $this->Flash->error($e->getMessage());
            }

            $this->redirect($this->referer());
        }

    }

    /**
     * @param string $partnerID
     * @return ShoppingCart
     */
    public function getShoppingCart(string $partnerID): ShoppingCart
    {
        return $this->ShoppingCarts->findOrCreate([
            'company_id' => $this->getCompanyID(),
            'partner_id' => $partnerID,
            'user_id' => $this->getAuthentication('id')
        ]);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    protected function getRedirectPartners(): ?\Cake\Http\Response
    {
        return $this->redirect(['controller' => 'Partners', 'action' => 'index', '?' => ['shop' => true]]);
    }
}
