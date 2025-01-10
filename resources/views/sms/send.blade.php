<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar SMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Enviar SMS</h1>
        <form action="{{ route('send.sms') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="to" class="form-label">Número de Teléfono</label>
                <input type="text" class="form-control" id="to" name="to" placeholder="+1234567890" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Mensaje</label>
                <textarea class="form-control" id="message" name="message" rows="3" placeholder="Escribe tu mensaje aquí..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar SMS</button>
        </form>
    </div>
</body>
</html>
