<?php
require_once __DIR__ . '/../../../../core/middleware/auth.middleware.php';
require_once __DIR__ . '/../../../../core/middleware/permisos.middleware.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
require_once __DIR__ . '/../../../layouts/layout.view.php';

$currentUri = $_SERVER['REQUEST_URI'];

$despachosOpen = str_contains($currentUri, '/expedicion/despachos') ? 'show' : '';
$despachosActive = str_contains($currentUri, '/expedicion/despachos') ? 'active' : '';

$remitosOpen = str_contains($currentUri, '/expedicion/remitos') ? 'show' : '';
$remitosActive = str_contains($currentUri, '/expedicion/remitos') ? 'active' : '';

$activeItems = [
  // Ítems del submenú Despachos
  'nuevo' => str_contains($currentUri, 'nuevo') ? 'fw-semibold text-primary' : '',
  'reimpresion' => str_contains($currentUri, 'reimpresion') ? 'fw-semibold text-primary' : '',
  'eliminacion' => str_contains($currentUri, 'eliminacion') ? 'fw-semibold text-primary' : '',

  // Ítems del Submenú Remitos
  'nuevo' => str_contains($currentUri, 'nuevo') ? 'fw-semibold text-primary' : '',
  'reimpresion' => str_contains($currentUri, 'reimpresion') ? 'fw-semibold text-primary' : '',
  'eliminacion' => str_contains($currentUri, 'eliminacion') ? 'fw-semibold text-primary' : '',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? "Expedición" ?></title>

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
            <a class="nav-link text-light" href="/trackpoint/public/produccion">PRODUCCIÓN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="/trackpoint/public/depositos">DEPÓSITOS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="/trackpoint/public/expedicion" aria-current="page">EXPEDICIÓN</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="/trackpoint/public/reportes">REPORTES</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="/trackpoint/public/configuracion">CONFIGURACIÓN</a>
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
          <a class="nav-link text-dark fw-semibold <?= $abmsActive ?>" data-bs-toggle="collapse" href="#submenuDespachos" role="button" aria-expanded="<?= $abmsOpen ? 'true' : 'false' ?>" aria-controls="submenuDespachos">
            Despachos
          </a>
          <div class="collapse ps-3 <?= $abmsOpen ?>" id="submenuDespachos">
            <a class="nav-link <?= $activeItems['nuevo'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/expedicion/despachos/nuevo">Nuevo Despacho</a>
            <a class="nav-link <?= $activeItems['reimpresion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/expedicion/despachos/reimpresion">Reimpresión de Despachos</a>
            <a class="nav-link <?= $activeItems['eliminacion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/expedicion/despachos/eliminacion">Eliminación de Despachos</a>
          </div>

          <a class="nav-link text-dark fw-semibold <?= $abmsActive ?>" data-bs-toggle="collapse" href="#submenuRemitos" role="button" aria-expanded="<?= $abmsOpen ? 'true' : 'false' ?>" aria-controls="submenuRemitos">
            Remitos
          </a>
          <div class="collapse ps-3 <?= $abmsOpen ?>" id="submenuRemitos">
            <a class="nav-link <?= $activeItems['nuevo'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/expedicion/remitos/nuevo">Nuevo Remito</a>
            <a class="nav-link <?= $activeItems['reimpresion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/expedicion/remitos/reimpresion">Reimpresión de Remitos</a>
            <a class="nav-link <?= $activeItems['eliminacion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/expedicion/remitos/eliminacion">Eliminación de Remitos</a>
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
              <div class="d-flex justify-content-center align-items-center fs-3" style="opacity: 0.5">
                <p class="text-primary fw-bold pt-4">Selecciona una pantalla para comenzar</p>
              </div>
          <?php } ?>
        </div>
      </main>
    </div>
  </div>

</body>
</html>