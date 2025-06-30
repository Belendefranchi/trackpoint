document.addEventListener('DOMContentLoaded', function () {

  /* ##################### MODAL DE SELECCIÓN PROCESO ##################### */

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarProceso = document.getElementById('modalSeleccionarProceso');

	if (modalSeleccionarProceso) {
		modalSeleccionarProceso.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-seleccionar-proceso');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}

	// Manejar el cambio de selección de la mercadería
	document.querySelectorAll('.seleccionar-proceso').forEach(radio => {
		radio.addEventListener('change', function () {

			// Cargar datos al formulario cuando se confirma el modal
			document.getElementById('input-proceso-id').value = this.dataset.procesoid;
			document.getElementById('input-codigo-proceso').value = this.dataset.codigop;
			document.getElementById('input-descripcion-proceso').value = this.dataset.descripcionp;

		});
	});

	

	/* ##################### MODAL DE SELECCIÓN MERCADERÍA ##################### */

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarMercaderia = document.getElementById('modalSeleccionarMercaderia');

	if (modalSeleccionarMercaderia) {
		modalSeleccionarMercaderia.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-seleccionar-mercaderia');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}

	// Manejar el cambio de selección de la mercadería
	document.querySelectorAll('.seleccionar-mercaderia').forEach(radio => {
		radio.addEventListener('change', function () {

			// Cargar datos al formulario cuando se confirma el modal
			document.getElementById('input-mercaderia-id').value = this.dataset.mercaderiaid;
			document.getElementById('input-codigo-mercaderia').value = this.dataset.codigom;
			document.getElementById('input-descripcion-mercaderia').value = this.dataset.descripcionm;

		});
	});

});
