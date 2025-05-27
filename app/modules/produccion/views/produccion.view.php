<?php
require_once __DIR__ . '/../../../../core/middleware/auth.middleware.php';
/* require_once __DIR__ . '/../controllers/produccion.controller.php'; */

$currentUri = $_SERVER['REQUEST_URI'];

$abmsOpen = str_contains($currentUri, '/produccion/ABMs') ? 'show' : '';
$abmsActive = str_contains($currentUri, '/produccion/ABMs') ? 'active' : '';

$recetasOpen = str_contains($currentUri, '/produccion/recetas') ? 'show' : '';
$recetasActive = str_contains($currentUri, '/produccion/recetas') ? 'active' : '';

$planificacionOpen = str_contains($currentUri, '/produccion/planificacion') ? 'show' : '';
$planificacionActive = str_contains($currentUri, '/produccion/planificacion') ? 'active' : '';

$ingresoOpen = str_contains($currentUri, '/produccion/ingreso') ? 'show' : '';
$ingresoActive = str_contains($currentUri, '/produccion/ingreso') ? 'active' : '';

$etqPrimariasOpen = str_contains($currentUri, '/produccion/etqPrimarias') ? 'show' : '';
$etqPrimariasActive = str_contains($currentUri, '/produccion/etqPrimarias') ? 'active' : '';

$etqSecundariasOpen = str_contains($currentUri, '/produccion/etqSecundarias') ? 'show' : '';
$etqSecundariasActive = str_contains($currentUri, '/produccion/etqSecundarias') ? 'active' : '';

$activeItems = [
  // Ítems del submenú ABMs
  'familias' => str_contains($currentUri, 'familias') ? 'fw-semibold text-primary' : '',
  'grupos' => str_contains($currentUri, 'grupos') ? 'fw-semibold text-primary' : '',
  'subGrupos' => str_contains($currentUri, 'subGrupos') ? 'fw-semibold text-primary' : '',
  'mercaderias' => str_contains($currentUri, 'mercaderias') ? 'fw-semibold text-primary' : '',
  'procesos' => str_contains($currentUri, 'procesos') ? 'fw-semibold text-primary' : '',
  'traducciones' => str_contains($currentUri, 'traducciones') ? 'fw-semibold text-primary' : '',

  // Ítems del Submenú Recetas
  'nuevaReceta' => str_contains($currentUri, 'nuevaReceta') ? 'fw-semibold text-primary' : '',
  'recetas' => str_contains($currentUri, 'recetas') ? 'fw-semibold text-primary' : '',

  // Ítems del Submenú Planificación
  'planConSeleccion' => str_contains($currentUri, 'planConSeleccion') ? 'fw-semibold text-primary' : '',
  'planSinSeleccion' => str_contains($currentUri, 'planSinSeleccion') ? 'fw-semibold text-primary' : '',

  // Ítems del Submenú Ingreso
  'ingresoConSeleccion' => str_contains($currentUri, 'ingresoConSeleccion') ? 'fw-semibold text-primary' : '',
  'ingresoSinSeleccion' => str_contains($currentUri, 'ingresoSinSeleccion') ? 'fw-semibold text-primary' : '',

  // Ítems del Submenú Etiquetas Primarias
  'etqPrimariasConSeleccion' => str_contains($currentUri, 'etqPrimariasConSeleccion') ? 'fw-semibold text-primary' : '',
  'etqPrimariasSinSeleccion' => str_contains($currentUri, 'etqPrimariasSinSeleccion') ? 'fw-semibold text-primary' : '',

  // Ítems del Submenú Etiquetas Secundarias
  'etqSecundariasConSeleccion' => str_contains($currentUri, 'etqSecundariasConSeleccion') ? 'fw-semibold text-primary' : '',
  'etqSecundariasSinSeleccion' => str_contains($currentUri, 'etqSecundariasSinSeleccion') ? 'fw-semibold text-primary' : '',
];

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? 'Producción' ?></title>

  <!-- Bootstrap -->
  <link href="/trackpoint/public/assets/css/bootstrap.min.css" rel="stylesheet" />
  <script src="/trackpoint/public/assets/js/bootstrap.min.js" defer></script>

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/style.css">
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon" />
  <style>
    .nav-link.active-lateral {
      color: #22265D !important;
      font-weight: 600;
      border-left: 4px solid #22265D;
      padding-left: 0.75rem; /* igual a ps-3 */
      background-color: #e9ecef; /* opcional, mejora contraste */
    }
  </style>
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
            <a class="nav-link active" href="/trackpoint/public/produccion" aria-current="page">PRODUCCIÓN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="/trackpoint/public/depositos">DEPÓSITOS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="/trackpoint/public/expedicion">EXPEDICIÓN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="/trackpoint/public/reportes">REPORTES</a>
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
          
          <a class="nav-link text-dark fw-semibold <?= $abmsActive ?>" data-bs-toggle="collapse" href="#submenuABMs" role="button" aria-expanded="<?= $abmsOpen ? 'true' : 'false' ?>" aria-controls="submenuABMs">
            ABMs
          </a>
          <div class="collapse ps-3" id="submenuABMs">
            <a class="nav-link <?= $activeItems['familias'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/ABMs/familias">Familias</a>
            <a class="nav-link <?= $activeItems['grupos'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/ABMs/grupos">Grupos</a>
            <a class="nav-link <?= $activeItems['subGrupos'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/ABMs/subGrupos">Sub Grupos</a>
            <a class="nav-link <?= $activeItems['mercaderias'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/ABMs/mercaderias">Mercaderías</a>
            <a class="nav-link <?= $activeItems['procesos'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/ABMs/procesos">Procesos Productivos</a>
            <a class="nav-link <?= $activeItems['traducciones'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/ABMs/traducciones">Traducciones</a>
          </div>

          <a class="nav-link text-dark fw-semibold <?= $recetasActive ?>" data-bs-toggle="collapse" href="#submenuRecetas" role="button" aria-expanded="<?= $recetasOpen ? 'true' : 'false' ?>" aria-controls="submenuRecetas">
            Recetas
          </a>
          <div class="collapse ps-3" id="submenuRecetas">
            <a class="nav-link <?= $activeItems['nuevaReceta'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/recetas/nuevaReceta">Nueva Receta</a>
            <a class="nav-link <?= $activeItems['recetas'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/recetas/recetas">Recetas</a>
          </div>
          
          <a class="nav-link text-dark fw-semibold <?= $planificacionActive ?>" data-bs-toggle="collapse" href="#submenuPlanificacion" role="button" aria-expanded="<?= $planificacionOpen ? 'true' : 'false' ?>" aria-controls="submenuPlanificacion">
            Planificación de la producción
          </a>
          <div class="collapse ps-3" id="submenuPlanificacion">
            <a class="nav-link <?= $activeItems['planConSeleccion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/planificacion/planConSeleccion">Plan con Selección de Stock</a>
            <a class="nav-link <?= $activeItems['planSinSeleccion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/planificacion/planSinSeleccion">Plan sin Selección de Stock</a>
          </div>

          <a class="nav-link text-dark fw-semibold <?= $ingresoActive ?>" data-bs-toggle="collapse" href="#submenuIngreso" role="button" aria-expanded="<?= $ingresoOpen ? 'true' : 'false' ?>" aria-controls="submenuIngreso">
            Ingreso a producción
          </a>
          <div class="collapse ps-3" id="submenuIngreso">
            <a class="nav-link <?= $activeItems['ingresoConSeleccion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/ingreso/planConSeleccion">Ingreso a proceso con Selección de Stock</a>
            <a class="nav-link <?= $activeItems['ingresoSinSeleccion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/ingreso/planSinSeleccion">Ingreso a proceso sin Selección de Stock</a>
          </div>

          <a class="nav-link text-dark fw-semibold <?= $etqPrimariasActive ?>" data-bs-toggle="collapse" href="#submenuEtqPrimarias" role="button" aria-expanded="<?= $etqPrimariasOpen ? 'true' : 'false' ?>" aria-controls="submenuEtqPrimarias">
            Emisión de Etiquetas Primarias
          </a>
          <div class="collapse ps-3" id="submenuEtqPrimarias">
            <a class="nav-link <?= $activeItems['etqPrimariasConSeleccion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/etqPrimarias/planConSeleccion">Etiquetas primarias con Selección de Stock</a>
            <a class="nav-link <?= $activeItems['etqPrimariasSinSeleccion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/etqPrimarias/planSinSeleccion">Etiquetas primarias sin Selección de Stock</a>
          </div>

          <a class="nav-link text-dark fw-semibold <?= $etqSecundariasActive ?>" data-bs-toggle="collapse" href="#submenuEtqSecundarias" role="button" aria-expanded="<?= $etqSecundariasOpen ? 'true' : 'false' ?>" aria-controls="submenuEtqSecundarias">
            Emisión de Etiquetas Secundarias
          </a>
          <div class="collapse ps-3" id="submenuEtqSecundarias">
            <a class="nav-link <?= $activeItems['etqSecundariasConSeleccion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/etqSecundarias/planConSeleccion">Etiquetas secundarias con Selección de Stock</a>
            <a class="nav-link <?= $activeItems['etqSecundariasSinSeleccion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/produccion/etqSecundarias/planSinSeleccion">Etiquetas secundarias sin Selección de Stock</a>
          </div>

        </nav>
      </aside>

      <!-- Contenido principal -->
      <main class="col-md-9 col-lg-10 py-4">
          <div class="container">
            <?php if (!empty($content) && file_exists($content)) {
                require $content;
            } else { ?>
                <div class="d-flex justify-content-center align-items-center" style="height: 70vh; position: relative;">
                  <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" 
                      alt="Fondo" 
                      style="opacity: 0.1; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />
                </div>
            <?php } ?>
        </div>
      </main>
    </div>
  </div>

</body>
</html>
