document.addEventListener('DOMContentLoaded', function () {

	/* ##################### MODAL DE SELECCIÓN ##################### */

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarOperador = document.getElementById('modalSeleccionarOperador');
	var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');

	if (modalSeleccionarOperador) {
		modalSeleccionarOperador.addEventListener('hidden.bs.modal', function () {
			if (mensajeErrorSeleccionar) {
				mensajeErrorSeleccionar.classList.add('d-none'); // Ocultar el div
				mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}

	const formSeleccionarOperador = document.getElementById('formSeleccionarOperador');

	if (formSeleccionarOperador) {
		formSeleccionarOperador.addEventListener('submit', function (e) {

			const seleccionado = document.querySelector('input[name="seleccion_operador"]:checked');

			if (!seleccionado) {
				e.preventDefault();

				mensajeErrorSeleccionar.classList.remove('d-none');
				mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Debe seleccionar un operador.';
				return;
			}

			// opcional: limpiar error si todo está OK
			mensajeErrorSeleccionar.classList.add('d-none');
		});
	}

	// Manejar el cambio de selección del operador
	document.querySelectorAll('.seleccionar-operador').forEach(radio => {
		radio.addEventListener('change', function () {

			// Limpiar mensaje de error al cambiar de selección
			mensajeErrorSeleccionar.classList.add('d-none');
			mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';

			// Cargar datos al formulario cuando se confirma el modal
			document.getElementById('input-operador-id').value = this.dataset.operadorid;
			document.getElementById('input-username').value = this.dataset.username;
			document.getElementById('input-nombre').value = this.dataset.nombre;
			document.getElementById('input-email').value = this.dataset.email;
			document.getElementById('input-rol').value = this.dataset.rol;

			// Obtener perfiles asignados al operador con $.ajax
			const operadorId = this.dataset.operadorid;

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador&seleccionar',
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
						console.log('Error al obtener el perfil:', response.message);
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
		$('#miTablaConCheckbox').on('change', '.checkbox-perfil', function () {
			const perfilId = $(this).data('perfil_id');
			const estaTildado = $(this).is(':checked');
			const operadorId = $('#operador_id').val();

			console.log({
				operador_id: operadorId,
				perfil_id: perfilId,
				asignar: estaTildado ? 1 : 0
			});

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador&asignar',
				method: 'POST',
				dataType: 'json',
				data: {
					operador_id: operadorId,
					perfil_id: perfilId,
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
