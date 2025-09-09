<?php
require_once __DIR__ . '/../../../../core/middleware/auth.middleware.php';
require_once __DIR__ . '/../../../../core/middleware/permisos.middleware.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
require_once __DIR__ . '/../../../layouts/layout.view.php';

verificarPermiso();

$currentUri = $_SERVER['REQUEST_URI'];

$abmsOpen = str_contains($currentUri, '/expedicion/ABMs') ? 'show' : '';
$abmsActive = str_contains($currentUri, '/expedicion/ABMs') ? 'active' : '';

$egresosOpen = str_contains($currentUri, '/expedicion/egresos') ? 'show' : '';
$egresosActive = str_contains($currentUri, '/expedicion/egresos') ? 'active' : '';

$despachosOpen = str_contains($currentUri, '/expedicion/despachos') ? 'show' : '';
$despachosActive = str_contains($currentUri, '/expedicion/despachos') ? 'active' : '';

$remitosOpen = str_contains($currentUri, '/expedicion/remitos') ? 'show' : '';
$remitosActive = str_contains($currentUri, '/expedicion/remitos') ? 'active' : '';

$activeItems = [
  // Ítems del submenú ABM
  'destinos' => str_contains($currentUri, 'destinos') ? 'fw-semibold text-primary' : '',
  'transportes' => str_contains($currentUri, 'transportes') ? 'fw-semibold text-primary' : '',
  'vehiculos' => str_contains($currentUri, 'vehiculos') ? 'fw-semibold text-primary' : '',

  // Ítems del submenú Egresos
  'ventas' => str_contains($currentUri, 'ventas') ? 'fw-semibold text-primary' : '',
  'cierre' => str_contains($currentUri, 'cierre') ? 'fw-semibold text-primary' : '',

  // Ítems del submenú Despachos
  'nuevo_despacho' => str_contains($currentUri, 'nuevo_despacho') ? 'fw-semibold text-primary' : '',
  'reimpresion_despachos' => str_contains($currentUri, 'reimpresion_despachos') ? 'fw-semibold text-primary' : '',
  'eliminacion_despachos' => str_contains($currentUri, 'eliminacion_despachos') ? 'fw-semibold text-primary' : '',

  // Ítems del Submenú Remitos
  'nuevo_remito' => str_contains($currentUri, 'nuevo_remito') ? 'fw-semibold text-primary' : '',
  'reimpresion_remitos' => str_contains($currentUri, 'reimpresion_remitos') ? 'fw-semibold text-primary' : '',
  'eliminacion_remitos' => str_contains($currentUri, 'eliminacion_remitos') ? 'fw-semibold text-primary' : '',
];
?>
      <div class="col-6 d-flex justify-content-start align-items-center">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/recepcion">RECEPCIÓN</a>
          </li>
<!--           <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/produccion">PRODUCCIÓN</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/depositos">DEPÓSITOS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white active" style="background-color: #3A4280;" href="/trackpoint/public/expedicion" aria-current="page">EXPEDICIÓN</a>
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
          <a class="nav-link text-white table-hover rounded <?= $abmsActive ?>" data-bs-toggle="collapse" href="#submenuABM" role="button" aria-expanded="<?= $abmsOpen ? 'true' : 'false' ?>" aria-controls="submenuABM">
            ABM
          </a>
          <div class="collapse ps-3 <?= $abmsOpen ?>" id="submenuABM">
            <a class="nav-link <?= $activeItems['destinos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/ABMs/destinos">Destinos</a>
            <a class="nav-link <?= $activeItems['transportes'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/ABMs/transportes">Transportes</a>
            <a class="nav-link <?= $activeItems['vehiculos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/ABMs/vehiculos">Vehículos</a>
          </div>
          
          <a class="nav-link text-white table-hover rounded <?= $egresosActive ?>" data-bs-toggle="collapse" href="#submenuEgresos" role="button" aria-expanded="<?= $egresosOpen ? 'true' : 'false' ?>" aria-controls="submenuEgresos">
            EGRESOS
          </a>
          <div class="collapse ps-3 <?= $egresosOpen ?>" id="submenuEgresos">
            <a class="nav-link <?= $activeItems['ventas'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/egresos/ventas">Ventas</a>
            <a class="nav-link <?= $activeItems['cierre'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/egresos/cierre">Cierre de caja</a>
          </div>

          <a class="nav-link text-white table-hover rounded <?= $despachosActive ?>" data-bs-toggle="collapse" href="#submenuDespachos" role="button" aria-expanded="<?= $despachosOpen ? 'true' : 'false' ?>" aria-controls="submenuDespachos">
            DESPACHOS
          </a>
          <div class="collapse ps-3 <?= $despachosOpen ?>" id="submenuDespachos">
            <a class="nav-link <?= $activeItems['nuevo_despacho'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/despachos/nuevo_despacho">Nuevo despacho</a>
            <a class="nav-link <?= $activeItems['reimpresion_despachos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/despachos/reimpresion_despachos">Reimpresión de despachos</a>
            <a class="nav-link <?= $activeItems['eliminacion_despachos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/despachos/eliminacion_despachos">Eliminación de despachos</a>
          </div>

          <a class="nav-link text-white table-hover rounded <?= $remitosActive ?>" data-bs-toggle="collapse" href="#submenuRemitos" role="button" aria-expanded="<?= $remitosOpen ? 'true' : 'false' ?>" aria-controls="submenuRemitos">
            REMITOS
          </a>
          <div class="collapse ps-3 <?= $remitosOpen ?>" id="submenuRemitos">
            <a class="nav-link <?= $activeItems['nuevo_remito'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/remitos/nuevo_remito">Nuevo remito</a>
            <a class="nav-link <?= $activeItems['reimpresion_remitos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/remitos/reimpresion_remitos">Reimpresión de remitos</a>
            <a class="nav-link <?= $activeItems['eliminacion_remitos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/expedicion/remitos/eliminacion_remitos">Eliminación de remitos</a>
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