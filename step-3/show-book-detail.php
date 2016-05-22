<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$environment = new Dotenv(__DIR__);
$environment->load();
$environment->required(['DSN', 'USERNAME', 'PASSWORD']);

try {
    $connection = new PDO(getenv('DSN'), getenv('USERNAME'), getenv('PASSWORD'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]);
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

    //Setup the view Layer
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
    $view = new Twig_Environment($loader, [
        'cache' => __DIR__ . '/var/cache',
        'strict_variables' => true,
        'debug' => true,
    ]);
    echo $view->render('show.html.twig', ['book' => $book]);
} catch (PDOException $e) {
    error_log("PDO Exception: \n{$e}\n");
    http_response_code(500);
}
