
<?php
include 'config.php';
include 'style.css';

// si no esta autenticada se redigira 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $due_date = $_POST['due_date'];

    // Validacion de la tarea co
    if (!empty($title) && !empty($due_date) && strtotime($due_date) > time()) {
        $_SESSION['tasks'][] = [
            'title' => $title,
            'due_date' => $due_date
        ];
    } else {
        $error = "Porfavor completar los campos requeridos!";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablero</title>
</head>
<body class="dasboard" >
    <h1>PARCIAL_3 Bienvenvido <?php echo $_SESSION['username']; ?></h1>
    
    <button class="general-style-button">
        <a  href="logout.php">Salir</a>
    </button>
    <div class="task">
        <h2>Tareas</h2>
        <ul>
            <?php foreach ($_SESSION['tasks'] as $task): ?>
                <li><?php echo $task['title'] . " - " . $task['due_date']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <div class="task">
        <h2>Agregar </h2>
        <form method="post">
            <input type="text" name="title" placeholder="Título de la tarea" required>
            <input type="date" name="due_date" required>
            <button type="submit">subir</button>
        </form>    
    </div>        
    
    <?php if ($error) echo "<p>$error</p>"; ?>
</body>
</html>