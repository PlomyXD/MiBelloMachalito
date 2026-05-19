<?php
/**
 * Conexión a la Base de Datos
 * Base de datos: gatitos
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');      // Host del servidor
define('DB_USER', 'root');           // Usuario de MySQL
define('DB_PASS', '');               // Contraseña de MySQL (vacía por defecto en localhost)
define('DB_NAME', 'gatitos');        // Nombre de la base de datos

// Crear conexión
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establecer charset UTF-8
$conexion->set_charset("utf8mb4");

?>
