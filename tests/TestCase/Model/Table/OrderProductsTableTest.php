<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderProductsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderProductsTable Test Case
 */
class OrderProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderProductsTable
     */
    protected $OrderProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderProducts',
        'app.Orders',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderProducts') ? [] : ['className' => OrderProductsTable::class];
        $this->OrderProducts = $this->getTableLocator()->get('OrderProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderProducts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
