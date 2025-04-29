<?php
require_once __DIR__ . '/../../../../middleware/auth.middleware.php';

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

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? 'Configuración' ?></title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/bootstrap.min.css" />
  <script src="/trackpoint/public/assets/js/bootstrap.min.js" defer></script>
  <link rel="stylesheet" href="/trackpoint/public/assets/icons/font/bootstrap-icons.css">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/style.css">
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon" />
</head>

<body style="background-color: #f4f7fc;">
  <!-- Navbar -->
  <nav class="navbar navbar-dark shadow-custom" style="background-color: #22265D;">
    <div class="container-fluid">
      
      <div class="col-2 d-flex align-items-center justify-content-center">
        <a class="navbar-brand d-flex align-items-center gap-2 text-white" href="/trackpoint/">
          <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="Logo" width="30" height="30" />
          TrackPoint
        </a>
      </div>

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

        <a class="nav-link text-light p-2" href="/trackpoint/public/home">Dashboard</a>
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
          <a class="nav-link text-white fw-semibold <?= $abmsActive ?>" data-bs-toggle="collapse" href="#submenuABMs" role="button" aria-expanded="<?= $abmsOpen ? 'true' : 'false' ?>" aria-controls="submenuABMs">
            ABMs
          </a>
          <div class="collapse ps-3 <?= $abmsOpen ?>" id="submenuABMs">
            <a class="nav-link <?= $activeItems['operadores'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/operadores">Operadores</a>
            <a class="nav-link <?= $activeItems['perfiles'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/perfiles">Perfiles</a>
            <a class="nav-link <?= $activeItems['perfilesPorOperador'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/perfilesPorOperador">Perfiles por Operador</a>
            <a class="nav-link <?= $activeItems['permisos'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/permisos">Permisos</a>
            <a class="nav-link <?= $activeItems['permisosPorOperador'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/permisosPorOperador">Permisos por Operador</a>
            <a class="nav-link <?= $activeItems['permisosPorPerfil'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/permisosPorPerfil">Permisos por Perfil</a>
            <a class="nav-link <?= $activeItems['personas'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/personas">Personas</a>
            <a class="nav-link <?= $activeItems['numeradores'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/numeradores">Numeradores</a>
            <a class="nav-link <?= $activeItems['destinos'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/destinos">Destinos</a>
            <a class="nav-link <?= $activeItems['transportes'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/transportes">Transportes</a>
            <a class="nav-link <?= $activeItems['vehiculos'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/ABMs/vehiculos">Vehículos</a>
          </div>
          <a class="nav-link text-white fw-semibold <?= $configPCActive ?>" data-bs-toggle="collapse" href="#submenuConfigPC" role="button" aria-expanded="<?= $configPCOpen ? 'true' : 'false' ?>" aria-controls="submenuConfigPC">
            Configuración PC
          </a>
          <div class="collapse ps-3 <?= $configPCOpen ?>" id="submenuConfigPC">
            <a class="nav-link <?= $activeItems['impresoras'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/configPC/impresoras">Impresoras</a>
            <a class="nav-link <?= $activeItems['balanzas'] ? 'active-lateral' : 'text-white' ?>" href="/trackpoint/public/configuracion/configPC/balanzas">Balanzas</a>
          </div>
        </div>
      </aside>


      <!-- Contenido principal -->
      <main class="col-md-9 col-lg-10 py-4">
        <div class="container">
          <?php if (isset($content) && file_exists($content)) {
            require_once $content;
          } else { ?>
              <div class="d-flex justify-content-center align-items-center" style="height: 70vh; position: relative;">
<!--                 <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" 
                    alt="Fondo" 
                    style="opacity: 0.4; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" /> -->
              </div>
          <?php } ?>
        </div>
      </main>
    </div>
  </div>

</body>
</html>



