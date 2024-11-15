<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'config.php';
include 'db_connection.php';

// Maneja el registro de nuevos usuarios
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashea la contraseña

    // Verifica si el usuario ya existe
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo 'Este correo ya está registrado. Por favor, inicia sesión.';
    } else {
        // Inserta el nuevo usuario en la base de datos
        $stmt = $pdo->prepare('INSERT INTO usuarios (email, password, nombre) VALUES (?, ?, ?)');
        $stmt->execute([$email, $password, 'Usuario sin nombre']);
        echo 'Registro exitoso. Por favor, inicia sesión.';
    }
}

// Maneja el inicio de sesión de usuarios
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica las credenciales
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Inicia la sesión
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['nombre']
        ];
        header('Location: index.php');
        exit;
    } else {
        echo 'Correo o contraseña incorrectos.';
    }
}

// URL para inicio de sesión con Google
$googleLoginUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
    'client_id' => CLIENT_ID,
    'redirect_uri' => REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'openid email profile'
]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión o Registrarse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión o Registrarse</h2>

        <!-- Formulario de Registro -->
        <h3>Registrarse</h3>
        <form method="POST" action="login.php">
            <label for="email">Correo:</label>
            <input type="email" name="email" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit" name="register">Registrarse</button>
        </form>

        <!-- Formulario de Inicio de Sesión -->
        <h3>Iniciar Sesión</h3>
        <form method="POST" action="login.php">
            <label for="email">Correo:</label>
            <input type="email" name="email" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit" name="login">Iniciar Sesión</button>
        </form>

        <!-- Botón de Inicio de Sesión con Google -->
        <p>O</p>
        <a href="<?php echo htmlspecialchars($googleLoginUrl); ?>" class="button">
            <button class="button">
                <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" viewBox="0 0 256 262">
                    <path fill="#4285F4" d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"></path>
                    <path fill="#34A853" d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"></path>
                    <path fill="#FBBC05" d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"></path>
                    <path fill="#EB4335" d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"></path>
                </svg>
                Continue with Google
            </button>
        </a>
    </div>
</body>
</html>
