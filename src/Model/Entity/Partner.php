<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Partner Entity
 *
 * @property string $id
 * @property string $partner_type_id
 * @property string|null $expense_category_id
 * @property string $name
 * @property string $document
 * @property string|null $image
 * @property float $credit_line
 * @property float $open_credit_line
 * @property string|null $observations
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\PartnerType $partner_type
 * @property \App\Model\Entity\CheckControl[] $check_controls
 * @property \App\Model\Entity\Contact[] $contacts
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Address[] $addresses
 * @property \App\Model\Entity\ShoppingCart[] $shopping_carts
 * @property \App\Model\Entity\Category[] $categories
 */
class Partner extends Entity
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
        'partner_type_id' => true,
        'expense_category_id' => true,
        'name' => true,
        'document' => true,
        'image' => true,
        'credit_line' => true,
        'observations' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'partner_type' => true,
        'check_controls' => true,
        'contacts' => true,
        'orders' => true,
        'shopping_carts' => true,
        'categories' => true,
        'addresses' => true,
    ];

    protected $_virtual = ['open_credit_line'];

    protected function _getOpenCreditLine(): float
    {
        if (isset($this->id)) {
            $result = TableRegistry::getTableLocator()->get('Billings')
                ->find('all')
                ->where([
                    'model' => 'Partners',
                    'foreing_key' => $this->id,
                    'type' => 'input',
                    'removed' => false,
                    'confirmation' => false,
                ]);

            $total = $result->sumOf('value');
        }
        return $total ?? 0;
    }

    protected function _setDocument($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}
