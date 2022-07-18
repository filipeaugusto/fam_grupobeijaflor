<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Rules Controller
 *
 * @property \App\Model\Table\RulesTable $Rules
 * @method \App\Model\Entity\Rule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RulesController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $query = $this->Rules
        ->find('search', [
            'search' => $this->request->getQueryParams()
        ]);

        $rules = $this->paginate($query);

        $this->set(compact('rules'));
    }

    /**
     * View method
     *
     * @param string|null $id Rule id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $rule = $this->Rules->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('rule'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rule = $this->Rules->newEmptyEntity();
        if ($this->request->is('post')) {
            $rule = $this->Rules->patchEntity($rule, $this->request->getData());
            if ($this->Rules->save($rule)) {
                $this->Flash->success(__('The {0} has been saved.', __('rule')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('rule')));
        }
        $this->set(compact('rule'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rule id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $rule = $this->Rules->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rule = $this->Rules->patchEntity($rule, $this->request->getData());
            if ($this->Rules->save($rule)) {
                $this->Flash->success(__('The {0} has been saved.', __('rule')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('rule')));
        }
        $this->set(compact('rule'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rule id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rule = $this->Rules->get($id);
        try {
            if ($this->Rules->delete($rule)) {
                $this->Flash->success(__('The {0} has been deleted.', __('rule')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('rule')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('rule')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
