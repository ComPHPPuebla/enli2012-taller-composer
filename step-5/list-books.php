<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;

$environment = new Dotenv(__DIR__);
$environment->load();
$environment->required(['DATABASE', 'USERNAME', 'PASSWORD']);

try {
    $adapter = new Adapter([
        'driver' => 'Pdo_Mysql',
        'database' => getenv('DATABASE'),
        'username' => getenv('USERNAME'),
        'password' => getenv('PASSWORD'),
    ]);
    $booksTable = new TableGateway('book', $adapter);
    $books = $booksTable->select();

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
