<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function obtenerConexion(): PDO
{
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
    activo INTEGER NOT NULL DEFAULT 1,
    creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_usuarios_correo ON usuarios(correo);
CREATE INDEX IF NOT EXISTS idx_mensajes_contacto_correo ON mensajes_contacto(correo);
CREATE INDEX IF NOT EXISTS idx_reservas_fecha ON reservas(fecha);
CREATE INDEX IF NOT EXISTS idx_productos_categoria ON productos(categoria);
SQL);
}

function volverAtras(string $fallback = 'index.php'): void
{
    $destino = $_SERVER['HTTP_REFERER'] ?? $fallback;
    header('Location: ' . $destino);
    exit;
}

function guardarMensajeFlash(string $tipo, string $texto): void
{
    $_SESSION['flash'] = [
        'tipo' => $tipo,
        'texto' => $texto,
    ];
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
?>
