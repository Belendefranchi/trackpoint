<?php
// layouts/layout.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'Panel de Control' ?></title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

  <!-- Estilos propios -->
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_blanco.png" type="image/x-icon">
</head>
<body style="background-color: #D3EBF9;">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #22265D;">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/trackpoint/public/">
      <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" alt="Logo" width="30" height="30">
      TrackPoint
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-white" href="/trackpoint/public/dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/trackpoint/public/produccion">Producción</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/trackpoint/public/expedicion">Expedición</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/trackpoint/public/configuracion">Configuración</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-info" href="/trackpoint/public/logout">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Contenido principal -->
<main class="container py-4">
  <?= $content ?? '' ?>
</main>

</body>
</html>
