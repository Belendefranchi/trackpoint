<?php
function cargarVistaHead() {
  echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title><?= $title ?? "Panel de Control" ?></title>

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
    <body style="background-color: #D3EBF9;">';
}

function cargarVistaNavbarStart() {
  echo '
    <!-- Navbar -->
    <nav class="navbar navbar-dark" style="background-color: #22265D;">
      <div class="container-fluid">
        <div class="col-2 d-flex align-items-center justify-content-center">
          <a class="navbar-brand d-flex align-items-center gap-2" href="/trackpoint/public/">
            <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="Logo" width="30" height="30" />
            TrackPoint
          </a>
        </div>';
}

    
function cargarVistaNavbarEnd() {
  echo '
    <div class="col-4 d-flex align-items-center justify-content-end">
      <div class="search-bar d-flex align-items-center me-3">
        <i class="bd-search"></i>
        <input type="text" class="form-control search-input" id="search" placeholder="Buscar..." aria-label="Search" />
      </div>
      <a class="nav-link text-light p-2" href="/trackpoint/public/home">Dashboard</a>
      <a class="nav-link text-info p-2" href="/trackpoint/public/logout">Cerrar sesión</a>
    </div>
  </div>
</nav>';
}

function cargarVistaMain() {
  echo '
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
</html>';
}


function cargarVistaAsideStart(){
  echo '
  <!-- Layout con Aside + Main -->
  <div class="container-fluid">
    <div class="row">
      <!-- Aside -->
      <aside class="col-md-3 col-lg-2 bg-white shadow-sm min-vh-100 py-4 px-3">
        <nav class="nav flex-column">';
}


function cargarVistaAsideEnd(){
  echo '
        </nav>
      </aside>';
}

?>