<?php
require_once __DIR__ . '/conexion.php';

session_destroy();
session_start();
guardarMensajeFlash('success', 'Sesion cerrada correctamente.');
header('Location: index.php');
exit;
?>
