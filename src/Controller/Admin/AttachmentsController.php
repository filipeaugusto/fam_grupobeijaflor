<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Attachments Controller
 *
 * @property \App\Model\Table\AttachmentsTable $Attachments
 * @property \App\Controller\Component\UploadFilesComponent $UploadFiles
 * @method \App\Model\Entity\Attachment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttachmentsController extends AdminController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('UploadFiles', [
            'field' => 'archive',
            'pathname' => mb_strtolower($this->name),
            'prefix' => 'ATT_'
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $query = $this->Attachments
        ->find('search', [
            'search' => $this->request->getQueryParams()
        ]);

        $attachments = $this->paginate($query);

        $this->set(compact('attachments'));
    }

    /**
     * View method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $attachment = $this->Attachments->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('attachment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attachment = $this->Attachments->newEmptyEntity();
        if ($this->request->is('post')) {
            $attachment = $this->Attachments->patchEntity($attachment, $this->request->getData());
            $this->UploadFiles->upload($attachment);
            if ($this->Attachments->save($attachment)) {
                $this->Flash->success(__('The {0} has been saved.', __('attachment')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('attachment')));
        }
        $this->set(compact('attachment'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $attachment = $this->Attachments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attachment = $this->Attachments->patchEntity($attachment, $this->request->getData());
            $this->UploadFiles->upload($attachment);
            if ($this->Attachments->save($attachment)) {
                $this->Flash->success(__('The {0} has been saved.', __('attachment')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('attachment')));
        }
        $this->set(compact('attachment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attachment = $this->Attachments->get($id);
        $this->UploadFiles->remove($attachment);
        try {
            if ($this->Attachments->delete($attachment)) {
                $this->Flash->success(__('The {0} has been deleted.', __('attachment')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('attachment')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('attachment')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
