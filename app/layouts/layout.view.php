<?php
$superadminUser = defined('superadmin') ? superadmin : 'superadmin';
$isSuperadmin = isset($_SESSION['username']) && $_SESSION['username'] === $superadminUser;

$menuSections = [
    [
        'key' => 'recepcion',
        'label' => 'Recepción',
        'icon' => 'bi bi-box-arrow-in-down',
        'route_match' => '/recepcion/',
        'items' => [
            [
                'title' => 'ABM Mercaderías',
                'description' => 'Alta, baja, modificación y consulta de mercaderías',
                'href' => '/trackpoint/public/recepcion/ABMs/mercaderias',
                'icon' => 'bi bi-box-seam'
            ],
            [
                'title' => 'Ingreso de mercaderías',
                'description' => 'Registro de mercaderías recepcionadas al sistema',
                'href' => '/trackpoint/public/recepcion/noProductivos/ingreso_mercaderia',
                'icon' => 'bi bi-arrow-down-square'
            ],
        ],
    ],
    [
        'key' => 'produccion',
        'label' => 'Producción',
        'icon' => 'bi bi-gear-wide-connected',
        'route_match' => '/produccion/',
        'items' => [
            [
                'title' => 'ABM Mercaderías',
                'description' => 'Alta, baja, modificación y consulta de mercaderías',
                'href' => '/trackpoint/public/produccion/ABMs/mercaderias',
                'icon' => 'bi bi-box-seam'
            ],
            [
                'title' => 'ABM Procesos',
                'description' => 'Alta, baja, modificación y consulta de procesos',
                'href' => '/trackpoint/public/produccion/ABMs/procesos',
                'icon' => 'bi bi-diagram-3'
            ],
            [
                'title' => 'Recetas',
                'description' => 'Creación y consulta de recetas para producción',
                'href' => '/trackpoint/public/produccion/recetas/recetas',
                'icon' => 'bi bi-journal-text'
            ],
            [
                'title' => 'Planificación de la producción',
                'description' => 'Creación y consulta de planes de producción',
                'href' => '/trackpoint/public/produccion/planificacion/planConSeleccion',
                'icon' => 'bi bi-calendar-check'
            ],
            [
                'title' => 'Ingreso a producción',
                'description' => 'Ingreso de productos semielaborados a producción',
                'href' => '/trackpoint/public/produccion/ingreso/planSinSeleccion',
                'icon' => 'bi bi-play-circle'
            ],
            [
                'title' => 'Etiquetas primarias',
                'description' => 'Emisión de etiquetas primarias',
                'href' => '/trackpoint/public/produccion/salida/etqPrim',
                'icon' => 'bi bi-tag'
            ],
            [
                'title' => 'Etiquetas secundarias',
                'description' => 'Emisión de etiquetas secundarias',
                'href' => '/trackpoint/public/produccion/salida/etqSecSinSeleccion',
                'icon' => 'bi bi-tags'
            ],
        ],
    ],
    [
        'key' => 'depositos',
        'label' => 'Depósitos',
        'icon' => 'bi bi-box-seam',
        'route_match' => '/depositos/',
        'items' => [],
    ],
    [
        'key' => 'expedicion',
        'label' => 'Expedición',
        'icon' => 'bi bi-truck',
        'route_match' => '/expedicion/',
        'items' => [
            [
                'title' => 'ABM Destinos',
                'description' => 'Alta, baja, modificación y consulta de destinos',
                'href' => '/trackpoint/public/expedicion/ABMs/destinos',
                'icon' => 'bi bi-geo-alt'
            ],
            [
                'title' => 'ABM Transportes',
                'description' => 'Alta, baja, modificación y consulta de transportes',
                'href' => '/trackpoint/public/expedicion/ABMs/transportes',
                'icon' => 'bi bi-truck-flatbed'
            ],
            [
                'title' => 'ABM Vehículos',
                'description' => 'Alta, baja, modificación y consulta de vehículos',
                'href' => '/trackpoint/public/expedicion/ABMs/vehiculos',
                'icon' => 'bi bi-car-front'
            ],
            [
                'title' => 'Pedidos',
                'description' => 'Emisión, eliminación y consulta de pedidos',
                'href' => '/trackpoint/public/expedicion/egresos/pedidos',
                'icon' => 'bi bi-clipboard-check'
            ],
            [
                'title' => 'Despachos',
                'description' => 'Emisión, eliminación y consulta de despachos',
                'href' => '/trackpoint/public/expedicion/egresos/despachos',
                'icon' => 'bi bi-send-check'
            ],
            [
                'title' => 'Remitos',
                'description' => 'Emisión, eliminación y consulta de remitos',
                'href' => '/trackpoint/public/expedicion/egresos/remitos',
                'icon' => 'bi bi-receipt'
            ],
        ],
    ],
    [
        'key' => 'ventas',
        'label' => 'Ventas',
        'icon' => 'bi bi-cart3',
        'route_match' => '/ventas/',
        'items' => [
            [
                'title' => 'Lista de precios',
                'description' => 'Lista de precios de productos y servicios',
                'href' => '/trackpoint/public/ventas/egresos/listaPrecios',
                'icon' => 'bi bi-cash-stack'
            ],
            [
                'title' => 'Presupuestos',
                'description' => 'Confección de presupuestos',
                'href' => '/trackpoint/public/ventas/egresos/presupuestos',
                'icon' => 'bi bi-file-earmark-text'
            ],
            [
                'title' => 'Ventas diarias',
                'description' => 'Registro de ventas diarias',
                'href' => '/trackpoint/public/ventas/egresos/ventas',
                'icon' => 'bi bi-bag-check'
            ],
            [
                'title' => 'Cierre de caja',
                'description' => 'Cierre de caja diario',
                'href' => '/trackpoint/public/ventas/egresos/cierre',
                'icon' => 'bi bi-calculator'
            ],
        ],
    ],
    [
        'key' => 'configuracion',
        'label' => 'Configuración',
        'icon' => 'bi bi-sliders',
        'route_match' => '/configuracion/',
        'items' => [
            [
                'title' => 'ABM Operadores',
                'description' => 'Alta, baja, modificación y consulta de operadores',
                'href' => '/trackpoint/public/configuracion/ABMs/operadores',
                'icon' => 'bi bi-person-gear'
            ],
            [
                'title' => 'ABM Perfiles',
                'description' => 'Alta, baja, modificación y consulta de perfiles',
                'href' => '/trackpoint/public/configuracion/ABMs/perfiles',
                'icon' => 'bi bi-person-badge'
            ],
            [
                'title' => 'Perfiles por Operador',
                'description' => 'Asignación de perfiles por operador',
                'href' => '/trackpoint/public/configuracion/ABMs/perfilesPorOperador',
                'icon' => 'bi bi-people'
            ],
            [
                'title' => 'Permisos por Perfil',
                'description' => 'Asignación de permisos por perfil',
                'href' => '/trackpoint/public/configuracion/ABMs/permisosPorPerfil',
                'icon' => 'bi bi-shield-check'
            ],
            [
                'title' => 'ABM Mercaderías',
                'description' => 'Alta, baja, modificación y consulta de mercaderías',
                'href' => '/trackpoint/public/configuracion/ABMs/mercaderias',
                'icon' => 'bi bi-box-seam'
            ],
            [
                'title' => 'ABM Grupos',
                'description' => 'Alta, baja, modificación y consulta de grupos',
                'href' => '/trackpoint/public/configuracion/ABMs/grupos',
                'icon' => 'bi bi-collection'
            ],
            [
                'title' => 'ABM Subgrupos',
                'description' => 'Alta, baja, modificación y consulta de subgrupos',
                'href' => '/trackpoint/public/configuracion/ABMs/subgrupos',
                'icon' => 'bi bi-diagram-2'
            ],
            [
                'title' => 'ABM Traducciones',
                'description' => 'Alta, baja, modificación y consulta de traducciones',
                'href' => '/trackpoint/public/configuracion/ABMs/traducciones',
                'icon' => 'bi bi-translate'
            ],
            [
                'title' => 'ABM Personas',
                'description' => 'Alta, baja, modificación y consulta de personas',
                'href' => '/trackpoint/public/configuracion/ABMs/personas',
                'icon' => 'bi bi-person-vcard'
            ],
            [
                'title' => 'ABM Numeradores',
                'description' => 'Alta, baja, modificación y consulta de numeradores',
                'href' => '/trackpoint/public/configuracion/ABMs/numeradores',
                'icon' => 'bi bi-123'
            ],
            [
                'title' => 'Configuración PCs',
                'description' => 'Asignación de impresoras y balanzas',
                'href' => '/trackpoint/public/configuracion/configPC/dispositivos',
                'icon' => 'bi bi-pc-display'
            ],
        ],
    ],
];

if ($isSuperadmin) {
    $menuSections[] = [
        'key' => 'sistema',
        'label' => 'Sistema',
        'icon' => 'bi bi-cpu',
        'route_match' => '/sistema/',
        'items' => [
            [
                'title' => 'ABM Estados',
                'description' => 'Habilitación y deshabilitación de estados',
                'href' => '/trackpoint/public/sistema/ABMs/estados',
                'icon' => 'bi bi-toggles'
            ],
            [
                'title' => 'ABM Logs',
                'description' => 'Habilitación y deshabilitación de logs',
                'href' => '/trackpoint/public/sistema/ABMs/logs',
                'icon' => 'bi bi-journal-code'
            ],
            [
                'title' => 'ABM Permisos',
                'description' => 'Habilitación y deshabilitación de permisos',
                'href' => '/trackpoint/public/sistema/ABMs/permisos',
                'icon' => 'bi bi-key'
            ],
        ],
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TrackPoint</title>

  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/bootstrap.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/icons/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/buttons.bootstrap5.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/colReorder.bootstrap5.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/jquery.dataTables.colResize.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/style.css">
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_blanco.png" type="image/x-icon" />

  <script>
    (function () {
      try {
        var sidebarState = JSON.parse(sessionStorage.getItem('trackpointSidebarState') || 'null');
        if (sidebarState && sidebarState.mode === 'open' && sidebarState.key) {
          document.documentElement.classList.add('sidebar-preopen');
          document.documentElement.setAttribute('data-sidebar-preopen-key', sidebarState.key);
        }
      } catch (error) {}
    })();
  </script>

</head>

<body class="layout-sidebar" style="background-color: #f4f7fc;">
  <aside class="sidebar-nav shadow-custom">
    <nav class="sidebar-menu px-2 py-3">
      <ul class="nav flex-column gap-2 sidebar-menu-list">
        <?php foreach ($menuSections as $section): ?>
          <?php $hasItems = !empty($section['items']); ?>
          <li class="nav-item w-100 sidebar-module <?php echo $hasItems ? 'sidebar-module-has-panel' : 'sidebar-module-static'; ?>" data-module-key="<?php echo htmlspecialchars($section['key']); ?>" data-route-match="<?php echo htmlspecialchars($section['route_match']); ?>">
            <a
              class="nav-link sidebar-link text-white rounded-3 px-2 py-3 <?php echo $hasItems ? 'sidebar-trigger' : 'sidebar-link-disabled'; ?>"
              href="#"
              role="button"
              <?php if ($hasItems): ?>data-sidebar-trigger="<?php echo htmlspecialchars($section['key']); ?>" aria-expanded="false"<?php else: ?>aria-disabled="true"<?php endif; ?>
            >
              <span class="sidebar-link-icon"><i class="<?php echo htmlspecialchars($section['icon']); ?>"></i></span>
              <span class="sidebar-link-text"><?php echo htmlspecialchars($section['label']); ?></span>
            </a>

            <?php if ($hasItems): ?>
              <div class="sidebar-context-panel" data-sidebar-panel="<?php echo htmlspecialchars($section['key']); ?>" aria-hidden="true">
                <div class="sidebar-context-shell">
                  <div class="sidebar-context-header">
                    <div class="sidebar-context-badge"><i class="<?php echo htmlspecialchars($section['icon']); ?>"></i></div>
                    <div class="sidebar-context-copy">
<h5 class="sidebar-context-title"><?php echo htmlspecialchars($section['label']); ?></h5>
                    </div>
                    <button type="button" class="sidebar-context-toggle" data-sidebar-close="<?php echo htmlspecialchars($section['key']); ?>" aria-label="Ocultar panel de <?php echo htmlspecialchars($section['label']); ?>">
                      <i class="bi bi-layout-sidebar-inset"></i>
                    </button>
                  </div>

                  <div class="sidebar-context-search d-flex align-items-center">
                    <i class="bi bi-search text-secondary me-2"></i>
                    <input type="text" class="form-control sidebar-context-search-input" placeholder="Buscar en <?php echo htmlspecialchars($section['label']); ?>" data-sidebar-search="<?php echo htmlspecialchars($section['key']); ?>" />
                  </div>

                  <div class="sidebar-context-list" data-sidebar-list="<?php echo htmlspecialchars($section['key']); ?>">
                    <?php foreach ($section['items'] as $item): ?>
                      <a class="sidebar-context-item text-decoration-none" href="<?php echo htmlspecialchars($item['href']); ?>" data-sidebar-item>
                        <span class="sidebar-context-item-icon"><i class="<?php echo htmlspecialchars($item['icon']); ?>"></i></span>
                        <span class="sidebar-context-item-copy">
                          <span class="sidebar-context-item-title"><?php echo htmlspecialchars($item['title']); ?></span>
                          <span class="sidebar-context-item-desc"><?php echo htmlspecialchars($item['description']); ?></span>
                        </span>
</a>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </aside>

  <header class="topbar shadow-custom">
    <div class="container-fluid d-flex align-items-center justify-content-between gap-3 h-100">
      <div class="topbar-start d-flex align-items-center flex-grow-1">
        <a class="topbar-brand d-inline-flex align-items-center justify-content-center text-decoration-none" href="/trackpoint/" aria-label="TrackPoint">
          <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="Logo TrackPoint" width="34" height="34" />
        </a>

        <div class="topbar-search-wrap">
          <div class="search-bar d-flex align-items-center">
            <i class="bi bi-search me-2"></i>
            <input type="text" class="form-control search-input" id="search" placeholder="Buscar" aria-label="Search" />
          </div>
        </div>
      </div>

      <div class="topbar-actions d-flex align-items-center justify-content-end flex-wrap">
        <a class="nav-link topbar-link p-2"><?php echo $_SESSION['username']; ?></a>
        <p class="topbar-divider nav-link p-2 m-0"> | </p>
        <a class="nav-link topbar-link p-2" href="/trackpoint/public/logout">Cerrar sesión</a>
      </div>
    </div>
  </header>
