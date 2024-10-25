<?php
include 'config.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar credenciales
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header(header: "Location: dashboard.php");
        exit();
    } else {
        $error = "Nombre de usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar</title>
</head>
<body>
    <form method="post">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php if ($error) echo "<p>$error</p>"; ?>
</body>
</html>
