<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * OrderEvolutions Controller
 *
 * @property \App\Model\Table\OrderEvolutionsTable $OrderEvolutions
 * @method \App\Model\Entity\OrderEvolution[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderEvolutionsController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->OrderEvolutions
            ->find('search', [
                'contain' => ['Users', 'Orders', 'OrderStatus'],
                'search' => $this->request->getQueryParams()
            ]);

        $orderEvolutions = $this->paginate($query);

        $this->set(compact('orderEvolutions'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Evolution id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $orderEvolution = $this->OrderEvolutions->get($id, [
            'contain' => ['Users', 'Orders', 'OrderStatus'],
        ]);

        $this->set(compact('orderEvolution'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderEvolution = $this->OrderEvolutions->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderEvolution = $this->OrderEvolutions->patchEntity($orderEvolution, $this->request->getData());
            if ($this->OrderEvolutions->save($orderEvolution)) {
                $this->Flash->success(__('The {0} has been saved.', __('order evolution')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order evolution')));
        }
        $users = $this->OrderEvolutions->Users->find('list', ['limit' => 500]);
        $orders = $this->OrderEvolutions->Orders->find('list', ['limit' => 500]);
        $orderStatus = $this->OrderEvolutions->OrderStatus->find('list', ['limit' => 500]);
        $this->set(compact('orderEvolution', 'users', 'orders', 'orderStatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Evolution id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $orderEvolution = $this->OrderEvolutions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderEvolution = $this->OrderEvolutions->patchEntity($orderEvolution, $this->request->getData());
            if ($this->OrderEvolutions->save($orderEvolution)) {
                $this->Flash->success(__('The {0} has been saved.', __('order evolution')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('order evolution')));
        }
        $users = $this->OrderEvolutions->Users->find('list', ['limit' => 500]);
        $orders = $this->OrderEvolutions->Orders->find('list', ['limit' => 500]);
        $orderStatus = $this->OrderEvolutions->OrderStatus->find('list', ['limit' => 500]);
        $this->set(compact('orderEvolution', 'users', 'orders', 'orderStatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Evolution id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderEvolution = $this->OrderEvolutions->get($id);
        try {
            if ($this->OrderEvolutions->delete($orderEvolution)) {
                $this->Flash->success(__('The {0} has been deleted.', __('order evolution')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('order evolution')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('order evolution')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
