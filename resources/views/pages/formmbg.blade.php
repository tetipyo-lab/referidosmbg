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
        <div class="row">
            <!-- Información del agente -->
            <div class="col-md-8">
                <div class="text-center mb-4">
                    <h2>Agent Information</h2>
                    <p class="text-muted">Name: <strong>{{ $agente->name ?? '' }}</strong></p>
                    <p class="text-muted">NPN Agent: <strong>{{ $agente->agent_npn ?? '' }}</strong></p>
                </div>
            </div>
             <!-- Espacio para la foto -->
             <div class="col-md-4 text-center mb-4">
                <img src="{{ $agente->profile_photo ?? 'placeholder.jpg' }}" alt="Foto del Agente" class="img-fluid rounded-circle"  style="width: 35%;">
            </div>
        </div>
        <hr>
        <form id="__vtigerWebForm" name="Occidental Life Form" action="https://crm.callmbg.com/modules/Webforms/capture.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <!-- Datos del Asegurado -->
            <div class="container">
                <!-- Hidden Fields PARA VTIGER NO TOCAR -->
                <input type="hidden" name="__vtrftk" value="sid:161cdebb6efa746937e63773fca9ccfc012f46c7,1735243994">
                <input type="hidden" name="publicid" value="1cd093b59e60d84c4e200e4645ea98f9">
                <input type="hidden" name="urlencodeenable" value="1">
                <input type="hidden" name="name" value="Occidental Life Form">
                <!-- Hidden Fields -->

                <h4 class="mb-3">Insured Information</h4>
                <div class="row g-3">
                    <!-- Nombre y Apellido -->
                    <div class="col-md-6">
                        <label class="form-label" for="firstName">First Name</label>
                        <input class="form-control" id="firstname" name="firstname" type="text" placeholder="First Name" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="firstName:required">First Name is required.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="lastName">Last Name</label>
                        <input class="form-control" id="lastName" name="lastname" type="text" placeholder="Last Name" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="lastName:required">Last Name is required.</div>
                    </div>
            
                    <!-- Fechas y Edad -->
                    <div class="col-md-4">
                        <label class="form-label" for="dobMmDdYyyy">DOB (mm/dd/yyyy)</label>
                        <input class="form-control" id="dobMmDdYyyy" name="cf_853" type="date" placeholder="DOB (mm/dd/yyyy)" data-sb-validations="required"/>
                        <div class="invalid-feedback" data-sb-feedback="dobMmDdYyyy:required">DOB (mm/dd/yyyy) is required.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="appDate">App date (mm/dd/yyyy)</label>
                        <input class="form-control" id="appDate" name="cf_949" type="date" placeholder="App date (mm/dd/yyyy)" data-sb-validations="required" pattern="\d{2}/\d{2}/\d{4}" value="{{ now()->format('Y-m-d') }}" />
                        <div class="invalid-feedback" data-sb-feedback="appDate:required">App date (mm/dd/yyyy) is required.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="age">Age</label>
                        <input class="form-control" id="age" type="number" placeholder="Age" data-sb-validations="required" name="cf_905"/>
                        <div class="invalid-feedback" data-sb-feedback="age:required">Age is required.</div>
                    </div>
            
                    <!-- SSN y Occupation -->
                    <div class="col-md-6">
                        <label class="form-label" for="ssn">SSN</label>
                        <input class="form-control" id="ssn" type="text" placeholder="SSN" data-sb-validations="required" name="cf_945"/>
                        <div class="invalid-feedback" data-sb-feedback="ssn:required">SSN is required.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="occupation">Occupation</label>
                        <input class="form-control" id="occupation" type="text" placeholder="Occupation" data-sb-validations="required" name="cf_947"/>
                        <div class="invalid-feedback" data-sb-feedback="occupation:required">Occupation is required.</div>
                    </div>
            
                    <!-- Contacto -->
                    <div class="col-md-6">
                        <label class="form-label" for="emailAddress">Email Address</label>
                        <input class="form-control" id="emailAddress" type="email" placeholder="Email Address" data-sb-validations="required,email" name="email" />
                        <div class="invalid-feedback" data-sb-feedback="emailAddress:required">Email Address is required.</div>
                        <div class="invalid-feedback" data-sb-feedback="emailAddress:email">Email Address Email is not valid.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="phone">Phone</label>
                        <input class="form-control" id="phone" type="text" placeholder="Phone" data-sb-validations="required" name="mobile" />
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
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" name="lane" />
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-6">
                    <label class="form-label" for="city">City</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" name="city"/>
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" name="state"/>
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-2">
                    <label class="form-label" for="zipCode">Zip Code</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" name="code" />
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
                    <input class="form-control" id="nameSPrimaryBeneficiary" type="text" placeholder="Name(s) Primary Beneficiary" data-sb-validations="" name="cf_955" />
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="beneficiaryExtra">-</label>
                    <input class="form-control" id="beneficiaryExtra" type="text" placeholder="-" data-sb-validations="" name="cf_953"/>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="relationship">Relationship</label>
                    <input class="form-control" id="relationship" type="text" placeholder="Relationship" data-sb-validations="" name="cf_957"/>
                </div>
            </div>
            <hr>
            <h4 class="mb-3">Address</h4>
            <div class="row g-3">
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address</label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" name="cf_965"/>
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-6">
                    <label class="form-label" for="city">City</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" name="cf_967" />
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" name="cf_969" />
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-2">
                    <label class="form-label" for="zipCode">Zip Code</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" name="cf_971" />
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
                    <input class="form-control" id="nameSContingentBeneficiary" type="text" placeholder="Name(s) Primary Beneficiary" data-sb-validations="" name="cf_959"/>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="beneficiaryExtra">-</label>
                    <input class="form-control" id="beneficiaryExtra" type="text" placeholder="-" data-sb-validations="" name="cf_961"/>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="relationship">Relationship</label>
                    <input class="form-control" id="relationship" type="text" placeholder="Relationship" data-sb-validations="" name="cf_963"/>
                </div>
            </div>
            <hr>
            <h4 class="mb-3">Address</h4>
            <div class="row g-3">
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address</label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="required" name="cf_973" />
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-6">
                    <label class="form-label" for="city">City</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="required" name="cf_975"/>
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="required" name="cf_977"/>
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-2">
                    <label class="form-label" for="zipCode">Zip Code</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="required" name="cf_979"/>
                    <div class="invalid-feedback" data-sb-feedback="zipCode:required">Zip Code is required.</div>
                </div>
            </div>
            <!-- Valores ocultos para el formulario NO REMOVER XXX -->
            <input type="hidden" name="cf_941" data-label="" value="{{$agente->referral_code ?? '' }}">
            <input type="hidden" name="cf_929" data-label="" value="occ_life_policy">
            <!-- Botón de Enviar -->
            <button type="submit" class="btn btn-primary w-100 mt-3">Enviar Solicitud</button>
        </form>
    </div>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
