<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property string $id
 * @property string|null $expense_category_id
 * @property string|null $partner_id
 * @property string $name
 * @property string $observations
 * @property boolean $repeat_value
 * @property string $value
 * @property int $pay_when
 * @property string $frequency
 * @property string $type
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Company[] $companies
 */
class Payment extends Entity
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
        'expense_category_id' => true,
        'partner_id' => true,
        'name' => true,
        'observations' => true,
        'repeat_value' => true,
        'value' => true,
        'pay_when' => true,
        'frequency' => true,
        'type' => true,
        'created' => true,
        'modified' => true,
        'companies' => true,
    ];
}
