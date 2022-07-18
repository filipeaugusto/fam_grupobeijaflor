<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Banks Controller
 *
 * @property \App\Model\Table\BanksTable $Banks
 * @method \App\Model\Entity\Bank[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BanksController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $query = $this->Banks
        ->find('search', [
            'search' => $this->request->getQueryParams()
        ]);

        $banks = $this->paginate($query);

        $this->set(compact('banks'));
    }

    /**
     * View method
     *
     * @param string|null $id Bank id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $bank = $this->Banks->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('bank'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bank = $this->Banks->newEmptyEntity();
        if ($this->request->is('post')) {
            $bank = $this->Banks->patchEntity($bank, $this->request->getData());
            if ($this->Banks->save($bank)) {
                $this->Flash->success(__('The {0} has been saved.', __('bank')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('bank')));
        }
        $this->set(compact('bank'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bank id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $bank = $this->Banks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bank = $this->Banks->patchEntity($bank, $this->request->getData());
            if ($this->Banks->save($bank)) {
                $this->Flash->success(__('The {0} has been saved.', __('bank')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('bank')));
        }
        $this->set(compact('bank'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bank id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bank = $this->Banks->get($id);
        try {
            if ($this->Banks->delete($bank)) {
                $this->Flash->success(__('The {0} has been deleted.', __('bank')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('bank')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('bank')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
