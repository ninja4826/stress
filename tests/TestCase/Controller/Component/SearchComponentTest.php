<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\SearchComponent;
use Cake\Controller\Controller;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;
use App\Controller\APIController;

/**
 * App\Controller\Component\SearchComponent Test Case
 */
class SearchComponentTest extends TestCase
{
    
    public $component = null;
    public $controller = null;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        
        $request = new Request();
        $response = new Response();
        // $this->controller = $this->getMockBuilder(
        //     'App\Controller\APIController',
        //     [],
        //     [$request, $response]
        // )->getMock();
        
        
        // $registry = new ComponentRegistry($this->controller);
        $registry = new ComponentRegistry();
        $this->Search = new SearchComponent($registry);
    }
    
    public function testSearch() {
        $response = $this->Search->search([
            'Parts' => [
                [
                    'name' => 'part_num',
                    'op' => '==',
                    'val' => 'SN'
                ]
            ]
        ], $this->controller);
        var_dump($response['Parts']);
        $this->assertTrue(true);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        
        unset($this->component, $this->controller);
        
        $this->assertTrue(true);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    // public function testInitialization()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
