<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property string $id
 * @property string|null $parent_id
 * @property string $name
 * @property string|null $image
 * @property int|null $lft
 * @property int|null $rght
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Category[] $categories
 * @property \App\Model\Entity\Product[] $products
 * @property \App\Model\Entity\Partner[] $partners
 */
class Category extends Entity
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
        'image' => true,
        'lft' => true,
        'rght' => true,
        'created' => true,
        'modified' => true,
        'categories' => true,
        'products' => true,
        'partners' => true,
    ];
}
