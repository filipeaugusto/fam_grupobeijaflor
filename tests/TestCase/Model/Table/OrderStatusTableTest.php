<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderStatusTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderStatusTable Test Case
 */
class OrderStatusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderStatusTable
     */
    protected $OrderStatus;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderStatus',
        'app.OrderEvolutions',
        'app.Orders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderStatus') ? [] : ['className' => OrderStatusTable::class];
        $this->OrderStatus = $this->getTableLocator()->get('OrderStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderStatus);

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
