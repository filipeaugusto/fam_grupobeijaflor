<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderStatus Entity
 *
 * @property string $id
 * @property string|null $parent_id
 * @property string $name
 * @property string $background_color
 * @property string $font_color
 * @property string $type
 * @property bool $active
 * @property int|null $lft
 * @property int|null $rght
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\OrderStatus $parent_order_status
 * @property \App\Model\Entity\OrderEvolution[] $order_evolutions
 * @property \App\Model\Entity\OrderStatus[] $child_order_status
 * @property \App\Model\Entity\Order[] $orders
 */
class OrderStatus extends Entity
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
        'background_color' => true,
        'font_color' => true,
        'active' => true,
        'type' => true,
        'lft' => true,
        'rght' => true,
        'created' => true,
        'modified' => true,
        'parent_order_status' => true,
        'order_evolutions' => true,
        'child_order_status' => true,
        'orders' => true,
    ];
}
