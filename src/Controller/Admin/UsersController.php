<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\User;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Hash;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Controller\Component\UploadFilesComponent $UploadFiles
 * @method User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AdminController
{

    use MailerAwareTrait;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('UploadFiles', [
            'field' => 'avatar',
            'pathname' => mb_strtolower($this->name),
            'prefix' => 'USER_'
        ]);
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users
            ->find('search', [
                'contain' => ['Rules', 'Addresses'],
                'search' => $this->request->getQueryParams(),
                'conditions' => [
//                    'Companies.id IN' => $this->getRelatedCompaniesIDs(),
                    'Users.active' => true
                ]
            ]);

        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Rules', 'Companies'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $this->renewToken($user);

            $this->UploadFiles->upload($user);
            if ($this->Users->save($user)) {

                $this->getMailer('User')->send('welcome', [$user]);

                $this->Flash->success(__('The {0} has been saved.', __('user')));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('user')));
        }
        $rules = $this->Users->Rules->find('list', ['limit' => 500]);
        $companies = $this->Users->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])
            ->where(['Companies.id IN' => $this->getRelatedCompaniesIDs()])
            ->orderAsc('lft');
        $this->set(compact('user', 'rules', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Companies'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $this->UploadFiles->upload($user);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The {0} has been saved.', __('user')));

                return $this->redirect(['action' => 'index', '?' => ['page' => $this->request->getQuery('page')]]);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', __('user')));
        }
        $rules = $this->Users->Rules->find('list', ['limit' => 500]);
        $companyIDS = Hash::extract($user->companies, '{n}.id');
        $companies = $this->Users->Companies->find('treeList', ['spacer' => '--', 'limit' => 500])
            ->where([
                'Companies.id IN' => array_merge($companyIDS, $this->getRelatedCompaniesIDs())
            ])
            ->orderAsc('lft');
        $this->set(compact('user', 'rules', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $user->active = false;
        $this->UploadFiles->remove($user);
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The {0} has been deleted.', __('user')));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', __('user')));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Reset method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function reset(string $id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->renewToken($user);

            if ($this->Users->save($user)) {
                $this->getMailer('User')->send('resetPassword', [$user]);

                $this->Flash->success(__('The {0} has been confirmed.', __('user')));
            } else {
                $this->Flash->error(__('The {0} could not be confirmed. Please, try again.', __('user')));
            }
        }
        return $this->redirect($this->referer());

    }


    /**
     * Confirmed method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function confirmed(string $id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->confirmed = true;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The {0} has been confirmed.', __('user')));

                return $this->redirect(['controller' => 'Pages', 'action' => 'dashboard']);
            }
            $this->Flash->error(__('The {0} could not be confirmed. Please, try again.', __('user')));
        }
        unset($user->password);
        $this->set(compact('user'));
    }

    /**
     * resetPassword method
     *
     * @param string|null $token
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function resetPassword(string $token = null)
    {
        try {
            $user = $this->Users->find('all')
                ->where([
                    'token' => $token,
                    'token_validity >=' => date('Y-m-d H:i:s')
                ])
                ->firstOrFail()
            ;

            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                $this->renewToken($user);
                $user->confirmed = true;
                if ($this->Users->save($user)) {
                    $this->Authentication->setIdentity($user);
                    $this->Flash->success(__('The {0} has been confirmed.', __('user')));

                    return $this->redirect(['controller' => 'Pages', 'action' => 'dashboard']);
                }
                $this->Flash->error(__('The {0} could not be confirmed. Please, try again.', __('user')));
            }
            unset($user->password);
            $this->set(compact('user'));
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('The {0} could not be confirmed. Please, try again.', __('user')));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

    }


    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect', ['controller' => 'Pages', 'action' => 'dashboard']);

            return $this->redirect($redirect);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->getRequest()->getSession()->delete('Config');
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * @param User $user
     */
    protected function renewToken(User $user): void
    {
        $user->confirmed = false;
        $user->token = Text::uuid();
        $user->token_validity = (new FrozenTime('now'))->addHours(12);
    }
}
