<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderProduct Entity
 *
 * @property string $id
 * @property string $order_id
 * @property string $product_id
 * @property string $sale_price
 * @property string $sale_unit
 * @property int $amount
 * @property bool|null $removed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Product $product
 */
class OrderProduct extends Entity
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
        'order_id' => true,
        'product_id' => true,
        'sale_price' => true,
        'sale_unit' => true,
        'amount' => true,
        'removed' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'product' => true,
    ];

    protected $_virtual = ['total_amount'];

    /**
     * @return float
     */
    protected function _getTotalAmount(): float
    {
        if (isset($this->sale_price) && isset($this->amount)) {
            $total = $this->sale_price * $this->amount;
        }
        return $total ?? 0;
    }
}
