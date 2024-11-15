<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('DELETE FROM libros_guardados WHERE id = ? AND user_id = ?');
    $stmt->execute([$_POST['book_id'], $_SESSION['user']['id']]);

    echo 'Libro eliminado de tu biblioteca.';
    header('Location: my_books.php');
}
?>
