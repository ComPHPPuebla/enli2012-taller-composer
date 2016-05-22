<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;

$environment = new Dotenv(__DIR__);
$environment->load();
$environment->required(['DSN', 'USERNAME', 'PASSWORD']);

try {
    $connection = new PDO(getenv('DSN'), getenv('USERNAME'), getenv('PASSWORD'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]);
    $statement = $connection->prepare('SELECT * FROM book');
    $statement->execute();
    $books = $statement->fetchAll();

    //Setup the view Layer
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
    $view = new Twig_Environment($loader, [
        'cache' => __DIR__ . '/var/cache',
        'strict_variables' => true,
        'debug' => true,
    ]);

    $response = new HtmlResponse($view->render('list.html.twig', [
        'books' => $books,
    ]));
    $emitter = new SapiEmitter();
    $emitter->emit($response);

} catch (PDOException $e) {
    error_log("PDO Exception: \n{$e}\n");
    http_response_code(500);
}
