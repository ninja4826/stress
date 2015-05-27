<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

class PartsPurchaseController extends AppController {
    
    public function change() {
        $this->loadComponent('API');
        $info = $this->API->get_info('parts', ['search' => false]);
        $info['results'] = $this->API->search(['Parts' => []])['Parts'];
        $this->set(compact('info'));
    }
}