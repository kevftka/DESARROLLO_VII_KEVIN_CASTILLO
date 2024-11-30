<form method="GET" action="search.php">
    <label for="query">Buscar libros:</label>
    <input type="text" name="query" id="query" required>
    <button type="submit">Buscar</button>
</form>

<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['query'])) {
    $query = urlencode($_GET['query']);
    $url = "https://www.googleapis.com/books/v1/volumes?q={$query}";

    // Realiza la solicitud
    $response = file_get_contents($url);
    $books = json_decode($response, true);

    if ($books['totalItems'] > 0) {
        echo '<h2>Resultados de búsqueda:</h2>';
        foreach ($books['items'] as $book) {
            $title = $book['volumeInfo']['title'] ?? 'Sin título';
            $author = $book['volumeInfo']['authors'][0] ?? 'Autor desconocido';
            $thumbnail = $book['volumeInfo']['imageLinks']['thumbnail'] ?? '';

            echo "<div>";
            echo "<img src='{$thumbnail}' alt='Portada'>";
            echo "<h3>{$title}</h3>";
            echo "<p>Autor: {$author}</p>";
            echo "<form method='POST' action='save_book.php'>";
            echo "<input type='hidden' name='google_books_id' value='{$book['id']}'>";
            echo "<input type='hidden' name='title' value='{$title}'>";
            echo "<input type='hidden' name='author' value='{$author}'>";
            echo "<input type='hidden' name='thumbnail' value='{$thumbnail}'>";
            echo "<button type='submit'>Guardar en mi biblioteca</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo 'No se encontraron resultados.';
    }
}

