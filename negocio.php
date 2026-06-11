<?php
require_once __DIR__ . '/conexion.php';
requerirNegocio();

$editar = null;
if (isset($_GET['editar'])) {
    $editar = obtenerProducto((int) $_GET['editar']);
}
$productos = obtenerProductosNegocio();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Negocio - Inticoffee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php mostrarMensaje(); ?>
    <?php renderHeader('negocio'); ?>

    <main class="business-page">
        <section class="shop-hero compact">
            <span>Vista negocio</span>
            <h1>CRUD de productos</h1>
            <p>Agrega, edita, activa/desactiva o elimina productos. El stock limita las compras del cliente.</p>
        </section>

        <section class="business-layout">
            <form action="negocio_accion.php" method="POST" class="business-form">
                <h2><?php echo $editar ? 'Editar producto' : 'Nuevo producto'; ?></h2>
                <input type="hidden" name="accion" value="guardar">
                <input type="hidden" name="id" value="<?php echo (int) ($editar['id'] ?? 0); ?>">

                <label>Nombre</label>
                <input type="text" name="nombre" value="<?php echo e($editar['nombre'] ?? ''); ?>" required>

                <label>Categoria</label>
                <select name="categoria" required>
                    <?php foreach (['Cafes', 'Acompanamiento', 'Productos', 'Congelados'] as $categoria): ?>
                        <option value="<?php echo e($categoria); ?>" <?php echo ($editar['categoria'] ?? '') === $categoria ? 'selected' : ''; ?>><?php echo e($categoria); ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Descripcion</label>
                <textarea name="descripcion" rows="4"><?php echo e($editar['descripcion'] ?? ''); ?></textarea>

                <label>Precio</label>
                <input type="number" name="precio" step="0.01" min="0" value="<?php echo e($editar['precio'] ?? ''); ?>" required>

                <label>Stock</label>
                <input type="number" name="stock" min="0" value="<?php echo e($editar['stock'] ?? 0); ?>" required>

                <label>Imagen URL o ruta local</label>
                <input type="text" name="imagen" value="<?php echo e($editar['imagen'] ?? ''); ?>" placeholder="img/productos.png">

                <label class="check-row">
                    <input type="checkbox" name="activo" value="1" <?php echo !isset($editar['activo']) || (int) $editar['activo'] === 1 ? 'checked' : ''; ?>>
                    Visible para clientes
                </label>

                <button type="submit">Guardar producto</button>
                <?php if ($editar): ?>
                    <a class="btn-secondary" href="negocio.php">Cancelar edicion</a>
                <?php endif; ?>
            </form>

            <section class="business-table-wrap">
                <h2>Productos registrados</h2>
                <table class="business-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo e($producto['nombre']); ?></td>
                                <td><?php echo e($producto['categoria']); ?></td>
                                <td>S/ <?php echo number_format((float) $producto['precio'], 2); ?></td>
                                <td><?php echo (int) $producto['stock']; ?></td>
                                <td><?php echo (int) $producto['activo'] === 1 ? 'Visible' : 'Oculto'; ?></td>
                                <td class="table-actions">
                                    <a class="btn-secondary" href="negocio.php?editar=<?php echo (int) $producto['id']; ?>">Editar</a>
                                    <form action="negocio_accion.php" method="POST" onsubmit="return confirm('Eliminar producto?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?php echo (int) $producto['id']; ?>">
                                        <button class="danger-btn" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>