<?php
session_start();

// Array de usuarios predefinidos
$users = [
    'user1' => 'password1',
    'user2' => 'password2'
];

// Inicializar tareas en la sesión si no existen
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

