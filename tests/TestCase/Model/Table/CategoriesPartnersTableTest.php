<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoriesPartnersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoriesPartnersTable Test Case
 */
class CategoriesPartnersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoriesPartnersTable
     */
    protected $CategoriesPartners;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CategoriesPartners',
        'app.Categories',
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
        $config = $this->getTableLocator()->exists('CategoriesPartners') ? [] : ['className' => CategoriesPartnersTable::class];
        $this->CategoriesPartners = $this->getTableLocator()->get('CategoriesPartners', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CategoriesPartners);

        parent::tearDown();
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
