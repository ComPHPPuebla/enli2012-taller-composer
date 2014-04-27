<?php
chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

use \Exception;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use \Zend\Di\Config;
use \Zend\Di\Di;
use \ComPHPPuebla\Dispatcher\Dispatcher;
use \ComPHPPuebla\Dispatcher\NotFoundException;

//Configure your application
$config = require 'configs/application.php';
$diConfig = new Config($config);
$di = new Di();
$diConfig->configure($di);

// Setup the router
$router = $di->get('Aura\Router\Map');

// Route the request
$request = Request::createFromGlobals();
$route = $router->match($request->getPathInfo(), $request->server->all());

//Dispatch the request
$viewValues = [];
try {
    $dispatcher = new Dispatcher();
    $controller = $di->get($dispatcher->getControllerClass($route));
    $viewValues = $dispatcher->dispatch($controller, $route->values);
    $responseCode = 200;
    $template = $dispatcher->getTemplateName();
} catch (NotFoundException $nfe) {
    $responseCode = 404;
    $template = 'error/not-found.html.twig';
} catch (Exception $e) {var_dump((string)$e);die();
    $responseCode = 500;
    $template = 'error/error.html.twig';
}

//Setup the view Layer
$twig = $di->get('Twig_Environment');
$content = $twig->render($template, $viewValues);

//Send the response
$response = new Response($content);
$response->setStatusCode($responseCode);
$response->send();
