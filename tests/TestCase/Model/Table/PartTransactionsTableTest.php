<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PartTransactionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PartTransactionsTable Test Case
 */
class PartTransactionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'PartTransactions' => 'app.part_transactions',
        'PartVendors' => 'app.part_vendors',
        'Parts' => 'app.parts',
        'Manufacturers' => 'app.manufacturers',
        'Categories' => 'app.categories',
        'Locations' => 'app.locations',
        'CostCenters' => 'app.cost_centers',
        'Vendors' => 'app.vendors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PartTransactions') ? [] : ['className' => 'App\Model\Table\PartTransactionsTable'];
        $this->PartTransactions = TableRegistry::get('PartTransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PartTransactions);

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
