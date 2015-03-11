<?php
namespace Workorders\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Workorders\Model\Table\WoStatusesTable;

/**
 * Workorders\Model\Table\WoStatusesTable Test Case
 */
class WoStatusesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'WoStatuses' => 'plugin.workorders.wo_statuses',
        'Workorders' => 'plugin.workorders.workorders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WoStatuses') ? [] : ['className' => 'Workorders\Model\Table\WoStatusesTable'];
        $this->WoStatuses = TableRegistry::get('WoStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WoStatuses);

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
}
