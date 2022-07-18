<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Controller\Utils\DashboardReturn;
use App\Model\Entity\Billing;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Billings Controller
 *
 * @property \App\Model\Table\BillingsTable $Billings
 * @method Billing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BillingsController extends AdminController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->FormProtection->setConfig('unlockedActions', ['confirmAll']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $billing = $this->Billings->newEmptyEntity();

        $billing->type = $this->request->getQuery('type') ?? null;
        $billing->value = $this->request->getQuery('value') ?? null;
        $billing->confirmation = $this->request->getQuery('confirmation') ?? null;
        $billing->description = $this->request->getQuery('description') ?? null;
        $billing->limit_deadline = $this->request->getQuery('limit_deadline') ?? null;

        if ($this->request->getQuery('sort') === null) {
            $order = [
                'Billings.authorization' => 'ASC',
                'Billings.confirmation' => 'ASC',
                'Billings.deadline' => 'DESC',
            ];
        }

        $query = $this->Billings
            ->find('search', [
                'contain' => ['Companies', 'CheckControls', 'Partners', 'Users', 'Accounts'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
                    'Billings.type NOT IN' => 'control',
                    'Billings.value >' => 0,
                    'Billings.removed' => 0,
                    'Billings.company_id IN' => $this->getRelatedCompaniesIDs()
                ],
                'order' => $order ?? null
            ]);

        $waiting_for_input = (clone $query)
            ->andWhere(['Billings.type' => 'input', 'Billings.confirmation' => 0])
            ->sumOf('value');

        $input = (clone $query)
            ->andWhere(['Billings.type' => 'input', 'Billings.confirmation' => 1])
            ->sumOf('value');

        $input_check = (clone $query)
            ->andWhere(['Billings.type' => 'input', 'Billings.confirmation' => 1, 'Billings.model' => 'CheckControls'])
            ->sumOf('value');

        $waiting_for_output = (clone $query)
            ->andWhere(['Billings.type' => 'output', 'Billings.confirmation' => 0])
            ->sumOf('value');

        $output = (clone $query)
            ->andWhere(['Billings.type' => 'output', 'Billings.confirmation' => 1])
            ->sumOf('value');

        $dashboard = new DashboardReturn($input, $output);

        $dashboard->setWaitingForInput($waiting_for_input);

        $dashboard->setWaitingForOutput($waiting_for_output);

        $dashboard->setInputCheck($input_check);

        $billings = $this->paginate($query);

        $accounts = $this->Billings->Companies->Accounts
            ->find('list', ['limit' => 500])
            ->where(['Accounts.company_id IN' => $this->getRelatedCompaniesIDs()])
            ->contain(['Companies'])->orderAsc('Companies.lft');

        $this->set(compact('billings', 'dashboard', 'billing', 'accounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Billing id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $billing = $this->Billings->get($id, [
            'contain' => [
                'Companies',
                'Accounts',
                'RemovedUsers',
                'ConfirmationUsers',
                'Orders' => [
                    'Users',
                    'Partners',
                    'OrderStatus'
                ],
                'CheckControls',
                'ExpenseCategories',
                'Partners'
            ],
        ]);

        $this->set(compact('billing'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billing = $this->Billings->newEmptyEntity();
        if ($this->request->is('post')) {
            $billing->created_user_id = $this->getAuthentication('id');
            if ($this->request->getData('account_id')) {
                $billing->company_id = $this->Billings->Companies->Accounts->get($this->request->getData('account_id'))->company_id;
            }
            $billing = $this->Billings->patchEntity($billing, $this->request->getData());
            if ($this->Billings->save($billing)) {
                $this->Flash->success(__('The {0} has been saved.', __('billing')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing')));
        }

        $companies = $this->Billings->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])
            ->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);

        $expenseCategories = $this->Billings->ExpenseCategories->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['ExpenseCategories.lft' => 'ASC']]);

        $partners = $this->Billings->Partners->find('list', ['limit' => 500, 'order' => ['Partners.name' => 'ASC']]);

        $this->set(compact('billing', 'companies', 'expenseCategories', 'partners'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Billing id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $billing = $this->Billings->get($id, [
            'contain' => [],
        ]);

        if ($this->confirmationDone($billing)) {
            return $this->redirect($this->referer());
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->getData('account_id')) {
                $billing->company_id = $this->Billings->Companies->Accounts->get($this->request->getData('account_id'))->company_id;
            }

            if ($billing->is_loan === true && $billing->value > $this->request->getData('value')) {
                $newBilling = $this->Billings->newEntity($billing->toArray());
                $newBilling->expense_category_id = null;
                $newBilling->value = $billing->value - $this->request->getData('value');
            }

            $billing = $this->Billings->patchEntity($billing, $this->request->getData());

            if ($this->Billings->save($billing)) {

                if (isset($newBilling)) {
                    $this->Billings->save($newBilling);
                }

                $this->Flash->success(__('The {0} has been saved.', __('billing')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing')));
        }

        $companies = $this->Billings->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])
            ->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);

        $expenseCategories = $this->Billings->ExpenseCategories->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['ExpenseCategories.lft' => 'ASC']]);

        $partners = $this->Billings->Partners->find('list', ['limit' => 500, 'order' => ['Partners.name' => 'ASC']]);

        $this->set(compact('billing', 'expenseCategories', 'companies', 'partners'));
    }



    /**
     * Delete method
     *
     * @param string|null $id Billing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billing = $this->Billings->get($id);

        if ($this->confirmationDone($billing)) {
            return $this->redirect($this->referer());
        }

        $billing->removed_user_id = $this->getAuthentication('id');;
        $billing->removed = !$billing->removed;
        $billing->removed_date = new FrozenTime();

        if ($this->Billings->save($billing)) {
            $this->Flash->success(__('The {0} has been deleted.', __('billing')));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('billing')));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Authorization method
     *
     * @param string|null $id Billing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function authorization(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billing = $this->Billings->get($id);

        $billing->authorization_user_id = $this->getAuthentication('id');
        $billing->authorization = !$billing->authorization;
        $billing->authorization_date = new FrozenTime();

        if ($this->Billings->save($billing)) {
            $this->Flash->success(__('The {0} has been authorization.', __('billing')));
        } else {
            $this->Flash->error(__('The {0} could not be authorization. Please, try again.', __('billing')));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Confirmation method
     *
     * @param string|null $id Billing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function confirmation(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billing = $this->Billings->get($id);

        $billing->confirmation_user_id = $this->getAuthentication('id');
        $billing->confirmation = !$billing->confirmation;
        $billing->confirmation_date = new FrozenTime();
        if ($billing->confirmation) {
            $billing->deadline = new FrozenTime();
        }

        if ($this->Billings->save($billing)) {
            $this->Flash->success(__('The {0} has been confirmation.', __('billing')));
        } else {
            $this->Flash->error(__('The {0} could not be confirmation. Please, try again.', __('billing')));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Removed method
     *
     * @param string|null $id Billing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function removed(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billing = $this->Billings->get($id);

        $billing->removed_user_id = $this->getAuthentication('id');;
        $billing->removed = !$billing->removed;
        $billing->removed_date = new FrozenTime();

        if ($this->Billings->save($billing)) {
            $this->Flash->success(__('The {0} has been removed.', __('billing')));
        } else {
            $this->Flash->error(__('The {0} could not be removed. Please, try again.', __('billing')));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Waiting method
     *
     * @param string|null $id Billing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function waiting(string $id = null)
    {
        $billing = $this->Billings->get($id, [
            'contain' => ['Companies'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $billing->authorization_user_id = $this->getAuthentication('id');
            $billing->authorization = true;
            $billing->authorization_date = new FrozenTime();

//            $billing->confirmation_user_id = $this->getAuthentication('id');
//            $billing->confirmation = true;
//            $billing->confirmation_date = new FrozenTime();

//            $billing->type = 'control';

            $billing = $this->Billings->patchEntity($billing, $this->request->getData());
            if ($this->Billings->save($billing)) {
                $this->Flash->success(__('The {0} has been saved.', __('billing')));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing')));
        }

        $accounts = TableRegistry::getTableLocator()->get('Accounts')
            ->find('list', ['limit' => 500])
            ->where(['Accounts.company_id IN' => $this->getRelatedCompaniesIDs()])
            ->contain(['Companies'])->orderAsc('Companies.lft');

        $users =  TableRegistry::getTableLocator()->get('Users')->find('list', ['limit' => 500])
            ->innerJoinWith('Companies', function (Query $query) {
                return $query->where([
                    'company_id IN' => $this->getRelatedCompaniesIDs()
                ]);
            })
            ->orderAsc('Users.name');

        $partners = TableRegistry::getTableLocator()->get('Partners')->find('list', ['limit' => 500])
            ->orderAsc('partner_type_id')
            ->orderAsc('name');

        $this->set(compact('billing', 'accounts', 'users', 'partners'));

    }

    /**
     * Account method
     *
     * @param string|null $id Billing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function account(string $id = null)
    {
        $billing = $this->Billings->get($id, [
            'contain' => ['Companies'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $billing->confirmation_user_id = $this->getAuthentication('id');
            $billing->confirmation = true;
            $billing->confirmation_date = new FrozenTime();

            if (!$this->request->getData('model')) {
                $this->request = $this->request->withData('model', null);
                $this->request = $this->request->withData('foreing_key', null);
            }

            $billing = $this->Billings->patchEntity($billing, $this->request->getData());
            if ($this->Billings->save($billing)) {
                $this->Flash->success(__('The {0} has been saved.', __('billing')));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing')));
        }

        $accounts = TableRegistry::getTableLocator()->get('Accounts')
            ->find('list', ['limit' => 500])
            ->where(['Accounts.company_id IN' => $this->getRelatedCompaniesIDs()])
            ->contain(['Companies'])->orderAsc('Companies.lft');

        $users =  TableRegistry::getTableLocator()->get('Users')->find('list', ['limit' => 500])
            ->innerJoinWith('Companies', function (Query $query) {
                return $query->where([
                    'company_id IN' => $this->getRelatedCompaniesIDs()
                ]);
            })
            ->orderAsc('Users.name');

        $partners = TableRegistry::getTableLocator()->get('Partners')->find('list', ['limit' => 500])
            ->orderAsc('partner_type_id')
            ->orderAsc('name');

        $this->set(compact('billing', 'accounts', 'users', 'partners'));

    }


    /**
     * @return \Cake\Http\Response|void|null
     */
    public function confirmAll()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            try {
                $this->Billings->updateAll(
                    [
                        'account_id' => $this->request->getData('account_id'),
                        'confirmation_user_id'  => $this->getAuthentication('id'),
                        'confirmation' => true,
                        'confirmation_date' => FrozenTime::now(),
                        'authorization' => true,
                    ],
                    [
                        'id IN' => $this->request->getData('billings')
                    ]
                );

                $this->Flash->success(__('The {0} has been saved.', __('billing')));

            } catch (\Exception $e) {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing')));
            }

            return $this->redirect($this->referer());
        }
    }

    /**
     * Conference method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function conference()
    {
        $query = $this->Billings
            ->find('search', [
                'contain' => ['Companies', 'CheckControls', 'Partners', 'Users', 'Accounts'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
                    'Billings.type NOT IN' => 'control',
                    'Billings.value >' => 0,
                    'Billings.removed' => 0,
                    'Billings.authorization' => 1,
                    'Billings.confirmation' => 1,
                    'Billings.company_id IN' => $this->getRelatedCompaniesIDs()
                ],
                'order' => $order ?? null
            ]);

        $billings = $this->paginate($query);

        $title = 'Transactions conference';

        $this->set(compact('billings', 'title'));
    }


    /**
     * @param string|null $id
     * @return \Cake\Http\Response|null
     */
    public function conferenceFinal(string $id = null): ?\Cake\Http\Response
    {
        $this->request->allowMethod(['post', 'put']);
        $billing = $this->Billings->get($id);

        $billing->conference_final_user_id = $this->getAuthentication('id');;
        $billing->conference_final = !$billing->conference_final;
        $billing->conference_final_date = new FrozenTime();

        if ($this->Billings->save($billing)) {
            $this->Flash->success(__('The {0} has been checked.', __('billing')));
        } else {
            $this->Flash->error(__('The {0} could not be checked. Please, try again.', __('billing')));
        }

        return $this->redirect($this->referer());
    }

    /**
     * @param Billing $billing
     * @return bool
     */
    protected function confirmationDone(Billing $billing): bool
    {
        if ($billing->confirmation) {
            $this->Flash->success(__('It is not possible because it has been confirmed.'), ['params' => ['class' => 'alert alert-dismissible fade show alert-secondary']]);
        }

        return $billing->confirmation;
    }
}
