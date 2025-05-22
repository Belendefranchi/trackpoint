document.addEventListener('DOMContentLoaded', function () {

  /* ##################### MODAL DE SELECCIÓN ##################### */

	// Interceptar el evento de apertura del modal de selección
	var formSeleccionarPerfil = document.getElementById('formSeleccionarPerfil');
	if(formSeleccionarPerfil){
		formSeleccionarPerfil.addEventListener('submit', function(e) {
			
			const seleccionado = document.querySelector('input[name="seleccion_perfil"]:checked');
			
			if (!seleccionado) {
				e.preventDefault(); // evitar envío del form

				// Limpiar cualquier mensaje de error antes de hacer la solicitud
				$('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');
		
				const contenedor = document.getElementById('mensaje-error-seleccionar');
				const mensaje = contenedor.querySelector('.mensaje-texto');
				mensaje.textContent = 'Error: Por favor seleccione un perfil';
				contenedor.classList.remove('d-none');
				contenedor.classList.add('show');

				// Tomar valores desde los campos ocultos
				const perfilId = document.getElementById('input-perfil-id').value;
				const nombre = document.getElementById('input-nombre').value;
				const descripcion = document.getElementById('input-descripcion').value;

				// Mostrar la tabla con los datos del perfil
				document.getElementById('tabla-perfil-seleccionado-container').style.display = 'block';
				document.getElementById('col-perfil-id').textContent = perfilId;
				document.getElementById('col-nombre').textContent = nombre;
				document.getElementById('col-descripcion').textContent = descripcion;
		
				return false;
			}
		});
	}

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarPerfil = document.getElementById('modalSeleccionarPerfil');
	
	if (modalSeleccionarPerfil) {
		modalSeleccionarPerfil.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-seleccionar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}

	// Manejar el cambio de selección del perfil
	document.querySelectorAll('.seleccionar-perfil').forEach(radio => {
		radio.addEventListener('change', function () {

			// Cargar datos al formulario cuando se confirma el modal
			document.getElementById('input-perfil-id').value = this.dataset.perfilid;
			document.getElementById('input-nombre').value = this.dataset.nombre;
			document.getElementById('input-descripcion').value = this.dataset.descripcion;

			// Obtener permisos asignados al perfil con $.ajax
			const perfilId = this.dataset.perfilid;

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/permisosPorPerfil&seleccionar',
				type: 'POST',
				data: { perfil_id: perfilId },
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						// Desmarcar todos los checkboxes
						document.querySelectorAll('.checkbox-permiso').forEach(cb => cb.checked = false);

						// Marcar solo los que corresponden
						response.permisos.forEach(permisoId => {
							const checkbox = document.querySelector(`.checkbox-permiso[data-permiso-id="${permisoId}"]`);
							if (checkbox) checkbox.checked = true;
						});
					} else {
						console.log('Error al obtener el permiso:', response.message);
            $('#mensaje-error-crear').removeClass('d-none').find('.mensaje-texto').text(response.message);
					}
				},
				error: function(xhr, status, error) {
					console.log('Código de estado:', xhr.status);
					console.log('Mensaje de error:', error);
					$('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos');
				}
				
			});
		});
	});

	$(document).ready(function () {
		$('#miTabla').on('change', '.checkbox-permiso', function () {
			const permisoId = $(this).data('permiso_id');
			const estaTildado = $(this).is(':checked');
			const perfilId = $('#perfil_id').val(); // Asegurate que este input exista

			console.log({
				perfil_id: perfilId,
				permiso_id: permisoId,
				asignar: estaTildado ? 1 : 0
			});
	
			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/permisosPorPerfil&asignar',
				method: 'POST',
				dataType: 'json',
				data: {
					perfil_id: perfilId,
					permiso_id: permisoId,
					asignar: estaTildado ? 1 : 0
				},
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						console.log('Perfil actualizado correctamente');
					} else {
						console.error('Error del servidor:', response.message);
					}
				},
				error: function (xhr, status, error) {
					console.error('Error en AJAX:', error);
				}
			});
		});
	});	

});
