<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity
 *
 * @property string $id
 * @property string|null $parent_id
 * @property string $name
 * @property string $document
 * @property string|null $logo
 * @property string|null $phone
 * @property string|null $information
 * @property int|null $lft
 * @property int|null $rght
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company $parent_company
 * @property \App\Model\Entity\Billing[] $billings
 * @property \App\Model\Entity\CheckControl[] $check_controls
 * @property \App\Model\Entity\Company[] $child_companies
 * @property \App\Model\Entity\FileImport[] $file_imports
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\ShoppingCart[] $shopping_carts
 * @property \App\Model\Entity\User[] $users
 */
class Company extends Entity
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
        'parent_id' => true,
        'name' => true,
        'document' => true,
        'logo' => true,
        'phone' => true,
        'information' => true,
        'lft' => true,
        'rght' => true,
        'created' => true,
        'modified' => true,
        'parent_company' => true,
        'billings' => true,
        'check_controls' => true,
        'child_companies' => true,
        'file_imports' => true,
        'orders' => true,
        'payments' => true,
        'shopping_carts' => true,
        'users' => true,
    ];

    protected function _setDocument($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    protected function _setPhone($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}
