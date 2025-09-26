<?php
require_once __DIR__ . '/../../../../core/middleware/auth.middleware.php';
require_once __DIR__ . '/../../../../core/middleware/permisos.middleware.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
require_once __DIR__ . '/../../../layouts/layout.view.php';

verificarPermiso();

$currentUri = $_SERVER['REQUEST_URI'];

$abmsOpen = str_contains($currentUri, '/recepcion/ABMs') ? 'show' : '';
$abmsActive = str_contains($currentUri, '/recepcion/ABMs') ? 'active' : '';

/* $ingresosPOpen = str_contains($currentUri, '/recepcion/productivos') ? 'show' : '';
$ingresosPActive = str_contains($currentUri, '/recepcion/productivos') ? 'active' : ''; */

$ingresosNPOpen = str_contains($currentUri, '/recepcion/noProductivos') ? 'show' : '';
$ingresosNPActive = str_contains($currentUri, '/recepcion/noProductivos') ? 'active' : '';


$activeItems = [
  // Ítems del submenú ABM
  'hacienda' => str_contains($currentUri, 'hacienda') ? 'fw-semibold text-primary' : '',
  'materiaPrima' => str_contains($currentUri, 'materiaPrima') ? 'fw-semibold text-primary' : '',
  'insumos' => str_contains($currentUri, 'insumos') ? 'fw-semibold text-primary' : '',
  'mercaderias' => str_contains($currentUri, 'mercaderias') ? 'fw-semibold text-primary' : '',
  // Ítems del submenú INGRESOS
  'ingreso_hacienda' => str_contains($currentUri, 'ingreso_hacienda') ? 'fw-semibold text-primary' : '',
  'ingreso_materiaPrima' => str_contains($currentUri, 'ingreso_materiaPrima') ? 'fw-semibold text-primary' : '',
  'ingreso_insumos' => str_contains($currentUri, 'ingreso_insumos') ? 'fw-semibold text-primary' : '',
  'ingreso_mercaderia' => str_contains($currentUri, 'ingreso_mercaderia') ? 'fw-semibold text-primary' : '',

];

?>

      <div class="col-6 d-flex justify-content-start align-items-center">
        <ul class="nav nav-underline">
<!--           <li class="nav-item">
            <a class="nav-link text-white active" style="background-color: #3A4280;" href="/trackpoint/public/recepcion" aria-current="page">Recepción</a>
          </li> -->
          <li class="nav-item dropdown">
            <a class="nav-link text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Recepción</a>
            <ul class="dropdown-menu">
              <div class="d-flex gap-3 px-3">
                <li>
                  <a class="dropdown-item" href="#">
                    <div class="card" style="width: 18rem;">
                      <a href="#" class="text-dark text-decoration-none">
                        <div class="card-body">
                          <h6 class="card-title text-primary">ABM Mercaderías</h6>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>

                <li>
                  <a class="dropdown-item" href="#">
                    <div class="card" style="width: 18rem;">
                      <a href="#" class="text-dark text-decoration-none">
                        <div class="card-body">
                          <h6 class="card-title text-primary">Ingreso de mercaderías</h6>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
            </ul>
          </li>

<!--           <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/produccion">Producción</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/depositos">Depósitos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/expedicion">Expedición</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/reportes">Reportes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/configuracion">Configuración</a>
          </li>
          <?php if (isset($_SESSION['username']) && $_SESSION['username'] === superadmin): ?>
            <li class="nav-item">
              <a class="nav-link text-white table-hover" href="/trackpoint/public/sistema">Sistema</a>
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
<!--       <aside class="col-md-3 col-lg-2 min-vh-100 py-4 px-3" style="background-color: #22265D; color: white;">
        <div class="nav flex-column">
          <a class="nav-link text-white table-hover rounded <?= $abmsActive ?>" data-bs-toggle="collapse" href="#submenuABM" role="button" aria-expanded="<?= $abmsOpen ? 'true' : 'false' ?>" aria-controls="submenuABM">
            ABM
          </a>
          <div class="collapse ps-3 <?= $abmsOpen ?>" id="submenuABM">
            <a class="nav-link <?= $activeItems['insumos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/recepcion/ABMs/insumos">Insumos</a>
            <a class="nav-link <?= $activeItems['mercaderias'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/recepcion/ABMs/mercaderias">Mercaderías</a>
          </div>
          
          <a class="nav-link text-white table-hover rounded <?= $ingresosNPActive ?>" data-bs-toggle="collapse" href="#submenuNoProductivos" role="button" aria-expanded="<?= $ingresosNPOpen ? 'true' : 'false' ?>" aria-controls="submenuNoProductivos">
            NO PRODUCTIVOS
          </a>
          <div class="collapse ps-3 <?= $ingresosNPOpen ?>" id="submenuNoProductivos">
            <a class="nav-link <?= $activeItems['ingreso_mercaderia'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/recepcion/noProductivos/ingreso_mercaderia">Ingreso de Mercaderías</a>
          </div>
          
          <a class="nav-link text-white table-hover rounded <?= $ingresosPActive ?>" data-bs-toggle="collapse" href="#submenuProductivos" role="button" aria-expanded="<?= $ingresosPOpen ? 'true' : 'false' ?>" aria-controls="submenuProductivos">
            PRODUCTIVOS
          </a>
          <div class="collapse ps-3 <?= $ingresosPOpen ?>" id="submenuProductivos">
            <a class="nav-link <?= $activeItems['ingreso_hacienda'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/recepcion/productivos/hacienda">Ingreso de Hacienda</a>
            <a class="nav-link <?= $activeItems['ingreso_materiaPrima'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/recepcion/productivos/materiaPrima">Ingreso de Materia Prima</a>
            <a class="nav-link <?= $activeItems['ingreso_insumos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/recepcion/productivos/insumos">Ingreso de Insumos</a>
          </div>

        </div>
      </aside> -->
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