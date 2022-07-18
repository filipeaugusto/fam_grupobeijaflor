<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;

/**
 * FileImports Controller
 *
 * @property \App\Model\Table\FileImportsTable $FileImports
 * @property \App\Controller\Component\UploadFilesComponent $UploadFiles
 * @method \App\Model\Entity\FileImport[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FileImportsController extends AdminController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('UploadFiles', [
            'field' => 'archive',
            'pathname' => mb_strtolower($this->name),
            'prefix' => 'IMP_'
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->FileImports
            ->find('search', [
                'contain' => ['Companies'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
                    'FileImports.company_id IN' => $this->getRelatedCompaniesIDs()
                ]
            ]);

        $fileImports = $this->paginate($query);

        $this->set(compact('fileImports'));
    }

    /**
     * View method
     *
     * @param string|null $id File Import id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $fileImport = $this->FileImports->get($id, [
            'contain' => ['Companies', 'CheckControls'],
        ]);

        $this->set(compact('fileImport'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fileImport = $this->FileImports->newEmptyEntity();
        if ($this->request->is('post')) {
            $fileImport = $this->FileImports->patchEntity($fileImport, $this->request->getData());
            $this->UploadFiles->upload($fileImport);
            if ($this->FileImports->save($fileImport)) {
                $this->Flash->success(__('The {0} has been saved.', __('file import')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('file import')));
        }
        $companies = $this->FileImports->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);
        $this->set(compact('fileImport', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id File Import id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $fileImport = $this->FileImports->get($id, [
            'contain' => [],
        ]);
        if ($fileImport->finished) {
            $this->Flash->set(__('The {0} could not be edited.', __('file import')));
            return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fileImport = $this->FileImports->patchEntity($fileImport, $this->request->getData());
            $this->UploadFiles->upload($fileImport);
            if ($this->FileImports->save($fileImport)) {
                $this->Flash->success(__('The {0} has been saved.', __('file import')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('file import')));
        }
        $companies = $this->FileImports->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()]);
        $this->set(compact('fileImport', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id File Import id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fileImport = $this->FileImports->get($id);
        if ($fileImport->finished) {
            $this->Flash->set(__('The {0} could not be deleted.', __('file import')));
            return $this->redirect(['action' => 'index']);
        }
        try {
            $this->UploadFiles->remove($fileImport);
            if ($this->FileImports->delete($fileImport)) {
                $this->Flash->success(__('The {0} has been deleted.', __('file import')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('file import')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('file import')));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function process(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fileImport = $this->FileImports->get($id);

        $file = WWW_ROOT . 'files' . DS . strtolower($this->name) . DS . $fileImport->archive;

        $csv = array_map('str_getcsv', file($file));

        array_shift($csv);
//        array_pop($csv);

        array_walk($csv, function(&$a) use ($csv, $fileImport) {

            if (preg_match('/\//', $a[6])) {
                $date = explode('/', $a[6]);
                $a[6] = implode('-', array_reverse($date));
            }

            $a[7] = (float) str_replace(',', '.', str_replace('.', '', $a[7]));

            $a[] = $fileImport->company_id;
            $a[] = $fileImport->id;

            $a = array_combine([
                'document',
                'bank',
                'agency',
                'account',
                'number',
                'description',
                'deadline',
                'value',
                'company_id',
                'file_import_id'
            ], $a);
        });

        $checkControls = TableRegistry::getTableLocator()->get('CheckControls');

        $total = 0;

        foreach ($csv as $data) {
            try {
                $entity = $checkControls->newEntity($data);
                $checkControls->saveOrFail($entity);
                $total++;
            } catch (\Exception $e) {
            }
        }

        $fileImport->finished = true;
        $this->FileImports->save($fileImport);

        $this->Flash->success(__('The {0} has been process. Created {1}', __('file import'), $total));

        return $this->redirect(['action' => 'index']);

    }

}
