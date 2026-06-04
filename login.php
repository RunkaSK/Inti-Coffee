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

$pdo = obtenerConexion();
$stmt = $pdo->prepare('SELECT id, nombre_completo, correo, password_hash FROM usuarios WHERE correo = :correo LIMIT 1');
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
];

guardarMensajeFlash('success', 'Sesion iniciada correctamente.');
volverAtras();
?>
