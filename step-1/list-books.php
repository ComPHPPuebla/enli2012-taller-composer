<?php
$dsn = 'mysql:host=localhost;dbname=book_store';
$user = 'bstore_user';
$password = 'book_store_us3r';
try {
    $conn = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]);
    $statement = $conn->prepare('SELECT * FROM book');
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
