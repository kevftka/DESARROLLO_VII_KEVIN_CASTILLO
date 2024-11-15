<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM libros_guardados WHERE user_id = ?');
$stmt->execute([$_SESSION['user']['id']]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h2>Mi Biblioteca</h2>';

if (count($books) > 0) {
    foreach ($books as $book) {
        echo "<div>";
        echo "<img src='{$book['imagen_portada']}' alt='Portada'>";
        echo "<h3>{$book['titulo']}</h3>";
        echo "<p>Autor: {$book['autor']}</p>";
        echo "<p>Fecha guardado: {$book['fecha_guardado']}</p>";
        echo "<form method='POST' action='delete_book.php'>";
        echo "<input type='hidden' name='book_id' value='{$book['id']}'>";
        echo "<button type='submit'>Eliminar</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo '<p>No tienes libros guardados en tu biblioteca.</p>';
}


?>
