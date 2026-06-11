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
    <?php renderHeader('nosotros'); ?>
    <?php renderAuthModal(); ?>

    <section class="about-section">
        <div class="about-container">
            <div class="about-image">
                <img src="img/cafe1.png" alt="Nuestra cafeteria">
            </div>
            <div class="about-text">
                <span class="about-subtitle">NUESTRA HISTORIA</span>
                <h2>Sobre Inticoffee</h2>
                <p>En Inticoffee creemos que el cafe es mas que una bebida: es una experiencia que conecta personas, momentos y emociones.</p>
                <p>Nuestro objetivo es ofrecer un ambiente calido, moderno y acogedor, acompanado de productos de calidad y atencion personalizada.</p>
                <p>Cada taza es preparada cuidadosamente por nuestros baristas para brindar una experiencia unica.</p>
                <button class="btn-primary" onclick="location.href='menu.php'">Ver productos</button>
            </div>
        </div>
        <div class="about-gallery">
            <div class="gallery-card"><img src="img/cafe3.png" alt="Interior cafeteria"><div class="gallery-overlay"><h3>Ambiente Premium</h3></div></div>
            <div class="gallery-card"><img src="img/cafe4.png" alt="Barista"><div class="gallery-overlay"><h3>Baristas Expertos</h3></div></div>
            <div class="gallery-card"><img src="img/acompanamiento.png" alt="Postres"><div class="gallery-overlay"><h3>Postres Artesanales</h3></div></div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>