<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$environment = new Dotenv(__DIR__);
$environment->load();
$environment->required(['DSN', 'USERNAME', 'PASSWORD']);

try {
    $conn = new PDO(getenv('DSN'), getenv('USERNAME'), getenv('PASSWORD'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]);
    $statement = $conn->prepare('SELECT * FROM book');
    $statement->execute();
    $books = $statement->fetchAll();

    //Setup the view Layer
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
    $twig = new Twig_Environment($loader, [
        'cache' => __DIR__ . '/var/cache',
        'strict_variables' => true,
        'debug' => true,
    ]);
    echo $twig->render('list.html.twig', ['books' => $books]);
} catch (PDOException $e) {
    error_log("PDO Exception: \n{$e}\n");
    http_response_code(500);
}
