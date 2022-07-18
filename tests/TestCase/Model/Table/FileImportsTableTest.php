<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FileImportsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FileImportsTable Test Case
 */
class FileImportsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FileImportsTable
     */
    protected $FileImports;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.FileImports',
        'app.Companies',
        'app.CheckControls',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FileImports') ? [] : ['className' => FileImportsTable::class];
        $this->FileImports = $this->getTableLocator()->get('FileImports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->FileImports);

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
