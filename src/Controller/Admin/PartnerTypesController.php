<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * PartnerTypes Controller
 *
 * @property \App\Model\Table\PartnerTypesTable $PartnerTypes
 * @method \App\Model\Entity\PartnerType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PartnerTypesController extends AdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $query = $this->PartnerTypes
        ->find('search', [
            'search' => $this->request->getQueryParams()
        ]);

        $partnerTypes = $this->paginate($query);

        $this->set(compact('partnerTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Partner Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $partnerType = $this->PartnerTypes->get($id, [
            'contain' => ['Partners'],
        ]);

        $this->set(compact('partnerType'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $partnerType = $this->PartnerTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $partnerType = $this->PartnerTypes->patchEntity($partnerType, $this->request->getData());
            if ($this->PartnerTypes->save($partnerType)) {
                $this->Flash->success(__('The {0} has been saved.', __('partner type')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('partner type')));
        }
        $this->set(compact('partnerType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Partner Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $partnerType = $this->PartnerTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $partnerType = $this->PartnerTypes->patchEntity($partnerType, $this->request->getData());
            if ($this->PartnerTypes->save($partnerType)) {
                $this->Flash->success(__('The {0} has been saved.', __('partner type')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('partner type')));
        }
        $this->set(compact('partnerType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Partner Type id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $partnerType = $this->PartnerTypes->get($id);
        try {
            if ($this->PartnerTypes->delete($partnerType)) {
                $this->Flash->success(__('The {0} has been deleted.', __('partner type')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('partner type')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('partner type')));
        }

        return $this->redirect(['action' => 'index']);
    }
}
