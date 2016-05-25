<?php
use FastRoute\RouteCollector;

$routes = $options['routes'];

return FastRoute\simpleDispatcher(function(RouteCollector $router) use ($routes) {
    foreach ($routes as $route) {
        $router->addRoute($route['method'], $route['path'], $route['handler']);
    }
});
