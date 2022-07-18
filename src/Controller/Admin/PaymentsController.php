<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Response;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AdminController
{
    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {
    $query = $this->Payments
        ->find('search', [
            'search' => $this->request->getQueryParams()
        ]);

        $payments = $this->paginate($query);

        $this->set(compact('payments'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => ['Companies'],
        ]);

        $this->set(compact('payment'));
    }

    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payment = $this->Payments->newEmptyEntity();
        if ($this->request->is('post')) {

            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The {0} has been saved.', __('payment')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('payment')));
        }
        $partners= $this->Payments->Partners->find('list', ['limit' => 500, 'order' => ['Partners.name' => 'ASC']]);
        $companies = $this->Payments->Companies->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['Companies.lft' => 'ASC']]);
        $expenseCategories = $this->Payments->ExpenseCategories->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['ExpenseCategories.lft' => 'ASC']]);
        $this->set(compact('payment', 'companies', 'expenseCategories', 'partners'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => ['Companies'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The {0} has been saved.', __('payment')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('payment')));
        }
        $partners= $this->Payments->Partners->find('list', ['limit' => 500, 'order' => ['Partners.name' => 'ASC']]);
        $companies = $this->Payments->Companies->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['Companies.lft' => 'ASC']]);
        $expenseCategories = $this->Payments->ExpenseCategories->find('treeList', ['spacer' => '--', 'limit' => 500, 'order' => ['ExpenseCategories.lft' => 'ASC']]);
        $this->set(compact('payment', 'companies', 'expenseCategories', 'partners'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        try {
            if ($this->Payments->delete($payment)) {
                $this->Flash->success(__('The {0} has been deleted.', __('payment')));
            } else {
                $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('payment')));
            }
        } catch (\Exception $exception) {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('payment')));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @return Response|null
     */
    public function generate(): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);

        if ($this->Payments->generate()->rowCount() > 0) {
            $this->Flash->success(__('The {0} has been generated.', __('payment')));
        } else {
            $this->Flash->error(__('The {0} could not be generated. Please, try again.', __('payment')));
        }

        $billings = $this->getTableLocator()->get('Billings');
        $billings->recover();

        return $this->redirect($this->referer());
    }
}
