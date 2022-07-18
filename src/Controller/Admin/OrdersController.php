<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Billing;
use App\Model\Entity\Order;
use App\Model\Table\BillingsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\FrozenTime;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 * @method Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AdminController
{

    public function initialize(): void
    {
        $this->loadComponent('UploadFiles', [
            'field' => 'archive',
            'pathname' => mb_strtolower($this->name),
            'prefix' => 'ORD_'
        ]);

        parent::initialize();
    }

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

        $query = $this->Orders
            ->find('search', [
                'contain' => ['Companies', 'Partners', 'Users', 'OrderStatus', 'Billings'],
                'search' => $this->request->getQueryParams(),
                'order' => $order ?? null,
                'conditions' => [
                    'Orders.company_id IN' => $this->getRelatedCompaniesIDs()
                ]
            ]);

        $orders = $this->paginate($query);

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [
                'Companies',
                'Partners',
                'Users',
                'OrderStatus',
                'Addresses',
                'Billings',
                'OrderEvolutions',
                'OrderProducts' => [
                    'Products'
                ]
            ]
        ]);

        $this->set(compact('order'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->redirect(['controller' => 'Partners', 'action' => 'index', '?' => ['shop' => true]]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            $this->UploadFiles->upload($order);
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The {0} has been saved.', __('order')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order')));
        }
        $this->set(compact('order'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id, [
            'contain' => ['Billings'],
        ]);

        try {
            $order->order_status_id = $this->Orders->OrderStatus->cancel()->id;

            if ($order->has('billing')) {
                $order->billing_id = null;
                $this->Orders->Billings->removeBilling($order->billing, $this->getAuthentication('id'));
            }

            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The {0} has been deleted.', __('order')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('order')));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('There is no cancellation status. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param string|null $id
     * @return \Cake\Http\Response|void|null
     */
    public function next(string $id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['OrderStatus'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $status = $this->Orders->OrderStatus->next($order->order_status);
                $order->order_status_id = $status->id;
                if ($this->Orders->save($order)) {
                    $this->Flash->success(__('The {0} has been saved. Sent to: {1}', __('order'), strtolower($status->name)));
                } else {
                    $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order')));
                }
            } catch (RecordNotFoundException $e) {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order')));
            }
            return $this->redirect($this->referer());
        }
    }

    /**
     * @param string|null $id
     * @return \Cake\Http\Response|void|null
     */
    public function previous(string $id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['OrderStatus'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $status = $this->Orders->OrderStatus->previous($order->order_status);
                $order->order_status_id = $status->id;
                if ($this->Orders->save($order)) {
                    $this->Flash->success(__('The {0} has been saved. Sent to: {1}', __('order'), strtolower($status->name)));
                } else {
                    $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order')));
                }
            } catch (RecordNotFoundException $e) {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order')));
            }
            return $this->redirect($this->referer());
        }
    }

    /**
     * @param string|null $id
     * @return \Cake\Http\Response|void|null
     */
    public function generateBilling(string $id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [
                'Partners'
            ],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            try {

                if ($order->total_order == 0) {
                    throw new \Exception(__('Order without products and without billing value'));
                }

                $billing = $this->getEntityBilling($order);

                $order->billing_id = $billing->id;

                if ($this->Orders->save($order)) {
                    $this->Flash->success(__('The {0} has been saved.', __('order')));
                } else {
                    $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order')));
                }
            } catch (RecordNotFoundException $e) {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order')));
            } catch (\Exception $e) {
                $this->Flash->error($e->getMessage());
            }
            return $this->redirect($this->referer());
        }
    }

    /**
     * @param Order $order
     * @return \App\Model\Entity\Billing
     */
    protected function getEntityBilling(Order $order): Billing
    {
        $billing = $this->Orders->Billings->newEmptyEntity();

        $billing->company_id = $order->company_id;
        $billing->partner_id = $order->partner_id;
        $billing->deadline = $order->delivery_date;
        $billing->description = $order->observations ?? __('Pedido realizado para: {0}, por: {1}', $order->partner->name, $this->getAuthentication('name'));
        $billing->value = $order->total_order;
        $billing->type = BillingsTable::OUTPUT;
        $billing->model = $this->name;
        $billing->foreing_key = $order->id;
        $billing->authorization_user_id = $this->getAuthentication('id');
        $billing->authorization = !$billing->authorization;
        $billing->authorization_date = new FrozenTime();

        return $this->Orders->Billings->saveOrFail($billing);
    }
}
