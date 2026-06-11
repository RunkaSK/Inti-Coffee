<?php
require_once __DIR__ . '/conexion.php';

$_SESSION = [];
session_destroy();
session_start();
guardarMensajeFlash('success', 'Sesion cerrada correctamente.');
header('Location: index.php');
exit;
?>