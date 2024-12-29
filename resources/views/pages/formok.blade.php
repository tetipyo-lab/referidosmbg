<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Seguro</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 600px;
            max-width: 800px;
        }
        .d-none {
            display: none;
        }
        .invalid-feedback {
            display: none;
        }
        .btn.disabled {
            pointer-events: none;
            opacity: 0.65;
        }
        /* Eliminar márgenes entre los contenedores */
        .no-margin {
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo centrado -->
        <div class="text-center mb-4">
            <img src="https://www.mariobarrera.us/wp-content/uploads/2020/07/Mario-Barrera-Agente-de-aseguranzas.png" alt="Logo de Mario Barrera" class="logo" style="max-width: 90%;">
        </div>

        <!-- Video de YouTube -->
        <div class="container no-margin text-white" style="background-color: #0769b4; padding: 20px;">
            <h2 class="text-center mb-4">Gracias Por Confiar en Nosotros</h2>
            <div class="d-flex justify-content-center">
                <div class="embed-responsive">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/h6HRJ5sGfuQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" width="400px" height="600px"></iframe>
                </div>
            </div>
        </div>

        <!-- Beneficios -->
        <div class="container no-margin" style="background-color: #4BB6B3; padding: 20px;">
            <h2 class="text-center text-white mb-4">Algunos de los beneficios que puedes tener</h2>
            <div>
                <h3 class="text-white">1. Aseguranza con Beneficios en Vida</h3>
                <h3 class="text-white">2. Beneficios post muerte</h3>
                <h3 class="text-white">3. Acceso a beneficios de la agencia</h3>
                <h3 class="text-white">4. Acceso a tasas preferenciales para Hogar y Auto</h3>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-dark text-white text-center py-4" style="background-color: #0769b4;">
            <p>© 2024 Mario Barrera Insurance. All rights reserved.</p>
            <p>Website by Mario Barrera</p>
        </footer>
    </div>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
