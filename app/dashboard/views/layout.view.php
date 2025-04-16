<?php require_once __DIR__ . '/../../middleware/auth.middleware.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? 'Panel de Control' ?></title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/trackpoint/public/css/style.css" />
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon" />
</head>

<body style="background-color: #D3EBF9;">

<!-- Navbar -->
<nav class="navbar navbar-dark" style="background-color: #22265D;">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/trackpoint/public/">
      <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="Logo" width="30" height="30" />
      TrackPoint
    </a>
    <div class="d-flex">
      <a class="nav-link text-light p-2" href="/trackpoint/public/home">Dashboard</a>
      <a class="nav-link text-info p-2" href="/trackpoint/public/logout">Cerrar sesión</a>
    </div>
  </div>
</nav>

<!-- Layout con Aside + Main -->
<div class="container-fluid">
  <div class="row">
    <!-- Aside -->
    <aside class="col-md-3 col-lg-2 bg-white shadow-sm min-vh-100 py-4 px-3">
      <nav class="nav flex-column">
        

        <!-- Producción (con submenú) -->
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#menuProduccion" role="button" aria-expanded="false" aria-controls="menuProduccion">
          Producción
        </a>
        <div class="collapse ps-3" id="menuProduccion">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion">Recetas</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion">Planificación de la producción</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion">Ingreso a producción</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion">Emisión de etiquetas primarias</a>
        </div>

        <!-- Expedición -->
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#menuExpedicion" role="button" aria-expanded="false" aria-controls="menuExpedicion">
          Expedición
        </a>
        <div class="collapse ps-3" id="menuExpedicion">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/recepcion">Recepción</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/desposte">Desposte</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/cuarto">Cuarteo</a>
        </div>

        <!-- Configuración (colapsable) -->
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#menuConfig" role="button" aria-expanded="false" aria-controls="menuConfig">
          Configuración
        </a>
        <div class="collapse ps-3" id="menuConfig">
          <a class="nav-link text-muted" href="/trackpoint/public/configuracion/usuarios">Usuarios</a>
          <a class="nav-link text-muted" href="/trackpoint/public/configuracion/parametros">Parámetros</a>
        </div>
      </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="col-md-9 col-lg-10 py-4">
      <div class="container">
        <?= $content ?? '' ?>
      </div>
    </main>
  </div>
</div>

</body>
</html>
