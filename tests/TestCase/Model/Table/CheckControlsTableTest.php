<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CheckControlsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CheckControlsTable Test Case
 */
class CheckControlsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CheckControlsTable
     */
    protected $CheckControls;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CheckControls',
        'app.Companies',
        'app.FileImports',
        'app.Partners',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CheckControls') ? [] : ['className' => CheckControlsTable::class];
        $this->CheckControls = $this->getTableLocator()->get('CheckControls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CheckControls);

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
