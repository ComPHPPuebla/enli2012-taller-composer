<?php
$loader = require '../vendor/autoload.php';
$loader->add('', __DIR__ . '/../vendor/notorm'); //Autoload NotORM component

use Aura\Router\Map;
use Aura\Router\RouteFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Define your routes
$routes = array(
	'/books' => array(
		'name_prefix' => 'composer.books.',
		'values' => array(
			'controller' => 'books', //Controller will default to books
		),
		'routes' => array(
			'list' => '/{:action}',
			'show' => '/{:action}/{:bookId}'
		)
	)
);
$factory = new RouteFactory();
$map = new Map($factory, $routes);

// Route the request
$request = Request::createFromGlobals();
$route = $map->match($request->getPathInfo(), $request->server->all());

if (!$route) {
	$template = 'error/not-found.phtml';
    $responseCode = 404;
    $viewValues = array();
} else {
	// Setup database access
	$dsn = 'mysql:host=localhost;dbname=digit2012';
	$user = 'digit2012_user';
	$password = 'digit2012_us3r';
	$pdo = new PDO($dsn, $user, $password);
	$notORM = new NotORM($pdo);
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
$loader = new Twig_Loader_Filesystem(__DIR__ . '/../views');
$twig = new Twig_Environment($loader, array(
	'cache' => __DIR__ . '/../views/cache',
));
$content = $twig->render($template, $viewValues);

//Send the response
$response = new Response($content);
$response->setStatusCode(404);
$response->send();