<?php
require_once __DIR__ . '/../../../../core/middleware/auth.middleware.php';
require_once __DIR__ . '/../../../../core/middleware/permisos.middleware.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
require_once __DIR__ . '/../../../layouts/layout.view.php';

verificarPermiso();

$currentUri = $_SERVER['REQUEST_URI'];

$abmsOpen = str_contains($currentUri, '/produccion/ABMs') ? 'show' : '';
$abmsActive = str_contains($currentUri, '/produccion/ABMs') ? 'active' : '';

$recetasOpen = str_contains($currentUri, '/produccion/recetas') ? 'show' : '';
$recetasActive = str_contains($currentUri, '/produccion/recetas') ? 'active' : '';

$planificacionOpen = str_contains($currentUri, '/produccion/planificacion') ? 'show' : '';
$planificacionActive = str_contains($currentUri, '/produccion/planificacion') ? 'active' : '';

$ingresoOpen = str_contains($currentUri, '/produccion/ingreso') ? 'show' : '';
$ingresoActive = str_contains($currentUri, '/produccion/ingreso') ? 'active' : '';

$salidaOpen = str_contains($currentUri, '/produccion/salida') ? 'show' : '';
$salidaActive = str_contains($currentUri, '/produccion/salida') ? 'active' : '';

/* $etqPrimariasOpen = str_contains($currentUri, '/produccion/etqPrimarias') ? 'show' : '';
$etqPrimariasActive = str_contains($currentUri, '/produccion/etqPrimarias') ? 'active' : '';

$etqSecundariasOpen = str_contains($currentUri, '/produccion/etqSecundarias') ? 'show' : '';
$etqSecundariasActive = str_contains($currentUri, '/produccion/etqSecundarias') ? 'active' : ''; */

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

  // Ítems del Submenú Salida
  'salidaEtqPriConSeleccion' => str_contains($currentUri, 'etqPriConSeleccion') ? 'fw-semibold text-primary' : '',
  'salidaEtqPriSinSeleccion' => str_contains($currentUri, 'etqPriSinSeleccion') ? 'fw-semibold text-primary' : '',
  'salidaEtqSecConSeleccion' => str_contains($currentUri, 'etqSecConSeleccion') ? 'fw-semibold text-primary' : '',
  'salidaEtqSecSinSeleccion' => str_contains($currentUri, 'etqSecSinSeleccion') ? 'fw-semibold text-primary' : '',

];

?>

      <div class="col-6 d-flex justify-content-start align-items-center">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/recepcion">RECEPCIÓN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white active" style="background-color: #3A4280;" href="/trackpoint/public/produccion" aria-current="page">PRODUCCIÓN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/depositos">DEPÓSITOS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/expedicion">EXPEDICIÓN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/reportes">REPORTES</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/configuracion">CONFIGURACIÓN</a>
          </li>
          <?php if (isset($_SESSION['username']) && $_SESSION['username'] === superadmin): ?>
            <li class="nav-item">
              <a class="nav-link text-white table-hover" href="/trackpoint/public/sistema">SISTEMA</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>

      <div class="col-4 d-flex align-items-center justify-content-end">
        <div class="search-bar d-flex align-items-center me-3">
          <i class="bd-search"></i>
          <input type="text" class="form-control search-input" id="search" placeholder="Buscar..." aria-label="Search" />
        </div>
        <a class="nav-link text-white p-2"><?php echo $_SESSION['username']?></a>
        <p class="nav-link text-white p-2 m-0"> | </p>
        <a class="nav-link text-white p-2" href="/trackpoint/public/logout">Cerrar sesión</a>
      </div>
    </div>
  </nav>

  <!-- Layout con Aside + Main -->
  <div class="container-fluid">
    <div class="row">
      <!-- Aside -->
      <aside class="col-md-3 col-lg-2 min-vh-100 py-4 px-3" style="background-color: #22265D; color: white;">
        <div class="nav flex-column">
          <a class="nav-link text-white table-hover rounded <?= $abmsActive ?>" data-bs-toggle="collapse" href="#submenuABMs" role="button" aria-expanded="<?= $abmsOpen ? 'true' : 'false' ?>" aria-controls="submenuABMs">
            ABM
          </a>
          <div class="collapse ps-3 <?= $abmsOpen ?>" id="submenuABMs">
<!--             <a class="nav-link <?= $activeItems['familias'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/familias">Familias</a> -->
            <a class="nav-link <?= $activeItems['grupos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/grupos">Grupos</a>
            <a class="nav-link <?= $activeItems['subGrupos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/subGrupos">Sub Grupos</a>
            <a class="nav-link <?= $activeItems['mercaderias'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/mercaderias">Mercaderías</a>
            <a class="nav-link <?= $activeItems['procesos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/procesos">Procesos Productivos</a>
            <a class="nav-link <?= $activeItems['traducciones'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/traducciones">Traducciones</a>
          </div>

          <a class="nav-link text-white table-hover rounded <?= $recetasActive ?>" data-bs-toggle="collapse" href="#submenuRecetas" role="button" aria-expanded="<?= $recetasOpen ? 'true' : 'false' ?>" aria-controls="submenuRecetas">
            RECETAS
          </a>
          <div class="collapse ps-3 <?= $recetasOpen ?>" id="submenuRecetas">
            <a class="nav-link <?= $activeItems['nuevaReceta'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/recetas/nuevaReceta">Nueva Receta</a>
            <a class="nav-link <?= $activeItems['recetas'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/recetas/recetas">Recetas</a>
          </div>
          
          <a class="nav-link text-white table-hover rounded <?= $planificacionActive ?>" data-bs-toggle="collapse" href="#submenuPlanificacion" role="button" aria-expanded="<?= $planificacionOpen ? 'true' : 'false' ?>" aria-controls="submenuPlanificacion">
            PLANIFICACIÓN DE LA PRODUCCIÓN
          </a>
          <div class="collapse ps-3 <?= $planificacionOpen ?>" id="submenuPlanificacion">
            <a class="nav-link <?= $activeItems['planConSeleccion'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/planificacion/planConSeleccion">Plan con Selección de Stock</a>
            <a class="nav-link <?= $activeItems['planSinSeleccion'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/planificacion/planSinSeleccion">Plan sin Selección de Stock</a>
          </div>

          <a class="nav-link text-white table-hover rounded <?= $ingresoActive ?>" data-bs-toggle="collapse" href="#submenuIngreso" role="button" aria-expanded="<?= $ingresoOpen ? 'true' : 'false' ?>" aria-controls="submenuIngreso">
            INGRESO A PRODUCCIÓN
          </a>
          <div class="collapse ps-3 <?= $ingresoOpen ?>" id="submenuIngreso">
            <a class="nav-link <?= $activeItems['ingresoConSeleccion'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ingreso/planConSeleccion">Ingreso a proceso con Selección de Stock</a>
            <a class="nav-link <?= $activeItems['ingresoSinSeleccion'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ingreso/planSinSeleccion">Ingreso a proceso sin Selección de Stock</a>
          </div>

          <a class="nav-link text-white table-hover rounded <?= $salidaActive ?>" data-bs-toggle="collapse" href="#submenuSalida" role="button" aria-expanded="<?= $salidaOpen ? 'true' : 'false' ?>" aria-controls="submenuSalida">
            SALIDA DE PRODUCCIÓN
          </a>
          <div class="collapse ps-3 <?= $salidaOpen ?>" id="submenuSalida">
            <a class="nav-link <?= $activeItems['salidaEtqPriConSeleccion'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/salida/etqPriConSeleccion">Etiquetas primarias con Selección de Stock</a>
            <a class="nav-link <?= $activeItems['salidaEtqPriSinSeleccion'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/salida/etqPriSinSeleccion">Etiquetas primarias sin Selección de Stock</a>
            <a class="nav-link <?= $activeItems['salidaEtqSecConSeleccion'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/salida/etqSecConSeleccion">Etiquetas secundarias con Selección de Stock</a>
            <a class="nav-link <?= $activeItems['salidaEtqSecSinSeleccion'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/salida/etqSecSinSeleccion">Etiquetas secundarias sin Selección de Stock</a>
          </div>

        </div>
      </aside>
      <!-- Contenido principal -->
      <main class="col-md-9 col-lg-10 p-4">
        <?php if (isset($content) && file_exists($content)) {
          require_once $content;
        } else { ?>
<!--           <div class="d-flex justify-content-center align-items-center" style="height: 70vh;">
                <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" 
                alt="Fondo" 
                style="opacity: 0.4;" />
          </div> -->
        </main>
      </div>
    </div>
    <?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

  </body>
</html>
<?php } ?>