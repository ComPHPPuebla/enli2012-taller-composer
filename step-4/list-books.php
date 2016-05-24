<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/environment.php';
require __DIR__ . '/config/options.php';

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;

try {
    /** @var PDO $connection */
    $connection = require __DIR__ . '/config/connection.php';
    $statement = $connection->prepare('SELECT * FROM book');
    $statement->execute();
    $books = $statement->fetchAll();
    /** @var Twig_Environment $view */
    $view = require __DIR__ . '/config/view.php';
    $response = new HtmlResponse($view->render('books/list.html.twig', [
        'books' => $books,
    ]));
} catch (Exception $e) {
    error_log("Exception: \n{$e}\n");
    $response = new HtmlResponse($view->render('errors/500.html.twig'), 500);
} finally {
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
