<?php
use Cake\Routing\Router;

Router::plugin('Workorder', function ($routes) {
    $routes->fallbacks();
});
