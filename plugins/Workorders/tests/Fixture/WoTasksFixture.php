<?php
namespace Workorders\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WoTasksFixture
 *
 */
class WoTasksFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'workorder_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'staff_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'task_status_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'task_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'workorder_id' => ['type' => 'index', 'columns' => ['workorder_id'], 'length' => []],
            'staff_id' => ['type' => 'index', 'columns' => ['staff_id'], 'length' => []],
            'task_status_id' => ['type' => 'index', 'columns' => ['task_status_id'], 'length' => []],
            'task_id' => ['type' => 'index', 'columns' => ['task_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'wo_tasks_ibfk_1' => ['type' => 'foreign', 'columns' => ['workorder_id'], 'references' => ['workorders', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'wo_tasks_ibfk_2' => ['type' => 'foreign', 'columns' => ['staff_id'], 'references' => ['staffs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'wo_tasks_ibfk_3' => ['type' => 'foreign', 'columns' => ['task_status_id'], 'references' => ['task_statuses', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'wo_tasks_ibfk_4' => ['type' => 'foreign', 'columns' => ['task_id'], 'references' => ['tasks', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'workorder_id' => 1,
            'staff_id' => 1,
            'task_status_id' => 1,
            'task_id' => 1
        ],
    ];
}
