<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PVRatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PVRatesTable Test Case
 */
class PVRatesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'PVRates' => 'app.p_v_rates',
        'PVRateHistories' => 'app.p_v_rate_histories',
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
        $config = TableRegistry::exists('PVRates') ? [] : ['className' => 'App\Model\Table\PVRatesTable'];
        $this->PVRates = TableRegistry::get('PVRates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PVRates);

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
