<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * OrderStatus Controller
 *
 * @property \App\Model\Table\OrderStatusTable $OrderStatus
 * @method \App\Model\Entity\OrderStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderStatusController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if ($this->request->getQuery('sort') === null) {
            $order = [
                'OrderStatus.lft' => 'ASC'
            ];
        }

        $query = $this->OrderStatus
            ->find('search', [
                'contain' => ['ParentOrderStatus'],
                'order' => $order ?? null,
                'search' => $this->request->getQueryParams()
            ]);

        $orderStatus = $this->paginate($query);

        $this->set(compact('orderStatus'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Status id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $orderStatus = $this->OrderStatus->get($id, [
            'contain' => ['ParentOrderStatus', 'OrderEvolutions', 'ChildOrderStatus', 'Orders'],
        ]);

        $this->set(compact('orderStatus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderStatus = $this->OrderStatus->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderStatus = $this->OrderStatus->patchEntity($orderStatus, $this->request->getData());
            if ($this->OrderStatus->save($orderStatus)) {
                $this->Flash->success(__('The {0} has been saved.', __('order status')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order status')));
        }
        $parentOrderStatus = $this->OrderStatus->ParentOrderStatus->find('list', ['limit' => 500, 'order' => ['lft']]);
        $this->set(compact('orderStatus', 'parentOrderStatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Status id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $orderStatus = $this->OrderStatus->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderStatus = $this->OrderStatus->patchEntity($orderStatus, $this->request->getData());
            if ($this->OrderStatus->save($orderStatus)) {
                $this->Flash->success(__('The {0} has been saved.', __('order status')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order status')));
        }
        $parentOrderStatus = $this->OrderStatus->ParentOrderStatus->find('list', ['limit' => 500, 'conditions' => ['ParentOrderStatus.id <>' => $id], 'order' => ['lft']]);
        $this->set(compact('orderStatus', 'parentOrderStatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Status id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderStatus = $this->OrderStatus->get($id);
        try {
            if ($this->OrderStatus->delete($orderStatus)) {
                $this->Flash->success(__('The {0} has been deleted.', __('order status')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('order status')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('order status')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
