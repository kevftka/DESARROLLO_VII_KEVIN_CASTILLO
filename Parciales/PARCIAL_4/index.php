<?php
session_start();
include 'config.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Cerrar sesión
    session_destroy();
    header('Location: index.php');
    exit;
}

// Verifica si el usuario ya está autenticado
if (isset($_SESSION['user'])) {
    // Si está autenticado, muestra enlaces a las funcionalidades
    echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['user']['name']) . "</h2>";
    echo "<p><a href='search.php'>Buscar Libros</a></p>";
    echo "<p><a href='my_books.php'>Ver mi Biblioteca</a></p>";
    echo "<p><a href='index.php?action=logout'>Cerrar sesión</a></p>";
} else {
    // Si no está autenticado, muestra el botón de inicio de sesión con Google
    $googleLoginUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
        'client_id' => CLIENT_ID,
        'redirect_uri' => REDIRECT_URI,
        'response_type' => 'code',
        'scope' => 'openid email profile'
    ]);

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a tu Biblioteca Personal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido a tu Biblioteca Personal</h2>
        <a href="login.php" class="button">Iniciar Sesión</a>
    </div>
</body>
</html>


