<?php
$loader = require '../vendor/autoload.php';
$loader->add('', __DIR__ . '/../vendor/notorm'); //Autoload NotORM 
$loader->add('ComPHPPuebla', __DIR__ . '/../library/'); // Autoload ComPHPPuebla

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Di\Config;
use Zend\Di\Di;
use ComPHPPuebla\Dispatcher\Dispatcher;
use ComPHPPuebla\Dispatcher\NotFoundException;

//Configure your application
$config = require '../configs/application.php';
$diConfig = new Config($config);
$di = new Di();
$diConfig->configure($di);

// Setup the router
$map = $di->get('Aura\Router\Map');

// Route the request
$request = Request::createFromGlobals();
$route = $map->match($request->getPathInfo(), $request->server->all());

//Dispatch the request
try {
    $dispatcher = new Dispatcher();
    $controller = $di->get($dispatcher->getControllerClass($route));
    $viewValues = $dispatcher->dispatch($controller, $route->values);
    $responseCode = 200;
    $template = $dispatcher->getTemplateName();
} catch (NotFoundException $nfe) {
    $viewValues = array();
    $responseCode = 404;
    $template = 'error/not-found.phtml';
} catch (\Exception $e) {
    $viewValues = array();
    $responseCode = 500;
    $template = 'error/error.phtml';
}

//Setup the view Layer
$twig = $di->get('Twig_Environment');
$content = $twig->render($template, $viewValues);

//Send the response
$response = new Response($content);
$response->setStatusCode(404);
$response->send();