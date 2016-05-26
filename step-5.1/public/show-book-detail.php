<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/environment.php';
require __DIR__ . '/../config/options.php';

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

try {
    $request = ServerRequestFactory::fromGlobals();
    /** @var \ComPHPPuebla\BooksTable $books */
    $books = require __DIR__ . '/../config/books.php';
    $bookId = (int) $request->getQueryParams()['id'];
    $book = $books->with($bookId);
    /** @var Twig_Environment $view */
    $view = require __DIR__ . '/../config/view.php';
    $response = new HtmlResponse($view->render('books/show.html.twig', [
        'book' => $book,
    ]));
} catch (Exception $e) {
    error_log("Exception: \n{$e}\n");
    $response = new HtmlResponse($view->render('errors/500.html.twig'), 500);
} finally {
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
