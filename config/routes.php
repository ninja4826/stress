<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');

Router::connect('/', ['controller' => 'Modular', 'action' => 'index']);

Router::connect('/parts_change', ['controller' => 'PartsPurchase', 'action' => 'change']);

Router::scope('/api', ['controller' => 'API'], function($sub) {
    $sub->connect('/info/:model', ['action' => 'get_info'], ['pass' => ['model']]);
    $sub->connect('/save/:model', ['action' => 'save_entity'], ['pass' => ['model']]);
    $sub->connect('/type_search', ['action' => 'type_search']);
    $sub->connect('/url/:model/:id', ['action' => 'get_url'], ['pass' => ['model', 'id']]);
    $sub->connect('/purchase_order', ['action' => 'purchase_order']);
    $sub->connect('/:func', ['action' => 'main_func'], ['pass' => ['func']]);
});

// Router::scope('/search', ['controller' => 'Search'], function($sub) {
//     $sub->extensions(['json']);
//     $sub->connect('/search/results', ['controller' => 'Search', 'action' => 'format_results']);
//     $sub->connect('/', ['controller' => 'Search', 'action' => 'search']);
// });

Router::scope('/', ['controller' => 'Modular'], function ($routes) {
    $routes->connect('/:model', ['action' => 'index'], ['pass' => ['model']]);
    $routes->connect('/add/:model', ['action' => 'add'], ['pass' => ['model']]);
    $routes->connect('/view/:model/:id', ['action' => 'view'], ['id' => '\d+', 'pass' => ['model', 'id']]);
    $routes->connect('/edit/:model/:id', ['action' => 'edit'], ['id' => '\d+', 'pass' => ['model', 'id']]);
    
    $routes->fallbacks('InflectedRoute');
});
Plugin::routes();
