<?php require_once __DIR__ . '/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Inticoffee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php mostrarMensaje(); ?>
    <?php renderHeader('contacto'); ?>
    <?php renderAuthModal(); ?>

    <section class="contact-section">
        <div class="contact-title">
            <span>CONTACTANOS</span>
            <h2>Conversemos</h2>
            <p>Estamos listos para atender tus consultas, reservas o pedidos especiales.</p>
        </div>
        <div class="contact-container">
            <div class="contact-form">
                <form action="guardar_contacto.php" method="POST">
                    <input type="text" name="nombre" placeholder="Tu nombre" required>
                    <input type="email" name="correo" placeholder="Correo electronico" required>
                    <textarea name="mensaje" placeholder="Escribe tu mensaje..." required></textarea>
                    <button type="submit">Enviar mensaje</button>
                </form>
            </div>
            <div class="contact-info">
                <div class="info-card"><h3>Direccion</h3><p>Av. Cafe Premium 123, Lima</p></div>
                <div class="info-card"><h3>Telefono</h3><p>+51 999 999 999</p></div>
                <div class="info-card"><h3>Horario</h3><p>Lunes - Domingo<br>8:00 AM - 10:00 PM</p></div>
            </div>
        </div>
        <div class="social-section">
            <h3>Nuestras redes</h3>
            <div class="social-icons">
                <a href="#"><img src="img/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="img/instagram.png" alt="Instagram"></a>
                <a href="#"><img src="img/tiktok.png" alt="TikTok"></a>
                <a href="#"><img src="img/whatsapp.png" alt="WhatsApp"></a>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>