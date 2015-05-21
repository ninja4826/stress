<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class ViewController extends AppController {
    public function view($id = null) {
        if (is_null($id)) {
            return;
        }
        
        // TODO: ADD MORE STUFF TO CREATE MODULAR VIEW
    }
}