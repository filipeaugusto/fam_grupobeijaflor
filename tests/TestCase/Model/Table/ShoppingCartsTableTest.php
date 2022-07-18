<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShoppingCartsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShoppingCartsTable Test Case
 */
class ShoppingCartsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShoppingCartsTable
     */
    protected $ShoppingCarts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ShoppingCarts',
        'app.Companies',
        'app.Partners',
        'app.Users',
        'app.Addresses',
        'app.ShoppingCartItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ShoppingCarts') ? [] : ['className' => ShoppingCartsTable::class];
        $this->ShoppingCarts = $this->getTableLocator()->get('ShoppingCarts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ShoppingCarts);

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
