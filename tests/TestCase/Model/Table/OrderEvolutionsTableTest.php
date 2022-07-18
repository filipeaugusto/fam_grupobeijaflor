<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderEvolutionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderEvolutionsTable Test Case
 */
class OrderEvolutionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderEvolutionsTable
     */
    protected $OrderEvolutions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderEvolutions',
        'app.Users',
        'app.Orders',
        'app.OrderStatus',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderEvolutions') ? [] : ['className' => OrderEvolutionsTable::class];
        $this->OrderEvolutions = $this->getTableLocator()->get('OrderEvolutions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderEvolutions);

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
