<?php
require_once __DIR__ . '/conexion.php';
$items = obtenerCarritoDetalle();
$total = totalCarrito($items);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Inticoffee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php mostrarMensaje(); ?>
    <?php renderHeader('carrito'); ?>
    <?php renderAuthModal(); ?>

    <main class="cart-page">
        <section class="shop-hero compact">
            <span>Vista cliente</span>
            <h1>Carrito</h1>
            <p>Revisa cantidades antes de confirmar tu pedido.</p>
        </section>

        <?php if (!$items): ?>
            <section class="empty-state">
                <h2>Tu carrito esta vacio</h2>
                <a class="btn-primary" href="menu.php">Ver productos</a>
            </section>
        <?php else: ?>
            <section class="cart-list">
                <?php foreach ($items as $item): $producto = $item['producto']; ?>
                    <article class="cart-item">
                        <img src="<?php echo e($producto['imagen'] ?: 'img/productos.png'); ?>" alt="<?php echo e($producto['nombre']); ?>">
                        <div>
                            <h3><?php echo e($producto['nombre']); ?></h3>
                            <p>Stock: <?php echo (int) $producto['stock']; ?> | S/ <?php echo number_format((float) $producto['precio'], 2); ?></p>
                        </div>
                        <form action="carrito_accion.php" method="POST" class="cart-controls">
                            <input type="hidden" name="accion" value="actualizar">
                            <input type="hidden" name="producto_id" value="<?php echo (int) $producto['id']; ?>">
                            <input type="number" name="cantidad" min="1" max="<?php echo max(1, (int) $producto['stock']); ?>" value="<?php echo (int) $item['cantidad']; ?>">
                            <button type="submit">Actualizar</button>
                        </form>
                        <strong>S/ <?php echo number_format((float) $item['subtotal'], 2); ?></strong>
                        <form action="carrito_accion.php" method="POST">
                            <input type="hidden" name="accion" value="quitar">
                            <input type="hidden" name="producto_id" value="<?php echo (int) $producto['id']; ?>">
                            <button type="submit" class="danger-btn">Quitar</button>
                        </form>
                    </article>
                <?php endforeach; ?>
            </section>
            <section class="cart-summary">
                <h2>Total: S/ <?php echo number_format($total, 2); ?></h2>
                <form action="carrito_accion.php" method="POST">
                    <input type="hidden" name="accion" value="comprar">
                    <button type="submit">Confirmar pedido</button>
                </form>
                <form action="carrito_accion.php" method="POST">
                    <input type="hidden" name="accion" value="vaciar">
                    <button type="submit" class="danger-btn">Vaciar carrito</button>
                </form>
            </section>
        <?php endif; ?>
    </main>

    <script src="script.js"></script>
</body>
</html>