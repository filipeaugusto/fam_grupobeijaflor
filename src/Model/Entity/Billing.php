<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Table\BillingsTable;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Billing Entity
 *
 * @property string $id
 * @property string $company_id
 * @property string|null $parent_id
 * @property string|null $expense_category_id
 * @property string|null $model
 * @property string|null $foreing_key
 * @property string|null $partner_id
 * @property string|null $user_id
 * @property string|null $created_user_id
 * @property string|null $account_id
 * @property string|null $invoice_number
 * @property \Cake\I18n\FrozenDate|null $deadline
 * @property string $description
 * @property string $value
 * @property string $history_value
 * @property string $type
 * @property string $limit_deadline
 * @property bool|null $automatic
 * @property bool|null $authorization
 * @property string|null $authorization_user_id
 * @property \Cake\I18n\FrozenTime|null $authorization_date
 * @property bool|null $is_loan
 * @property bool|null $confirmation
 * @property string|null $confirmation_user_id
 * @property \Cake\I18n\FrozenTime|null $confirmation_date
 * @property bool|null $conference_final
 * @property string|null $conference_final_user_id
 * @property \Cake\I18n\FrozenTime|null $conference_final_date
 * @property bool|null $removed
 * @property string|null $removed_user_id
 * @property \Cake\I18n\FrozenTime|null $removed_date
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\User $created_user
 * @property \App\Model\Entity\Partner $partner
 * @property \App\Model\Entity\User $confirmation_user
 * @property \App\Model\Entity\User $removed_user
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\ParentBilling $parent_billing
 * @property \App\Model\Entity\ChildBilling[] $child_billings
 */
class Billing extends Entity
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
        'model' => true,
        'foreing_key' => true,
        'partner_id' => true,
        'user_id' => true,
        'created_user_id' => true,
        'account_id' => true,
        'expense_category_id' => true,
        'deadline' => true,
        'description' => true,
        'value' => true,
        'history_value' => true,
        'type' => true,
        'invoice_number' => true,
        'automatic' => true,
        'authorization' => true,
        'authorization_user_id' => true,
        'authorization_date' => true,
        'confirmation' => true,
        'confirmation_user_id' => true,
        'confirmation_date' => true,
        'removed' => true,
        'removed_user_id' => true,
        'removed_date' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'user' => true,
        'created_user' => true,
        'partner' => true,
        'orders' => true,
        'parent_billings' => true,
        'child_billings' => true,
    ];

    protected $_virtual = ['status_emoji', 'is_loan'];

    /**
     * @return string
     */
    protected function _getStatusEmoji(): string
    {
        if ($this->confirmation === false) {
            $status = 'bi bi-emoji-neutral text-secondary';
            if ($this->deadline !== null && $this->deadline->lte(new FrozenTime())) {
                $status = 'bi bi-emoji-frown text-danger';
            }
        }
        return $status ?? 'bi bi-emoji-smile text-success';
    }

    /**
     * @return bool
     */
    protected function _getIsLoan(): bool
    {
        return $this->model === 'Partners'
            && $this->type === BillingsTable::INPUT
            && $this->parent_id !== null;
    }
}
