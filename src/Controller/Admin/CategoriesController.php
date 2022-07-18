<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @property \App\Controller\Component\UploadFilesComponent $UploadFiles
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AdminController
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
        if ($this->request->getQuery('sort') === null) {
            $order = [
                'Categories.lft' => 'ASC'
            ];
        }

        $query = $this->Categories
            ->find('search', [
                'search' => $this->request->getQueryParams(),
                'order' => $order ?? null,
                'contain' => ['ParentCategories']
            ]);

        $categories = $this->paginate($query);

        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Partners', 'ParentCategories', 'Products', 'ChildCategories'],
        ]);

        $this->set(compact('category'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            $this->UploadFiles->upload($category);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The {0} has been saved.', __('category')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('category')));
        }
        $parentCategories = $this->Categories->ParentCategories->find('list', ['limit' => 500]);
        $partners = $this->Categories->Partners->find('list', ['limit' => 500])
            ->contain(['PartnerTypes'])
            ->where(['PartnerTypes.accept_orders' => true])
            ->orderAsc('Partners.name');

        $this->set(compact('category', 'partners', 'parentCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Partners'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            $this->UploadFiles->upload($category);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The {0} has been saved.', __('category')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('category')));
        }
        $parentCategories = $this->Categories->ParentCategories->find('list', ['limit' => 500]);
        $partners = $this->Categories->Partners->find('list', ['limit' => 500])
            ->contain(['PartnerTypes'])
            ->where(['PartnerTypes.accept_orders' => true])
            ->orderAsc('Partners.name');

        $this->set(compact('category', 'partners', 'parentCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        $this->UploadFiles->remove($category);
        try {
            if ($this->Categories->delete($category)) {
                $this->Flash->success(__('The {0} has been deleted.', __('category')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('category')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('category')));
        }

        return $this->redirect(['action' => 'index']);
    }

}
