<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\UploadFilesComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\UploadFilesComponent Test Case
 */
class UploadFilesComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\UploadFilesComponent
     */
    protected $UploadFiles;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->UploadFiles = new UploadFilesComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UploadFiles);

        parent::tearDown();
    }
}
