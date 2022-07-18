<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property string $id
 * @property int $rule_id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $phone
 * @property string|null $avatar
 * @property bool|null $active
 * @property bool|null $confirmed
 * @property string|null $token
 * @property \Cake\I18n\FrozenTime|null $token_validity
 * @property string|null $api_key
 * @property string|null $api_key_plain
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Rule $rule
 * @property \App\Model\Entity\Billing[] $billings
 * @property \App\Model\Entity\OrderEvolution[] $order_evolutions
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\ShoppingCart[] $shopping_carts
 * @property \App\Model\Entity\Company[] $companies
 * @property \App\Model\Entity\Address $address
 * @property \App\Model\Entity\Attachment[] $attachments
 */
class User extends Entity
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
        'rule_id' => true,
        'name' => true,
        'username' => true,
        'password' => true,
        'phone' => true,
        'avatar' => true,
        'active' => true,
        'confirmed' => true,
        'token' => true,
        'token_validity' => true,
        'api_key' => true,
        'api_key_plain' => true,
        'created' => true,
        'modified' => true,
        'rule' => true,
        'billings' => true,
        'order_evolutions' => true,
        'orders' => true,
        'shopping_carts' => true,
        'companies' => true,
        'address' => true,
        'attachments' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        'token',
    ];

    protected $_virtual = ['first_name'];

    // Add this method
    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }

    protected function _getFirstName()
    {
        return !is_null($this->name) ? current(explode(' ', $this->name)) : null;
    }
}
