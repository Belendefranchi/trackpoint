/* ================================
		EVENTOS DE APERTURA DE MODALES
		DELEGACIÓN CENTRALIZADA
================================ */

document.addEventListener('show.bs.modal', function (event) {
	const modal = event.target;          // Modal que se está abriendo
	const button = event.relatedTarget;  // Botón que disparó el modal

	switch (modal.id) {

		/* -----------------------------------------
				MODAL CREAR LISTA DE PRECIOS
		----------------------------------------- */
		case 'modalCrearListaPrecios':
			// Limpia campos, errores, estados previos
			document.querySelector('#formCrearListaPrecios').reset();
			$('#mensaje-error-crear').addClass('d-none');
			const hoy = new Date();

			// fecha hoy
			const fechaHoy = hoy.toISOString().split('T')[0];

			modal.querySelector('#crearFechaLista').value = fechaHoy;

			break;

		/* -----------------------------------------
				MODAL EDITAR LISTA DE PRECIOS
		----------------------------------------- */
		case 'modalEditarListaPrecios':
			if (!button) return;

			// Cargar los datos del ListaPrecios en el modal
			document.querySelector('#editarListaPreciosId').value = button.getAttribute('data-id');
			document.querySelector('#editarTipoLista').value = button.getAttribute('data-tipo');
			document.querySelector('#editarProveedorLista').value = button.getAttribute('data-proveedor');
			document.querySelector('#editarMonedaLista').value = button.getAttribute('data-moneda');
			document.querySelector('#editarFechaLista').value = button.getAttribute('data-fecha');
			break;

		/* -----------------------------------------
				MODAL ELIMINAR LISTA DE PRECIOS
		----------------------------------------- */
		case 'modalEliminarListaPrecios':
			if (!button) return;

			document.querySelector('#eliminarListaPreciosId').value = button.getAttribute('data-id');
			break;

		/* -----------------------------------------
				MODAL VER Y EDITAR LISTA DE PRECIOS
		----------------------------------------- */
/* 		case 'modalVerListaPrecios':
			if (!button) return;

			document.querySelector('#verListaPreciosId').value = button.getAttribute('data-id');
			break; */

		/* -----------------------------------------
				MODAL MENSAJE (éxito / error / info)
		----------------------------------------- */
		
		case 'modalMensajeListaPrecios':
			// Se muestra un mensaje ya cargado previamente
			// No requiere cargarse valores desde el botón
			break;
	}
});
