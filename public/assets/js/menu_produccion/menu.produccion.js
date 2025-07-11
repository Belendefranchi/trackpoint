const fechaHoy = new Date().toISOString().slice(0, 10);

$(document).ready(function () {

	const configuracionDataTable = {
		dom: 'ftp',
		pageLength: 10,
		language: {
			sZeroRecords: "No se encontraron resultados",
			sSearch: "Buscar:",
			sEmptyTable: "No hay datos disponibles en la tabla",
			oPaginate: {
				sFirst: "Primero",
				sPrevious: "Anterior",
				sNext: "Siguiente",
				sLast: "Último"
			}
		}
	};

	const tablaEnModalProceso = $('#miTablaEnModalProceso').DataTable(configuracionDataTable);
	const tablaEnModalMercaderia = $('#miTablaEnModalMercaderia').DataTable(configuracionDataTable);

	$('#miTabla').DataTable().destroy();

	const tabla = $('#miTabla').DataTable({
		initComplete: function () {
      var api = this.api();

      api.columns().every(function () {
        var empty = true;
        this.data().each(function (value) {
          if ($.trim(value) !== '') {
            empty = false;
            return false; // Salir del loop si encuentra dato
          }
        });

        // Ocultar la columna si está vacía
        api.column(this.index()).visible(!empty);
      });
    },
		stateSave: true,
		stateLoadParams: function (settings, data) {
			// Solo restaurar la página si hay un estado guardado
			const paginaGuardada = localStorage.getItem('pagina_' + subtitulo);
			if (paginaGuardada !== null) {
				// Establecer la página guardada al cargar la tabla
				settings.oApi._fnPageChange(settings, parseInt(paginaGuardada));
			}
		}, // Guarda el estado de la tabla, incluyendo la página actual
		colResize: {
			realtime: true
		},
		colReorder: true,
		scrollX: true,
		dom: 'Blfrtip',
		buttons: [
			{
				extend: 'colvis',
				text: 'Mostrar u ocultar columnas <span class="dropdown-caret"></span>',
				className: 'btn btn-outline-secondary'
			},
			{
				extend: 'pdfHtml5',
				text: 'PDF',
				title: '',
				filename: `${fechaHoy}_TrackPoint_${subtitulo}`,
				orientation: 'portrait',
				pageSize: 'A4',
				exportOptions: {
					columns: ':visible:not(.no-export)'
				},
				customize: function (doc) {
					doc.content.unshift({
						table: {
							widths: ['auto', '*', 'auto'],
							body: [[
								{
									image: logoBase64_100x109,
									width: 50,
									alignment: 'left',
									margin: [5, 5, 5, 5]
								},
								{
									stack: [
										{ text: titulo, fontSize: 18, bold: true, color: '#22265D' },
										{
											text: [
												{ text: 'Track ', fontSize: 14, bold: true, color: '#22265D' },
												{ text: 'Point', fontSize: 14, bold: true, color: '#00B0E6' }
											],
											alignment: 'center'
										},
										{ text: subtitulo, fontSize: 14, color: '#adadad' }
									],
									alignment: 'center',
									margin: [0, 15, 0, 0],
								},
								{
									text: fechaHoy,
									alignment: 'right',
									fontSize: 10,
									color: '#22265D',
									margin: [5, 15, 5, 15],
								}
							]]
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
								{ text: 'Página ' + currentPage + ' de ' + pageCount,
									alignment: 'center',
									fontSize: 9,
									margin: [0, 10, 0, 0] },
								''
							]
						};
					};

					doc.defaultStyle.fontSize = 10;
					doc.styles.tableHeader = {
						fillColor: '#22265D',
						color: 'white',
						bold: true,
						fontSize: 11,
						alignment: 'center'
					};

					// Bordes para la tabla
					let objLayout = {};
					objLayout['hLineWidth'] = function () { return 0.5; };
					objLayout['vLineWidth'] = function () { return 0.5; };
					objLayout['hLineColor'] = function () { return '#adadad'; };
					objLayout['vLineColor'] = function () { return '#adadad'; };
					doc.content[doc.content.length - 1].layout = objLayout;

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

					$('row c[r=A1] t', sheet).text('TrackPoint - ' + subtitulo + ' - ' + fechaHoy);

					const font = styles.createElement('font');
					font.appendChild(styles.createElement('sz')).setAttribute('val', '16');
					font.appendChild(styles.createElement('color')).setAttribute('rgb', 'FF22265D');
					font.appendChild(styles.createElement('name')).setAttribute('val', 'Calibri');
					font.appendChild(styles.createElement('b'));

					const fonts = $('fonts', styles)[0];
					fonts.appendChild(font);

					const xf = styles.createElement('xf');
					xf.setAttribute('xfId', '0');
					xf.setAttribute('applyFont', '1');
					xf.setAttribute('applyAlignment', '1');
					xf.setAttribute('fontId', fonts.childNodes.length - 1);

					const alignment = styles.createElement('alignment');
					alignment.setAttribute('horizontal', 'center');
					alignment.setAttribute('vertical', 'center');
					xf.appendChild(alignment);

					const cellXfs = $('cellXfs', styles)[0];
					cellXfs.appendChild(xf);

					$('row c[r=A1]', sheet).attr('s', cellXfs.childNodes.length - 1);
				}
			},
		],
		language: {
			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros en total)",
			"sSearch": "Buscar:",
			"sEmptyTable": "No hay datos disponibles en la tabla",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst": "Primero",
				"sPrevious": "Anterior",
				"sNext": "Siguiente",
				"sLast": "Último"
			},
			"oAria": {
				"sSortAscending": ": activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": activar para ordenar la columna de manera descendente"
			}
		}
	});

	tabla.on('page.dt', function () {
		localStorage.setItem('pagina_' + subtitulo, tabla.page());
	});

});

window.addEventListener('DOMContentLoaded', function () {
	const hoy = new Date().toISOString().split('T')[0];
	document.getElementById('fecha_faena').value = hoy;
	document.getElementById('fecha_produccion').value = hoy;
});


document.getElementById('unidades').addEventListener('input', function () {
this.value = this.value.replace(/\D/g, ''); // Elimina cualquier cosa que no sea dígito
});

document.getElementById('cantidad').addEventListener('input', function () {
this.value = this.value.replace(/\D/g, ''); // Elimina cualquier cosa que no sea dígito
});

function getFloat(id) {
	return parseFloat(document.getElementById(id).value) || 0;
}

function actualizarCamposActivos() {
	const modo = document.querySelector('input[name="modo_peso"]:checked').value;
	const inputNeto = document.getElementById('peso_neto');
	const inputBruto = document.getElementById('peso_bruto');

	if (modo === 'neto') {
			inputNeto.removeAttribute('readonly');
			inputNeto.classList.remove('input-disabled-style');
			inputNeto.classList.remove('bg-light');
			inputNeto.classList.add('text-primary');
			inputNeto.classList.add('bg-primary-subtle');
			
			inputBruto.setAttribute('readonly', 'readonly');
			inputBruto.classList.remove('bg-primary-subtle');
			inputBruto.classList.remove('text-primary');
			inputBruto.classList.add('input-disabled-style');
			inputBruto.classList.add('bg-light');

	} else {
			inputBruto.removeAttribute('readonly');
			inputBruto.classList.remove('input-disabled-style');
			inputBruto.classList.remove('bg-light');
			inputBruto.classList.add('text-primary');
			inputBruto.classList.add('bg-primary-subtle');
			
			inputNeto.setAttribute('readonly', 'readonly');
			inputNeto.classList.remove('bg-primary-subtle');
			inputNeto.classList.remove('text-primary');
			inputNeto.classList.add('input-disabled-style');
			inputNeto.classList.add('bg-light');

	}
}

function calcularSegunModo() {
	const modo = document.querySelector('input[name="modo_peso"]:checked').value;
	const taraPri = getFloat('tara_pri');
	const taraSec = getFloat('tara_sec');

	if (modo === 'neto') {
			const neto = getFloat('peso_neto');
			const bruto = neto + taraPri + taraSec;
			document.getElementById('peso_bruto').value = bruto.toFixed(2);
	} else if (modo === 'bruto') {
			const bruto = getFloat('peso_bruto');
			const neto = bruto - taraPri - taraSec;
			document.getElementById('peso_neto').value = neto.toFixed(2);
	}
}

// Escuchar cambios
['peso_neto', 'peso_bruto', 'tara_pri', 'tara_sec'].forEach(id => {
	document.getElementById(id).addEventListener('input', calcularSegunModo);
});

document.querySelectorAll('input[name="modo_peso"]').forEach(radio => {
	radio.addEventListener('change', () => {
			actualizarCamposActivos();
			calcularSegunModo();
	});
});

// Inicializar al cargar
window.addEventListener('DOMContentLoaded', () => {
	actualizarCamposActivos();
	calcularSegunModo();
});