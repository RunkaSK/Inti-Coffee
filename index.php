<?php require_once __DIR__ . '/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Inticoffee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php mostrarMensaje(); ?>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo Inticoffee">
        </div>
        <nav>
            <a href="index.php" class="nav-link active">Inicio</a>
            <a href="menu.php" class="nav-link">Menú</a>
            <a href="nosotros.php" class="nav-link">Nosotros</a>
            <a href="contacto.php" class="nav-link">Contacto</a>
            <div class="user-profile" onclick="toggleAuthModal()">
                <img src="img/incognito.png" alt="Perfil">
            </div>
        </nav>
    </header>

    <!-- Modal de Autenticación -->
    <div id="authModal" class="auth-modal">
        <div class="auth-container">
            <button class="close-btn" onclick="toggleAuthModal()">×</button>
            <div class="auth-tabs">
                <button class="tab-btn active" onclick="switchTab('login')">Iniciar Sesión</button>
                <button class="tab-btn" onclick="switchTab('register')">Registrarse</button>
            </div>

            <!-- Tab Login -->
            <div id="login" class="tab-content active">
                <h2>Bienvenido</h2>
                <form action="login.php" method="POST"><input type="email" name="correo" placeholder="Correo electrónico" required><input type="password" name="password" placeholder="Contraseña" required><button type="submit">Iniciar Sesión</button></form>
                <p><a href="#">¿Olvidaste tu contraseña?</a></p>
            </div>

            <!-- Tab Register -->
            <div id="register" class="tab-content">
                <h2>Crear Cuenta</h2>
                <form action="registrar.php" method="POST"><input type="text" name="nombre_completo" placeholder="Nombre completo" required><input type="email" name="correo" placeholder="Correo electrónico" required><input type="password" name="password" placeholder="Contraseña" required><input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required><button type="submit">Registrarse</button></form>
            </div>
        </div>
    </div>

    <section class="hero">
        <div class="slides">
            <img class="slide active" src="img/cafe1.png" alt="Café 1">
            <img class="slide" src="img/cafe2.png" alt="Café 2">
            <img class="slide" src="img/cafe3.png" alt="Café 3">
            <img class="slide" src="img/cafe4.png" alt="Café 4">
        </div>

        <div class="hero-content">
            <h2>El mejor café de la ciudad ☕</h2>
            <p>Frescura, aroma y calidad en cada taza</p>
            <button onclick="irAlMenu()">Ver menú</button>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>