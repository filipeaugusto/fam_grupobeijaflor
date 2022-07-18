<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Controller\Utils\DashboardReturn;
use App\Model\Entity\Account;
use App\Model\Table\BillingsTable;
use Cake\I18n\FrozenTime;

/**
 * Accounts Controller
 *
 * @property \App\Model\Table\AccountsTable $Accounts
 * @method Account[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountsController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Accounts
            ->find('search', [
                'contain' => ['Companies'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
                    'Accounts.company_id IN' => $this->getRelatedCompaniesIDs()
                ],
            ]);

        $accounts = $this->paginate($query);

        $this->set(compact('accounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $account = $this->Accounts->get($id, [
            'contain' => ['Companies'],
        ]);

        $this->set(compact('account'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $account = $this->Accounts->newEmptyEntity();
        if ($this->request->is('post')) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('The {0} has been saved.', __('account')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('account')));
        }
        $companies = $this->Accounts->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);
        $this->set(compact('account', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $account = $this->Accounts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('The {0} has been saved.', __('account')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('account')));
        }
        $companies = $this->Accounts->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);
        $this->set(compact('account', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $account = $this->Accounts->get($id);
        try {
            if ($this->Accounts->delete($account)) {
                $this->Flash->success(__('The {0} has been deleted.', __('account')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('account')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('account')));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Extract method
     *
     * @param string|null $id Accounts id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function extract(string $id = null)
    {
        if (is_null($id)) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->getQuery('sort') === null) {
            $order = [
                'Billings.authorization' => 'ASC',
                'Billings.confirmation' => 'ASC',
                'Billings.created' => 'DESC',
            ];
        }

        $account = $this->Accounts->get($id, [
            'contain' => [],
        ]);

        $query = $this->Accounts->Billings
            ->find('extract')
            ->contain(['Companies'])
            ->andWhere([
                'account_id' => $account->id
            ])
            ->order($order ?? null)
        ;

        $waiting_for_input = (clone $query)
            ->andWhere(['Billings.type' => 'input', 'Billings.confirmation' => 0])
            ->sumOf('value');

        $input = (clone $query)
            ->andWhere(['Billings.type' => 'input', 'Billings.confirmation' => 1])
            ->sumOf('value');

        $waiting_for_output = (clone $query)
            ->andWhere(['Billings.type' => 'output', 'Billings.confirmation' => 0])
            ->sumOf('value');

        $output = (clone $query)
            ->andWhere(['Billings.type' => 'output', 'Billings.confirmation' => 1])
            ->sumOf('value');

        $dashboard = new DashboardReturn($input, $output);

        $dashboard
            ->setWaitingForInput($waiting_for_input)
            ->setWaitingForOutput($waiting_for_output)
            ->setProgress(false);

        $billings = $this->paginate($query);

        $this->set(compact('account', 'billings', 'dashboard'));
    }

    public function transfer(string $id = null)
    {
        $account = $this->Accounts->get($id, [
            'contain' => ['Companies'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $accountIn = $this->Accounts->get($this->request->getData('account_id'), [
                'contain' => [],
            ]);

            $billing = $this->getBilling($account, $id);
            $billing->foreing_key = $id;
            $billing->type = BillingsTable::OUTPUT;
            $billing->description .= __(', transferência enviada: {0}', $accountIn->details);

            $billingIn = $this->getBilling($accountIn, $this->request->getData('account_id'));
            $billingIn->foreing_key = $this->request->getData('account_id');
            $billingIn->type = BillingsTable::INPUT;
            $billingIn->description .= __(', transferência recebida: {0}', $account->details);

            try {
                $this->Accounts->Billings->saveOrFail($billing);

                $billingIn->parent_id = $billing->id;
                $this->Accounts->Billings->saveOrFail($billingIn);

                $this->Flash->success(__('The {0} has been saved.', __('account')));
            } catch (\Exception $e) {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('account')));
            }
            return $this->redirect(['action' => 'index']);
        }
        $accounts = $this->Accounts->find('list', [])
            ->andWhere(['id <>' => $id])
            ->orderAsc('bank');
        $this->set(compact('account', 'accounts'));

    }

    /**
     * @param Account $account
     * @param string|null $id
     * @return \App\Model\Entity\Billing|\Cake\Datasource\EntityInterface
     */
    private function getBilling(Account $account, ?string $id)
    {
        $billing = $this->Accounts->Billings->newEmptyEntity();

        $deadline = $this->request->getData('deadline') ?? new FrozenTime();

        $billing->company_id = $account->company_id;
        $billing->account_id = $id;
        $billing->deadline = $deadline;
        $billing->description = $this->request->getData('observations') ?? __('Realizada por: {0}', $this->getAuthentication('name'));
        $billing->value = $this->request->getData('value');
        $billing->model = $this->name;
        $billing->authorization_user_id = $this->getAuthentication('id');
        $billing->authorization = !$billing->authorization;
        $billing->authorization_date = $deadline;
        $billing->confirmation_user_id = $this->getAuthentication('id');
        $billing->confirmation = !$billing->confirmation;
        $billing->confirmation_date = $deadline;

        return $billing;
    }
}
