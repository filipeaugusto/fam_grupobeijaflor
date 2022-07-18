<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Addresses Controller
 *
 * @property \App\Model\Table\AddressesTable $Addresses
 * @method \App\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AddressesController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $query = $this->Addresses
        ->find('search', [
            'search' => $this->request->getQueryParams()
        ]);

        $addresses = $this->paginate($query);

        $this->set(compact('addresses'));
    }

    /**
     * View method
     *
     * @param string|null $id Address id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $address = $this->Addresses->get($id, [
            'contain' => ['Orders', 'ShoppingCarts'],
        ]);

        $this->set(compact('address'));
    }

    /**
     * Add method
     *
     * @param string|null $model
     * @param string|null $foreingKey
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(string $model = null, string $foreingKey = null)
    {
        if (is_null($model) || is_null($foreingKey)) {
            $this->redirect($this->referer());
        }
        $address = $this->Addresses->newEmptyEntity();
        $address->name = $model;
        $address->model = $model;
        $address->foreing_key = $foreingKey;
        if ($this->request->is('post')) {
            $address = $this->Addresses->patchEntity($address, $this->request->getData());
            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('The {0} has been saved.', __('address')));
                return $this->redirect(['controller' => $address->model, 'action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('address')));
        }
        $this->set(compact('address'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Address id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $address = $this->Addresses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $address = $this->Addresses->patchEntity($address, $this->request->getData());
            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('The {0} has been saved.', __('address')));

                return $this->redirect(['controller' => $address->model, 'action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('address')));
        }
        $this->set(compact('address'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Address id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $address = $this->Addresses->get($id);
        try {
            if ($this->Addresses->delete($address)) {
                $this->Flash->success(__('The {0} has been deleted.', __('address')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('address')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('address')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
