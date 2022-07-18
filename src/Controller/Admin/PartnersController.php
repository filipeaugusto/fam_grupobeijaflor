<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Partners Controller
 *
 * @property \App\Model\Table\PartnersTable $Partners
 * @property \App\Controller\Component\UploadFilesComponent $UploadFiles
 * @method \App\Model\Entity\Partner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PartnersController extends AdminController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('UploadFiles', [
            'field' => 'image',
            'pathname' => mb_strtolower($this->name),
            'prefix' => 'CAT_'
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Partners
            ->find('search', [
                'contain' => ['PartnerTypes', 'Addresses'],
                'search' => $this->request->getQueryParams()
            ]);

        $partners = $this->paginate($query);

        $this->set(compact('partners'));
    }

    /**
     * View method
     *
     * @param string|null $id Partner id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $partner = $this->Partners->get($id, [
            'contain' => [
                'PartnerTypes',
                'ExpenseCategories',
                'Categories',
                'CheckControls',
                'Contacts',
                'Orders',
                'ShoppingCarts'
            ],
        ]);

        $this->set(compact('partner'));
    }

    /**
     * Money method
     *
     * @param string|null $id Partner id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function money(string $id = null)
    {
        $partner = $this->Partners->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $date = new FrozenTime('now');

            $breaks = [];

            if ($this->request->getData('break') < 1) {
                $break = 1;
            } else {
                $break = $this->request->getData('break') * 3;
            }

            $value = round($this->request->getData('credit_line') / $break, 2);

            for ($i = 1; $i <= $break; $i++) {
                $breaks[] = [
                    'company_id' => $this->request->getData('company_id'),
                    'type' => 'input',
                    'model' => $this->getName(),
                    'foreing_key' => $id,
                    'deadline' => $date->addMonths($i),
                    'description' => __('Parcela {0}, empréstimo p/ {1} realizado por: {2} em {3}', str_pad((string)$i, 2, '0', STR_PAD_LEFT), $partner->name, $this->getAuthentication('name'), $date->format('d/m/Y')),
                    'value' => $value,
                ];
            }

            $data = [
                'company_id' => $this->request->getData('company_id'),
                'type' => 'output',
                'deadline' => $date,
                'model' => $this->getName(),
                'foreing_key' => $id,
                'description' => __('Empréstimo p/ {0} realizado por: {1} em {2}. Em {3}x de R$ {4}', $partner->name, $this->getAuthentication('name'), $date->format('d/m/Y'), count($breaks), number_format($value, 2, ',', '.')),
                'value' => $this->request->getData('credit_line'),
                'child_billings' => $breaks,
            ];

            $billingsTable = TableRegistry::getTableLocator()->get('Billings');

            $entity = $billingsTable->newEntity($data, ['associated' => ['ChildBillings']]);

            try {
                $billingsTable->saveOrFail($entity);
                $this->Flash->success(__('The {0} has been saved.', __('partner')));

            } catch (\Exception $e) {
                $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('partner')));
            }

            return $this->redirect(['action' => 'index']);

        }

        $companies = TableRegistry::getTableLocator()->get('Companies')->find('treeList', ['spacer' => '--', 'limit' => 500])
            ->where([
                'Companies.id IN' => $this->getRelatedCompaniesIDs()
            ]);

        $this->set(compact('partner', 'companies'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $partner = $this->Partners->newEmptyEntity();
        if ($this->request->is('post')) {
            $partner = $this->Partners->patchEntity($partner, $this->request->getData());
            $this->UploadFiles->upload($partner);
            if ($this->Partners->save($partner)) {
                $this->Flash->success(__('The {0} has been saved.', __('partner')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('partner')));
        }
        $partnerTypes = $this->Partners->PartnerTypes->find('list', ['limit' => 500]);
        $categories = $this->Partners->Categories->find('treeList', ['spacer' => '--', 'limit' => 500])->orderAsc('lft');
        $expenseCategories = $this->Partners->ExpenseCategories->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['ExpenseCategories.lft' => 'ASC']]);
        $this->set(compact('partner', 'partnerTypes', 'categories', 'expenseCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Partner id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $partner = $this->Partners->get($id, [
            'contain' => ['Categories', 'Contacts'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $partner = $this->Partners->patchEntity($partner, $this->request->getData());
            $this->UploadFiles->upload($partner);
            if ($this->Partners->save($partner)) {
                $this->Flash->success(__('The {0} has been saved.', __('partner')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('partner')));
        }
        $partnerTypes = $this->Partners->PartnerTypes->find('list', ['limit' => 500]);
        $categories = $this->Partners->Categories->find('treeList', ['spacer' => '--', 'limit' => 500])->orderAsc('lft');
        $expenseCategories = $this->Partners->ExpenseCategories->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['ExpenseCategories.lft' => 'ASC']]);
        $this->set(compact('partner', 'partnerTypes', 'categories', 'expenseCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Partner id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $partner = $this->Partners->get($id);
        try {
            $this->UploadFiles->remove($partner);
            if ($this->Partners->delete($partner)) {
                $this->Flash->success(__('The {0} has been deleted.', __('partner')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('partner')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('partner')));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function getExpenseCategory(string $id = null)
    {
//        $this->request->allowMethod(['post', 'put']);
        $partner = $this->Partners->get($id);
        if ($partner) {
            $message = __('The {0} has been deleted.', __('partner'));
        } else {
            $message = __('The {0} could not be deleted. Please, try again.', __('partner'));
        }

        $this->set(compact('partner', 'message'));

        $this->viewBuilder()->setOption('serialize', ['partner', 'message']);

    }

}
