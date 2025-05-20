document.addEventListener('DOMContentLoaded', function () {

  /* ##################### MODAL DE SELECCIÓN ##################### */

	// Interceptar el evento de apertura del modal de selección
	var fomrSeleccionarOperador = document.getElementById('formSeleccionarOperador');
	if(fomrSeleccionarOperador){
		fomrSeleccionarOperador.addEventListener('submit', function(e) {

			const seleccionado = document.querySelector('input[name="seleccion_operador"]:checked');
		
			if (!seleccionado) {
				e.preventDefault(); // evitar envío del form

				// Limpiar cualquier mensaje de error antes de hacer la solicitud
				$('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');
		
				const contenedor = document.getElementById('mensaje-error-seleccionar');
				const mensaje = contenedor.querySelector('.mensaje-texto');
				mensaje.textContent = 'Error: Por favor seleccione un operador.';
				contenedor.classList.remove('d-none');
				contenedor.classList.add('show');
		
				return false;
			}
		});
	}

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

	// Manejar el cambio de selección del operador
	document.querySelectorAll('.seleccionar-operador').forEach(radio => {
		radio.addEventListener('change', function () {

			// Cargar datos al formulario
			document.getElementById('input-operador-id').value = this.dataset.operadorid;
			document.getElementById('input-username').value = this.dataset.username;
			document.getElementById('input-nombre').value = this.dataset.nombre;
			document.getElementById('input-email').value = this.dataset.email;
			document.getElementById('input-rol').value = this.dataset.rol;

			// Obtener perfiles asignados al operador con $.ajax
			const operadorId = this.dataset.operadorid;

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador&perfilesAsignados',
				type: 'POST',
				data: { operador_id: operadorId },
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						// Desmarcar todos los checkboxes
						document.querySelectorAll('.checkbox-perfil').forEach(cb => cb.checked = false);

						// Marcar solo los que corresponden
						response.perfiles.forEach(perfilId => {
							const checkbox = document.querySelector(`.checkbox-perfil[data-perfil-id="${perfilId}"]`);
							if (checkbox) checkbox.checked = true;
						});
					} else {
						/* alert('Error al obtener perfiles: ' + (response.message || '')); */
						console.log('Error al obtener el perfil:', response.message);
            $('#mensaje-error-crear').removeClass('d-none').find('.mensaje-texto').text(response.message);
					}
				},
				error: function(xhr, status, error) {
					/* console.error("Error al obtener perfiles:", error); */
					console.log("Respuesta completa:", xhr.responseText);
				}
				
			});
		});
	});
});
