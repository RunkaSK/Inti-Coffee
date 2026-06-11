<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    volverAtras();
}

$nombre = trim($_POST['nombre_completo'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';
$confirmarPassword = $_POST['confirmar_password'] ?? '';

if ($nombre === '' || $correo === '' || $password === '' || $confirmarPassword === '') {
    guardarMensajeFlash('error', 'Completa todos los campos para registrarte.');
    volverAtras();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    guardarMensajeFlash('error', 'Ingresa un correo valido.');
    volverAtras();
}

if (strlen($password) < 6) {
    guardarMensajeFlash('error', 'La contrasena debe tener al menos 6 caracteres.');
    volverAtras();
}

if ($password !== $confirmarPassword) {
    guardarMensajeFlash('error', 'Las contrasenas no coinciden.');
    volverAtras();
}

try {
    $pdo = obtenerConexion();
    $stmt = $pdo->prepare('INSERT INTO usuarios (nombre_completo, correo, password_hash, rol) VALUES (:nombre, :correo, :password_hash, :rol)');
    $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ':rol' => 'cliente',
    ]);

    $_SESSION['usuario'] = [
        'id' => (int) $pdo->lastInsertId(),
        'nombre' => $nombre,
        'correo' => $correo,
        'rol' => 'cliente',
    ];

    guardarMensajeFlash('success', 'Cuenta creada correctamente.');
    header('Location: menu.php');
    exit;
} catch (PDOException $e) {
    guardarMensajeFlash('error', $e->getCode() === '23000' ? 'Ese correo ya esta registrado.' : 'No se pudo registrar el usuario.');
}

volverAtras();
?>