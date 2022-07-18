<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Order Entity
 *
 * @property string $id
 * @property string $company_id
 * @property string $partner_id
 * @property string $user_id
 * @property string $order_status_id
 * @property string|null $address_id
 * @property string|null $billing_id
 * @property \Cake\I18n\FrozenTime $delivery_date
 * @property string|null $observations
 * @property string|null $archive
 * @property float $total_order
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Partner $partner
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\OrderStatus $order_status
 * @property \App\Model\Entity\Address $address
 * @property \App\Model\Entity\Billing $billing
 * @property \App\Model\Entity\OrderEvolution[] $order_evolutions
 * @property \App\Model\Entity\OrderProduct[] $order_products
 */
class Order extends Entity
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
        'order_status_id' => true,
        'address_id' => true,
        'billing_id' => true,
        'delivery_date' => true,
        'observations' => true,
        'archive' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'partner' => true,
        'user' => true,
        'order_status' => true,
        'address' => true,
        'billing' => true,
        'order_evolutions' => true,
        'order_products' => true,
    ];

    protected $_virtual = ['move_next', 'move_previous', 'quantity_items', 'existing_items', 'quantity_products', 'total_order'];

    protected function _getMoveNext(): bool
    {
        try {
            if ($this->order_status === null) {
                throw new \Exception('Order status is not defined');
            }
            return TableRegistry::getTableLocator()->get('OrderStatus')
                    ->next($this->order_status) !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function _getMovePrevious(): bool
    {
        try {
            if ($this->order_status === null) {
                throw new \Exception('Order status is not defined');
            }
            return TableRegistry::getTableLocator()->get('OrderStatus')
                    ->previous($this->order_status) !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function _getMoveLast(): bool
    {
        try {
            $last = TableRegistry::getTableLocator()->get('OrderStatus')
                    ->last();

            return $last->id !== $this->order_status_id;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return int
     */
    protected function _getQuantityItems(): int
    {
        if (isset($this->id)) {
            $cartItems = $this->getOrderProducts();
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
            $cartItems = $this->getOrderProducts();
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
            $cartItems = $this->getOrderProducts();
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
            $cartItems = $this->getOrderProducts();
            $total = $cartItems->sumOf('total_amount');
        }
        return $total ?? 0;
    }

    /**
     * @return \Cake\ORM\Query
     */
    protected function getOrderProducts(): \Cake\ORM\Query
    {
        return TableRegistry::getTableLocator()->get('OrderProducts')
            ->find('all')
            ->where([
                'order_id' => $this->id,
                'removed' => 0
            ]);
    }

}
