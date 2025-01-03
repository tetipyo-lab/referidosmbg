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
                    <p class="text-muted" style="font-size: 1.2rem; color: rgba(255, 255, 255, 0.7);">Name: <strong style="font-weight: bold; color: white;">{{$agente->name}}</strong></p>
                    <p class="text-muted" style="font-size: 1.2rem; color: rgba(255, 255, 255, 0.7);">NPN Agent: <strong style="font-weight: bold; color: white;">{{$agente->agent_npn}}</strong></p>
                </div>
            </div>
            
             <!-- Espacio para la foto -->
            <div class="col-md-4 text-center mb-4" style="background-color: #4BB6B3; height: 100%; display: flex; justify-content: center; align-items: center;">
                <img src="{{ Storage::url($agente->profile_photo) }}" alt="Foto del Agente" class="img-fluid rounded-rectangule" style="width: 80%; height: 100%; object-fit: cover; border: 5px solid white; margin: 2px;">
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
            <input name="cf_949" type="hidden" value="{{ now()->toDateString() }}">
            <!-- Hidden Fields -->
               
            <div class="row g-3" style="background-color: #0769b4; color: white; padding: 20px; font-family: Arial, sans-serif;">
                <h4 class="mb-3">Insured Information / Información del Asegurado</h4>
                <!-- Nombre y Apellido -->
                <div class="col-md-6">
                    <label class="form-label" for="firstName">First Name / Nombre</label>
                    <input class="form-control" id="firstName" name="firstname" type="text" placeholder="First Name / Nombre" data-sb-validations="required">
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
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control" id="dobMonth" name="cf_981" data-sb-validations="required">
                                <option value="">MM</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                            <div class="invalid-feedback" data-sb-feedback="dobMonth:required">Month is required.</div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" id="dobDay" name="cf_983" data-sb-validations="required">
                                <option value="">DD</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                            <div class="invalid-feedback" data-sb-feedback="dobDay:required">Day is required.</div>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" id="dobYear" name="cf_985" type="text" placeholder="YYYY" maxlength="4" data-sb-validations="required">
                            <div class="invalid-feedback" data-sb-feedback="dobYear:required">Year is required.</div>
                        </div>
                    </div>
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
                    <input class="form-control" id="emailAddress" type="email" placeholder="Email Address" data-sb-validations="required" name="email">
                    <div class="invalid-feedback" data-sb-feedback="emailAddress:required">Email Address is required.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="phone">Phone / Teléfono</label>
                    <input class="form-control phoneValid" id="phone" type="text" placeholder="Phone number with country code" data-sb-validations="required" name="mobile">
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
                    <label class="form-label" for="nameSPrimaryBeneficiary">Name(s) / Nombre(s)</label>
                    <input class="form-control" id="nameSPrimaryBeneficiary" type="text" data-sb-validations="" name="cf_955">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="beneficiaryExtra">Last Name(s) / Apellido(s)</label>
                    <input class="form-control" id="beneficiaryExtra" type="text" data-sb-validations="" name="cf_953">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="relationship">Relationship / Parentesco</label>
                    <input class="form-control" id="relationship" type="text" data-sb-validations="" name="cf_957">
                </div>
            </div>
            <div class="row g-3" style="background-color: #4BB6B3; color: white; padding: 20px; font-family: Arial, sans-serif;">
                <!-- Contacto -->
                <div class="col-md-6">
                    <label class="form-label" for="emailAddressPrimary">Email Address / Correo Electrónico</label>
                    <input class="form-control" id="emailAddressPrimary" type="email" placeholder="Email Address" data-sb-validations="" name="email">
                    
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="phonePrimary">Phone / Teléfono</label>
                    <input class="form-control phoneValid" id="phonePrimary" type="text" placeholder="Phone number with country code" data-sb-validations="" name="mobile">
                </div>
            </div>
            <hr>
            <div class="row g-3" style="background-color: #4BB6B3; color: white; padding: 20px; font-family: Arial, sans-serif;">
                <h4 class="mb-3" >Address</h4>
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address / Dirección</label>
                    <input class="form-control" id="streetAddress" type="text" data-sb-validations="required" name="cf_965">
                    <div class="invalid-feedback" data-sb-feedback="streetAddress:required">Street Address is required.</div>
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="city">City / Ciudad</label>
                    <input class="form-control" id="city" type="text" data-sb-validations="required" name="cf_967">
                    <div class="invalid-feedback" data-sb-feedback="city:required">City is required.</div>
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State / Estado</label>
                    <input class="form-control" id="state" type="text" data-sb-validations="required" name="cf_969">
                    <div class="invalid-feedback" data-sb-feedback="state:required">State is required.</div>
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="zipCode">Zip Code / Código Postal</label>
                    <input class="form-control" id="zipCode" type="text" data-sb-validations="required" name="cf_971">
                    <div class="invalid-feedback" data-sb-feedback="zipCode:required">Zip Code is required.</div>
                </div>
            </div>
            <hr>
            <!-- Información del Seguro -->
            <div class="row g-3" style="padding: 20px;">
                <h4 class="mb-3">Contingent Beneficiary / Beneficiario Contingente</h4>
                <!-- Beneficiario Principal -->
                <div class="col-md-6">
                    <label class="form-label" for="nameSContingetBeneficiary">Name(s) / Nombre(s)</label>
                    <input class="form-control" id="nameSContingentBeneficiary" type="text" data-sb-validations="" name="cf_959">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="beneficiaryExtra">Last Name(s) / Apellido(s)</label>
                    <input class="form-control" id="beneficiaryExtra" type="text" data-sb-validations="" name="cf_961">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="relationship">Relationship / Parantesco</label>
                    <input class="form-control" id="relationship" type="text" data-sb-validations="" name="cf_963">
                </div>
            </div>
            <div class="row g-3" style="padding: 20px;" >
                <!-- Contacto -->
                <div class="col-md-6">
                    <label class="form-label" for="emailAddressContingent">Email Address / Correo Electrónico</label>
                    <input class="form-control" id="emailAddressContingent" type="email" placeholder="Email Address" data-sb-validations="" name="email">
                    
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="phoneContingent">Phone / Teléfono</label>
                    <input class="form-control phoneValid" id="phoneContingent" type="text" placeholder="Phone number with country code" data-sb-validations="" name="mobile">
                </div>
            </div>
            <hr>
            <div class="row g-3" style="padding: 20px;">
                <h4 class="mb-3">Address</h4>
                <!-- Street Address - Ocupa toda la fila -->
                <div class="col-12">
                    <label class="form-label" for="streetAddress">Street Address / Dirección </label>
                    <input class="form-control" id="streetAddress" type="text" placeholder="Street Address" data-sb-validations="" name="cf_973">
                </div>
                
                <!-- City - Ocupa 6 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="city">City / Ciudad</label>
                    <input class="form-control" id="city" type="text" placeholder="City" data-sb-validations="" name="cf_975">
                </div>
                
                <!-- State - Ocupa 4 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="state">State / Estado</label>
                    <input class="form-control" id="state" type="text" placeholder="State" data-sb-validations="" name="cf_977">
                </div>
                
                <!-- Zip Code - Ocupa 2 columnas -->
                <div class="col-md-4">
                    <label class="form-label" for="zipCode">Zip Code / Código Postal</label>
                    <input class="form-control" id="zipCode" type="text" placeholder="Zip Code" data-sb-validations="" name="cf_979">
                </div>
            </div>
            <!-- Valores ocultos para el formulario NO REMOVER XXX -->
            <input type="hidden" name="cf_941" data-label="" value="{{$agente->referral_code}}">
            <input type="hidden" name="cf_929" data-label="" value="occ_life_policy">
            <!-- Botón de Enviar -->
            <button type="button" id="btnSubmit" class="btn btn-primary w-100 mt-3">Enviar Solicitud</button>
        </form>

        <footer class="bg-dark text-white text-center py-4" style="background-color: #0769b4;">
            <p>© 2024 Mario Barrera Insurance. All rights reserved.</p>
            <p>Website by Mario Barrera</p>
        </footer>
    
    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/occidental/form-validate.js') }}"></script>    
</body>
</html>
