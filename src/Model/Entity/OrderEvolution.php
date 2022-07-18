<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderEvolution Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $order_id
 * @property string $order_status_id
 * @property \Cake\I18n\FrozenTime $date_start
 * @property \Cake\I18n\FrozenTime|null $date_end
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\OrderStatus $order_status
 */
class OrderEvolution extends Entity
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
        'user_id' => true,
        'order_id' => true,
        'order_status_id' => true,
        'date_start' => true,
        'date_end' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'order' => true,
        'order_status' => true,
    ];
}
