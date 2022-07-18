<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderProductsFixture
 */
class OrderProductsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'order_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'product_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'sale_price' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '0.000', 'comment' => ''],
        'sale_unit' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '1.000', 'comment' => ''],
        'amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'removed' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_order_products_orders1_idx' => ['type' => 'index', 'columns' => ['order_id'], 'length' => []],
            'fk_order_products_products1_idx' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_order_products_orders1' => ['type' => 'foreign', 'columns' => ['order_id'], 'references' => ['orders', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_order_products_products1' => ['type' => 'foreign', 'columns' => ['product_id'], 'references' => ['products', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'id' => '4756ba76-cd02-40db-8f83-38ab474731a7',
                'order_id' => '2319d72c-3321-4a84-8c12-52cef06482f3',
                'product_id' => 'b31da9a4-b6ac-4f51-bb39-7f55cb526373',
                'sale_price' => 1.5,
                'sale_unit' => 1.5,
                'amount' => 1,
                'removed' => 1,
                'created' => '2021-07-22 00:39:10',
                'modified' => '2021-07-22 00:39:10',
            ],
        ];
        parent::init();
    }
}
