<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CheckControlsFixture
 */
class CheckControlsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'company_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'file_import_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'partner_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'document' => ['type' => 'char', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'bank' => ['type' => 'char', 'length' => 5, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'agency' => ['type' => 'char', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'account' => ['type' => 'char', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'number' => ['type' => 'char', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'value' => ['type' => 'decimal', 'length' => 9, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'deadline' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'confirmation' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'confirmation_user_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'confirmation_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'destination' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'destination_user_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'destination_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_check_controls_users1_idx' => ['type' => 'index', 'columns' => ['confirmation_user_id'], 'length' => []],
            'fk_check_controls_users2_idx' => ['type' => 'index', 'columns' => ['destination_user_id'], 'length' => []],
            'fk_check_controls_partners1_idx' => ['type' => 'index', 'columns' => ['partner_id'], 'length' => []],
            'fk_check_controls_file_imports1_idx' => ['type' => 'index', 'columns' => ['file_import_id'], 'length' => []],
            'fk_check_controls_companies1_idx' => ['type' => 'index', 'columns' => ['company_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_check_controls_companies1' => ['type' => 'foreign', 'columns' => ['company_id'], 'references' => ['companies', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_check_controls_file_imports1' => ['type' => 'foreign', 'columns' => ['file_import_id'], 'references' => ['file_imports', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_check_controls_partners1' => ['type' => 'foreign', 'columns' => ['partner_id'], 'references' => ['partners', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_check_controls_users1' => ['type' => 'foreign', 'columns' => ['confirmation_user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_check_controls_users2' => ['type' => 'foreign', 'columns' => ['destination_user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '59fb67fd-d630-4dac-a375-22fd5e43c05b',
                'company_id' => '1f374790-9cf3-49a5-aa57-a5795f53b6ca',
                'file_import_id' => 'd84c71d6-95ec-46e3-97bd-5c5f14d5803e',
                'partner_id' => '2317e25d-4ee2-49cc-b89e-40accd597c0d',
                'document' => '',
                'bank' => '',
                'agency' => '',
                'account' => '',
                'number' => '',
                'value' => 1.5,
                'deadline' => '2021-07-22',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'confirmation' => 1,
                'confirmation_user_id' => '01ca4b08-e688-47b3-b07c-36687a9bb8dd',
                'confirmation_date' => '2021-07-22 00:39:09',
                'destination' => 1,
                'destination_user_id' => '94f150b6-ad18-4bda-b394-ef33a2e247b6',
                'destination_date' => '2021-07-22 00:39:09',
                'created' => '2021-07-22 00:39:09',
                'modified' => '2021-07-22 00:39:09',
            ],
        ];
        parent::init();
    }
}
