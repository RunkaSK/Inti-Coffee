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

if ($password !== $confirmarPassword) {
    guardarMensajeFlash('error', 'Las contrasenas no coinciden.');
    volverAtras();
}

try {
    $pdo = obtenerConexion();
    $stmt = $pdo->prepare('INSERT INTO usuarios (nombre_completo, correo, password_hash) VALUES (:nombre, :correo, :password_hash)');
    $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
    ]);

    $_SESSION['usuario'] = [
        'id' => (int) $pdo->lastInsertId(),
        'nombre' => $nombre,
        'correo' => $correo,
    ];

    guardarMensajeFlash('success', 'Cuenta creada correctamente.');
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        guardarMensajeFlash('error', 'Ese correo ya esta registrado.');
    } else {
        guardarMensajeFlash('error', 'No se pudo registrar el usuario.');
    }
}

volverAtras();
?>
