<?php
require_once __DIR__ . '/../controllers/login.controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar Sesión</title>

  <!-- Bootstrap -->
  <link href="/trackpoint/public/assets/css/plugins/bootstrap.min.css" rel="stylesheet" />
  <script src="/trackpoint/public/assets/js/plugins/bootstrap.min.js" defer></script>

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/style.css">
  <link rel="icon" href="/trackpoint/public/assets/images/logo_optimizado_453x453.png" type="image/x-icon">

</head>
<body style="background-color: #D3EBF9;" class="d-flex align-items-center justify-content-center min-vh-100">

  <div class="bg-white rounded-4 shadow p-4 p-md-5 w-100" style="max-width: 420px;">
    <div class="text-center mb-4">
      <img src="/trackpoint/public/assets/images/logo_optimizado_453x453.png" alt="Logo" class="img-fluid opacity-75" style="max-height: 80px;">
    </div>

    <h2 class="text-center text-primary fw-bold mb-4">Iniciar Sesión</h2>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label text-dark fw-semibold" for="username">Usuario</label>
        <input type="text" class="form-control" id="username" name="username">
      </div>

      <div class="mb-3">
        <label class="form-label text-dark fw-semibold" for="password">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>

      <?php if (isset($message)): ?>
        <div class="alert alert-info text-center py-2">
          <?= $message; ?>
        </div>
      <?php endif; ?>

      <div class="d-grid">
        <input class="btn btn-primary fw-bold" type="submit" value="Ingresar">
      </div>
    </form>

    <div class="text-center mt-3 small text-muted">
      <a href="#" class="d-block text-decoration-none text-primary">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</body>
</html>
