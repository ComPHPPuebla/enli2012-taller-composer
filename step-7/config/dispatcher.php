<?php
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$routes = $options['routes'];

return simpleDispatcher(function(RouteCollector $router) use ($routes) {
    foreach ($routes as $route) {
        $router->addRoute($route['method'], $route['path'], $route['handler']);
    }
});
