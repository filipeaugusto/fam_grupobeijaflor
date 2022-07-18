<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShoppingCartsFixture
 */
class ShoppingCartsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'company_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'partner_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'address_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'delivery_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'observations' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_shopping_carts_companies1_idx' => ['type' => 'index', 'columns' => ['company_id'], 'length' => []],
            'fk_shopping_carts_partners1_idx' => ['type' => 'index', 'columns' => ['partner_id'], 'length' => []],
            'fk_shopping_carts_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'fk_shopping_carts_addresses1_idx' => ['type' => 'index', 'columns' => ['address_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_shopping_carts_addresses1' => ['type' => 'foreign', 'columns' => ['address_id'], 'references' => ['addresses', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_shopping_carts_companies1' => ['type' => 'foreign', 'columns' => ['company_id'], 'references' => ['companies', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_shopping_carts_partners1' => ['type' => 'foreign', 'columns' => ['partner_id'], 'references' => ['partners', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_shopping_carts_users1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '075d3852-fe90-4678-826a-36964bb3955f',
                'company_id' => 'b4fe4811-6c0d-4ee4-a0cd-99dc16186333',
                'partner_id' => '27302d6c-495c-407d-bd17-59ef45ba1acb',
                'user_id' => '68a10228-0a46-4cf6-8ca7-4a376a3b6d7a',
                'address_id' => '86b11a82-9c91-4ca8-95b0-1f6ce5c924f4',
                'delivery_date' => '2021-07-22 00:39:11',
                'observations' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2021-07-22 00:39:11',
                'modified' => '2021-07-22 00:39:11',
            ],
        ];
        parent::init();
    }
}
