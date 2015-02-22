<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PartTransactionsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\PartTransactionsController Test Case
 */
class PartTransactionsControllerTest extends IntegrationTestCase
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
        'Vendors' => 'app.vendors',
        'PVRateHistories' => 'app.p_v_rate_histories',
        'PVRates' => 'app.p_v_rates',
        'PartPriceHistories' => 'app.part_price_histories'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}