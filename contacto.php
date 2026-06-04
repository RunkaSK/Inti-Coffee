<?php require_once __DIR__ . '/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Contacto - Inticoffee</title>

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

            <a href="index.php" class="nav-link">
                Inicio
            </a>

            <a href="menu.php" class="nav-link">
                Menú
            </a>

            <a href="nosotros.php" class="nav-link">
                Nosotros
            </a>

            <a href="contacto.php"
               class="nav-link active">
                Contacto
            </a>

            <div class="user-profile"
                 onclick="toggleAuthModal()">

                <img src="img/incognito.png"
                     alt="Perfil">

            </div>

        </nav>

    </header>

    <!-- MODAL -->
    <div id="authModal" class="auth-modal">

        <div class="auth-container">

            <button class="close-btn"
                    onclick="toggleAuthModal()">

                ×

            </button>

            <div class="auth-tabs">

                <button class="tab-btn active"
                        onclick="switchTab('login')">

                    Iniciar Sesión

                </button>

                <button class="tab-btn"
                        onclick="switchTab('register')">

                    Registrarse

                </button>

            </div>

            <!-- LOGIN -->
            <div id="login"
                 class="tab-content active">

                <h2>Bienvenido</h2>

                <form action="login.php" method="POST"><input type="email" name="correo" placeholder="Correo electrónico" required><input type="password" name="password" placeholder="Contraseña" required><button type="submit">Iniciar Sesión</button></form>

                <p>
                    <a href="#">
                        ¿Olvidaste tu contraseña?
                    </a>
                </p>

            </div>

            <!-- REGISTER -->
            <div id="register"
                 class="tab-content">

                <h2>Crear Cuenta</h2>

                <form action="registrar.php" method="POST"><input type="text" name="nombre_completo" placeholder="Nombre completo" required><input type="email" name="correo" placeholder="Correo electrónico" required><input type="password" name="password" placeholder="Contraseña" required><input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required><button type="submit">Registrarse</button></form>

            </div>

        </div>

    </div>

    <!-- CONTACTO -->
    <section class="contact-section">

        <!-- TÍTULO -->
        <div class="contact-title">

            <span>
                CONTÁCTANOS
            </span>

            <h2>
                Conversemos ☕
            </h2>

            <p>
                Estamos listos para atender tus consultas,
                reservas o pedidos especiales.
            </p>

        </div>

        <!-- CONTENEDOR -->
        <div class="contact-container">

            <!-- FORMULARIO -->
            <div class="contact-form">

                <form action="guardar_contacto.php" method="POST"><input type="text" name="nombre" placeholder="Tu nombre" required><input type="email" name="correo" placeholder="Correo electrónico" required><textarea name="mensaje" placeholder="Escribe tu mensaje..." required></textarea><button type="submit">Enviar mensaje</button></form>

            </div>

            <!-- INFORMACIÓN -->
            <div class="contact-info">

                <div class="info-card">

                    <h3>📍 Dirección</h3>

                    <p>
                        Av. Café Premium 123, Lima
                    </p>

                </div>

                <div class="info-card">

                    <h3>☎ Teléfono</h3>

                    <p>
                        +51 999 999 999
                    </p>

                </div>

                <div class="info-card">

                    <h3>🕒 Horario</h3>

                    <p>
                        Lunes - Domingo
                        <br>
                        8:00 AM - 10:00 PM
                    </p>

                </div>

            </div>

        </div>

        <!-- REDES -->
        <div class="social-section">

            <h3>
                Nuestras redes
            </h3>

            <div class="social-icons">

                <a href="#">
                    <img src="img/facebook.png"
                         alt="Facebook">
                </a>

                <a href="#">
                    <img src="img/instagram.png"
                         alt="Instagram">
                </a>

                <a href="#">
                    <img src="img/tiktok.png"
                         alt="TikTok">
                </a>

                <a href="#">
                    <img src="img/whatsapp.png"
                         alt="WhatsApp">
                </a>

            </div>

        </div>

    </section>

    <!-- SCRIPT -->
    <script src="script.js"></script>

</body>

</html>

