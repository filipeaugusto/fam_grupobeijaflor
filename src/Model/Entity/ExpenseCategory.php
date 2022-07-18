<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExpenseCategory Entity
 *
 * @property string $id
 * @property string $name
 * @property string|null $parent_id
 * @property int|null $level
 * @property int|null $lft
 * @property int|null $rght
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\ExpenseCategory $parent_expense_category
 * @property \App\Model\Entity\Billing[] $billings
 * @property \App\Model\Entity\ExpenseCategory[] $child_expense_categories
 * @property \App\Model\Entity\Payment[] $payments
 */
class ExpenseCategory extends Entity
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
        'name' => true,
        'parent_id' => true,
        'level' => true,
        'lft' => true,
        'rght' => true,
        'created' => true,
        'modified' => true,
        'parent_expense_category' => true,
        'billings' => true,
        'child_expense_categories' => true,
        'payments' => true,
    ];
}
