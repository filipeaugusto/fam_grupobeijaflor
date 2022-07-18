<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * OrderProducts Controller
 *
 * @property \App\Model\Table\OrderProductsTable $OrderProducts
 * @method \App\Model\Entity\OrderProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderProductsController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->OrderProducts
            ->find('search', [
                'contain' => ['Orders', 'Products'],
                'search' => $this->request->getQueryParams()
            ]);

        $orderProducts = $this->paginate($query);

        $this->set(compact('orderProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $orderProduct = $this->OrderProducts->get($id, [
            'contain' => ['Orders', 'Products'],
        ]);

        $this->set(compact('orderProduct'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderProduct = $this->OrderProducts->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderProduct = $this->OrderProducts->patchEntity($orderProduct, $this->request->getData());
            if ($this->OrderProducts->save($orderProduct)) {
                $this->Flash->success(__('The {0} has been saved.', __('order product')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order product')));
        }
        $orders = $this->OrderProducts->Orders->find('list', ['limit' => 500]);
        $products = $this->OrderProducts->Products->find('list', ['limit' => 500]);
        $this->set(compact('orderProduct', 'orders', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $orderProduct = $this->OrderProducts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderProduct = $this->OrderProducts->patchEntity($orderProduct, $this->request->getData());
            if ($this->OrderProducts->save($orderProduct)) {
                $this->Flash->success(__('The {0} has been saved.', __('order product')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order product')));
        }
        $orders = $this->OrderProducts->Orders->find('list', ['limit' => 500]);
        $products = $this->OrderProducts->Products->find('list', ['limit' => 500]);
        $this->set(compact('orderProduct', 'orders', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderProduct = $this->OrderProducts->get($id);
        try {
            if ($this->OrderProducts->delete($orderProduct)) {
                $this->Flash->success(__('The {0} has been deleted.', __('order product')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('order product')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('order product')));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Activate method
     *
     * @param string|null $id Order Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function activate(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderProduct = $this->OrderProducts->get($id);
        $orderProduct->removed = false;
        if ($this->OrderProducts->save($orderProduct)) {
            $this->Flash->success(__('The {0} has been activate.', __('order product')));
        } else {
            $this->Flash->error(__('The {0} could not be activate. Please, try again.', __('order product')));
        }

        return $this->redirect($this->referer());
    }


    /**
     * Delete method
     *
     * @param string|null $id Order Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function disable(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderProduct = $this->OrderProducts->get($id);
        $orderProduct->removed = true;
        if ($this->OrderProducts->save($orderProduct)) {
            $this->Flash->success(__('The {0} has been deleted.', __('order product')));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('order product')));
        }

        return $this->redirect($this->referer());
    }
}
