<?php
require_once __DIR__ . '/../../../../core/middleware/auth.middleware.php';
require_once __DIR__ . '/../../../../core/middleware/permisos.middleware.php';
require_once __DIR__ . '/../../../layouts/layout.view.php';

verificarPermiso();

$currentUri = $_SERVER['REQUEST_URI'];

$ingresosPOpen = str_contains($currentUri, '/recepcion/productivos') ? 'show' : '';
$ingresosPActive = str_contains($currentUri, '/recepcion/productivos') ? 'active' : '';

$ingresosNPOpen = str_contains($currentUri, '/recepcion/noProductivos') ? 'show' : '';
$ingresosNPActive = str_contains($currentUri, '/recepcion/noProductivos') ? 'active' : '';


$activeItems = [
  // Ítems del submenú INGRESOS
  'hacienda' => str_contains($currentUri, 'hacienda') ? 'fw-semibold text-primary' : '',
  'materiaPrima' => str_contains($currentUri, 'materiaPrima') ? 'fw-semibold text-primary' : '',
  'insumos' => str_contains($currentUri, 'insumos') ? 'fw-semibold text-primary' : '',
  'mercaderias' => str_contains($currentUri, 'mercaderias') ? 'fw-semibold text-primary' : '',


];

?>

      <div class="col-6 d-flex justify-content-start align-items-center">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link text-white active" style="background-color: #3A4280;" href="/trackpoint/public/recepcion" aria-current="page">RECEPCIÓN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/produccion">PRODUCCIÓN</a>
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
          <a class="nav-link text-white table-hover rounded <?= $ingresosPActive ?>" data-bs-toggle="collapse" href="#submenuProductivos" role="button" aria-expanded="<?= $ingresosPOpen ? 'true' : 'false' ?>" aria-controls="submenuProductivos">
            PRODUCTIVOS
          </a>
          <div class="collapse ps-3 <?= $ingresosPOpen ?>" id="submenuProductivos">
            <a class="nav-link <?= $activeItems['hacienda'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/hacienda">Hacienda</a>
            <a class="nav-link <?= $activeItems['materiaPrima'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/materiaPrima">Materia prima</a>
            <a class="nav-link <?= $activeItems['insumos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/produccion/ABMs/insumos">Insumos</a>
          </div>

          <a class="nav-link text-white table-hover rounded <?= $ingresosNPActive ?>" data-bs-toggle="collapse" href="#submenuNoProductivos" role="button" aria-expanded="<?= $ingresosNPOpen ? 'true' : 'false' ?>" aria-controls="submenuNoProductivos">
            NO PRODUCTIVOS
          </a>
          <div class="collapse ps-3 <?= $ingresosNPOpen ?>" id="submenuNoProductivos">
            <a class="nav-link <?= $activeItems['mercaderias'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/recepcion/noProductivos/mercaderias">Mercaderías</a>

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