<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShoppingCartItemsFixture
 */
class ShoppingCartItemsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'shopping_cart_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'product_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'sale_price' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '0.000', 'comment' => ''],
        'sale_unit' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '1.000', 'comment' => ''],
        'amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_shopping_cart_items_shopping_carts1_idx' => ['type' => 'index', 'columns' => ['shopping_cart_id'], 'length' => []],
            'fk_shopping_cart_items_products1_idx' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_shopping_cart_items_products1' => ['type' => 'foreign', 'columns' => ['product_id'], 'references' => ['products', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_shopping_cart_items_shopping_carts1' => ['type' => 'foreign', 'columns' => ['shopping_cart_id'], 'references' => ['shopping_carts', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'id' => 'a5b92019-fad2-4554-accd-0a7a81f2a371',
                'shopping_cart_id' => 'eb237c6e-e13d-4c4a-be8c-d847139370fd',
                'product_id' => 'd1059eec-6403-43e3-9d60-f3ecc10f8afc',
                'sale_price' => 1.5,
                'sale_unit' => 1.5,
                'amount' => 1,
                'created' => '2021-07-22 00:42:11',
                'modified' => '2021-07-22 00:42:11',
            ],
        ];
        parent::init();
    }
}
