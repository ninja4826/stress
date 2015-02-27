<?php
namespace Workorders\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WoTaskUpdateHistoriesFixture
 *
 */
class WoTaskUpdateHistoriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'wo_task_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'staff_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'update_type' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'date_modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'wo_task_id' => ['type' => 'index', 'columns' => ['wo_task_id'], 'length' => []],
            'staff_id' => ['type' => 'index', 'columns' => ['staff_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'wo_task_update_histories_ibfk_1' => ['type' => 'foreign', 'columns' => ['wo_task_id'], 'references' => ['wo_tasks', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'wo_task_update_histories_ibfk_2' => ['type' => 'foreign', 'columns' => ['staff_id'], 'references' => ['staffs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'wo_task_id' => 1,
            'staff_id' => 1,
            'update_type' => 'Lorem ipsum dolor sit amet',
            'date_modified' => '2015-02-27 11:28:40'
        ],
    ];
}
