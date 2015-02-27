<?php
namespace Workorders\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Workorders\Model\Table\WorkordersTable;

/**
 * Workorders\Model\Table\WorkordersTable Test Case
 */
class WorkordersTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Workorders' => 'plugin.workorders.workorders',
        'WoStatuses' => 'plugin.workorders.wo_statuses',
        'WoTypes' => 'plugin.workorders.wo_types',
        'Pms' => 'plugin.workorders.pms',
        'Reqs' => 'plugin.workorders.reqs',
        'Permissions' => 'plugin.workorders.permissions',
        'WoTasks' => 'plugin.workorders.wo_tasks',
        'WoUpdateHistories' => 'plugin.workorders.wo_update_histories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Workorders') ? [] : ['className' => 'Workorders\Model\Table\WorkordersTable'];
        $this->Workorders = TableRegistry::get('Workorders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Workorders);

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
