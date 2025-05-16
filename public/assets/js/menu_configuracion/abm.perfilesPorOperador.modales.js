document.addEventListener('DOMContentLoaded', function () {

	document.getElementById('formSeleccionarOperador').addEventListener('submit', function(e) {
		const seleccionado = document.querySelector('input[name="seleccion_operador"]:checked');
	
		if (!seleccionado) {
			e.preventDefault(); // evitar envío del form
	
			const contenedor = document.getElementById('mensaje-error-seleccionar');
			const mensaje = contenedor.querySelector('.mensaje-texto');
			mensaje.textContent = 'Error: Por favor seleccione un operador.';
			contenedor.classList.remove('d-none');
			contenedor.classList.add('show');
	
			return false;
		}
	});

	  // Limpiar el mensaje de error al cerrar el modal
		var modalSeleccionarOperador = document.getElementById('modalSeleccionarOperador');
		if (modalSeleccionarOperador) {
			modalSeleccionarOperador.addEventListener('hidden.bs.modal', function () {
				var mensajeError = document.getElementById('mensaje-error-seleccionar');
				if (mensajeError) {
					mensajeError.classList.add('d-none'); // Ocultar el div
					mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
				}
			});
		}

		document.querySelectorAll('.seleccionar-operador').forEach(radio => {
			radio.addEventListener('change', function () {
				document.getElementById('input-operador-id').value = this.dataset.operadorid;
				document.getElementById('input-username').value = this.dataset.username;
				document.getElementById('input-nombre').value = this.dataset.nombre;
				document.getElementById('input-email').value = this.dataset.email;
				document.getElementById('input-rol').value = this.dataset.rol;
			});
		});
});
