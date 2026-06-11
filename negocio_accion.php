<?php
require_once __DIR__ . '/conexion.php';
requerirNegocio();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: negocio.php');
    exit;
}

$accion = $_POST['accion'] ?? '';
$pdo = obtenerConexion();

if ($accion === 'guardar') {
    $id = (int) ($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = (float) ($_POST['precio'] ?? 0);
    $stock = max(0, (int) ($_POST['stock'] ?? 0));
    $imagen = trim($_POST['imagen'] ?? '');
    $activo = isset($_POST['activo']) ? 1 : 0;

    if ($nombre === '' || $categoria === '' || $precio <= 0) {
        guardarMensajeFlash('error', 'Completa nombre, categoria y precio valido.');
        header('Location: negocio.php' . ($id ? '?editar=' . $id : ''));
        exit;
    }

    if ($id > 0) {
        $stmt = $pdo->prepare('UPDATE productos SET nombre = :nombre, categoria = :categoria, descripcion = :descripcion, precio = :precio, imagen = :imagen, stock = :stock, activo = :activo WHERE id = :id');
        $stmt->execute([
            ':nombre' => $nombre,
            ':categoria' => $categoria,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':imagen' => $imagen,
            ':stock' => $stock,
            ':activo' => $activo,
            ':id' => $id,
        ]);
        guardarMensajeFlash('success', 'Producto actualizado.');
    } else {
        $stmt = $pdo->prepare('INSERT INTO productos (nombre, categoria, descripcion, precio, imagen, stock, activo) VALUES (:nombre, :categoria, :descripcion, :precio, :imagen, :stock, :activo)');
        $stmt->execute([
            ':nombre' => $nombre,
            ':categoria' => $categoria,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':imagen' => $imagen,
            ':stock' => $stock,
            ':activo' => $activo,
        ]);
        guardarMensajeFlash('success', 'Producto creado.');
    }

    header('Location: negocio.php');
    exit;
}

if ($accion === 'eliminar') {
    $id = (int) ($_POST['id'] ?? 0);
    $stmt = $pdo->prepare('DELETE FROM productos WHERE id = :id');
    $stmt->execute([':id' => $id]);
    guardarMensajeFlash('success', 'Producto eliminado.');
    header('Location: negocio.php');
    exit;
}

guardarMensajeFlash('error', 'Accion no valida.');
header('Location: negocio.php');
exit;
?>