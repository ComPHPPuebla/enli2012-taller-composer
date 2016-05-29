<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/environment.php';
require __DIR__ . '/../config/options.php';

try {
    /** @var PDO $connection */
    $connection = require __DIR__ . '/../config/connection.php';
    $bookId = (int) $_GET['id'];
    $sql = <<<SELECT
    SELECT
        b.title,
        a.name AS author
    FROM book b INNER JOIN author a
      ON b.author_id = a.author_id
    WHERE book_id = ?
SELECT;
    $statement = $connection->prepare($sql);
    $statement->execute([$bookId]);
    $book = $statement->fetch();
    /** @var Twig_Environment $view */
    $view = require __DIR__ . '/../config/view.php';
    echo $view->render('books/show.html.twig', ['book' => $book]);
} catch (Exception $e) {
    error_log("Exception: \n{$e}\n");
    http_response_code(500);
    echo $view->render('errors/500.html.twig');
}
