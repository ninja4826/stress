<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PartVendorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PartVendorsTable Test Case
 */
class PartVendorsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.part_vendors',
        'app.parts',
        'app.manufacturers',
        'app.parts_manufacturers',
        'app.categories',
        'app.locations',
        'app.cost_centers',
        'app.purchase_orders',
        'app.parts_purchases',
        'app.vendors',
        'app.p_v_rate_histories',
        'app.p_v_rates',
        'app.part_price_histories',
        'app.part_transactions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PartVendors') ? [] : ['className' => 'App\Model\Table\PartVendorsTable'];
        $this->PartVendors = TableRegistry::get('PartVendors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PartVendors);

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
