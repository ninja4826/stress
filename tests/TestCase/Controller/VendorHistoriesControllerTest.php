<?php
namespace App\Test\TestCase\Controller;

use App\Controller\VendorHistoriesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\VendorHistoriesController Test Case
 */
class VendorHistoriesControllerTest extends IntegrationTestCase
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
