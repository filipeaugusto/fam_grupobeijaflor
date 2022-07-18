<?php

namespace App\Controller\Admin;


use App\Controller\AppController;
use App\Controller\Utils\DashboardReturn;
use Cake\Datasource\ResultSetInterface;
use Cake\I18n\FrozenTime;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\BillingsTable $Billings
 * @property \App\Model\Table\CheckControlsTable $CheckControls
 */
class PagesController extends AdminController
{

    public function initialize(): void
    {
        $this->loadModel('Billings');
        $this->loadModel('CheckControls');

        parent::initialize();
    }

    /**
     *
     */
    public function dashboard(string $year = null, string $month = null)
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('m');

        $billing_monthly = $this->_getBillingsResults($year, $month);
        $billing_yearly = $this->_getBillingsResults($year);

        $check_monthly = $this->_getCheckResults($year, $month);
        $check_yearly = $this->_getCheckResults($year);

        $missedPayments = $this->_getMissedPayments();

//        dd($missedPayments);

        $title = __('Dashboard');

        $this->set(compact('title', 'billing_yearly', 'billing_monthly', 'check_yearly', 'check_monthly', 'missedPayments'));
    }

    protected function _getBillingsResults(string $year = null, string $month = null): DashboardReturn
    {
        $query = $this->Billings->find('all', [
            'conditions' => [
                'Billings.confirmation' => 1,
                'Billings.removed' => 0,
                'Billings.type NOT IN' => 'control',
                'Billings.company_id IN' => $this->getRelatedCompaniesIDs()
            ],
        ]);

        if (!is_null($year)) {
            $query->andWhere(['YEAR(deadline)' => $year]);
        }
        if (!is_null($month)) {
            $query->andWhere(['MONTH(deadline)' => $month]);
        }

        $input = (clone $query)
            ->andWhere(['type' => 'input'])
            ->sumOf('value');

        $output = (clone $query)
            ->andWhere(['type' => 'output'])
            ->sumOf('value');


//        dd($this->getRelatedCompaniesIDs(), $input, $output);

        return new DashboardReturn($input, $output);

    }

    protected function _getCheckResults(string $year = null, string $month = null): DashboardReturn
    {
        $query = $this->CheckControls->find('all', [
            'conditions' => [
                'CheckControls.company_id IN' => $this->getRelatedCompaniesIDs()
            ]
        ]);

        $waiting = (clone $query)
            ->andWhere(['confirmation' => false])
            ->andWhere(['deadline <=' => FrozenTime::now()])
            ->sumOf('value');

        if (!is_null($year)) {
            $query->andWhere(['YEAR(deadline)' => $year]);
        }
        if (!is_null($month)) {
            $query->andWhere(['MONTH(deadline)' => $month]);
        }

        $input = (clone $query)
            ->andWhere(['confirmation' => true])
            ->sumOf('value');

        $output = (clone $query)
            ->andWhere(['destination' => true])
            ->sumOf('value');

        $return = new DashboardReturn($input, $output);

        $return->setWaiting($waiting);

        return $return;

    }


    /**
     * @return ResultSetInterface
     */
    protected function _getMissedPayments(): ResultSetInterface
    {
        return $this->Billings
            ->find('missedPayments')
            ->andWhere([
                'Billings.company_id IN' => $this->getRelatedCompaniesIDs()
            ])
            ->orderAsc('Companies.lft')
            ->orderAsc('Billings.deadline')
            ->all();
    }

}
