<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Address Entity
 *
 * @property string $id
 * @property string $model
 * @property string $foreing_key
 * @property string $name
 * @property string $address
 * @property int $number
 * @property string|null $complement
 * @property string $zip_code
 * @property string $neighbourhood
 * @property string $city
 * @property string $state
 * @property string $type
 * @property string $ibge
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\ShoppingCart[] $shopping_carts
 */
class Address extends Entity
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
        'model' => true,
        'foreing_key' => true,
        'name' => true,
        'address' => true,
        'number' => true,
        'complement' => true,
        'zip_code' => true,
        'neighbourhood' => true,
        'city' => true,
        'state' => true,
        'type' => true,
        'ibge' => true,
        'created' => true,
        'modified' => true,
        'orders' => true,
        'shopping_carts' => true,
    ];

    protected function _setZipCode($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}
