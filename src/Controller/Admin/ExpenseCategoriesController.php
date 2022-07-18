<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ExpenseCategories Controller
 *
 * @property \App\Model\Table\ExpenseCategoriesTable $ExpenseCategories
 * @method \App\Model\Entity\ExpenseCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExpenseCategoriesController extends AppController
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
                'ExpenseCategories.lft' => 'ASC'
            ];
        }

        $query = $this->ExpenseCategories
            ->find('search', [
                'contain' => ['ParentExpenseCategories'],
                'search' => $this->request->getQueryParams(),
                'order' => $order ?? null
            ]);

        $expenseCategories = $this->paginate($query);

        $this->set(compact('expenseCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Expense Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $expenseCategory = $this->ExpenseCategories->get($id, [
            'contain' => ['ParentExpenseCategories', 'Billings', 'ChildExpenseCategories', 'Payments'],
        ]);

        $this->set(compact('expenseCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $expenseCategory = $this->ExpenseCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $expenseCategory = $this->ExpenseCategories->patchEntity($expenseCategory, $this->request->getData());
            if ($this->ExpenseCategories->save($expenseCategory)) {
                $this->Flash->success(__('The {0} has been saved.', __('expense category')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('expense category')));
        }
        $parentExpenseCategories = $this->ExpenseCategories->ParentExpenseCategories->find('list', ['limit' => 500]);
        $this->set(compact('expenseCategory', 'parentExpenseCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Expense Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $expenseCategory = $this->ExpenseCategories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $expenseCategory = $this->ExpenseCategories->patchEntity($expenseCategory, $this->request->getData());
            if ($this->ExpenseCategories->save($expenseCategory)) {
                $this->Flash->success(__('The {0} has been saved.', __('expense category')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('expense category')));
        }
        $parentExpenseCategories = $this->ExpenseCategories->ParentExpenseCategories->find('list', ['limit' => 500]);
        $this->set(compact('expenseCategory', 'parentExpenseCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Expense Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $expenseCategory = $this->ExpenseCategories->get($id);
        try {
            if ($this->ExpenseCategories->delete($expenseCategory)) {
                $this->Flash->success(__('The {0} has been deleted.', __('expense category')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('expense category')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('expense category')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
