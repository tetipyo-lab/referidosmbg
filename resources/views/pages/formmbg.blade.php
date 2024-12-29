<html lang="en"><head>
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
    </style>
</head>
<body>
    <div class="container">
         <!-- Logo centrado -->
         <div class="text-center mb-4">
            <img src="https://www.mariobarrera.us/wp-content/uploads/2020/07/Mario-Barrera-Agente-de-aseguranzas.png" alt="Logo de Mario Barrera" class="logo" style="max-width: 90%;">
        </div>

        <!-- Información del agente -->
        <div class="row g-3" style="background-color: #4BB6B3; display: flex; justify-content: center; align-items: center;">
            <!-- Información del agente -->
            <div class="col-md-8" style="background-color: #4BB6B3; color: white; display: flex; justify-content: center; align-items: center;">
                <div class="text-center mb-4">
                    <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Agent Information</h2>
                    <p class="text-muted" style="font-size: 1.2rem; color: rgba(255, 255, 255, 0.7);">Name: <strong style="font-weight: bold; color: white;">Mario Barrera</strong></p>
                    <p class="text-muted" style="font-size: 1.2rem; color: rgba(255, 255, 255, 0.7);">NPN Agent: <strong style="font-weight: bold; color: white;">7700000739694</strong></p>
                </div>
            </div>
            
             <!-- Espacio para la foto -->
            <div class="col-md-4 text-center mb-4" style="background-color: #4BB6B3; height: 100%; display: flex; justify-content: center; align-items: center;">
                <img src="/storage/profile_photos/01JG2FRV7MK0ACN5T9538H1E58.jpg" alt="Foto del Agente" class="img-fluid rounded-rectangule" style="width: 80%; height: 100%; object-fit: cover; border: 5px solid white; margin: 2px;">
            </div>

        </div>
        <hr>
        <form id="__vtigerWebForm" name="Occidental Life Form" action="https://crm.callmbg.com/modules/Webforms/capture.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <!-- Datos del Asegurado -->

            <!-- Hidden Fields PARA VTIGER NO TOCAR --> 
            <input type="hidden" name="__vtrftk" value="sid:161cdebb6efa746937e63773fca9ccfc012f46c7,1735243994">
            <input type="hidden" name="publicid" value="1cd093b59e60d84c4e200e4645ea98f9">
            <input type="hidden" name="urlencodeenable" value="1">
            <input type="hidden" name="name" value="Occidental Life Form">
            <!-- Hidden Fields -->
               
            <div class="row g-3" style="background-color: #0769b4; color: white; padding: 20px; font-family: Arial, sans-serif;">
                <h4 class="mb-3">Insured Information / Información del Asegurado</h4>
                <!-- Nombre y Apellido -->
                <div class="col-md-6">
                    <label class="form-label" for="firstName">First Name / Nombre</label>
                    <input class="form-control" id="firstname" name="firstname" type="text" placeholder="First Name / Nombre" data-sb-validations="required">
                    <div class="invalid-feedback" data-sb-feedback="firstName:required">First Name is required.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="lastName">Last Name / Apellido</label>
                    <input class="form-control" id="lastName" name="lastname" type="text" placeholder="Last Name / Apellido" data-sb-validations="required">
                    <div class="invalid-feedback" data-sb-feedback="lastName:required">Last Name is required.</div>
                </div>
        
                <!-- Fechas y Edad -->
                <div class="col-md-4">
                    <label class="form-label" for="dobMmDdYyyy">DOB / Fecha de Nacimiento</label>
                    <input class="form-control" id="dobMmDdYyyy" name="cf_853" type="date" placeholder="DOB (mm/dd/yyyy)" data-sb-validations="required">
                    <div class="invalid-feedback" data-sb-feedback="dobMmDdYyyy:required">DOB (mm/dd/yyyy) is required.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="appDate">App date / Fecha de aplicación (mm/dd/yyyy)</label>
                    <input class="form-control" id="appDate" name="cf_949" type="date" placeholder="App date (mm/dd/yyyy)" data-sb-validations="required" pattern="\d{2}/\d{2}/\d{4}" value="2024-12-27">
                    <div class="invalid-feedback" data-sb-feedback="appDate:required">App date (mm/dd/yyyy) is required.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="age">Age / Edad</label>
                    <input class="form-control" id="age" type="number" placeholder="Age / Edad" data-sb-validations="required" name="cf_905">
                    <div class="invalid-feedback" data-sb-feedback="age:required">Age is required.</div>
                </div>
        
                <!-- SSN y Occupation -->
                <div class="col-md-6">
                    <label class="form-label" for="ssn">SSN / ITIN</label>
                    <input class="form-control" id="ssn" type="text" placeholder="SSN" data-sb-validations="required" name="cf_945">
                    <div class="invalid-feedback" data-sb-feedback="ssn:required">SSN is required.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="occupation">Occupation / Ocupación </label>
                    <input class="form-control" id="occupation" type="text" placeholder="Occupation" data-sb-validations="required" name="cf_947">
                    <div class="invalid-feedback" data-sb-feedback="occupation:required">Occupation is required.</div>
                </div>
        
                <!-- Contacto -->
                <div class="col-md-6">
                    <label class="form-label" for="emailAddress">Email Address / Correo Electrónico</label>
                    <input class="form-control" id="emailAddress" type="email" placeholder="Email Address" data-sb-validations="required,email" name="email">
                    <div class="invalid-feedback" data-sb-feedback="emailAddress:required">Email Address is required.</div>
                    <div class="invalid-feedback" data-sb-feedback="emailAddress:email">Email Address Email is not valid.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="phone">Phone / Teléfono</label>
                    <input class="form-control" id="phone" type="text" placeholder="Phone" data-sb-validations="required" name="mobile">
                    <div class="invalid-feedback" data-sb-feedback="phone:required">Phone is required.</div>
                </div>
            </div>
            <hr>
            <div class="row g-3" style="background-color: #0769b4; color: white; padding: 20px; font-family: Arial, sans-serif;">
                <h4 class="mb-3" >Address</h4>
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address / Dirección</label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" name="lane">
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="city">City / Ciudad</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" name="city">
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State / Estado</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" name="state">
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="zipCode">Zip Code / Código postal</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" name="code">
                    <div class="invalid-feedback" data-sb-feedback="zipCode:required">Zip Code is required.</div>
                </div>
            </div>
            <hr>
            <!-- Información del Seguro -->
            <div class="row g-3" style="background-color: #4BB6B3; color: white; padding: 20px; font-family: Arial, sans-serif;">
                <h4 class="mb-3" style="">Primary Beneficiary / Beneficiario Principal</h4>
                <div class="col-md-6">
                    <label class="form-label" for="nameSPrimaryBeneficiary">Name(s) Primary Beneficiary / Nombre Beneficiario</label>
                    <input class="form-control" id="nameSPrimaryBeneficiary" type="text" placeholder="Name(s) Primary Beneficiary" data-sb-validations="" name="cf_955">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="beneficiaryExtra">-</label>
                    <input class="form-control" id="beneficiaryExtra" type="text" placeholder="-" data-sb-validations="" name="cf_953">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="relationship">Relationship / Parentesco</label>
                    <input class="form-control" id="relationship" type="text" placeholder="Relationship" data-sb-validations="" name="cf_957">
                </div>
            </div>
            <hr>
            <div class="row g-3" style="background-color: #4BB6B3; color: white; padding: 20px; font-family: Arial, sans-serif;">
                <h4 class="mb-3" >Address</h4>
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address / Dirección</label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" name="cf_965">
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="city">City / Ciudad</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" name="cf_967">
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State / Estado</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" name="cf_969">
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="zipCode">Zip Code / Código Postal</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" name="cf_971">
                    <div class="invalid-feedback" data-sb-feedback="zipCode:required">Zip Code is required.</div>
                </div>
            </div>
            <hr>
            <!-- Información del Seguro -->
            <div class="row g-3">
                <h4 class="mb-3">Contingent Beneficiary / Beneficiario Contingente</h4>
                <!-- Beneficiario Principal -->
                <div class="col-md-6">
                    <label class="form-label" for="nameSContingetBeneficiary">Name(s) Contingent Beneficiary / Nombre del Beneficiario Contingente</label>
                    <input class="form-control" id="nameSContingentBeneficiary" type="text" placeholder="Name(s) Primary Beneficiary" data-sb-validations="" name="cf_959">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="beneficiaryExtra">-</label>
                    <input class="form-control" id="beneficiaryExtra" type="text" placeholder="-" data-sb-validations="" name="cf_961">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="relationship">Relationship / Parantesco</label>
                    <input class="form-control" id="relationship" type="text" placeholder="Relationship" data-sb-validations="" name="cf_963">
                </div>
            </div>
            <hr>
            <div class="row g-3">
                <h4 class="mb-3">Address</h4>
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address / Dirección </label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" name="cf_973">
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="city">City / Ciudad</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" name="cf_975">
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State / Estado</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" name="cf_977">
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="zipCode">Zip Code / Código Postal</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" name="cf_979">
                    <div class="invalid-feedback" data-sb-feedback="zipCode:required">Zip Code is required.</div>
                </div>
            </div>
            <!-- Valores ocultos para el formulario NO REMOVER XXX -->
            <input type="hidden" name="cf_941" data-label="" value="QFETSZ7P2N">
            <input type="hidden" name="cf_929" data-label="" value="occ_life_policy">
            <!-- Botón de Enviar -->
            <button type="submit" class="btn btn-primary w-100 mt-3">Enviar Solicitud</button>
        </form>

        <footer class="bg-dark text-white text-center py-4" style="background-color: #0769b4;">
            <p>© 2024 Mario Barrera Insurance. All rights reserved.</p>
            <p>Website by Mario Barrera</p>
        </footer>
    
    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

</body>
</html>
