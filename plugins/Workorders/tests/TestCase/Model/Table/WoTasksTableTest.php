<?php
namespace Workorders\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Workorders\Model\Table\WoTasksTable;

/**
 * Workorders\Model\Table\WoTasksTable Test Case
 */
class WoTasksTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'WoTasks' => 'plugin.workorders.wo_tasks',
        'Workorders' => 'plugin.workorders.workorders',
        'WoStatuses' => 'plugin.workorders.wo_statuses',
        'WoTypes' => 'plugin.workorders.wo_types',
        'Pms' => 'plugin.workorders.pms',
        'Reqs' => 'plugin.workorders.reqs',
        'Permissions' => 'plugin.workorders.permissions',
        'WoUpdateHistories' => 'plugin.workorders.wo_update_histories',
        'Staffs' => 'plugin.workorders.staffs',
        'TaskStatuses' => 'plugin.workorders.task_statuses',
        'Tasks' => 'plugin.workorders.tasks',
        'TaskTypes' => 'plugin.workorders.task_types',
        'WoTaskUpdateHistories' => 'plugin.workorders.wo_task_update_histories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WoTasks') ? [] : ['className' => 'Workorders\Model\Table\WoTasksTable'];
        $this->WoTasks = TableRegistry::get('WoTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WoTasks);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
