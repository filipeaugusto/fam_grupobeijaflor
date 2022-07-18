<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderEvolutionsFixture
 */
class OrderEvolutionsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'order_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'order_status_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_start' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'date_end' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_order_evolutions_orders1_idx' => ['type' => 'index', 'columns' => ['order_id'], 'length' => []],
            'fk_order_evolutions_order_status1_idx' => ['type' => 'index', 'columns' => ['order_status_id'], 'length' => []],
            'fk_order_evolutions_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_order_evolutions_orders1' => ['type' => 'foreign', 'columns' => ['order_id'], 'references' => ['orders', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_order_evolutions_order_status1' => ['type' => 'foreign', 'columns' => ['order_status_id'], 'references' => ['order_status', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_order_evolutions_users1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'id' => 'b20189e7-dcde-45a0-a096-4cc7bbef88b5',
                'user_id' => '791b85ba-e4da-46f3-be30-ff078602a275',
                'order_id' => '34d2580b-2b01-4156-9c1f-7f0055fb6754',
                'order_status_id' => 'ceb2533a-d5db-445a-bb6c-ab95e02cf0e9',
                'date_start' => '2021-07-22 00:39:10',
                'date_end' => '2021-07-22 00:39:10',
                'created' => '2021-07-22 00:39:10',
                'modified' => '2021-07-22 00:39:10',
            ],
        ];
        parent::init();
    }
}
