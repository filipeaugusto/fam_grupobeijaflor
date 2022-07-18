<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property string $code
 * @property string|null $informations
 * @property string $store_stock
 * @property string $reserve_stock
 * @property string|null $history_price
 * @property bool|null $validate_stock
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\OrderProduct[] $order_products
 */
class Product extends Entity
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
        'category_id' => true,
        'name' => true,
        'code' => true,
        'information' => true,
        'store_stock' => true,
        'reserve_stock' => true,
        'history_price' => true,
        'validate_stock' => true,
        'created' => true,
        'modified' => true,
        'category' => true,
        'order_products' => true,
    ];
}
