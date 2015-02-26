<?php
use Cake\Routing\Router;

Router::plugin('Workorders', function ($routes) {
    $routes->fallbacks();
});
