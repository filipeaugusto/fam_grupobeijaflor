<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity
 *
 * @property string $id
 * @property string $partner_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $observations
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Partner $partner
 */
class Contact extends Entity
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
        'partner_id' => true,
        'name' => true,
        'email' => true,
        'phone' => true,
        'observations' => true,
        'created' => true,
        'modified' => true,
        'partner' => true,
    ];

    protected function _setPhone($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}
