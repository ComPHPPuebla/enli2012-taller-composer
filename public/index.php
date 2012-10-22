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
	$content = '<p>La página que buscas no existe</p>';
    $response = new Response($content);
    $response->setStatusCode(404);
    $response->send();
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
				$books = $statement->fetchAll(PDO::FETCH_ASSOC);
			?>
				<table>
				    <tr>
				        <th>ID</th>
				        <th>Título</th>
				    </tr>
				<?php foreach($books as $book) : ?>
				    <tr>
				        <td>
				            <a href="/enli2012/public/books/show/<?php echo $book['book_id'] ?>">
				                Detalles
				            </a>
				        </td>
				        <td><?php echo $book['title'] ?></td>
				    <tr>
				<?php endforeach ?>
				</table>
			<?php 
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
				$book = $statement->fetch(PDO::FETCH_ASSOC);
			?>
				<dl>
				    <dt>Título</dt>
				    <dd><?php echo $book['title'] ?></dd>
				    <dt>Autor</dt>
				    <dd><?php echo $book['author'] ?></dd>
				</dl>
				<p>
				    <a href="/enli2012/public/books/list">Volver a la lista</a>
				</p>
			<?php 
				break;
			default:
				$content = '<p>La página que buscas no existe</p>';
			    $response = new Response($content);
			    $response->setStatusCode(404);
			    $response->send();
		}	
	} else {
		$content = '<p>La página que buscas no existe</p>';
	    $response = new Response($content);
	    $response->setStatusCode(404);
	    $response->send();
	}
}