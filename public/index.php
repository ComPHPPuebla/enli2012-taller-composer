<?php
require '../vendor/autoload.php';

use Aura\Router\Map;
use Aura\Router\RouteFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Define your routes
$map = new Map(new RouteFactory());
// /books/list
$map->add('default', '/{:controller}/{:action}');
// /books/show/1
$map->add('detail', '/{:controller}/{:action}/{:bookId}');

// Route the request
$request = Request::createFromGlobals();
$route = $map->match($request->getPathInfo(), $request->server->all());

if (!$route) {
	$template = 'error/not-found.phtml';
    $responseCode = 404;
    $viewValues = array();
} else {
	if ('books' === $route->values['controller']) {
		switch($route->values['action']) {
			case 'list':
				$dsn = 'mysql:host=localhost;dbname=book_store';
				$user = 'bstore_user';
				$password = 'book_store_us3r';
				try {
				    $conn = new PDO($dsn, $user, $password);
				    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} catch (PDOException $e) {
				    echo $e->getMessage();
				    die();
				}
				$sql = 'SELECT * FROM book';
				$statement = $conn->prepare($sql);
				$statement->execute();
				$viewValues = array(
					'books' => $statement->fetchAll(PDO::FETCH_ASSOC)
				);
				$template = 'books/list.phtml';
				$responseCode = 200;
				break;
			case 'show':
				$dsn = 'mysql:host=localhost;dbname=book_store';
				$user = 'bstore_user';
				$password = 'book_store_us3r';
				try {
				    $conn = new PDO($dsn, $user, $password);
				    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} catch (PDOException $e) {
				    echo $e->getMessage();
				    die();
				}
				$bookId = $route->values['bookId'];
				$sql = 'SELECT b.title, a.name AS author '
				     . 'FROM book b INNER JOIN author a '
				     . 'ON b.author_id = a.author_id '
				     . 'WHERE book_id = ?';
				$statement = $conn->prepare($sql);
				$statement->execute(array($bookId));
				$viewValues = array(
					'book' => $statement->fetch(PDO::FETCH_ASSOC)
				);
				$template = 'books/show.phtml';
				$responseCode = 200;
				break;
			default:
				$content = '<p>La página que buscas no existe</p>';
				$template = 'error/not-found.phtml';
			    $responseCode = 404;
			    $viewValues = array();
		}	
	} else {
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