<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    volverAtras('contacto.php');
}

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $correo === '' || $mensaje === '') {
    guardarMensajeFlash('error', 'Completa todos los campos del mensaje.');
    volverAtras('contacto.php');
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    guardarMensajeFlash('error', 'Ingresa un correo valido.');
    volverAtras('contacto.php');
}

$pdo = obtenerConexion();
$stmt = $pdo->prepare('INSERT INTO mensajes_contacto (nombre, correo, mensaje) VALUES (:nombre, :correo, :mensaje)');
$stmt->execute([
    ':nombre' => $nombre,
    ':correo' => $correo,
    ':mensaje' => $mensaje,
]);

guardarMensajeFlash('success', 'Mensaje enviado y guardado en la base de datos.');
volverAtras('contacto.php');
?>
