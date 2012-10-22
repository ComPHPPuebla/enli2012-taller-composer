<?php
$loader = require '../vendor/autoload.php';
$loader->add('', __DIR__ . '/../vendor/notorm'); //Autoload NotORM component

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Di\Config;
use Zend\Di\Di;

//Configure your app
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
	
	// Setup database access
	$notORM = $di->get('NotORM');
	switch($route->values['action']) {
		case 'list':
			$viewValues = array('books' => $notORM->book());
			$template = 'books/list.phtml';
			$responseCode = 200;
			break;
		case 'show':
			$bookId = $route->values['bookId'];
			$book = $notORM->book('book_id = ?', $bookId)->fetch();
        	$book['author'] = $notORM->author('author_id', $book['author_id'])
                         			 ->fetch();
			$viewValues = array('book' => $book);
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