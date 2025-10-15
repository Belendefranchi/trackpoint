<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TrackPoint</title>

  <!-- Bootstrap 5 base -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/bootstrap.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/icons/font/bootstrap-icons.css" />

  <!-- DataTables con integración Bootstrap 5 -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/dataTables.bootstrap5.min.css" />

  <!-- Extensiones de DataTables integradas con Bootstrap 5 -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/buttons.bootstrap5.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/colReorder.bootstrap5.min.css" />
  
  <!-- DataTables -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/jquery.dataTables.colResize.css" />

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/style.css">
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_blanco.png" type="image/x-icon" />
</head>

<body style="background-color: #f4f7fc;">
  <!-- Navbar -->
  <nav class="navbar navbar-dark shadow-custom" style="background-color: #22265D;">
    <div class="container-fluid">
      
      <div class="col-2 d-flex align-items-center justify-content-start px-3">
        <a class="navbar-brand d-flex align-items-center gap-2 text-white" href="/trackpoint/">
          <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="Logo" width="30" height="30" />
          TrackPoint
        </a>
      </div>
      <div class="col-6 d-flex justify-content-start align-items-center">
        <ul class="nav nav-underline">
          <!-- RECEPCIÓN -->
          <li class="nav-item dropdown">
            <a class="nav-link text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Recepción</a>
            <ul class="dropdown-menu p-2">
              <div class="d-flex gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/recepcion/ABMs/mercaderias" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Mercaderías</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de mercaderías.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/recepcion/noProductivos/ingreso_mercaderia" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Ingreso de mercaderías</h6>
                          <p class="card-text text-primary fst-italic">Registro de mercaderías recepcionadas al sistema.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
            </ul>
          </li>
          <!-- PRODUCCIÓN -->
          <li class="nav-item dropdown">
            <a class="nav-link text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Producción</a>
            <ul class="dropdown-menu p-2">
              <div class="d-flex gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/produccion/ABMs/mercaderias" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Mercaderías</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de mercaderías.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/produccion/ABMs/procesos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Procesos</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de procesos.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/produccion/recetas/recetas" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Recetas</h6>
                          <p class="card-text text-primary fst-italic">Creación y consulta de recetas para producción.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/produccion/planificacion/planConSeleccion" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Planificación de la producción</h6>
                          <p class="card-text text-primary fst-italic">Creación y consulta de planes de producción.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
              <div class="d-flex justify-content-center gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/produccion/ingreso/planSinSeleccion" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Ingreso a producción</h6>
                          <p class="card-text text-primary fst-italic">Ingreso de productos semielaborados a producción.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/produccion/salida/etqPrim" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Etiquetas Primarias</h6>
                          <p class="card-text text-primary fst-italic">Emisión de etiquetas primarias.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/produccion/salida/etqSec" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Etiquetas Secundarias</h6>
                          <p class="card-text text-primary fst-italic">Emisión de etiquetas secundarias.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>

              </div>
            </ul>
          </li>
          <!-- DEPÓSITOS -->
          <li class="nav-item dropdown">
            <a class="nav-link text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Depósitos</a>

          </li>
          <!-- EXPEDICIÓN -->
          <li class="nav-item dropdown">
            <a class="nav-link text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Expedición</a>
            <ul class="dropdown-menu p-2">
              <div class="d-flex justify-content-center gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/expedicion/ABMs/destinos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Destinos</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de destinos.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/expedicion/ABMs/transportes" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Transportes</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de transportes.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/expedicion/ABMs/vehiculos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Vehículos</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de vehículos.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
              <div class="d-flex justify-content-center gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/expedicion/egresos/ventas" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Ventas</h6>
                          <p class="card-text text-primary fst-italic">Registro de ventas diarias.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/expedicion/egresos/cierre" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Cierre de caja</h6>
                          <p class="card-text text-primary fst-italic">Cierre de caja diario.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/expedicion/egresos/despachos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Despachos</h6>
                          <p class="card-text text-primary fst-italic">Emisión, eliminación y consulta de despachos.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/expedicion/egresos/remitos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Remitos</h6>
                          <p class="card-text text-primary fst-italic">Emisión, eliminación y consulta de remitos.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
            </ul>
          </li>
          <!-- CONFIGURACIÓN -->
          <li class="nav-item dropdown">
            <a class="nav-link text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Configuración</a>
            <ul class="dropdown-menu p-2">
              <div class="d-flex gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/operadores" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Operadores</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de operadores.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/perfiles" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Perfiles</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de perfiles.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/perfilesPorOperador" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Perfiles Por Operador</h6>
                          <p class="card-text text-primary fst-italic">Asignación de perfiles por operador.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/permisosPorPerfil" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Permisos por Perfil</h6>
                          <p class="card-text text-primary fst-italic">Asignación de permisos por perfil.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
              <div class="d-flex justify-content-center gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/mercaderias" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Mercaderías</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de mercaderías.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/grupos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Grupos</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de grupos.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/subgrupos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Subgrupos</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de subgrupos.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/traducciones" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Traducciones</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de traducciones.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
              <div class="d-flex justify-content-center gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/personas" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Personas</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de personas.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/ABMs/numeradores" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Numeradores</h6>
                          <p class="card-text text-primary fst-italic">Alta, baja, modificación y consulta de numeradores.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/configuracion/configPC/dispositivos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">Configuración PCs</h6>
                          <p class="card-text text-primary fst-italic">Asignación de impresoras y balanzas.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
            </ul>
          </li>
          <!-- SISTEMA -->
          <?php if (isset($_SESSION['username']) && $_SESSION['username'] === superadmin): ?>
          <li class="nav-item dropdown">
            <a class="nav-link text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Sistema</a>
            <ul class="dropdown-menu p-2">
              <div class="d-flex gap-3 p-2">
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/sistema/ABMs/estados" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Estados</h6>
                          <p class="card-text text-primary fst-italic">Habilitación y deshabilitación de estados.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/sistema/ABMs/logs" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Logs</h6>
                          <p class="card-text text-primary fst-italic">Habilitación y deshabilitación de logs.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item p-0" href="#">
                    <div class="card item-menu-hover shadow-sm" style="width: 15rem; height: 7rem; background-color: #f8f9fa">
                      <a href="/trackpoint/public/sistema/ABMs/permisos" class="text-dark text-decoration-none">
                        <div class="card-body text-center">
                          <h6 class="card-title text-primary fw-bold">ABM Permisos</h6>
                          <p class="card-text text-primary fst-italic">Habilitación y deshabilitación de permisos.</p>
                        </div>
                      </a>
                    </div>
                  </a>
                </li>
              </div>
            </ul>
          </li>
          <?php endif; ?>
        </ul>
      </div>

      <div class="col-4 d-flex align-items-center justify-content-end">
        <div class="search-bar d-flex align-items-center me-3">
          <i class="bd-search"></i>
          <input type="text" class="form-control search-input" id="search" placeholder="Buscar" aria-label="Search" />
        </div>
        <a class="nav-link text-white p-2"><?php echo $_SESSION['username']?></a>
        <p class="nav-link text-white p-2 m-0"> | </p>
        <a class="nav-link text-white p-2" href="/trackpoint/public/logout">Cerrar sesión</a>
      </div>
    </div>
  </nav>
          
      