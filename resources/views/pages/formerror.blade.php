<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Seguro</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0769b4; /* Fondo azul oscuro */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: white; /* Color de texto blanco en todo el documento */
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
        /* Estilo para el fondo amarillo tipo Amazon */
        .amazon-yellow {
            background-color: #FF9900;
            color: black;
        }
        /* Eliminar márgenes entre los contenedores */
        .no-margin {
            margin: 0 !important;
            padding: 0 !important;
        }
        /* Fondo azul para el error y texto amarillo */
        .error-container {
            background-color: #0769b4;
            color: #FF9900;
        }
        .btn-custom {
            margin: 2px;
        }
        .container {
            width: 100%; /* Hacer que todos los contenedores ocupen el mismo ancho */
            max-width: 900px; /* Máximo ancho para los contenedores */
        }
        /* Fondo blanco para el contenedor del logo */
        .logo-container {
            background-color: white; /* Fondo blanco */
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo centrado con fondo blanco -->
        <div class="text-center mb-4 logo-container">
            <img src="https://www.mariobarrera.us/wp-content/uploads/2020/07/Mario-Barrera-Agente-de-aseguranzas.png" alt="Logo de Mario Barrera" class="logo" style="max-width: 90%;">
        </div>

        <!-- Contenedor de Beneficios -->
        <div class="container no-margin" style="background-color: #4BB6B3; padding: 20px;">
            <!-- Título de error con fondo azul y texto amarillo -->
            <h2 class="text-center error-container mb-4">Ha ocurrido un error</h2>

            <!-- Mensaje de error en lugar de la lista de beneficios -->
            <div class="text-center">
                <h3 class="text-white">{{$errorMsg}}. Haz clic aquí para volver atrás.</h3>
                <!-- Botón con fondo amarillo tipo Amazon y márgenes de 2px -->
                <button onclick="window.history.back();" class="btn amazon-yellow btn-custom mt-3">Volver Atrás</button>
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
