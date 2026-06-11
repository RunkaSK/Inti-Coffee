<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function obtenerConexion(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dbPath = __DIR__ . '/database/inti_coffee.db';
    $dbDir = dirname($dbPath);
    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0777, true);
    }

    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');

    crearTablas($pdo);
    migrarTablas($pdo);
    sembrarDatosIniciales($pdo);

    return $pdo;
}

function crearTablas(PDO $pdo): void
{
    $pdo->exec(<<<SQL
CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre_completo TEXT NOT NULL,
    correo TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    rol TEXT NOT NULL DEFAULT 'cliente',
    creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mensajes_contacto (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    correo TEXT NOT NULL,
    mensaje TEXT NOT NULL,
    atendido INTEGER NOT NULL DEFAULT 0,
    creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reservas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario_id INTEGER,
    nombre TEXT NOT NULL,
    correo TEXT NOT NULL,
    telefono TEXT,
    fecha TEXT NOT NULL,
    hora TEXT NOT NULL,
    personas INTEGER NOT NULL DEFAULT 1,
    estado TEXT NOT NULL DEFAULT 'pendiente',
    creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    categoria TEXT NOT NULL,
    descripcion TEXT,
    precio REAL NOT NULL,
    imagen TEXT,
    stock INTEGER NOT NULL DEFAULT 0,
    activo INTEGER NOT NULL DEFAULT 1,
    creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_usuarios_correo ON usuarios(correo);
CREATE INDEX IF NOT EXISTS idx_mensajes_contacto_correo ON mensajes_contacto(correo);
CREATE INDEX IF NOT EXISTS idx_reservas_fecha ON reservas(fecha);
CREATE INDEX IF NOT EXISTS idx_productos_categoria ON productos(categoria);
SQL);
}

function migrarTablas(PDO $pdo): void
{
    agregarColumnaSiFalta($pdo, 'usuarios', 'rol', "TEXT NOT NULL DEFAULT 'cliente'");
    agregarColumnaSiFalta($pdo, 'productos', 'stock', 'INTEGER NOT NULL DEFAULT 20');
    agregarColumnaSiFalta($pdo, 'productos', 'activo', 'INTEGER NOT NULL DEFAULT 1');
}

function agregarColumnaSiFalta(PDO $pdo, string $tabla, string $columna, string $definicion): void
{
    $stmt = $pdo->query("PRAGMA table_info($tabla)");
    $columnas = array_column($stmt->fetchAll(), 'name');
    if (!in_array($columna, $columnas, true)) {
        $pdo->exec("ALTER TABLE $tabla ADD COLUMN $columna $definicion");
    }
}

function sembrarDatosIniciales(PDO $pdo): void
{
    $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE correo = :correo LIMIT 1');
    $stmt->execute([':correo' => 'negocio@inticoffee.local']);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare('INSERT INTO usuarios (nombre_completo, correo, password_hash, rol) VALUES (:nombre, :correo, :password_hash, :rol)');
        $stmt->execute([
            ':nombre' => 'Administrador Inti Coffee',
            ':correo' => 'negocio@inticoffee.local',
            ':password_hash' => password_hash('negocio123', PASSWORD_DEFAULT),
            ':rol' => 'negocio',
        ]);
    }

    $totalProductos = (int) $pdo->query('SELECT COUNT(*) FROM productos')->fetchColumn();
    if ($totalProductos > 0) {
        return;
    }

    $productos = [
        ['Espresso', 'Cafes', 'Cafe intenso y aromatico preparado al momento.', 8.00, 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=500&h=350&fit=crop', 25],
        ['Cappuccino', 'Cafes', 'Espresso con leche vaporizada y espuma cremosa.', 10.00, 'https://images.unsplash.com/photo-1511920170033-f8396924c348?w=500&h=350&fit=crop', 18],
        ['Frappuccino', 'Congelados', 'Bebida fria con cafe, crema y toque dulce.', 12.00, 'https://images.unsplash.com/photo-1521302080334-4bebac2763a6?w=500&h=350&fit=crop', 16],
        ['Cheesecake', 'Acompanamiento', 'Postre cremoso para acompanar tu bebida.', 9.00, 'https://images.unsplash.com/photo-1508736793122-f516e3ba5569?w=500&h=350&fit=crop', 12],
        ['Cafe en grano', 'Productos', 'Bolsa de cafe seleccionado para preparar en casa.', 28.00, 'img/productos.png', 10],
        ['Brownie', 'Acompanamiento', 'Brownie de chocolate con textura suave.', 7.00, 'img/acompanamiento.png', 20],
    ];

    $stmt = $pdo->prepare('INSERT INTO productos (nombre, categoria, descripcion, precio, imagen, stock, activo) VALUES (?, ?, ?, ?, ?, ?, 1)');
    foreach ($productos as $producto) {
        $stmt->execute($producto);
    }
}

function usuarioActual(): ?array
{
    return $_SESSION['usuario'] ?? null;
}

function estaLogueado(): bool
{
    return !empty($_SESSION['usuario']);
}

function usuarioEsNegocio(): bool
{
    return ($_SESSION['usuario']['rol'] ?? '') === 'negocio';
}

function requerirLogin(): void
{
    if (!estaLogueado()) {
        guardarMensajeFlash('error', 'Inicia sesion para continuar.');
        header('Location: index.php');
        exit;
    }
}

function requerirNegocio(): void
{
    requerirLogin();
    if (!usuarioEsNegocio()) {
        guardarMensajeFlash('error', 'Esta vista es solo para el negocio.');
        header('Location: menu.php');
        exit;
    }
}

function obtenerProductosActivos(): array
{
    return obtenerConexion()->query('SELECT * FROM productos WHERE activo = 1 ORDER BY categoria, nombre')->fetchAll();
}

function obtenerProductosNegocio(): array
{
    return obtenerConexion()->query('SELECT * FROM productos ORDER BY activo DESC, categoria, nombre')->fetchAll();
}

function obtenerProducto(int $id): ?array
{
    $stmt = obtenerConexion()->prepare('SELECT * FROM productos WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $producto = $stmt->fetch();
    return $producto ?: null;
}

function contarCarrito(): int
{
    return array_sum($_SESSION['carrito'] ?? []);
}

function obtenerCarritoDetalle(): array
{
    $carrito = $_SESSION['carrito'] ?? [];
    if (!$carrito) {
        return [];
    }

    $items = [];
    foreach ($carrito as $productoId => $cantidad) {
        $producto = obtenerProducto((int) $productoId);
        if (!$producto || !$producto['activo'] || (int) $producto['stock'] <= 0) {
            unset($_SESSION['carrito'][$productoId]);
            continue;
        }

        $cantidad = max(1, min((int) $cantidad, (int) $producto['stock']));
        $_SESSION['carrito'][$productoId] = $cantidad;
        $items[] = [
            'producto' => $producto,
            'cantidad' => $cantidad,
            'subtotal' => $cantidad * (float) $producto['precio'],
        ];
    }
    return $items;
}

function totalCarrito(array $items): float
{
    return array_sum(array_column($items, 'subtotal'));
}

function volverAtras(string $fallback = 'index.php'): void
{
    $destino = $_SERVER['HTTP_REFERER'] ?? $fallback;
    header('Location: ' . $destino);
    exit;
}

function guardarMensajeFlash(string $tipo, string $texto): void
{
    $_SESSION['flash'] = ['tipo' => $tipo, 'texto' => $texto];
}

function mostrarMensaje(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }
    $tipo = htmlspecialchars($_SESSION['flash']['tipo'], ENT_QUOTES, 'UTF-8');
    $texto = htmlspecialchars($_SESSION['flash']['texto'], ENT_QUOTES, 'UTF-8');
    unset($_SESSION['flash']);
    echo "<div class=\"flash-message flash-$tipo\">$texto</div>";
}

function e(?string $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function renderHeader(string $activo = ''): void
{
    $usuario = usuarioActual();
    $carrito = contarCarrito();
    ?>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo Inticoffee">
        </div>
        <nav>
            <a href="index.php" class="nav-link <?php echo $activo === 'inicio' ? 'active' : ''; ?>">Inicio</a>
            <a href="menu.php" class="nav-link <?php echo $activo === 'menu' ? 'active' : ''; ?>">Menu</a>
            <a href="nosotros.php" class="nav-link <?php echo $activo === 'nosotros' ? 'active' : ''; ?>">Nosotros</a>
            <a href="contacto.php" class="nav-link <?php echo $activo === 'contacto' ? 'active' : ''; ?>">Contacto</a>
            <a href="carrito.php" class="nav-link <?php echo $activo === 'carrito' ? 'active' : ''; ?>">Carrito (<?php echo $carrito; ?>)</a>
            <?php if (usuarioEsNegocio()): ?>
                <a href="negocio.php" class="nav-link <?php echo $activo === 'negocio' ? 'active' : ''; ?>">Negocio</a>
            <?php endif; ?>
            <?php if ($usuario): ?>
                <span class="user-name"><?php echo e($usuario['nombre']); ?></span>
                <a href="logout.php" class="nav-link logout-link">Salir</a>
            <?php else: ?>
                <div class="user-profile" onclick="toggleAuthModal()">
                    <img src="img/incognito.png" alt="Perfil">
                </div>
            <?php endif; ?>
        </nav>
    </header>
    <?php
}

function renderAuthModal(): void
{
    if (estaLogueado()) {
        return;
    }
    ?>
    <div id="authModal" class="auth-modal">
        <div class="auth-container">
            <button class="close-btn" onclick="toggleAuthModal()">x</button>
            <div class="auth-tabs">
                <button class="tab-btn active" onclick="switchTab('login')">Iniciar Sesion</button>
                <button class="tab-btn" onclick="switchTab('register')">Registrarse</button>
            </div>
            <div id="login" class="tab-content active">
                <h2>Bienvenido</h2>
                <form action="login.php" method="POST">
                    <input type="email" name="correo" placeholder="Correo electronico" required>
                    <input type="password" name="password" placeholder="Contrasena" required>
                    <button type="submit">Iniciar Sesion</button>
                </form>
                <p class="login-hint">Negocio: negocio@inticoffee.local / negocio123</p>
            </div>
            <div id="register" class="tab-content">
                <h2>Crear Cuenta</h2>
                <form action="registrar.php" method="POST">
                    <input type="text" name="nombre_completo" placeholder="Nombre completo" required>
                    <input type="email" name="correo" placeholder="Correo electronico" required>
                    <input type="password" name="password" placeholder="Contrasena" required>
                    <input type="password" name="confirmar_password" placeholder="Confirmar contrasena" required>
                    <button type="submit">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>