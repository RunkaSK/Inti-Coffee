<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    volverAtras();
}

$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if ($correo === '' || $password === '') {
    guardarMensajeFlash('error', 'Ingresa tu correo y contrasena.');
    volverAtras();
}

$stmt = obtenerConexion()->prepare('SELECT id, nombre_completo, correo, password_hash, rol FROM usuarios WHERE correo = :correo LIMIT 1');
$stmt->execute([':correo' => $correo]);
$usuario = $stmt->fetch();

if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
    guardarMensajeFlash('error', 'Correo o contrasena incorrectos.');
    volverAtras();
}

$_SESSION['usuario'] = [
    'id' => (int) $usuario['id'],
    'nombre' => $usuario['nombre_completo'],
    'correo' => $usuario['correo'],
    'rol' => $usuario['rol'],
];

guardarMensajeFlash('success', 'Sesion iniciada correctamente.');
header('Location: ' . ($usuario['rol'] === 'negocio' ? 'negocio.php' : 'menu.php'));
exit;
?>