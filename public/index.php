<?php
$loader = require '../vendor/autoload.php';
$loader->add('', __DIR__ . '/../vendor/notorm'); //Autoload NotORM 
$loader->add('ComPHPPuebla', __DIR__ . '/../library/'); // Autoload ComPHPPuebla

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Di\Config;
use Zend\Di\Di;

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

if (!$route) {
	$template = 'error/not-found.phtml';
    $responseCode = 404;
    $viewValues = array();
} else {
	
	// Get the controller and its dependencies
	$controller = ucfirst($route->values['controller']);
	$className = sprintf('ComPHPPuebla\Controller\%sController', $controller);
	$controller = $di->get($className);
	$controller->setParams($route->values);
	switch($route->values['action']) {
		case 'list':
			$viewValues = $controller->listAction();
			$template = 'books/list.phtml';
			$responseCode = 200;
			break;
		case 'show':
			$viewValues = $controller->showAction();
			$template = 'books/show.phtml';
			$responseCode = 200;
			break;
		default:
			$content = '<p>La página que buscas no existe</p>';
			$template = 'error/not-found.phtml';
			$responseCode = 404;
			$viewValues = array();
	}	
}

//Setup the view Layer
$twig = $di->get('Twig_Environment');
$content = $twig->render($template, $viewValues);

//Send the response
$response = new Response($content);
$response->setStatusCode(404);
$response->send();