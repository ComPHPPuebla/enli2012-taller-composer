<?php
$dsn = 'mysql:host=localhost;dbname=book_store';
$user = 'bstore_user';
$password = 'book_store_us3r';
try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}
$sql = 'SELECT * FROM book';
$statement = $conn->prepare($sql);
$statement->execute();
$books = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<table>
    <tr>
        <th>ID</th>
        <th>Título</th>
    </tr>
<?php foreach($books as $book) : ?>
    <tr>
        <td>
            <a href="show-book-detail.php?id=<?php echo $book['book_id'] ?>">
                Detalles
            </a>
        </td>
        <td><?php echo $book['title'] ?></td>
    <tr>
<?php endforeach ?>
</table>