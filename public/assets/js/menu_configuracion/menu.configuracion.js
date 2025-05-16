const fechaHoy = new Date().toISOString().slice(0, 10);

/*-----##################### DATATABLES #####################-----*/
$(document).ready(function () {
	
	const tabla = $('#miTabla').DataTable({
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
										{ text: 'PUNTO CONECTADO', fontSize: 18, bold: true, color: '#22265D' },
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
							hLineWidth: () => 0.5,
							vLineWidth: () => 0.5,
							hLineColor: () => '#adadad',
							vLineColor: () => '#adadad',
							paddingLeft: () => 5,
							paddingRight: () => 5,
							paddingTop: () => 5,
							paddingBottom: () => 5
						},
						margin: [0, 20, 0, 20]
					});

					doc.footer = function(currentPage, pageCount) {
						return {
							columns: [
								'',
								{ text: 'Página ' + currentPage + ' de ' + pageCount, alignment: 'center', fontSize: 9, margin: [0, 10, 0, 0] },
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

	const tablaEnModal = $('#miTablaEnModal').DataTable({
		dom: 'ftp',
		pageLength: 10,
		language: {
			"sZeroRecords": "No se encontraron resultados",
			"sSearch": "Buscar:",
			"sEmptyTable": "No hay datos disponibles en la tabla",
			"oPaginate": {
				"sFirst": "Primero",
				"sPrevious": "Anterior",
				"sNext": "Siguiente",
				"sLast": "Último"
			},
		}
	});

});

/*-----##################### TOGGLE SIDEBAR #####################-----*/

document.addEventListener('DOMContentLoaded', function () {
	const sidebar = document.getElementById('sidebar');

	// Restaurar estado desde localStorage al cargar la página
	if (localStorage.getItem('sidebar-collapsed') === 'true') {
		sidebar.classList.add('collapsed');
	}

	// Manejador del botón
	document.getElementById('toggleSidebar').addEventListener('click', function () {
		const isCollapsed = sidebar.classList.toggle('collapsed');

		// Guardar estado en localStorage
		localStorage.setItem('sidebar-collapsed', isCollapsed);

		// Cerrar submenús solo si se colapsa
		if (isCollapsed) {
			const submenus = sidebar.querySelectorAll('.collapse.show');
			submenus.forEach(sm => sm.classList.remove('show'));
		}
	});
});
