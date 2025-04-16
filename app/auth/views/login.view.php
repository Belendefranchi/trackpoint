<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon">

  <?php require_once __DIR__ . '/../controllers/login.controller.php'; ?>
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100" style="background-color: #D3EBF9;">

  <div class="bg-white rounded-4 shadow p-4 p-md-5 w-100" style="max-width: 420px;">
    <div class="text-center mb-4">
      <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" alt="Logo" class="img-fluid opacity-75" style="max-height: 80px;">
    </div>

    <h2 class="text-center text-primary fw-bold mb-4">Iniciar Sesión</h2>

    <form method="POST">
      <div class="mb-3">
        <label for="email" class="form-label text-dark fw-semibold">Correo electrónico</label>
        <input type="text" class="form-control" id="email" name="email">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label text-dark fw-semibold">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>

      <?php if (isset($message)): ?>
        <div class="alert alert-info text-center py-2">
          <?= $message; ?>
        </div>
      <?php endif; ?>

      <div class="d-grid">
        <input type="submit" value="Ingresar" class="btn btn-primary fw-bold">
      </div>
    </form>

    <div class="text-center mt-3 small text-muted">
      <a href="/trackpoint/public/register" class="d-block text-decoration-none text-primary">¿No tenés una cuenta? Registrate</a>
      <a href="#" class="d-block text-decoration-none text-primary">¿Olvidaste tu contraseña?</a>
    </div>
  </div>

</body>
</html>
