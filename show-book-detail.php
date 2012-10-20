<?php
$dsn = 'mysql:host=localhost;dbname=digit2012';
$user = 'digit2012_user';
$password = 'digit2012_us3r';
try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}
$bookId = $_GET['id'];
$sql = 'SELECT b.title, a.name AS author '
     . 'FROM book b INNER JOIN author a '
     . 'ON b.author_id = a.author_id '
     . 'WHERE book_id = ?';
$statement = $conn->prepare($sql);
$statement->execute(array($bookId));
$book = $statement->fetch(PDO::FETCH_ASSOC);
?>
<dl>
    <dt>Título</dt>
    <dd><?php echo $book['title'] ?></dd>
    <dt>Autor</dt>
    <dd><?php echo $book['author'] ?></dd>
</dl>
<p>
    <a href="list-books.php">Volver a la lista</a>
</p>