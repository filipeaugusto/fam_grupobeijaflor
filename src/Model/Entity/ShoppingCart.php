<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * ShoppingCart Entity
 *
 * @property string $id
 * @property string $company_id
 * @property string $partner_id
 * @property string $user_id
 * @property string|null $address_id
 * @property int $quantity_items
 * @property array $existing_items
 * @property float $total_order
 * @property \Cake\I18n\FrozenTime $delivery_date
 * @property string|null $observations
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Partner $partner
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Address $address
 * @property \App\Model\Entity\ShoppingCartItem[] $shopping_cart_items
 */
class ShoppingCart extends Entity
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
        'partner_id' => true,
        'user_id' => true,
        'address_id' => true,
        'delivery_date' => true,
        'observations' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'partner' => true,
        'user' => true,
        'address' => true,
        'shopping_cart_items' => true,
    ];

    protected $_virtual = ['quantity_items', 'existing_items', 'quantity_products', 'total_order'];

    /**
     * @return int
     */
    protected function _getQuantityItems(): int
    {
        if (isset($this->id)) {
            $cartItems = $this->getCartItems();
            $quantity = (int) $cartItems->sumOf('amount');

        }
        return $quantity ?? 0;
    }

    /**
     * @return array
     */
    protected function _getExistingItems(): array
    {
        if (isset($this->id)) {
            $cartItems = $this->getCartItems();
            $ids = $cartItems->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'product_id'
                ])
                ->toArray();
        }
        return $ids ?? [];
    }


    /**
     * @return int
     */
    protected function _getQuantityProducts(): int
    {
        if (isset($this->id)) {
            $cartItems = $this->getCartItems();
            $quantity = $cartItems->count();
        }
        return $quantity ?? 0;
    }

    /**
     * @return float
     */
    protected function _getTotalOrder(): float
    {
        if (isset($this->id)) {
            $cartItems = $this->getCartItems();
            $total = $cartItems->sumOf('total_amount');
        }
        return $total ?? 0;
    }

    /**
     * @return \Cake\ORM\Query
     */
    protected function getCartItems(): \Cake\ORM\Query
    {
        return TableRegistry::getTableLocator()->get('ShoppingCartItems')
            ->find('all')
            ->where([
                'shopping_cart_id' => $this->id
            ]);
    }
}
