<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PVRateHistoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PVRateHistoriesTable Test Case
 */
class PVRateHistoriesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'PVRateHistories' => 'app.p_v_rate_histories',
        'PVRates' => 'app.p_v_rates',
        'PartVendors' => 'app.part_vendors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PVRateHistories') ? [] : ['className' => 'App\Model\Table\PVRateHistoriesTable'];
        $this->PVRateHistories = TableRegistry::get('PVRateHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PVRateHistories);

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
