<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Table Controller
 *
 * @property \App\Model\Table\TableTable $Table
 */
class TableController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->loadComponent('API');
    }
}
