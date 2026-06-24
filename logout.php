<?php
require_once __DIR__ . '/conexion.php';
// Limpiar datos de sesión
$_SESSION = [];
// Destruir sesión activa
session_destroy();
// Reiniciar sesión (por seguridad para mensajes flash)
session_start();
// Mensaje de confirmación
guardarMensajeFlash('success', 'Sesion cerrada correctamente.');
// Redirigir al inicio
header('Location: index.php');
exit;
?>
