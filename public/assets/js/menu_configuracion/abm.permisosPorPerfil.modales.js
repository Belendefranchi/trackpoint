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

			/* const seleccionado = document.querySelector('input[name="seleccion_perfil"]:checked'); */
			const seleccionado = document.getElementById('input-perfil-id').value;

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
	document.addEventListener('change', function (e) {
		if (!e.target.matches('.seleccionar-perfil')) return;
		const radio = e.target;

		// Limpiar mensaje de error al cambiar de selección
		mensajeErrorSeleccionar.classList.add('d-none');
		mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';

		// Cargar datos al formulario cuando se confirma el modal
		document.getElementById('input-perfil-id').value = radio.dataset.perfilid;
		document.getElementById('input-nombre').value = radio.dataset.nombre;
		document.getElementById('input-descripcion').value = radio.dataset.descripcion;

		// Obtener permisos asignados al perfil con $.ajax
		const perfilId = radio.dataset.perfilid;

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
	/* CLICK FILA COMPLETA - TABLA PERMISOS */
	$('#miTablaConCheckbox tbody').on('click', 'tr', function (e) {
		if ($(e.target).is('input')) return;
		const checkbox = $(this).find('.checkbox-permiso');

		if (checkbox.length) {
			checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
		}
	});

	/* CLICK FILA COMPLETA - MODAL PERFILES */
	$('#miTablaEnModal tbody').on('click', 'tr', function (e) {
		if ($(e.target).is('input')) return;

		const radio = $(this).find('.seleccionar-perfil');

		if (radio.length) {
			// desmarcar todos
			$('.seleccionar-perfil').prop('checked', false);

			// marcar actual
			radio.prop('checked', true);

			// disparar evento real
			radio[0].dispatchEvent(new Event('change', { bubbles: true }));
		}
	});
});
