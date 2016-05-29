<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$routes = $options['routes'];

return simpleDispatcher(function(RouteCollector $router) use ($routes) {
    foreach ($routes as $route) {
        $router->addRoute($route['method'], $route['path'], $route['handler']);
    }
});
