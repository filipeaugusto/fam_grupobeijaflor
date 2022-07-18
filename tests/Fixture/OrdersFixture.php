<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 */
class OrdersFixture extends TestFixture
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
        'order_status_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'address_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'billing_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'delivery_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'observations' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_orders_partners1_idx' => ['type' => 'index', 'columns' => ['partner_id'], 'length' => []],
            'fk_orders_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'fk_orders_order_status1_idx' => ['type' => 'index', 'columns' => ['order_status_id'], 'length' => []],
            'fk_orders_billings1_idx' => ['type' => 'index', 'columns' => ['billing_id'], 'length' => []],
            'fk_orders_companies1_idx' => ['type' => 'index', 'columns' => ['company_id'], 'length' => []],
            'fk_orders_addresses1_idx' => ['type' => 'index', 'columns' => ['address_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_orders_addresses1' => ['type' => 'foreign', 'columns' => ['address_id'], 'references' => ['addresses', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_orders_billings1' => ['type' => 'foreign', 'columns' => ['billing_id'], 'references' => ['billings', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_orders_companies1' => ['type' => 'foreign', 'columns' => ['company_id'], 'references' => ['companies', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_orders_order_status1' => ['type' => 'foreign', 'columns' => ['order_status_id'], 'references' => ['order_status', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_orders_partners1' => ['type' => 'foreign', 'columns' => ['partner_id'], 'references' => ['partners', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_orders_users1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'id' => '6ad30c5b-83d7-4017-ace2-100c8a11ba15',
                'company_id' => '81fbca66-e428-48d4-8a2b-d72e9c30ee4a',
                'partner_id' => 'd8203f24-9088-40de-ae17-ccbebb65d7bb',
                'user_id' => '609dd964-6a36-48ef-9b43-6b98e59589b4',
                'order_status_id' => '9d01dce1-eaa4-4a44-a521-f5c77b1f3679',
                'address_id' => '47229eb8-b1b4-4f57-9635-15e82c4e4511',
                'billing_id' => 'ed6afa14-fbb8-4680-85a0-ad4498d44497',
                'delivery_date' => '2021-07-22 00:39:10',
                'observations' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2021-07-22 00:39:10',
                'modified' => '2021-07-22 00:39:10',
            ],
        ];
        parent::init();
    }
}
