<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

$environment = new Dotenv(__DIR__);
$environment->load();
$environment->required(['DSN', 'USERNAME', 'PASSWORD']);

$request = ServerRequestFactory::fromGlobals();

try {
    $adapter = new Adapter([
        'driver' => 'Pdo_Mysql',
        'database' => getenv('DATABASE'),
        'username' => getenv('USERNAME'),
        'password' => getenv('PASSWORD'),
    ]);
    $booksTable = new TableGateway('book', $adapter);

    $bookId = (int) $request->getQueryParams()['id'];
    $books = $booksTable->select(function (Select $select) use ($bookId) {
        $select
            ->from(['book' => 'b'])
            ->columns(['b.title', 'a.name AS author'])
            ->join(
                ['author' => 'a'],
                'b.author_id = a.author_id'
            )
            ->where(['b.book_id' => $bookId])
        ;
    });

    //Setup the view Layer
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
    $view = new Twig_Environment($loader, [
        'cache' => __DIR__ . '/var/cache',
        'strict_variables' => true,
        'debug' => true,
    ]);
    $response = new HtmlResponse($view->render('show.html.twig', [
        'book' => $book,
    ]));
    $emitter = new SapiEmitter();
    $emitter->emit($response);

} catch (PDOException $e) {
    error_log("PDO Exception: \n{$e}\n");
    http_response_code(500);
}
