<?php require_once __DIR__ . '/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Inticoffee</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php mostrarMensaje(); ?>

    <!-- HEADER -->
    <header>

        <div class="logo">
            <img src="logo.png" alt="Logo Inticoffee">
        </div>

        <nav>
            <a href="index.php" class="nav-link">Inicio</a>
            <a href="menu.php" class="nav-link">Menú</a>
            <a href="nosotros.php" class="nav-link active">Nosotros</a>
            <a href="contacto.php" class="nav-link">Contacto</a>

            <div class="user-profile" onclick="toggleAuthModal()">
                <img src="img/incognito.png" alt="Perfil">
            </div>
        </nav>

    </header>

    <!-- MODAL AUTENTICACIÓN -->
    <div id="authModal" class="auth-modal">

        <div class="auth-container">

            <button class="close-btn" onclick="toggleAuthModal()">
                ×
            </button>

            <div class="auth-tabs">
                <button class="tab-btn active" onclick="switchTab('login')">
                    Iniciar Sesión
                </button>

                <button class="tab-btn" onclick="switchTab('register')">
                    Registrarse
                </button>
            </div>

            <!-- LOGIN -->
            <div id="login" class="tab-content active">

                <h2>Bienvenido</h2>

                <form action="login.php" method="POST"><input type="email" name="correo" placeholder="Correo electrónico" required><input type="password" name="password" placeholder="Contraseña" required><button type="submit">Iniciar Sesión</button></form>

                <p>
                    <a href="#">
                        ¿Olvidaste tu contraseña?
                    </a>
                </p>

            </div>

            <!-- REGISTER -->
            <div id="register" class="tab-content">

                <h2>Crear Cuenta</h2>

                <form action="registrar.php" method="POST"><input type="text" name="nombre_completo" placeholder="Nombre completo" required><input type="email" name="correo" placeholder="Correo electrónico" required><input type="password" name="password" placeholder="Contraseña" required><input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required><button type="submit">Registrarse</button></form>

            </div>

        </div>

    </div>

    <!-- SECCIÓN NOSOTROS -->
    <section class="about-section">

        <div class="about-container">

            <!-- IMAGEN -->
            <div class="about-image">
                <img src="img/cafe1.png" alt="Nuestra cafetería">
            </div>

            <!-- TEXTO -->
            <div class="about-text">

                <span class="about-subtitle">
                    NUESTRA HISTORIA
                </span>

                <h2>
                    Sobre Inticoffee ☕
                </h2>

                <p>
                    En Inticoffee creemos que el café es más que una bebida:
                    es una experiencia que conecta personas, momentos y emociones.
                </p>

                <p>
                    Nuestro objetivo es ofrecer un ambiente cálido,
                    moderno y acogedor, acompañado de productos de calidad
                    y atención personalizada.
                </p>

                <p>
                    Cada taza es preparada cuidadosamente por nuestros baristas,
                    utilizando ingredientes seleccionados y recetas artesanales
                    para brindar una experiencia única.
                </p>

                <button class="btn-primary">
                    Descubrir más
                </button>

            </div>

        </div>

        <!-- GALERÍA -->
        <div class="about-gallery">

            <!-- CARD 1 -->
            <div class="gallery-card">

                <img src="img/cafe3.png" alt="Interior cafetería">

                <div class="gallery-overlay">
                    <h3>Ambiente Premium</h3>
                </div>

            </div>

            <!-- CARD 2 -->
            <div class="gallery-card">

                <img src="img/cafe4.png" alt="Barista">

                <div class="gallery-overlay">
                    <h3>Baristas Expertos</h3>
                </div>

            </div>

            <!-- CARD 3 -->
            <div class="gallery-card">

                <img src="img/acompañamiento.png" alt="Postres">

                <div class="gallery-overlay">
                    <h3>Postres Artesanales</h3>
                </div>

            </div>

        </div>

    </section>

    <!-- SCRIPT -->
    <script src="script.js"></script>

</body>
</html>

