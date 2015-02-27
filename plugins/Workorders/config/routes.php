<?php
use Cake\Routing\Router;

Router::plugin('Workorders', ['path' => '/workorders'], function ($routes) {
    $routes->connect('/', ['controller' => 'Workorders', 'action' => 'index']);
    $routes->connect('/add', ['controller' => 'Workorders', 'action' => 'add']);
    $routes->connect('/:id', ['controller' => 'Workorders', 'action' => 'view'], ['id' => '\d+', 'pass' => ['id']]);
    $routes->connect('/:id/edit', ['controller' => 'Workorders', 'action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
    
    $routes->fallbacks();
});
