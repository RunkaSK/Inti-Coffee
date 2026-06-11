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
    <?php renderHeader('inicio'); ?>
    <?php renderAuthModal(); ?>

    <section class="hero">
        <div class="slides">
            <img class="slide active" src="img/cafe1.png" alt="Cafe 1">
            <img class="slide" src="img/cafe2.png" alt="Cafe 2">
            <img class="slide" src="img/cafe3.png" alt="Cafe 3">
            <img class="slide" src="img/cafe4.png" alt="Cafe 4">
        </div>
        <div class="hero-content">
            <h2>El mejor cafe de la ciudad</h2>
            <p>Frescura, aroma y calidad en cada taza</p>
            <button onclick="irAlMenu()">Ver menu</button>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>