<?php
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
    <dl>
        <dt>Título</dt>
        <dd><?= $book['title'] ?></dd>
        <dt>Autor</dt>
        <dd><?= $book['author'] ?></dd>
    </dl>
    <p>
        <a href="list-books.php">Volver a la lista</a>
    </p>
</body>
</html>
