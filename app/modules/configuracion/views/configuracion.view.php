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

  /* MODALES DE CREACION, EDICION Y ELIMINACION */
  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('modalCrear');
    modal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var perfilId = button.getAttribute('data-id');
      var nombre = button.getAttribute('data-nombre');
      var descripcion = button.getAttribute('data-descripcion');

      modal.querySelector('#crearPerfilId').value = perfilId;
      modal.querySelector('#crearNombre').value = nombre;
      modal.querySelector('#crearDescripcion').value = descripcion;
    });
  });
  
  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('modalEditar');
    modal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var perfilId = button.getAttribute('data-id');
      var nombre = button.getAttribute('data-nombre');
      var descripcion = button.getAttribute('data-descripcion');
      var activo = button.getAttribute('data-activo');

      modal.querySelector('#editarPerfilId').value = perfilId;
      modal.querySelector('#editarNombre').value = nombre;
      modal.querySelector('#editarDescripcion').value = descripcion;
      modal.querySelector('#editarActivo').value = activo;
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('modalEliminar');
    modal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var perfilId = button.getAttribute('data-id');
      var nombre = button.getAttribute('data-nombre');

      modal.querySelector('#eliminarPerfilId').value = perfilId;
      modal.querySelector('#eliminarNombre').value = nombre;
    });
  });
</script>

</body>
</html>



