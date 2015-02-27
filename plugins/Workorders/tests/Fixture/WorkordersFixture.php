<?php
namespace Workorders\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WorkordersFixture
 *
 */
class WorkordersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'date_received' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_required' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'expedite' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'description' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'location' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'date_signed' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'fixed_price' => ['type' => 'decimal', 'length' => 10, 'precision' => 0, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'date_promised' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'est_time' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'wo_status_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'wo_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'project_number' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'req_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'wo_req' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'wo_status_id' => ['type' => 'index', 'columns' => ['wo_status_id'], 'length' => []],
            'wo_type_id' => ['type' => 'index', 'columns' => ['wo_type_id'], 'length' => []],
            'pm_id' => ['type' => 'index', 'columns' => ['pm_id'], 'length' => []],
            'req_id' => ['type' => 'index', 'columns' => ['req_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'workorders_ibfk_1' => ['type' => 'foreign', 'columns' => ['wo_status_id'], 'references' => ['wo_statuses', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'workorders_ibfk_2' => ['type' => 'foreign', 'columns' => ['wo_type_id'], 'references' => ['wo_types', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'workorders_ibfk_3' => ['type' => 'foreign', 'columns' => ['pm_id'], 'references' => ['staffs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'workorders_ibfk_4' => ['type' => 'foreign', 'columns' => ['req_id'], 'references' => ['requestors', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'date_received' => '2015-02-27 11:28:03',
            'date_required' => '2015-02-27 11:28:03',
            'expedite' => 1,
            'description' => 'Lorem ipsum dolor sit amet',
            'location' => 'Lorem ipsum dolor sit amet',
            'date_signed' => '2015-02-27 11:28:03',
            'fixed_price' => '',
            'date_promised' => '2015-02-27 11:28:03',
            'est_time' => 'Lorem ipsum dolor sit amet',
            'wo_status_id' => 1,
            'wo_type_id' => 1,
            'project_number' => 1,
            'pm_id' => 1,
            'req_id' => 1,
            'wo_req' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
