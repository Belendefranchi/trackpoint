<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TrackPoint</title>

  <!-- Bootstrap 5 base -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/icons/font/bootstrap-icons.css" />

  <!-- DataTables con integración Bootstrap 5 -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/dataTables.bootstrap5.min.css" />

  <!-- Extensiones de DataTables integradas con Bootstrap 5 -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/buttons.bootstrap5.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/colReorder.bootstrap5.min.css" />
  
  <!-- DataTables -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/jquery.dataTables.colResize.css" />

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/style.css">
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon" />
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
			<?php
				require_once __DIR__ . '/../controllers/abm.perfiles.controller.php';
				require_once __DIR__ . '/../../../../config/constants.php';
				require_once __DIR__ . '/../../../../core/permisos.php';
				?>

				<script>
					const subtitulo = 'Perfiles';
				</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2">Perfiles</h2>
										<a href="#" class="btn btn-sm btn-primary"
											data-bs-toggle="modal" 
											data-bs-target="#modalCrearPerfil" 
											data-nombre=""
											data-descripcion="">
											<i class="bi-plus-circle me-2"></i>Nuevo Perfil
										</a>
									</div>
								</td>
							</tr>
							<tr>
								<td class="p-2">
									<table id="miTabla" class="display pt-2 pb-4" style="width:100%">
										<thead class="table-primary">
											<tr class="text-light">
												<td class="p-2 border text-center">ID</td>
												<td class="p-2 border text-center">Perfil</td>
												<td class="p-2 border text-center">Descripción</td>
												<td class="p-2 border text-center">Fecha de creación</td>
												<td class="p-2 border text-center">Creado por</td>
												<td class="p-2 border text-center">Fecha de edición</td>
												<td class="p-2 border text-center">Editado por</td>
												<td class="p-2 border text-center">Activo</td>
												<td class="p-2 border text-center no-export">Acciones</td>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($perfiles as $perfil): ?>
												<tr class="text-start">
													<td class="p-2 border text-center"><?= htmlspecialchars($perfil['perfil_id']) ?></td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['nombre']) ?></td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['descripcion']) ?></td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['creado_en']) ?></td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['creado_por']) ?></td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['editado_en']) ?></td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['editado_por']) ?></td>
													<td class="p-2 border text-center"><?= $perfil['activo'] == 1 ? 'Si' : 'No' ?></td>
													<td class="p-2 border">
														<div class="d-flex no-wrap">
															<a href="#" class="btn btn-sm btn-warning me-1 d-flex no-wrap"
																data-bs-toggle="modal" 
																data-bs-target="#modalEditarPerfil"
																data-id="<?= $perfil['perfil_id'] ?>"
																data-nombre="<?= htmlspecialchars($perfil['nombre']) ?>"
																data-descripcion="<?= htmlspecialchars($perfil['descripcion']) ?>"
																data-activo="<?= $perfil['activo'] ?>">
																<i class="bi bi-pencil me-2"></i>Editar
															</a>
															<a href="#" class="btn btn-sm btn-danger me-1 d-flex no-wrap"
																data-bs-toggle="modal"
																data-bs-target="#modalEliminarPerfil"
																data-id="<?= $perfil['perfil_id'] ?>"
																data-nombre="<?= htmlspecialchars($perfil['nombre']) ?>">
																<i class="bi bi-trash me-2"></i>Eliminar
															</a>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</td>
							</tr>
					</table>
					<?php
						if (isset($_SESSION['message'])) {
							$message = $_SESSION['message'];
							unset($_SESSION['message']); // Limpiamos para que no persista
						}
					?>

					<!-- Modal de creación -->
					<div class="modal fade m-5" id="modalCrearPerfil" tabindex="-1" aria-labelledby="modalCrearPerfilLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&crear">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalCrearPerfilLabel">Nuevo perfil</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">

										<div class="mb-3">
											<?php if (isset($message)): ?>
												<div class="alert alert-danger rounded m-2" role="alert">
													<strong>Error: </strong>
													<span class="block sm:inline"><?= htmlspecialchars($message) ?></span>
												</div>
											<?php endif; ?>
										</div>

										<div class="mb-3">
											<label for="crearNombrePerfil" class="form-label">Nombre</label>
											<input type="text" class="form-control" name="nombre" id="crearNombrePerfil">
										</div>

										<div class="mb-3">
											<label for="crearDescripcionPerfil" class="form-label">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="crearDescripcionPerfil">
										</div>

									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="crear_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<!-- Modal de edición -->
					<div class="modal fade m-5" id="modalEditarPerfil" tabindex="-1" aria-labelledby="modalEditarPerfilLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&editar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEditarPerfilLabel">Editar perfil</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="perfil_id" id="editarPerfilId">

										<div class="mb-3">
											<label for="editarNombrePerfil" class="form-label">Nombre</label>
											<input type="text" class="form-control" name="nombre" id="editarNombrePerfil" required>
										</div>

										<div class="mb-3">
											<label for="editarDescripcionPerfil" class="form-label">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="editarDescripcionPerfil" required>
										</div>

										<div class="mb-3">
											<label for="editarActivoPerfil" class="form-label">Activo</label>
											<select class="form-select" name="activo" id="editarActivoPerfil" required>
												<option value="1">Sí</option>
												<option value="0">No</option>
											</select>
										</div>
									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<!-- Modal de eliminación -->
					<div class="modal fade m-5" id="modalEliminarPerfil" tabindex="-1" aria-labelledby="modalEliminarPerfilLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&eliminar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEliminarPerfilLabel">Eliminar perfil</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="perfil_id" id="eliminarPerfilId">
										<input type="hidden" name="nombre" id="eliminarNombrePerfil">
										<div class="mb-3">
											<p>¿Está seguro que desea eliminar el perfil?</p>
											<p>Esta acción no se puede deshacer.</p>
										</div>
									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-danger m-2" name="eliminar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Eliminar</button>
										<button type="button" class="btn btn-sm btn-secondary m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
									</div>
								</div>
							</form>
						</div>
					</div>

				</div>
            <div class="d-flex justify-content-center align-items-center" style="height: 70vh; position: relative;">
<!--                 <img src="/trackpoint/public/assets/images/logo_fondo_transparente.png" 
                  alt="Fondo" 
                  style="opacity: 0.4; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" /> -->
            </div>
      </main>
    </div>
  </div>
<!-- jQuery (obligatorio para DataTables) -->
<script src="/trackpoint/public/assets/js/jquery.js"></script>

<!-- Bootstrap JS -->
<script src="/trackpoint/public/assets/js/bootstrap.min.js"></script>

<!-- Núcleo de DataTables -->
<script src="/trackpoint/public/assets/js/jquery.dataTables.min.js"></script>

<!-- Extensión ColResize -->
<script src="/trackpoint/public/assets/js/jquery.dataTables.colResize.js"></script>

<!-- Extensión ColReorder -->
<script src="/trackpoint/public/assets/js/dataTables.colReorder.min.js"></script>
<script src="/trackpoint/public/assets/js/colReorder.bootstrap5.min.js"></script>

<!-- Botones de DataTables -->
<script src="/trackpoint/public/assets/js/dataTables.buttons.min.js"></script>
<script src="/trackpoint/public/assets/js/buttons.bootstrap5.min.js"></script>
<script src="/trackpoint/public/assets/js/buttons.colVis.min.js"></script>
<script src="/trackpoint/public/assets/js/buttons.html5.min.js"></script>
<script src="/trackpoint/public/assets/js/buttons.print.min.js"></script>

<!-- pdfmake para exportar a PDF -->
<script src="/trackpoint/public/assets/js/pdfmake.min.js"></script>
<script src="/trackpoint/public/assets/js/vfs_fonts.js"></script>

<!-- JSZip para exportar a Excel -->
<script src="/trackpoint/public/assets/js/jszip.min.js"></script>

<!-- Logos base64 -->
<script src="/trackpoint/public/assets/js/logo_base64_100x109.js"></script>



<!-- Script DataTables y modales -->
<script>
  /* PLUGINS DATATABLES */
  const fechaHoy = new Date().toISOString().slice(0, 10);
  $(document).ready(function () {
    $('#miTabla').DataTable({
      colResize: {
        realtime: true
      },
      colReorder: true,
      dom: 'Blfrtip',
      buttons: [
        {
          extend: 'colvis',
          text: 'Mostrar u ocultar columnas <span class="dropdown-caret"></span>',
          className: 'btn btn-outline-secondary'
        },
        {
          extend: 'pdfHtml5',
          title: '',
          text: 'PDF',
          filename: `${fechaHoy}_TrackPoint_${subtitulo}`,
          orientation: 'portrait',
          pageSize: 'A4',
          exportOptions: {
            columns: ':visible:not(.no-export)'
          },
          customize: function (doc) {
            // Insertar logo al principio (debe estar en base64 o en una URL pública)
            doc.content.unshift({ 
                table: {
                  widths: ['auto', '*', 'auto'], // Logo, título, fecha
                  body: [
                    [
                      {
                        image: logoBase64_100x109,
                        width: 50,
                        alignment: 'left',
                        margin: [5, 5, 5, 5]
                      },
                      {
                        stack: [
                          { text: 'PUNTO CONECTADO', fontSize: 18, bold: true, color: '#22265D' },
                          {
                            text: [
                              { text: 'Track ', fontSize: 14, bold: true, color: '#22265D' },
                              { text: 'Point', fontSize: 14, bold: true, color: '#00B0E6' }
                            ],
                            alignment: 'center'
                          },
                          { text: 'Perfiles', fontSize: 14, color: '#adadad' }
                        ],
                        alignment: 'center',
                        fontSize: 16,
                        bold: true,
                        margin: [0, 15, 0, 0],
                      },
                      {
                        text: fechaHoy,
                        alignment: 'right',
                        fontSize: 10,
                        color: '#22265D',
                        margin: [5, 15, 5, 15],
                      }
                    ]
                  ]
                },
                layout: {
                  hLineWidth: function () { return 0.5; },
                  vLineWidth: function () { return 0.5; },
                  hLineColor: function () { return '#adadad'; },
                  vLineColor: function () { return '#adadad'; },
                  paddingLeft: function () { return 5; },
                  paddingRight: function () { return 5; },
                  paddingTop: function () { return 5; },
                  paddingBottom: function () { return 5; }
                },
                margin: [0, 20, 0, 20]
            });
            doc.footer = function(currentPage, pageCount) {
              return {
                columns: [
                  '',
                  { 
                    text: 'Página ' + currentPage.toString() + ' de ' + pageCount,
                    alignment: 'center',
                    fontSize: 9,
                    margin: [0, 10, 0, 0]
                  },
                  ''
                ]
              };
            };

            // Estilo general
            doc.defaultStyle.fontSize = 10;
            doc.styles.tableHeader = {
              fillColor: '#22265D',
              color: 'white',
              bold: true,
              fontSize: 11,
              alignment: 'center'
            };

            // Estilo de bordes
            let objLayout = {};
            objLayout['hLineWidth'] = function () { return 0.5; };
            objLayout['vLineWidth'] = function () { return 0.5; };
            objLayout['hLineColor'] = function () { return '#adadad'; };
            objLayout['vLineColor'] = function () { return '#adadad'; };
            doc.content[doc.content.length - 1].layout = objLayout;

            // Márgenes del documento
            doc.pageMargins = [30, 20, 30, 20];
          }
        },
        {
          extend: 'excelHtml5',
          text: 'Excel',
          title: `TrackPoint - ${subtitulo}`,
          filename: `${fechaHoy}_TrackPoint_${subtitulo}`,
          exportOptions: {
            columns: ':visible:not(.no-export)'
          },
          customize: function (xlsx) {
            const sheet = xlsx.xl.worksheets['sheet1.xml'];
            const styles = xlsx.xl['styles.xml'];

            // Cambiar texto del A1
            $('row c[r=A1] t', sheet).text('TrackPoint - ' + subtitulo + ' - ' + fechaHoy);

            // Crear nuevo font
            const font = styles.createElement('font');

            const sz = styles.createElement('sz');
            sz.setAttribute('val', '16');
            font.appendChild(sz);

            const color = styles.createElement('color');
            color.setAttribute('rgb', 'FF22265D');
            font.appendChild(color);

            const name = styles.createElement('name');
            name.setAttribute('val', 'Calibri');
            font.appendChild(name);

            const bold = styles.createElement('b');
            font.appendChild(bold);

            // Insertar font en <fonts>
            const fonts = $('fonts', styles)[0];
            fonts.appendChild(font);

            // Crear nuevo xf
            const xf = styles.createElement('xf');
            xf.setAttribute('xfId', '0');
            xf.setAttribute('applyFont', '1');
            xf.setAttribute('applyAlignment', '1');
            xf.setAttribute('fontId', fonts.childNodes.length - 1); // index del font recién agregado

            const alignment = styles.createElement('alignment');
            alignment.setAttribute('horizontal', 'center');
            alignment.setAttribute('vertical', 'center');
            xf.appendChild(alignment);

            // Insertar xf en <cellXfs>
            const cellXfs = $('cellXfs', styles)[0];
            cellXfs.appendChild(xf);

            // Aplicar estilo a celda A1
            $('row c[r=A1]', sheet).attr('s', cellXfs.childNodes.length - 1);
          }

        },
      ],
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


  /* ##################### MODAL DE CREACION ##################### */
  document.addEventListener('DOMContentLoaded', function () {

    /* -------- MODAL CREAR OPERADOR -------- */
    var modalCrearOperador = document.getElementById('modalCrearOperador');
    if (modalCrearOperador) {
      modalCrearOperador.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalCrearOperador.querySelector('#crearNombre').value = button.getAttribute('data-nombre_completo');
        modalCrearOperador.querySelector('#crearEmail').value = button.getAttribute('data-email');
        modalCrearOperador.querySelector('#crearUsuario').value = button.getAttribute('data-username');
        modalCrearOperador.querySelector('#crearPassword').value = button.getAttribute('data-password');
        modalCrearOperador.querySelector('#crearRol').value = button.getAttribute('data-rol');
      });
    }

    /* -------- MODAL CREAR PERFIL -------- */
    var modalCrearPerfil = document.getElementById('modalCrearPerfil');
    if (modalCrearPerfil) {
      modalCrearPerfil.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalCrearPerfil.querySelector('#crearNombrePerfil').value = button.getAttribute('data-nombre');
        modalCrearPerfil.querySelector('#crearDescripcion').value = button.getAttribute('data-descripcion');
      });
    }
  });


  /* ##################### MODAL DE EDICIÓN ##################### */

  document.addEventListener('DOMContentLoaded', function () {

    /* -------- MODAL EDITAR OPERADOR -------- */
    var modalEditarOperador = document.getElementById('modalEditarOperador');
    if (modalEditarOperador) {
      modalEditarOperador.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalEditarOperador.querySelector('#editarOperadorId').value = button.getAttribute('data-id');
        modalEditarOperador.querySelector('#editarNombre').value = button.getAttribute('data-nombre_completo');
        modalEditarOperador.querySelector('#editarEmail').value = button.getAttribute('data-email');
        modalEditarOperador.querySelector('#editarUsuario').value = button.getAttribute('data-username');
        modalEditarOperador.querySelector('#editarPassword').value = button.getAttribute('data-password');
        modalEditarOperador.querySelector('#editarRol').value = button.getAttribute('data-rol');
        modalEditarOperador.querySelector('#editarActivo').value = button.getAttribute('data-activo');
      });
    }

    /* -------- MODAL EDITAR PERFIL -------- */
    var modalEditarPerfil = document.getElementById('modalEditarPerfil');
    if (modalEditarPerfil) {
      modalEditarPerfil.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalEditarPerfil.querySelector('#editarPerfilId').value = button.getAttribute('data-id');
        modalEditarPerfil.querySelector('#editarNombrePerfil').value = button.getAttribute('data-nombre');
        modalEditarPerfil.querySelector('#editarDescripcionPerfil').value = button.getAttribute('data-descripcion');
        modalEditarPerfil.querySelector('#editarActivoPerfil').value = button.getAttribute('data-activo');
      });
    }
  });


  /* ##################### MODAL DE ELIMINACIÓN ##################### */

  document.addEventListener('DOMContentLoaded', function () {

    /* -------- MODAL ELIMINAR OPERADOR -------- */
    var modalEliminarOperador = document.getElementById('modalEliminarOperador');
    if (modalEliminarOperador) {
      modalEliminarOperador.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalEliminarOperador.querySelector('#eliminarOperadorId').value = button.getAttribute('data-id');
        modalEliminarOperador.querySelector('#eliminarUsuario').value = button.getAttribute('data-username');
      });
    }

    /* -------- MODAL ELIMINAR PERFIL -------- */
    var modalEliminarPerfil = document.getElementById('modalEliminarPerfil');
    if (modalEliminarPerfil) {
      modalEliminarPerfil.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        modalEliminarPerfil.querySelector('#eliminarPerfilId').value = button.getAttribute('data-id');
        modalEliminarPerfil.querySelector('#eliminarNombrePerfil').value = button.getAttribute('data-nombre');
      });
    }
  });

</script>

</body>
</html>



