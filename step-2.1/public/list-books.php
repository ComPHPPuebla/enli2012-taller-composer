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
    $statement = $connection->prepare('SELECT * FROM book');
    $statement->execute();
    $books = $statement->fetchAll();
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
    <title>Catálogo de libros</title>
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
        <h1>Catálogo de libros</h1>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>ID</th>
                <th>Título</th>
            </tr>
            <?php foreach ($books as $book) : ?>
            <tr>
                <td>
                    <a href="show-book-detail.php?id=<?= $book['book_id'] ?>">
                        Detalles
                    </a>
                </td>
                <td><?= $book['title'] ?></td>
            <tr>
            <?php endforeach ?>
        </table>
    </article>
</div>
<script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
    integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
    crossorigin="anonymous"
></script>
</body>
</html>
