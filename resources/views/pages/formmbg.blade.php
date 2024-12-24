<!DOCTYPE html>
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
        /*@media (max-width: 600px) {
            .form-container {
                min-width: 100%;
                padding: 20px;
            }
        }*/
    </style>
</head>
<body>
    <div class="container">
         <!-- Logo centrado -->
         <div class="text-center mb-4">
            <img src="https://www.mariobarrera.us/wp-content/uploads/2020/07/Mario-Barrera-Agente-de-aseguranzas.png" alt="Logo de Mario Barrera" class="logo">
        </div>

        <!-- Información del agente -->
        <div class="text-center mb-4">
            <h2>Información del Agente</h2>
            <p class="text-muted">Nombre: <strong>Juan Pérez</strong></p>
            <p class="text-muted">Teléfono: <strong>+595 123 456 789</strong></p>
        </div>
        <hr>
        <h2 class="text-center mb-4">Formulario de Seguro</h2>
        <form>
            <!-- Datos del Asegurado -->
            <div class="container">
                <h4 class="mb-3">Datos del Asegurado</h4>
                <div class="row g-3">
                    <!-- Nombre y Apellido -->
                    <div class="col-md-6">
                        <label class="form-label" for="firstName">First Name</label>
                        <input class="form-control" id="firstName" type="text" placeholder="First Name" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="firstName:required">First Name is required.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="lastName">Last Name</label>
                        <input class="form-control" id="lastName" type="text" placeholder="Last Name" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="lastName:required">Last Name is required.</div>
                    </div>
            
                    <!-- Fechas y Edad -->
                    <div class="col-md-4">
                        <label class="form-label" for="dobMmDdYyyy">DOB (mm/dd/yyyy)</label>
                        <input class="form-control" id="dobMmDdYyyy" type="date" placeholder="DOB (mm/dd/yyyy)" data-sb-validations="required" pattern="\d{2}/\d{2}/\d{4}" />
                        <div class="invalid-feedback" data-sb-feedback="dobMmDdYyyy:required">DOB (mm/dd/yyyy) is required.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="appDateMmDdYyyy">App date (mm/dd/yyyy)</label>
                        <input class="form-control" id="appDateMmDdYyyy" type="date" placeholder="App date (mm/dd/yyyy)" data-sb-validations="required" pattern="\d{2}/\d{2}/\d{4}" />
                        <div class="invalid-feedback" data-sb-feedback="appDateMmDdYyyy:required">App date (mm/dd/yyyy) is required.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="age">Age</label>
                        <input class="form-control" id="age" type="number" placeholder="Age" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="age:required">Age is required.</div>
                    </div>
            
                    <!-- SSN y Occupation -->
                    <div class="col-md-6">
                        <label class="form-label" for="ssn">SSN</label>
                        <input class="form-control" id="ssn" type="text" placeholder="SSN" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="ssn:required">SSN is required.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="occupation">Occupation</label>
                        <input class="form-control" id="occupation" type="text" placeholder="Occupation" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="occupation:required">Occupation is required.</div>
                    </div>
            
                    <!-- Contacto -->
                    <div class="col-md-6">
                        <label class="form-label" for="emailAddress">Email Address</label>
                        <input class="form-control" id="emailAddress" type="email" placeholder="Email Address" data-sb-validations="required,email" />
                        <div class="invalid-feedback" data-sb-feedback="emailAddress:required">Email Address is required.</div>
                        <div class="invalid-feedback" data-sb-feedback="emailAddress:email">Email Address Email is not valid.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="phone">Phone</label>
                        <input class="form-control" id="phone" type="text" placeholder="Phone" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="phone:required">Phone is required.</div>
                    </div>
                </div>
            </div>
            <hr>
             <!-- Información del Seguro -->
            <h4 class="mb-3">Address</h4>
            <div class="row g-3">
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address</label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-6">
                    <label class="form-label" for="city">City</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-2">
                    <label class="form-label" for="zipCode">Zip Code</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="zipCode:required">Zip Code is required.</div>
                </div>
            </div>
            <hr>
            <!-- Información del Seguro -->
            <h4 class="mb-3">Primary Beneficiary</h4>
            <div class="row g-3">
                <!-- Beneficiario Principal -->
                <div class="col-md-6">
                    <label class="form-label" for="nameSPrimaryBeneficiary">Name(s) Primary Beneficiary</label>
                    <input class="form-control" id="nameSPrimaryBeneficiary" type="text" placeholder="Name(s) Primary Beneficiary" data-sb-validations="" />
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="beneficiaryExtra">-</label>
                    <input class="form-control" id="beneficiaryExtra" type="text" placeholder="-" data-sb-validations="" />
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="relationship">Relationship</label>
                    <input class="form-control" id="relationship" type="text" placeholder="Relationship" data-sb-validations="" />
                </div>
            </div>
            <hr>
            <h4 class="mb-3">Address</h4>
            <div class="row g-3">
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address</label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-6">
                    <label class="form-label" for="city">City</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-2">
                    <label class="form-label" for="zipCode">Zip Code</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="zipCode:required">Zip Code is required.</div>
                </div>
            </div>
            <hr>
            <!-- Información del Seguro -->
            <h4 class="mb-3">Contingent Beneficiary</h4>
            <div class="row g-3">
                <!-- Beneficiario Principal -->
                <div class="col-md-6">
                    <label class="form-label" for="nameSContingetBeneficiary">Name(s) Contingent Beneficiary</label>
                    <input class="form-control" id="nameSContingentBeneficiary" type="text" placeholder="Name(s) Primary Beneficiary" data-sb-validations="" />
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="beneficiaryExtra">-</label>
                    <input class="form-control" id="beneficiaryExtra" type="text" placeholder="-" data-sb-validations="" />
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="relationship">Relationship</label>
                    <input class="form-control" id="relationship" type="text" placeholder="Relationship" data-sb-validations="" />
                </div>
            </div>
            <hr>
            <h4 class="mb-3">Address</h4>
            <div class="row g-3">
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address</label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-6">
                    <label class="form-label" for="city">City</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-2">
                    <label class="form-label" for="zipCode">Zip Code</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="zipCode:required">Zip Code is required.</div>
                </div>
            </div>
            <!-- Botón de Enviar -->
            <button type="submit" class="btn btn-primary w-100 mt-3">Enviar Solicitud</button>
        </form>
    </div>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
