<?php
require '../vendor/autoload.php';

use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ComPHPPuebla\Dispatcher\Dispatcher;
use ComPHPPuebla\Dispatcher\NotFoundException;

//Configure your application
$builder = new ContainerBuilder();
$builder->addDefinitions(require '../configs/application.php');
$di = $builder->build();

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
} catch (Exception $e) {
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
