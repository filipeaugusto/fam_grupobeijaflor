<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Controller\Utils\DashboardReturn;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;

/**
 * BillingSlips Controller
 *
 * @property \App\Model\Table\BillingSlipsTable $BillingSlips
 * @property \App\Controller\Component\UploadFilesComponent $UploadFiles
 * @method \App\Model\Entity\BillingSlip[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BillingSlipsController extends BillingsController
{

    public function initialize(): void
    {
        $this->loadModel('Billings');

        $this->loadComponent('UploadFiles', [
            'field' => 'archive',
            'pathname' => mb_strtolower($this->name),
            'prefix' => 'SLI_'
        ]);

        parent::initialize();
    }

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

        $billingSlip = $this->BillingSlips->newEmptyEntity();

        $billingSlip->type = $this->request->getQuery('type') ?? null;
        $billingSlip->value = $this->request->getQuery('value') ?? null;
        $billingSlip->confirmation = $this->request->getQuery('confirmation') ?? null;
        $billingSlip->description = $this->request->getQuery('description') ?? null;
        $billingSlip->invoice_number = $this->request->getQuery('invoice_number') ?? null;
        $billingSlip->limit_deadline = $this->request->getQuery('limit_deadline') ?? null;
        $billingSlip->start_deadline = $this->request->getQuery('start_deadline') ?? null;
        $billingSlip->end_deadline = $this->request->getQuery('end_deadline') ?? null;

        if ($this->request->getQuery('sort') === null) {
            $order = [
                'BillingSlips.authorization' => 'ASC',
                'BillingSlips.confirmation' => 'ASC',
                'BillingSlips.deadline' => 'DESC',
            ];
        }

        $query = $this->BillingSlips
            ->find('search', [
                'contain' => ['Companies', 'CheckControls', 'Partners', 'Users', 'Accounts'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
                    'BillingSlips.type' => 'control',
                    'BillingSlips.removed' => 0,
                    'BillingSlips.value >' => 0,
                    'BillingSlips.company_id IN' => $this->getRelatedCompaniesIDs()
                ],
                'order' => $order ?? null
            ]);

        $accounts = $this->BillingSlips->Companies->Accounts
            ->find('list', ['limit' => 500])
            ->where(['Accounts.company_id IN' => $this->getRelatedCompaniesIDs()])
            ->contain(['Companies'])->orderAsc('Companies.lft');

        $billingSlips = $this->paginate($query);

        $this->set(compact('billingSlips', 'billingSlip', 'accounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Billing Slip id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $billingSlip = $this->BillingSlips->get($id, [
            'contain' => [
                'Companies',
                'Users',
                'Orders',
                'ExpenseCategories',
                'Accounts',
                'Partners',
                'CreatedUsers'
            ],
        ]);

        $this->set(compact('billingSlip'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billingSlip = $this->BillingSlips->newEmptyEntity();
        if ($this->request->is('post')) {
            $billingSlip->created_user_id = $this->getAuthentication('id');
            $this->UploadFiles->upload($billingSlip);
            $billingSlip = $this->BillingSlips->patchEntity($billingSlip, $this->request->getData());
            if ($this->BillingSlips->save($billingSlip)) {
                $this->Flash->success(__('The {0} has been saved.', __('billing slip')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing slip')));
        }
        $companies = $this->BillingSlips->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])
            ->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);

        $expenseCategories = $this->BillingSlips->ExpenseCategories->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['ExpenseCategories.lft' => 'ASC']]);

        $partners = $this->BillingSlips->Partners->find('list', ['limit' => 500, 'order' => ['Partners.name' => 'ASC']]);

        $this->set(compact('billingSlip', 'companies', 'expenseCategories', 'partners'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Billing Slip id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $billingSlip = $this->BillingSlips->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billingSlip = $this->BillingSlips->patchEntity($billingSlip, $this->request->getData());
            $this->UploadFiles->upload($billingSlip);
            if ($this->BillingSlips->save($billingSlip)) {
                $this->Flash->success(__('The {0} has been saved.', __('billing slip')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing slip')));
        }
        $companies = $this->BillingSlips->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])
            ->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);

        $expenseCategories = $this->BillingSlips->ExpenseCategories->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['ExpenseCategories.lft' => 'ASC']]);

        $partners = $this->BillingSlips->Partners->find('list', ['limit' => 500, 'order' => ['Partners.name' => 'ASC']]);

        $this->set(compact('billingSlip', 'companies', 'expenseCategories', 'partners'));
    }

    /**
     * @param string|null $id
     * @return \Cake\Http\Response|void|null
     */
    public function waiting(string $id = null)
    {
        $billingSlip = $this->BillingSlips->get($id, [
            'contain' => ['Companies'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $billingSlip->confirmation_user_id = $this->getAuthentication('id');
            $billingSlip->confirmation = true;
            $billingSlip->confirmation_date = new FrozenTime();

            $this->request = $this->request->withData('authorization', true);

            $billingSlip = $this->BillingSlips->patchEntity($billingSlip, $this->request->getData());

            if ($this->BillingSlips->save($billingSlip)) {
                $this->Flash->success(__('The {0} has been saved.', __('billing slip')));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing slip')));
        }

        $accounts = $this->BillingSlips->Companies->Accounts
            ->find('list', ['limit' => 500])
            ->where(['Accounts.company_id IN' => $this->getRelatedCompaniesIDs()])
            ->contain(['Companies'])->orderAsc('Companies.lft');

        $this->set(compact('billingSlip', 'accounts'));
    }

    /**
     * @return \Cake\Http\Response|void|null
     */
    public function confirmAll()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $this->BillingSlips->updateAll(
                    [
                        'account_id' => $this->request->getData('account_id'),
                        'confirmation_user_id'  => $this->getAuthentication('id'),
                        'confirmation' => true,
                        'confirmation_date' => FrozenTime::now(),
                        'authorization' => true,
                    ],
                    [
                        'id IN' => $this->request->getData('billings_slips')
                    ]
                );

                $this->Flash->success(__('The {0} has been saved.', __('billing slip')));

            } catch (\Exception $e) {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('billing slip')));
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
        $query = $this->BillingSlips
            ->find('search', [
                'contain' => ['Companies', 'CheckControls', 'Partners', 'Users', 'Accounts'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
                    'BillingSlips.type IN' => 'control',
                    'BillingSlips.value >' => 0,
                    'BillingSlips.removed' => 0,
                    'BillingSlips.authorization' => 1,
                    'BillingSlips.confirmation' => 1,
                    'BillingSlips.company_id IN' => $this->getRelatedCompaniesIDs()
                ],
                'order' => $order ?? null
            ]);

        $billingSlips = $this->paginate($query);

        $title = 'Conferência de boletos';

        $this->set(compact('billingSlips', 'title'));
    }


    /**
     * @param string|null $id
     * @return \Cake\Http\Response|null
     */
    public function conferenceFinal(string $id = null): ?\Cake\Http\Response
    {
        $this->request->allowMethod(['post', 'put']);
        $billingSlip = $this->BillingSlips->get($id);

        $billingSlip->conference_final_user_id = $this->getAuthentication('id');;
        $billingSlip->conference_final = !$billingSlip->conference_final;
        $billingSlip->conference_final_date = new FrozenTime();

        if ($this->BillingSlips->save($billingSlip)) {
            $this->Flash->success(__('The {0} has been checked.', __('billing')));
        } else {
            $this->Flash->error(__('The {0} could not be checked. Please, try again.', __('billing')));
        }

        return $this->redirect($this->referer());
    }
}
