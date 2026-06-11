<?php
require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    volverAtras('menu.php');
}

$accion = $_POST['accion'] ?? '';
$productoId = (int) ($_POST['producto_id'] ?? 0);
$cantidad = max(1, (int) ($_POST['cantidad'] ?? 1));

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($accion === 'vaciar') {
    $_SESSION['carrito'] = [];
    guardarMensajeFlash('success', 'Carrito vaciado.');
    header('Location: carrito.php');
    exit;
}

if ($accion === 'comprar') {
    requerirLogin();
    $items = obtenerCarritoDetalle();
    if (!$items) {
        guardarMensajeFlash('error', 'Tu carrito esta vacio.');
        header('Location: carrito.php');
        exit;
    }

    $pdo = obtenerConexion();
    try {
        $pdo->beginTransaction();
        foreach ($items as $item) {
            $producto = obtenerProducto((int) $item['producto']['id']);
            if (!$producto || (int) $producto['stock'] < (int) $item['cantidad']) {
                throw new RuntimeException('Stock insuficiente para ' . ($producto['nombre'] ?? 'un producto'));
            }
            $stmt = $pdo->prepare('UPDATE productos SET stock = stock - :cantidad WHERE id = :id');
            $stmt->execute([
                ':cantidad' => (int) $item['cantidad'],
                ':id' => (int) $producto['id'],
            ]);
        }
        $pdo->commit();
        $_SESSION['carrito'] = [];
        guardarMensajeFlash('success', 'Pedido confirmado. El stock fue actualizado.');
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        guardarMensajeFlash('error', $e->getMessage());
    }

    header('Location: carrito.php');
    exit;
}

$producto = obtenerProducto($productoId);
if (!$producto || !$producto['activo']) {
    guardarMensajeFlash('error', 'Producto no encontrado.');
    volverAtras('menu.php');
}

$stock = (int) $producto['stock'];
if ($stock <= 0) {
    guardarMensajeFlash('error', 'Producto sin stock.');
    volverAtras('menu.php');
}

if ($accion === 'agregar') {
    $actual = (int) ($_SESSION['carrito'][$productoId] ?? 0);
    $_SESSION['carrito'][$productoId] = min($stock, $actual + $cantidad);
    guardarMensajeFlash('success', 'Producto agregado al carrito.');
    volverAtras('menu.php');
}

if ($accion === 'actualizar') {
    $_SESSION['carrito'][$productoId] = min($stock, $cantidad);
    guardarMensajeFlash('success', 'Cantidad actualizada.');
    header('Location: carrito.php');
    exit;
}

if ($accion === 'quitar') {
    unset($_SESSION['carrito'][$productoId]);
    guardarMensajeFlash('success', 'Producto retirado del carrito.');
    header('Location: carrito.php');
    exit;
}

guardarMensajeFlash('error', 'Accion no valida.');
volverAtras('menu.php');
?>