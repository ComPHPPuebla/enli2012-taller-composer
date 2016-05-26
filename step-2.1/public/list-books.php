<?php
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
    <title>Catálogo de libros</title>
    <meta charset="utf8">
</head>
<body>
<table>
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
</body>
</html>
