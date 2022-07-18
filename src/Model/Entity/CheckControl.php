<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * CheckControl Entity
 *
 * @property string $id
 * @property string $company_id
 * @property string|null $file_import_id
 * @property string|null $partner_id
 * @property string $document
 * @property string|null $details
 * @property string|null $status_emoji
 * @property string $bank
 * @property string $agency
 * @property string $account
 * @property string $number
 * @property string $value
 * @property \Cake\I18n\FrozenDate $deadline
 * @property \Cake\I18n\FrozenDate $deposit_date
 * @property string|null $description
 * @property bool|null $confirmation
 * @property string|null $confirmation_user_id
 * @property \Cake\I18n\FrozenTime|null $confirmation_date
 * @property bool|null $destination
 * @property string|null $destination_user_id
 * @property \Cake\I18n\FrozenTime|null $destination_date
 * @property string|null $model
 * @property string|null $foreing_key
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\FileImport $file_import
 * @property \App\Model\Entity\Partner $partner
 * @property \App\Model\Entity\User $user
 */
class CheckControl extends Entity
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
        'file_import_id' => true,
        'partner_id' => true,
        'document' => true,
        'bank' => true,
        'agency' => true,
        'account' => true,
        'number' => true,
        'value' => true,
        'deadline' => true,
        'deposit_date' => true,
        'description' => true,
        'confirmation' => true,
        'confirmation_user_id' => true,
        'confirmation_date' => true,
        'destination' => true,
        'destination_user_id' => true,
        'destination_date' => true,
        'model' => true,
        'foreing_key' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'file_import' => true,
        'partner' => true,
        'user' => true,
    ];

    protected $_virtual = ['details', 'status_emoji'];

    protected function _getDetails()
    {
        return isset($this->bank) ? __('Bco: {0} Ag: {1} CC: {2} Nr: {3}', $this->bank, $this->agency, $this->account, $this->number) : null;
    }

    protected function _getStatusEmoji()
    {
        if ($this->confirmation === false) {
            $status = 'bi bi-emoji-neutral text-secondary';
            if ($this->deadline->lte(new FrozenTime())) {
                $status = 'bi bi-emoji-frown text-danger';
            }
        }
        return $status ?? 'bi bi-emoji-smile text-success';
    }

    protected function _setDocument($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    protected function _setBank($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    protected function _setAgency($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    protected function _setAccount($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    protected function _setNumber($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

}
