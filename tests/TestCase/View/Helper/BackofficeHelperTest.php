<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\BackofficeHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\BackofficeHelper Test Case
 */
class BackofficeHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\BackofficeHelper
     */
    protected $Backoffice;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Backoffice = new BackofficeHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Backoffice);

        parent::tearDown();
    }
}
