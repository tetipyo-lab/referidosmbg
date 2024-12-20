<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mario Barrera Group - Insurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="mb-4">Insured Information</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Datos del titular -->
        <h5>Datos del Agente</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="titularNombre" class="form-label">Nombre Completo: {{$agente->name}}</label>
            </div>
            <div class="col-md-4">
                <label for="titularCedula" class="form-label">Email: {{$agente->email}}</label>
            </div>
            <div class="col-md-4">
                <label for="titularCedula" class="form-label">Código referente: {{$agente->referral_code}}</label>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $agente->profile_photo) }}" alt="Foto de Perfil" class="img-responsive" width="200">
            </div>
            
        </div>    
        <form action="#" method="POST">
            @csrf

            <!-- Datos del titular -->
            <h5>Datos del Titular</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="titularNombre" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="titularNombre" name="titularNombre" value="{{ old('titularNombre') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="titularCedula" class="form-label">Cédula / Identificación</label>
                    <input type="text" class="form-control" id="titularCedula" name="titularCedula" value="{{ old('titularCedula') }}" required>
                </div>
                
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="titularTelefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="titularTelefono" name="titularTelefono" value="{{ old('titularTelefono') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="titularEmail" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="titularEmail" name="titularEmail" value="{{ old('titularEmail') }}" required>
                </div>
            </div>

            <!-- Campo referido -->
            <div class="mb-3">
                <label for="referred" class="form-label">Referido Por</label>
                <input type="text" class="form-control" id="referred" name="referred" value="{{ old('referred') }}" required>
            </div>

            <!-- Beneficiarios -->
            <h5 class="mt-4">Beneficiarios</h5>
            <div id="beneficiarios">
                <div class="beneficiario mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" name="beneficiarios[0][nombre]" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Parentesco</label>
                            <input type="text" class="form-control" name="beneficiarios[0][parentesco]" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Edad</label>
                            <input type="number" class="form-control" name="beneficiarios[0][edad]" min="0" max="120" required>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm mb-3" id="agregarBeneficiario">+ Agregar Beneficiario</button>

            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="reset" class="btn btn-secondary">Limpiar</button>
            </div>
        </form>
    </div>

    <script>
        // Agregar más beneficiarios dinámicamente
        let beneficiarioIndex = 1;
        document.getElementById('agregarBeneficiario').addEventListener('click', function() {
            const beneficiarios = document.getElementById('beneficiarios');
            const nuevoBeneficiario = document.createElement('div');
            nuevoBeneficiario.classList.add('beneficiario', 'mb-3');
            nuevoBeneficiario.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" name="beneficiarios[${beneficiarioIndex}][nombre]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Parentesco</label>
                        <input type="text" class="form-control" name="beneficiarios[${beneficiarioIndex}][parentesco]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Edad</label>
                        <input type="number" class="form-control" name="beneficiarios[${beneficiarioIndex}][edad]" min="0" max="120" required>
                    </div>
                </div>
            `;
            beneficiarios.appendChild(nuevoBeneficiario);
            beneficiarioIndex++;
        });
    </script>
</body>
</html>
