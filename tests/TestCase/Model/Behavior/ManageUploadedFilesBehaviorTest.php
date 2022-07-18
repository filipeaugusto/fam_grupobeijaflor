<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\ManageUploadedFilesBehavior;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\ManageUploadedFilesBehavior Test Case
 */
class ManageUploadedFilesBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\ManageUploadedFilesBehavior
     */
    protected $ManageUploadedFiles;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $table = new Table();
        $this->ManageUploadedFiles = new ManageUploadedFilesBehavior($table);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ManageUploadedFiles);

        parent::tearDown();
    }
}
