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