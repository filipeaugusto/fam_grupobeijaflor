<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ShoppingCartItems Controller
 *
 * @property \App\Model\Table\ShoppingCartItemsTable $ShoppingCartItems
 * @method \App\Model\Entity\ShoppingCartItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShoppingCartItemsController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ShoppingCartItems
            ->find('search', [
                'contain' => ['ShoppingCarts', 'Products'],
                'search' => $this->request->getQueryParams()
            ]);

        $shoppingCartItems = $this->paginate($query);

        $this->set(compact('shoppingCartItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Shopping Cart Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $shoppingCartItem = $this->ShoppingCartItems->get($id, [
            'contain' => ['ShoppingCarts', 'Products'],
        ]);

        $this->set(compact('shoppingCartItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shoppingCartItem = $this->ShoppingCartItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $shoppingCartItem = $this->ShoppingCartItems->patchEntity($shoppingCartItem, $this->request->getData());
            if ($this->ShoppingCartItems->save($shoppingCartItem)) {
                $this->Flash->success(__('The {0} has been saved.', __('shopping cart item')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('shopping cart item')));
        }
        $shoppingCarts = $this->ShoppingCartItems->ShoppingCarts->find('list', ['limit' => 500]);
        $products = $this->ShoppingCartItems->Products->find('list', ['limit' => 500]);
        $this->set(compact('shoppingCartItem', 'shoppingCarts', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Shopping Cart Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $shoppingCartItem = $this->ShoppingCartItems->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shoppingCartItem = $this->ShoppingCartItems->patchEntity($shoppingCartItem, $this->request->getData());
            if ($this->ShoppingCartItems->save($shoppingCartItem)) {
                $this->Flash->success(__('The {0} has been saved.', __('shopping cart item')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('shopping cart item')));
        }
        $shoppingCarts = $this->ShoppingCartItems->ShoppingCarts->find('list', ['limit' => 500]);
        $products = $this->ShoppingCartItems->Products->find('list', ['limit' => 500]);
        $this->set(compact('shoppingCartItem', 'shoppingCarts', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shopping Cart Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shoppingCartItem = $this->ShoppingCartItems->get($id);
        if ($this->ShoppingCartItems->delete($shoppingCartItem)) {
            $this->Flash->success(__('The {0} has been deleted.', __('shopping cart item')));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('shopping cart item')));
        }

        return $this->redirect($this->referer());
    }
}
