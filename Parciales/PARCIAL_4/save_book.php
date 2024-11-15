<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user']['id'])) {
    echo 'Error: usuario no autenticado.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO libros_guardados (user_id, google_books_id, titulo, autor, imagen_portada, fecha_guardado) VALUES (?, ?, ?, ?, ?, NOW())');
    $stmt->execute([
        $_SESSION['user']['id'], // user_id ahora debería estar definido
        $_POST['google_books_id'],
        $_POST['title'],
        $_POST['author'],
        $_POST['thumbnail']
    ]);

    echo 'Libro guardado en tu biblioteca personal.';
    header('Location: my_books.php');
}
?>
