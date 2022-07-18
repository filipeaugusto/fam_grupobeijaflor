<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShoppingCartItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShoppingCartItemsTable Test Case
 */
class ShoppingCartItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShoppingCartItemsTable
     */
    protected $ShoppingCartItems;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ShoppingCartItems',
        'app.ShoppingCarts',
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
        $config = $this->getTableLocator()->exists('ShoppingCartItems') ? [] : ['className' => ShoppingCartItemsTable::class];
        $this->ShoppingCartItems = $this->getTableLocator()->get('ShoppingCartItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ShoppingCartItems);

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
