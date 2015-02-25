<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VendorHistoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VendorHistoriesTable Test Case
 */
class VendorHistoriesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'VendorHistories' => 'app.vendor_histories',
        'Vendors' => 'app.vendors',
        'Parts' => 'app.parts',
        'Manufacturers' => 'app.manufacturers',
        'Categories' => 'app.categories',
        'Locations' => 'app.locations',
        'CostCenters' => 'app.cost_centers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('VendorHistories') ? [] : ['className' => 'App\Model\Table\VendorHistoriesTable'];
        $this->VendorHistories = TableRegistry::get('VendorHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VendorHistories);

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
