<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShoppingCartItem Entity
 *
 * @property string $id
 * @property string $shopping_cart_id
 * @property string $product_id
 * @property string $sale_price
 * @property string $sale_unit
 * @property int $amount
 * @property float $total_amount
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\ShoppingCart $shopping_cart
 * @property \App\Model\Entity\Product $product
 */
class ShoppingCartItem extends Entity
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
        'shopping_cart_id' => true,
        'product_id' => true,
        'sale_price' => true,
        'sale_unit' => true,
        'amount' => true,
        'created' => true,
        'modified' => true,
        'shopping_cart' => true,
        'product' => true,
    ];

    protected $_virtual = ['total_amount', 'status_emoji'];

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

    protected function _getStatusEmoji()
    {
        $status = 'bi bi-emoji-neutral text-secondary';
        if ($this->has('product') && $this->product->history_price > 0) {
            if ($this->sale_price > $this->product->history_price) {
                $status = 'bi bi-emoji-frown text-danger';
            } else if ($this->sale_price < $this->product->history_price) {
                $status = 'bi bi-emoji-smile text-success';
            }
        }
        return $status;
    }
}
