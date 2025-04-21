<?php
require_once __DIR__ . '/../../../../middleware/auth.middleware.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? 'Panel de Control' ?></title>

  <!-- Bootstrap -->
  <link href="/trackpoint/public/assets/css/bootstrap.min.css" rel="stylesheet" />
  <script src="/trackpoint/public/assets/js/bootstrap.min.js" defer></script>

  <!-- Estilos personalizados -->
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
          <a class="nav-link text-light" href="/trackpoint/public/ingresos">INGRESO A PLANTA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/trackpoint/public/produccion">PRODUCCIÓN</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="/trackpoint/public/depositos">DEPÓSITOS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="/trackpoint/public/expedicion">EXPEDICIÓN</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="/trackpoint/public/configuracion">CONFIGURACIÓN</a>
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
        

        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuRecetas" role="button" aria-expanded="false" aria-controls="submenuRecetas">
          Recetas
        </a>
        <div class="collapse ps-3" id="submenuRecetas">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/recetas/nuevaReceta">Nueva Receta</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/recetas/recetas">Recetas</a>
        </div>
        
        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuPlanificacion" role="button" aria-expanded="false" aria-controls="submenuPlanificacion">
          Planificación de la producción
        </a>
        <div class="collapse ps-3" id="submenuPlanificacion">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/planificacion/planConSeleccion">Plan con Selección de Stock</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/planificacion/planSinSeleccion">Plan sin Selección de Stock</a>
        </div>

        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuIngreso" role="button" aria-expanded="false" aria-controls="submenuIngreso">
          Ingreso a producción
        </a>
        <div class="collapse ps-3" id="submenuIngreso">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/ingreso/planConSeleccion">Ingreso a proceso con Selección de Stock</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/ingreso/planSinSeleccion">Ingreso a proceso sin Selección de Stock</a>
        </div>

        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuEtqPrimarias" role="button" aria-expanded="false" aria-controls="submenuEtqPrimarias">
          Emisión de Etiquetas Primarias
        </a>
        <div class="collapse ps-3" id="submenuEtqPrimarias">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/etqPrimarias/planConSeleccion">Etiquetas primarias con Selección de Stock</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/etqPrimarias/planSinSeleccion">Etiquetas primarias sin Selección de Stock</a>
        </div>

        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#submenuEtqSecundarias" role="button" aria-expanded="false" aria-controls="submenuEtqSecundarias">
          Emisión de Etiquetas Secundarias
        </a>
        <div class="collapse ps-3" id="submenuEtqSecundarias">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/etqSecundarias/planConSeleccion">Etiquetas secundarias con Selección de Stock</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/etqSecundarias/planSinSeleccion">Etiquetas secundarias sin Selección de Stock</a>
        </div>

<!--         <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#conSelStock" role="button" aria-expanded="false" aria-controls="conSelStock">
          Con selección de stock
        </a>
        <div class="collapse ps-3" id="conSelStock">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/conSelStock/recetas">Recetas</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/conSelStock/planificacion">Planificación de la Producción</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/conSelStock/ingresoaProd">Ingreso a Producción</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/conSelStock/etqsPrimarias">Etiquetas Primarias</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/conSelStock/etqsSecundarias">Etiquetas Secundarias</a>
        </div>

        <a class="nav-link text-dark fw-semibold" data-bs-toggle="collapse" href="#sinSelStock" role="button" aria-expanded="false" aria-controls="sinSelStock">
          Sin selección de stock
        </a>
        <div class="collapse ps-3" id="sinSelStock">
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/sinSelStock/recetas">Recetas</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/sinSelStock/planificacion">Planificación de la Producción</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/sinSelStock/ingresoaProd">Ingreso a Producción</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/sinSelStock/etqsPrimarias">Etiquetas Primarias</a>
          <a class="nav-link text-muted" href="/trackpoint/public/produccion/sinSelStock/etqsSecundarias">Etiquetas Secundarias</a>
        </div> -->
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
