<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Controller\Utils\DashboardReturn;
use App\Model\Entity\CheckControl;
use App\Model\Table\BillingsTable;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;

/**
 * CheckControls Controller
 *
 * @property \App\Model\Table\CheckControlsTable $CheckControls
 * @method \App\Model\Entity\CheckControl[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CheckControlsController extends AdminController
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
                'CheckControls.confirmation' => 'ASC',
                'CheckControls.deadline' => 'ASC'
            ];
        }

        $query = $this->CheckControls
            ->find('search', [
                'contain' => ['Companies', 'FileImports', 'Partners', 'Users'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
                    'CheckControls.company_id IN' => $this->getRelatedCompaniesIDs()
                ],
                'order' => $order ?? null
            ]);

        $waiting_for_input = (clone $query)
            ->andWhere(['confirmation' => false])
            ->andWhere(['deadline >' => FrozenTime::now()])
            ->sumOf('value');

        $waiting = (clone $query)
            ->andWhere(['confirmation' => false])
            ->andWhere(['deadline <=' => FrozenTime::now()])
            ->sumOf('value');

        $input = (clone $query)
            ->andWhere(['confirmation' => true])
            ->sumOf('value');

        $output = (clone $query)
            ->andWhere(['destination' => true])
            ->sumOf('value');

        $dashboard = new DashboardReturn($input, $output);

        $dashboard
            ->setWaitingForInput($waiting_for_input)
            ->setWaiting($waiting)
            ->setProgress(false);

        $checkControls = $this->paginate($query);

        $this->set(compact('checkControls', 'dashboard'));
    }

    /**
     * View method
     *
     * @param string|null $id Check Control id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $checkControl = $this->CheckControls->get($id, [
            'contain' => ['Companies', 'FileImports', 'Partners', 'Users'],
        ]);

        $this->set(compact('checkControl'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $checkControl = $this->CheckControls->newEmptyEntity();
        if ($this->request->is('post')) {
            $checkControl = $this->CheckControls->patchEntity($checkControl, $this->request->getData());
            if ($this->CheckControls->save($checkControl)) {
                $this->Flash->success(__('The {0} has been saved.', __('check control')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('check control')));
        }
        $companies = $this->CheckControls->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);
        $this->set(compact('checkControl', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Check Control id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $checkControl = $this->CheckControls->get($id, [
            'contain' => [],
        ]);

        if ($checkControl->confirmation || $checkControl->destination) {
            $this->Flash->set(__('The {0} could not be edited.', __('check control')));
            return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $checkControl = $this->CheckControls->patchEntity($checkControl, $this->request->getData());
            if ($this->CheckControls->save($checkControl)) {
                $this->Flash->success(__('The {0} has been saved.', __('check control')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('check control')));
        }
        $companies = $this->CheckControls->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);
        $this->set(compact('checkControl', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Check Control id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $checkControl = $this->CheckControls->get($id);

        if ($checkControl->confirmation || $checkControl->destination) {
            $this->Flash->set(__('The {0} could not be deleted.', __('check control')));
            return $this->redirect(['action' => 'index']);
        }

        try {
            if ($this->CheckControls->delete($checkControl)) {
                $this->Flash->success(__('The {0} has been deleted.', __('check control')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('check control')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('check control')));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function confirmation(string $id = null)
    {
        $checkControl = $this->CheckControls->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $checkControl->confirmation = !$checkControl->confirmation;
            $checkControl->confirmation_user_id = $this->getAuthentication('id');
            $checkControl->confirmation_date = new FrozenTime();

            try {
                if ($checkControl->confirmation === true) {
                    $this->createBilling($checkControl, BillingsTable::INPUT);
                } else {
                    $checkControl->destination = false;
                    $checkControl->destination_user_id = null;
                    $checkControl->destination_date = null;
                    $checkControl->model = null;
                    $checkControl->foreing_key = null;

                    $this->deleteBilling($checkControl);
                }
                if ($this->CheckControls->save($checkControl)) {
                    $this->Flash->success(__('The {0} has been saved.', __('check control')));

                    return $this->redirect(['action' => 'index', '#' => $checkControl->id]);
                }
            } catch (\Exception $e) {
            }

            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('check control')));
        }
        $this->set(compact('checkControl'));
    }


    private function createBilling(CheckControl $checkControl, string $type): void
    {
        $billing = $this->CheckControls->Billings->newEmptyEntity();

        $date = FrozenTime::now();
        $userID = $this->getAuthentication('id');

        if($checkControl->model == 'Partners') {
            $billing->partner_id = $checkControl->foreing_key;
        }
        if($checkControl->model == 'Users') {
            $billing->user_id = $checkControl->foreing_key;
        }

        $billing->company_id = $checkControl->company_id;
        $billing->model = $this->getName();
        $billing->foreing_key = $checkControl->id;
        $billing->deadline = $date;
        $billing->description = __('Cheque: {0}', $checkControl->details);
        $billing->value = $checkControl->value;
        $billing->type = $type;

        $billing->authorization = true;
        $billing->authorization_user_id = $userID;
        $billing->authorization_date = $date;

        $billing->confirmation = true;
        $billing->confirmation_user_id = $userID;
        $billing->confirmation_date = $date;

        $this->CheckControls->Billings->saveOrFail($billing);

    }

    private function deleteBilling(CheckControl $checkControl): void
    {
        $this->CheckControls->Billings->deleteAll([
            'model' => $this->getName(),
            'foreing_key' => $checkControl->id
        ]);
    }

    public function deposit(string $id = null)
    {
        $checkControl = $this->CheckControls->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $checkControl = $this->CheckControls->patchEntity($checkControl, $this->request->getData());

            $checkControl->destination = !$checkControl->destination;
            $checkControl->destination_user_id = $this->getAuthentication('id');
            $checkControl->destination_date = new FrozenTime();

            try {
                if ($checkControl->destination === true) {
                    $this->createBilling($checkControl, BillingsTable::OUTPUT);
                } else {
                    $this->deleteBilling($checkControl);
                }
                if ($this->CheckControls->save($checkControl)) {
                    $this->Flash->success(__('The {0} has been saved.', __('check control')));

                    return $this->redirect(['action' => 'index', '#' => $checkControl->id]);
                }
            } catch (\Exception $e) {
            }

            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('check control')));
        }

        $accounts = $this->CheckControls->Companies->Accounts
            ->find('list', ['limit' => 500])
            ->where(['Accounts.company_id IN' => $this->getRelatedCompaniesIDs()])
            ->contain(['Companies'])
            ->orderAsc('Companies.lft');

        $users = $this->CheckControls->Users->find('list', ['limit' => 500])
            ->innerJoinWith('Companies', function (Query $query) {
                return $query->where([
                    'company_id IN' => $this->getRelatedCompaniesIDs()
                ]);
            })
            ->orderAsc('Users.name');

        $partners = $this->CheckControls->Partners->find('list', ['limit' => 500])
            ->orderAsc('partner_type_id')
            ->orderAsc('name');

        $this->set(compact('checkControl', 'accounts', 'users', 'partners'));
    }
}
