<?php
require_once __DIR__ . '/../middleware/auth.middleware.php';
?>
<script>import bootstrap from 'bootstrap';</script>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? 'Panel de Control' ?></title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<!--   <link href="/trackpoint/public/assets/css/bootstrap.min.css" rel="stylesheet" />
  <script src="/trackpoint/public/assets/bootstrap.min.js" defer></script> -->

  <!-- Estilos personalizados -->
<!--   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> -->
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon" />
</head>

<body style="background-color: #D3EBF9;">

<!-- Navbar -->
<nav class="navbar navbar-dark" style="background-color: #22265D;">
  <div class="container-fluid">
    
    <div class="col-2 d-flex align-items-center justify-content-center">
      <a class="navbar-brand d-flex align-items-center gap-2" href="/trackpoint/public/">
        <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="Logo" width="30" height="30" />
        TrackPoint
      </a>
    </div>

    <div class="col-6 d-flex justify-content-start align-items-center">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">PRODUCCIÓN</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="#">EXPEDICIÓN</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="#">CONFIGURACIÓN</a>
        </li>
      </ul>
    </div>

    <div class="col-4 d-flex align-items-center justify-content-end">
      <div class="search-bar d-flex align-items-center me-3">
        <i class="bd-search"></i>
        <input type="text" class="form-control search-input" id="search" placeholder="Buscar..." aria-label="Search" />
      </div>

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
        
        <!--  -->
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuRecetas" role="button" aria-expanded="false" aria-controls="submenuRecetas">Recetas</a>
        <div class="collapse ps-3" id="submenuRecetas">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/recetas/nuevaReceta">Nueva Recetas</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/recetas/recetas">Recetas</a>
        </div>

        <!--  -->
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuPlanificacion" role="button" aria-expanded="false" aria-controls="submenuPlanificacion">
        Planificación de la producción
        </a>
        <div class="collapse ps-3" id="submenuPlanificacion">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/planificacion/planConSeleccion">Plan con Selección de Stock</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/planificacion/planSinSeleccion">Plan sin Selección de Stock</a>
        </div>

        <!--   -->
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuIngreso" role="button" aria-expanded="false" aria-controls="submenuIngreso">
        Ingreso a producción
        </a>
        <div class="collapse ps-3" id="submenuIngreso">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/ingreso/planConSeleccion">Plan con Selección de Stock</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/ingreso/planSinSeleccion">Plan sin Selección de Stock</a>
        </div>

        <!--   -->
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuEtqPrimarias" role="button" aria-expanded="false" aria-controls="submenuEtqPrimarias">
        Emisión de Etiquetas Primarias
        </a>
        <div class="collapse ps-3" id="submenuEtqPrimarias">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/etqPrimarias/planConSeleccion">Plan con Selección de Stock</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/etqPrimarias/planSinSeleccion">Plan sin Selección de Stock</a>
        </div>

        <!--   -->
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuEtqSecundarias" role="button" aria-expanded="false" aria-controls="submenuEtqSecundarias">
        Emisión de Etiquetas Secundarias
        </a>
        <div class="collapse ps-3" id="submenuEtqSecundarias">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/etqSecundarias/planConSeleccion">Plan con Selección de Stock</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/etqSecundarias/planSinSeleccion">Plan sin Selección de Stock</a>
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
