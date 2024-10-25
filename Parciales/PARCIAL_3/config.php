<?php
session_start();

// Array de usuarios predefinidos
$users = [
    'Kevftka' => '12345',
];

// Inicializar tareas en la sesión si no existen
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

