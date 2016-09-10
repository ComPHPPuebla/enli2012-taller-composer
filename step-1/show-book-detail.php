<?php
/**
 * PHP version 7
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
$dsn = 'mysql:host=phppuebla_db;dbname=book_store';
$user = 'bstore_user';
$password = 'bstore_us3r';
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
} catch (PDOException $e) {
    error_log("PDO Exception: \n{$e}\n");
    http_response_code(500);
    die;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $book['title'] ?></title>
    <link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous"
    >
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
    </script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js">
    </script>
    <![endif]-->
</head>
<body>
<div class="container">
    <article class="row">
        <h1>Detalles del libro</h1>
        <dl>
            <dt>Título</dt>
            <dd><?= $book['title'] ?></dd>
            <dt>Autor</dt>
            <dd><?= $book['author'] ?></dd>
        </dl>
        <p>
            <a href="list-books.php">Volver a la lista</a>
        </p>
    </article>
</div>
<script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
    integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
    crossorigin="anonymous"
></script>
</body>
</html>
