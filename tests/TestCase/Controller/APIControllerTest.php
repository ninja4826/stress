<?php
namespace App\Test\TestCase\Controller;

use App\Controller\APIController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\APIController Test Case
 */
class APIControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        
    ];
    
    public function testSearch() {
        $json = json_encode([
            'parts' => 'blah'
        ]);
        $this->get('/api/search?q='.$json);
        
        $this->assertResponseOk();
        // $this->assertResponseContains('bl');
    }
}
