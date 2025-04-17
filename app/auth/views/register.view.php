<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro de usuario</title>

  <!-- Bootstrap -->
  <link href="/trackpoint/public/assets/css/bootstrap.min.css" rel="stylesheet" />
  <script src="/trackpoint/public/assets/bootstrap.min.js" defer></script>

  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon">

  <?php
    require_once __DIR__ . '/../controllers/register.controller.php';
  ?>

</head>
<body style="background-color: #D3EBF9;" class="d-flex align-items-center justify-content-center min-vh-100">
  
  <div class="bg-white rounded-4 shadow p-4 p-md-5 w-100" style="max-width: 420px;">
    <div class="text-center mb-4">
      <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" alt="Logo" class="img-fluid opacity-75" style="max-height: 80px;">
    </div>

    <h2 class="text-center text-primary fw-bold mb-4">Crear Usuario</h2>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label text-dark fw-semibold" for="nombre_completo">Nombre completo</label>
        <input class="form-control" type="text" id="nombre_completo" name="nombre_completo">
      </div>

      <div>
        <label class="form-label text-dark fw-semibold" for="email">Email</label>
        <input class="form-control" type="email" id="email" name="email">
      </div>

      <div>
        <label class="form-label text-dark fw-semibold" for="username">Usuario</label>
        <input class="form-control" type="text" id="username" name="username">
      </div>

      <div>
        <label class="form-label text-dark fw-semibold" for="password">Contraseña</label>
        <input class="form-control" type="password" id="password" name="password">
      </div>

      <div>
        <label class="form-label text-dark fw-semibold" for="rol">Rol</label>
        <select class="form-control" name="rol">
          <option value="">Seleccionar rol</option>
          <option value="admin">Administrador</option>
          <option value="operario">Operario</option>
          <option value="supervisor">Supervisor</option>
        </select>
      </div>

      <?php if (isset($message)): ?>
        <div class="alert alert-info text-center py-2">
          <?= $message; ?>
        </div>
      <?php endif; ?>

      <div class="d-grid">
        <input class="btn btn-primary fw-bold" type="submit" value="Registrarse">
      </div>
    </form>

    <div class="text-center mt-3 small text-muted">
      <a href="/trackpoint/public/login" class="d-block text-decoration-none text-primary">¿Ya tenés cuenta? Iniciar sesión</a>
    </div>
  </div>
</body>
</html>
