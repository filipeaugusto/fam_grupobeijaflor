<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Companies Controller
 *
 * @property \App\Model\Table\CompaniesTable $Companies
 * @property \App\Controller\Component\UploadFilesComponent $UploadFiles
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompaniesController extends AdminController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('UploadFiles', [
            'field' => 'logo',
            'pathname' => mb_strtolower($this->name),
            'prefix' => 'COM_'
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if ($this->request->getQuery('sort') === null) {
            $order = [
                'Companies.lft' => 'ASC'
            ];
        }

        $query = $this->Companies
            ->find('search', [
                'contain' => ['ParentCompanies', 'Addresses'],
                'search' => $this->request->getQueryParams(),
//                'conditions' => [
//                    'Companies.id IN' => $this->getRelatedCompaniesIDs()
//                ],
                'order' => $order ?? null
            ]);

        $companies = $this->paginate($query);

        $this->set(compact('companies'));
    }

    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $company = $this->Companies->get($id, [
//            'contain' => ['ParentCompanies', 'Billings', 'CheckControls', 'ChildCompanies', 'FileImports', 'Orders', 'Payments', 'ShoppingCarts', 'Users'],
        ]);

        $this->set(compact('company'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $company = $this->Companies->newEmptyEntity();
        if ($this->request->is('post')) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            $this->UploadFiles->upload($company);
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The {0} has been saved.', __('company')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('company')));
        }
        $parentCompanies = $this->Companies->ParentCompanies->find('list', ['limit' => 500]);
        $payments = $this->Companies->Payments->find('list', ['limit' => 500])->orderAsc('name');
        $this->set(compact('company', 'parentCompanies', 'payments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['Payments'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            $this->UploadFiles->upload($company);
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The {0} has been saved.', __('company')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('company')));
        }
        $parentCompanies = $this->Companies->ParentCompanies->find('list', ['limit' => 500]);
        $payments = $this->Companies->Payments->find('list', ['limit' => 500])->orderAsc('name');
        $this->set(compact('company', 'parentCompanies', 'payments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $company = $this->Companies->get($id);
        $this->UploadFiles->remove($company);
        try {
            if ($this->Companies->delete($company)) {
                $this->Flash->success(__('The {0} has been deleted.', __('company')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('company')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('company')));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param string|null $id
     */
    public function change(string $id = null)
    {
        if ($this->getRequest()->getSession()->read('Config.company') != $id) {

            $this->getRequest()->getSession()->delete('Config.all_companies');

            if ($id === 'all') {
                $this->getRequest()->getSession()->write('Config.all_companies', true);
            }

            $this->setCompanyID($id);
            $this->Flash->success(__('{0} successfully changed.', __('Company')), ['params' =>['class' => 'alert alert-dismissible fade show alert-secondary']]);

            if (preg_match('/shopping-carts/', $this->referer())) {
                $this->redirect(['controller' => 'Pages', 'action' => 'dashboard']);
            }
        } else {
            $this->Flash->error(__('{0} has not been changed', __('Company')));
        }

        $this->redirect(preg_replace('/\?.*/', '', $this->referer()));
    }
}
