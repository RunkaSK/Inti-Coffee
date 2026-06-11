<?php
require_once __DIR__ . '/conexion.php';
$producto = obtenerProducto((int) ($_GET['id'] ?? 0));
if (!$producto || !$producto['activo']) {
    guardarMensajeFlash('error', 'Producto no encontrado.');
    header('Location: menu.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($producto['nombre']); ?> - Inticoffee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php mostrarMensaje(); ?>
    <?php renderHeader('menu'); ?>
    <?php renderAuthModal(); ?>

    <main class="detail-page">
        <section class="product-detail">
            <img src="<?php echo e($producto['imagen'] ?: 'img/productos.png'); ?>" alt="<?php echo e($producto['nombre']); ?>">
            <div>
                <span class="detail-category"><?php echo e($producto['categoria']); ?></span>
                <h1><?php echo e($producto['nombre']); ?></h1>
                <p><?php echo e($producto['descripcion']); ?></p>
                <strong>S/ <?php echo number_format((float) $producto['precio'], 2); ?></strong>
                <span class="detail-stock">Stock disponible: <?php echo (int) $producto['stock']; ?></span>
                <form action="carrito_accion.php" method="POST" class="detail-form">
                    <input type="hidden" name="accion" value="agregar">
                    <input type="hidden" name="producto_id" value="<?php echo (int) $producto['id']; ?>">
                    <label for="cantidad">Cantidad</label>
                    <input id="cantidad" type="number" name="cantidad" min="1" max="<?php echo max(1, (int) $producto['stock']); ?>" value="1" <?php echo (int) $producto['stock'] <= 0 ? 'disabled' : ''; ?>>
                    <button type="submit" <?php echo (int) $producto['stock'] <= 0 ? 'disabled' : ''; ?>>Agregar al carrito</button>
                </form>
                <a class="btn-secondary" href="menu.php">Volver al menu</a>
            </div>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>