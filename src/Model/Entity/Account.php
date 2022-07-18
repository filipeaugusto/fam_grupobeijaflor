<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Account Entity
 *
 * @property string $id
 * @property string $company_id
 * @property int $bank
 * @property string $agency
 * @property string $account
 * @property float $balance
 * @property string|null $details
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 */
class Account extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'company_id' => true,
        'bank' => true,
        'agency' => true,
        'account' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
    ];

    protected $_virtual = ['details', 'balance', 'status_emoji'];

    protected function _getDetails()
    {
        $model = '{0} - Bco: {1} Ag: {2} CC: {3}';
        if (isset($this->company->name)) {
            $details = __($model, $this->company->name, $this->bank, $this->agency, $this->account);
        } else if (isset($this->bank)) {
            $company = TableRegistry::getTableLocator()->get('Companies')->get($this->company_id)->get('name');
            $details = __($model, $company, $this->bank, $this->agency, $this->account);
        }
        return  $details ?? null;
    }

    protected function _getBalance()
    {
        if (isset($this->id)) {
            $input = $this->getBillings('input');
            $output = $this->getBillings('output');
            $total = $input->sumOf('value') - $output->sumOf('value');
        }
        return $total ?? 0;
    }

    protected function _getStatusEmoji()
    {
        if ($this->balance != 0) {
            $status = 'bi bi-emoji-smile text-success';
            if ($this->balance < 0) {
                $status = 'bi bi-emoji-frown text-danger';
            }
        }
        return $status ?? 'bi bi-emoji-neutral text-secondary';
    }

    /**
     * @param string $type
     * @return \Cake\ORM\Query
     */
    protected function getBillings(string $type = 'control'): \Cake\ORM\Query
    {
        return TableRegistry::getTableLocator()->get('Billings')
            ->find('all')
            ->where([
                'type' => $type,
                'account_id' => $this->id,
                'confirmation' => 1,
                'removed' => 0,
            ]);
    }


}
