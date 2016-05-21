<?php
require __DIR__ . '/vendor/autoload.php';

$dsn = 'mysql:host=localhost;dbname=book_store';
$user = 'bstore_user';
$password = 'book_store_us3r';
try {
    $connection = new PDO($dsn, $user, $password, [
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
    $twig = new Twig_Environment($loader, [
        'cache' => __DIR__ . '/var/cache',
        'strict_variables' => true,
        'debug' => true,
    ]);
    echo $twig->render('show.html.twg', ['book' => $book]);
} catch (PDOException $e) {
    error_log("PDO Exception: \n{$e}\n");
    http_response_code(500);
}
