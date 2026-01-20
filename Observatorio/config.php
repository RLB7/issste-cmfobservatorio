<?php
$host = "localhost";
$user = "root";
$pass = "Ti080824";
$db   = "control_incidencias";

$conexion = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conexion->connect_errno) {
    error_log("Error de conexión ({$conexion->connect_errno}): {$conexion->connect_error}");
    die("No se pudo conectar a la base de datos.");
}

// Configurar charset
if (!$conexion->set_charset("utf8mb4")) {
    error_log("Error al configurar charset: " . $conexion->error);
}
?>

