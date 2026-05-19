<?php
/**
 * Procesar login
 */

// Iniciar sesión
session_start();

// Incluir configuración de usuarios
require_once 'config.php';

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        header('Location: login.html?error=campos_vacios');
        exit();
    }

    // Verificar si el usuario existe y la contraseña es correcta
    if (isset($usuarios_validos[$username]) && $usuarios_validos[$username] === $password) {
        // Login exitoso - crear sesión
        $_SESSION['usuario_logueado'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['rol'] = $roles_usuarios[$username];
        $_SESSION['tiempo_login'] = time();

        // Redirigir al dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Login fallido
        header('Location: login.html?error=credenciales_invalidas');
        exit();
    }
} else {
    // Si no es POST, redirigir al login
    header('Location: login.html');
    exit();
}
?>
