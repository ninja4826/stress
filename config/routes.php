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

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    //$routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    $routes->connect('/', ['controller' => 'Parts', 'action' => 'index']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `InflectedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('InflectedRoute');
});

Router::scope('/parts', function($routes) {
    $routes->connect('/', ['controller' => 'Parts', 'action' => 'index']);
    $routes->connect('/:id', ['controller' => 'Parts', 'action' => 'view'], ['id' => '\d+', 'pass' => ['id']]);
    $routes->connect('/:id/edit', ['controller' => 'Parts', 'action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
    
    
    $routes->connect('/:id/vendors/add', ['controller' => 'PartVendors'], ['id' => '\d+', 'pass' => ['id']]);
    
    $routes->scope('/vendors', ['controller' => 'PartVendors'], function($sub) {
        $sub->connect('/:id', ['action' => 'view'], ['id' => '\d+', 'pass' => ['id']]);
        $sub->connect('/:id/edit', ['action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
    });
});

Router::scope('/manufacturers', ['controller' => 'Manufacturers'], function($sub) {
    $sub->connect('/', ['action' => 'index']);
    $sub->connect('/add', ['action' => 'add']);
    $sub->connect('/:id', ['action' => 'view'], ['id' => '\d+', 'pass' => ['id']]);
    $sub->connect('/:id/edit', ['action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
});

Router::scope('/categories', ['controller' => 'Categories'], function($sub) {
    $sub->connect('/', ['action' => 'index']);
    $sub->connect('/:id', ['action' => 'view'], ['id' => '\d+', 'pass' => ['id']]);
    $sub->connect('/:id/edit', ['action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
});

Router::scope('/locations', ['controller' => 'Locations'], function($sub) {
    $sub->connect('/', ['action' => 'index']);
    $sub->connect('/add', ['action' => 'add']);
    $sub->connect('/:id', ['action' => 'view'], ['id' => '\d+', 'pass' => ['id']]);
    $sub->connect('/:id/edit', ['action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
});

Router::scope('/cost_centers', ['controller' => 'CostCenters'], function($sub) {
    $sub->connect('/', ['action' => 'index']);
    $sub->connect('/add', ['action' => 'add']);
    $sub->connect('/:id', ['action' => 'view'], ['id' => '\d+', 'pass' => ['id']]);
    $sub->connect('/:id/edit', ['action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
});

Router::scope('/vendors', ['controller' => 'Vendors'], function($sub) {
    $sub->connect('/', ['action' => 'index']);
    $sub->connect('/add', ['action' => 'add']);
    $sub->connect('/:id', ['action' => 'view'], ['id' => '\d+', 'pass' => ['id']]);
    $sub->connect('/:id/edit', ['action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
});


/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
