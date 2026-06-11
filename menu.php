<?php
require_once __DIR__ . '/conexion.php';
$productos = obtenerProductosActivos();
$categorias = array_values(array_unique(array_map(fn($producto) => $producto['categoria'], $productos)));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Inticoffee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php mostrarMensaje(); ?>
    <?php renderHeader('menu'); ?>
    <?php renderAuthModal(); ?>

    <main class="shop-page">
        <section class="shop-hero">
            <span>Vista cliente</span>
            <h1>Productos disponibles</h1>
            <p>Elige un producto, revisa su detalle y agrega la cantidad segun el stock disponible.</p>
        </section>

        <section class="category-filter">
            <button type="button" onclick="filtrar('todos')">Todos</button>
            <?php foreach ($categorias as $categoria): ?>
                <button type="button" onclick="filtrar('<?php echo e($categoria); ?>')"><?php echo e($categoria); ?></button>
            <?php endforeach; ?>
        </section>

        <section class="product-grid">
            <?php foreach ($productos as $producto): ?>
                <article class="card product-card" data-category="<?php echo e($producto['categoria']); ?>">
                    <img src="<?php echo e($producto['imagen'] ?: 'img/productos.png'); ?>" alt="<?php echo e($producto['nombre']); ?>">
                    <h3><?php echo e($producto['nombre']); ?></h3>
                    <p><?php echo e($producto['descripcion']); ?></p>
                    <div class="product-meta">
                        <span class="price">S/ <?php echo number_format((float) $producto['precio'], 2); ?></span>
                        <span class="stock <?php echo (int) $producto['stock'] <= 0 ? 'empty' : ''; ?>">Stock: <?php echo (int) $producto['stock']; ?></span>
                    </div>
                    <div class="product-actions">
                        <a class="btn-secondary" href="producto.php?id=<?php echo (int) $producto['id']; ?>">Ver info</a>
                        <form action="carrito_accion.php" method="POST">
                            <input type="hidden" name="accion" value="agregar">
                            <input type="hidden" name="producto_id" value="<?php echo (int) $producto['id']; ?>">
                            <input type="number" name="cantidad" min="1" max="<?php echo max(1, (int) $producto['stock']); ?>" value="1" <?php echo (int) $producto['stock'] <= 0 ? 'disabled' : ''; ?>>
                            <button type="submit" <?php echo (int) $producto['stock'] <= 0 ? 'disabled' : ''; ?>>Agregar</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>