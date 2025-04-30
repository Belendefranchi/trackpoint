<?php
require_once __DIR__ . '/../../../../middleware/auth.middleware.php';
require_once __DIR__ . '/../../../layouts/layout.view.php';

$currentUri = $_SERVER['REQUEST_URI'];

$abmsOpen = str_contains($currentUri, '/configuracion/ABMs') ? 'show' : '';
$abmsActive = str_contains($currentUri, '/configuracion/ABMs') ? 'active' : '';

$configPCOpen = str_contains($currentUri, '/configuracion/configPC') ? 'show' : '';
$configPCActive = str_contains($currentUri, '/configuracion/configPC') ? 'active' : '';

$activeItems = [
  // Ítems del submenú ABMs
  'operadores' => str_contains($currentUri, 'operadores') ? 'fw-semibold text-primary' : '',
  'perfiles' => str_contains($currentUri, 'perfiles') && !str_contains($currentUri, 'Por') ? 'fw-semibold text-primary' : '',
  'perfilesPorOperador' => str_contains($currentUri, 'perfilesPorOperador') ? 'fw-semibold text-primary' : '',
  'permisos' => str_contains($currentUri, 'permisos') && !str_contains($currentUri, 'Por') ? 'fw-semibold text-primary' : '',
  'permisosPorOperador' => str_contains($currentUri, 'permisosPorOperador') ? 'fw-semibold text-primary' : '',
  'permisosPorPerfil' => str_contains($currentUri, 'permisosPorPerfil') ? 'fw-semibold text-primary' : '',
  'personas' => str_contains($currentUri, 'personas') ? 'fw-semibold text-primary' : '',
  'numeradores' => str_contains($currentUri, 'numeradores') ? 'fw-semibold text-primary' : '',
  'destinos' => str_contains($currentUri, 'destinos') ? 'fw-semibold text-primary' : '',
  'transportes' => str_contains($currentUri, 'transportes') ? 'fw-semibold text-primary' : '',
  'vehiculos' => str_contains($currentUri, 'vehiculos') ? 'fw-semibold text-primary' : '',

  // Ítems del Submenú Config PC
  'impresoras' => str_contains($currentUri, 'impresoras') ? 'fw-semibold text-primary' : '',
  'balanzas' => str_contains($currentUri, 'balanzas') ? 'fw-semibold text-primary' : '',
];

?>

      <div class="col-6 d-flex justify-content-start align-items-center">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link text-white table-hover" href="/trackpoint/public/ingresos">INGRESO A PLANTA</a>
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
            <a class="nav-link text-white active" style="background-color: #3A4280;" href="/trackpoint/public/configuracion" aria-current="page">CONFIGURACIÓN</a>
          </li>
        </ul>
      </div>

      <div class="col-4 d-flex align-items-center justify-content-end">
        <div class="search-bar d-flex align-items-center me-3">
          <i class="bd-search"></i>
          <input type="text" class="form-control search-input" id="search" placeholder="Buscar..." aria-label="Search" />
        </div>
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
            <a class="nav-link <?= $activeItems['operadores'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/operadores">Operadores</a>
            <a class="nav-link <?= $activeItems['perfiles'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/perfiles">Perfiles</a>
            <a class="nav-link <?= $activeItems['perfilesPorOperador'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/perfilesPorOperador">Perfiles por Operador</a>
            <a class="nav-link <?= $activeItems['permisos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/permisos">Permisos</a>
            <a class="nav-link <?= $activeItems['permisosPorPerfil'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/permisosPorPerfil">Permisos por Perfil</a>
            <a class="nav-link <?= $activeItems['personas'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/personas">Personas</a>
            <a class="nav-link <?= $activeItems['numeradores'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/numeradores">Numeradores</a>
            <a class="nav-link <?= $activeItems['destinos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/destinos">Destinos</a>
            <a class="nav-link <?= $activeItems['transportes'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/transportes">Transportes</a>
            <a class="nav-link <?= $activeItems['vehiculos'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/ABMs/vehiculos">Vehículos</a>
          </div>
          <a class="nav-link text-white table-hover rounded <?= $configPCActive ?>" data-bs-toggle="collapse" href="#submenuConfigPC" role="button" aria-expanded="<?= $configPCOpen ? 'true' : 'false' ?>" aria-controls="submenuConfigPC">
            CONFIGURACIÓN PC
          </a>
          <div class="collapse ps-3 <?= $configPCOpen ?>" id="submenuConfigPC">
            <a class="nav-link <?= $activeItems['impresoras'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/configPC/impresoras">Impresoras</a>
            <a class="nav-link <?= $activeItems['balanzas'] ? 'active-lateral' : 'table-hover rounded text-white' ?>" href="/trackpoint/public/configuracion/configPC/balanzas">Balanzas</a>
          </div>
        </div>
      </aside>


      <!-- Contenido principal -->
      <main class="col-md-9 col-lg-10 p-4">
        <?php if (isset($content) && file_exists($content)) {
          require_once $content;
        } else { ?>
            <div class="d-flex justify-content-center align-items-center" style="height: 70vh; position: relative;">
<!--                 <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" 
                  alt="Fondo" 
                  style="opacity: 0.4; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" /> -->
            </div>
        <?php } ?>
      </main>
    </div>
  </div>
  <script src="/trackpoint/public/assets/js/jquery.js"></script>
  <script src="/trackpoint/public/assets/js/jquery.dataTables.min.js"></script>
  <script src="/trackpoint/public/assets/js/jquery.dataTables.colResize.js"></script>
  <script src="/trackpoint/public/assets/js/bootstrap.min.js" defer></script>
  <script>
    $(document).ready(function () {
      $('#miTabla').DataTable({
        colResize: {
          realtime: true
        },
        dom: 'lfrtip',
        language: {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sInfo":           "Mostrando de _START_ a _END_ de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando 0 a 0 de 0 registros",
          "sInfoFiltered":   "(filtrado de _MAX_ registros en total)",
          "sSearch":         "Buscar:",
          "sEmptyTable":     "No hay datos disponibles en la tabla",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst":    "Primero",
            "sPrevious": "Anterior",
            "sNext":     "Siguiente",
            "sLast":     "Último"
          },
          "oAria": {
            "sSortAscending":  ": activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": activar para ordenar la columna de manera descendente"
          }
        },
      });
    });
  </script>
</body>
</html>



