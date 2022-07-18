<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Admin Controller
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $result = $this->Authentication->getResult();

        if ($result->isValid()) {

            if ($this->getAuthentication('active') !== true) {
                $this->redirect(['controller' => 'users', 'action' => 'logout']);
            }
            if (TableRegistry::getTableLocator()->get('Users')->get($this->getAuthentication('id'))->confirmed !== true && !in_array($this->getRequest()->getParam('action'), ['confirmed', 'resetPassword'])) {
                $this->redirect(['controller' => 'users', 'action' => 'confirmed', $this->getAuthentication('id')]);
            }

            if ($this->getRequest()->getSession()->check('Config.company') !== true) {

                $listOfCompanies = TableRegistry::getTableLocator()->get('Companies')
                    ->find('treeList', ['spacer' => '--', 'limit' => 500])
                    ->innerJoinWith('Users', function (Query $query) use ($result) {
                        return $query->where([
                            'user_id' => $result->getData()['id']
                        ]);
                    })
                    ->toArray();

                $this->getRequest()->getSession()->write('Config.companies', $listOfCompanies);

                $this->setCompanyID(current(array_keys($listOfCompanies)));
            }
        }

        $listOfCompanies = $this->getRequest()->getSession()->read('Config.companies');

        $this->set(compact('listOfCompanies'));

    }

    public function getAuthentication(?string $key)
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            return is_null($key) ? $result->getData() : $result->getData()[$key];
        }

        return null;
    }

    public function export()
    {
        $data = $this->{$this->modelClass}->find('search', ['search' => $this->request->getQueryParams()]);
        $this->set(compact('data'));
        $this->setResponse($this->getResponse()->withDownload(__('{0}-{1}.csv', date('YmdHi'), mb_strtolower($this->modelClass))));
        $this->viewBuilder()
            ->setClassName('CsvView.Csv')
            ->setOption('serialize', 'data');
    }

    public function move($id, $pos = 'up')
    {
        $node = $this->{$this->modelClass}->get($id);

        if ($pos === 'up') {
            $this->{$this->modelClass}->moveUp($node);
        } else {
            $this->{$this->modelClass}->moveDown($node);
        }

        $this->redirect(['action' => 'index']);
    }

    /**
     * @return mixed
     */
    public function getCompanyID()
    {
        return $this->getRequest()->getSession()->read('Config.company');
    }

    /**
     * @param mixed $companyID
     */
    public function setCompanyID($companyID): void
    {
        $this->getRequest()->getSession()->write('Config.company', $companyID);
    }


    public function getRelatedCompaniesIDs(): array
    {
        if ($this->getRequest()->getSession()->read('Config.all_companies')) {
            return array_keys($this->getRequest()->getSession()->read('Config.companies'));
        }

        return [$this->getRequest()->getSession()->read('Config.company')];

    }
}
