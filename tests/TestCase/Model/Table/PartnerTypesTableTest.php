<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PartnerTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PartnerTypesTable Test Case
 */
class PartnerTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PartnerTypesTable
     */
    protected $PartnerTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PartnerTypes',
        'app.Partners',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PartnerTypes') ? [] : ['className' => PartnerTypesTable::class];
        $this->PartnerTypes = $this->getTableLocator()->get('PartnerTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PartnerTypes);

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
