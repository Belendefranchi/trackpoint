/* ================================
		EVENTOS DE APERTURA DE MODALES
		DELEGACIÓN CENTRALIZADA
================================ */

document.addEventListener('show.bs.modal', function (event) {
	const modal = event.target;          // Modal que se está abriendo
	const button = event.relatedTarget;  // Botón que disparó el modal

	switch (modal.id) {

		/* -----------------------------------------
				MODAL CREAR PRESUPUESTO
		----------------------------------------- */
		case 'modalCrearPresupuesto':
			// Limpia campos, errores, estados previos
			document.querySelector('#formCrearPresupuesto').reset();
			$('#mensaje-error-crear').addClass('d-none');
			const hoy = new Date();

			// fecha hoy
			const fechaHoy = hoy.toISOString().split('T')[0];

			// fecha vencimiento +10 días
			const vencimiento = new Date(hoy);
			vencimiento.setDate(vencimiento.getDate() + 10);
			const fechaVencimiento = vencimiento.toISOString().split('T')[0];

			modal.querySelector('#crearFechaPresupuesto').value = fechaHoy;
			modal.querySelector('#crearFechaVencimientoPresupuesto').value = fechaVencimiento;

			break;

		/* -----------------------------------------
				MODAL EDITAR PRESUPUESTO
		----------------------------------------- */
		case 'modalEditarPresupuesto':
			if (!button) return;

			// Cargar los datos del presupuesto en el modal
			document.querySelector('#editarPresupuestoId').value = button.getAttribute('data-id');
			document.querySelector('#editarEmpresaPresupuesto').value = button.getAttribute('data-empresa');
			document.querySelector('#editarSucursalPresupuesto').value = button.getAttribute('data-sucursal');
			document.querySelector('#editarRubroPresupuesto').value = button.getAttribute('data-rubro');
			document.querySelector('#editarFechaPresupuesto').value = button.getAttribute('data-fechap');
			document.querySelector('#editarFechaVencimientoPresupuesto').value = button.getAttribute('data-fechav');
			document.querySelector('#editarClientePresupuesto').value = button.getAttribute('data-cliente');
			document.querySelector('#editarDireccionClientePresupuesto').value = button.getAttribute('data-direccionc');
			document.querySelector('#editarContactoClientePresupuesto').value = button.getAttribute('data-contactoc');
			document.querySelector('#editarListaPreciosPresupuesto').value = button.getAttribute('data-lista');
			break;

		/* -----------------------------------------
				MODAL ELIMINAR PRESUPUESTO
		----------------------------------------- */
		case 'modalEliminarPresupuesto':
			if (!button) return;

			document.querySelector('#eliminarPresupuestoId').value = button.getAttribute('data-id');
			break;

		/* -----------------------------------------
				MODAL GENERAR PRESUPUESTO
		----------------------------------------- */
		case 'modalGenerarPresupuesto':
			if (!button) return;

			document.querySelector('#generarPresupuestoId').value = button.getAttribute('data-id');
			document.querySelector('#generarEmpresaPresupuesto').value = button.getAttribute('data-empresa');
			document.querySelector('#generarSucursalPresupuesto').value = button.getAttribute('data-sucursal');
			document.querySelector('#generarRubroPresupuesto').value = button.getAttribute('data-rubro');
			document.querySelector('#generarFechaPresupuesto').value = button.getAttribute('data-fechap');
			document.querySelector('#generarFechaVencimientoPresupuesto').value = button.getAttribute('data-fechav');
			document.querySelector('#generarClientePresupuesto').value = button.getAttribute('data-cliente');
			document.querySelector('#generarDireccionClientePresupuesto').value = button.getAttribute('data-direccionc');
			document.querySelector('#generarContactoClientePresupuesto').value = button.getAttribute('data-contactoc');
			break;

		/* -----------------------------------------
				MODAL SELECCIONAR MERCADERÍA
		----------------------------------------- */
		/* 		case 'modalSeleccionarMercaderia':
					$('#mensaje-error-seleccionar').addClass('d-none');
					var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');
					console.log('DEBUG estado actual:', presupuestoSeleccionado, listaPrecioId);
					if (!presupuestoSeleccionado) {
						if (mensajeErrorSeleccionar) {
							mensajeErrorSeleccionar.classList.remove('d-none');
							mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent =
								'Puede seleccionar mercadería, pero deberá ingresar el precio manualmente.';
						}
					} else {
						console.log('Presupuesto OK:', presupuestoSeleccionado);
						console.log('Lista OK:', listaPrecioId);
					}
					break; */

		case 'modalSeleccionarMercaderia':
			// Limpia errores, reinicia el buscador
			$('#mensaje-error-seleccionar').addClass('d-none');

			const mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');
			/* const presupuestoSeleccionado = localStorage.getItem('presupuestoSeleccionado'); */

/* 			if (!presupuestoSeleccionado) {
				console.warn('No hay presupuesto seleccionado');
				mensajeErrorSeleccionar.classList.remove('d-none');
				mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent =
					'Debe seleccionar un presupuesto primero.';
			} else {
				console.log('Presupuesto seleccionado ID:', presupuestoSeleccionado);
			} */
			break;

		/* -----------------------------------------
				MODAL EDITAR MERCADERÍA EN EL DETALLE
		----------------------------------------- */
		case 'modalEditarMercaderia':
			if (!button) return;

			document.querySelector('#editarItemId').value = button.getAttribute('data-id');
			document.querySelector('#editarCodigoMercaderia').value = button.getAttribute('data-codigom');
			document.querySelector('#editarDescripcionMercaderia').value = button.getAttribute('data-descripcionm');
			document.querySelector('#editarCantidadMercaderia').value = button.getAttribute('data-cantidad');
			document.querySelector('#editarPrecioMercaderia').value = button.getAttribute('data-preciov');
			break;

		/* -----------------------------------------
				MODAL ELIMINAR MERCADERÍA DEL DETALLE
		----------------------------------------- */
		case 'modalEliminarMercaderia':
			if (!button) return;

			document.querySelector('#eliminarItemId').value = button.getAttribute('data-id');;
			break;

		/* -----------------------------------------
				MODAL MENSAJE (éxito / error / info)
		----------------------------------------- */
		case 'modalMensajePresupuesto':
			// Se muestra un mensaje ya cargado previamente
			// No requiere cargarse valores desde el botón
			break;
	}
});
