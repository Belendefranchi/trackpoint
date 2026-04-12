document.addEventListener('DOMContentLoaded', function () {

	/* ##################### MODAL DE SELECCIÓN ##################### */

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarPerfil = document.getElementById('modalSeleccionarPerfil');
	var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');

	if (modalSeleccionarPerfil) {
		modalSeleccionarPerfil.addEventListener('hidden.bs.modal', function () {
			var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');
			if (mensajeErrorSeleccionar) {
				mensajeErrorSeleccionar.classList.add('d-none'); // Ocultar el div
				mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}

	const formSeleccionarPerfil = document.getElementById('formSeleccionarPerfil');

	if (formSeleccionarPerfil) {
		formSeleccionarPerfil.addEventListener('submit', function (e) {

			const seleccionado = document.querySelector('input[name="seleccion_perfil"]:checked');

			if (!seleccionado) {
				e.preventDefault();

				mensajeErrorSeleccionar.classList.remove('d-none');
				mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Debe seleccionar un perfil.';
				return;
			}

			// opcional: limpiar error si todo está OK
			mensajeErrorSeleccionar.classList.add('d-none');
		});
	}

	// Manejar el cambio de selección del perfil
	document.querySelectorAll('.seleccionar-perfil').forEach(radio => {
		radio.addEventListener('change', function () {

			// Limpiar mensaje de error al cambiar de selección
			mensajeErrorSeleccionar.classList.add('d-none');
			mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';

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
				error: function (xhr, status, error) {
					console.log('Código de estado:', xhr.status);
					console.log('Mensaje de error:', error);
					$('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos');
				}

			});
		});
	});

	$(document).ready(function () {
		$('#miTablaConCheckbox').on('change', '.checkbox-permiso', function () {
			const permisoId = $(this).data('permiso_id');
			const estaTildado = $(this).is(':checked');
			const perfilId = $('#perfil_id').val();

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
