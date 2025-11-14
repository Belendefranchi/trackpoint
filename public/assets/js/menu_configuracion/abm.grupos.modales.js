document.addEventListener('DOMContentLoaded', function () {

	/* ##################### MODAL DE CREACION ##################### */

	// Interceptar el evento de apertura del modal de creación
	var modalCrearGrupo = document.getElementById('modalCrearGrupo');
	if (modalCrearGrupo) {
		modalCrearGrupo.addEventListener('show.bs.modal', function (event) {
			var button = event.relatedTarget;

			modalCrearGrupo.querySelector('#crearCodigoGrupo').value = button.getAttribute('data-codigo');
			modalCrearGrupo.querySelector('#crearDescripcionGrupo').value = button.getAttribute('data-descripcion');
		});
	}

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearGrupo');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/grupos&crear',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Grupo creado con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaGrupos', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear el grupo:', response.message);
            $('#mensaje-error-crear').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText); 
          $('#mensaje-error-crear').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

	// Limpiar el mensaje de error al cerrar el modal
	var modalCrearGrupo = document.getElementById('modalCrearGrupo');
	if (modalCrearGrupo) {
		modalCrearGrupo.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-crear');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}


/* ##################### MODAL DE EDICIÓN ##################### */

	// Interceptar el evento de apertura del modal de edición
	var modalEditarGrupo = document.getElementById('modalEditarGrupo');
	if (modalEditarGrupo) {
		modalEditarGrupo.addEventListener('show.bs.modal', function (event) {
			console.log('Modal abrir - event.relatedTarget:', event.relatedTarget);
			const button = event.relatedTarget;

			if (!button) {
				console.warn('No se detectó el botón que activó el modal.');
				return;
			}

			modalEditarGrupo.querySelector('#editarGrupoId').value = button.getAttribute('data-id');
			modalEditarGrupo.querySelector('#editarCodigoGrupo').value = button.getAttribute('data-codigo');
			modalEditarGrupo.querySelector('#editarDescripcionGrupo').value = button.getAttribute('data-descripcion');
			modalEditarGrupo.querySelector('#editarActivoGrupo').value = button.getAttribute('data-activo');
		});
	}

	// Interceptar el envío del formulario con AJAX
	const formEditar = document.querySelector('#formEditarGrupo');
	if (formEditar) {
		formEditar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/grupos&editar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Grupo modificado con éxito:', response.message);

						const tabla = $('#miTabla').DataTable();
						localStorage.setItem('paginaGrupos', tabla.page());

						location.reload();
					} else {
						console.log('Error al modificar el grupo:', response.message); 
						$('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text(response.message);
					}
				},
				error: function (xhr, status, error) {
					console.log('Error al guardar los datos');
					console.log('Código de estado:', xhr.status);
					console.log('Mensaje de error:', error);
					console.log('Respuesta del servidor:', xhr.responseText); 
					$('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
				}
			});
		});
	}

	// Limpiar el mensaje de error al cerrar el modal
	var modalEditarGrupo = document.getElementById('modalEditarGrupo');
	if (modalEditarGrupo) {
		modalEditarGrupo.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-editar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}


/* ##################### MODAL DE ELIMINACIÓN ##################### */

	// Interceptar el evento de apertura del modal de eliminación
  var modalEliminarGrupo = document.getElementById('modalEliminarGrupo');
  if (modalEliminarGrupo) {
    modalEliminarGrupo.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarGrupo.querySelector('#eliminarGrupoId').value = button.getAttribute('data-id');
      modalEliminarGrupo.querySelector('#eliminarCodigoGrupo').value = button.getAttribute('data-codigo');
    });
  }

	// Interceptar el envío del formulario con AJAX
	const formEliminar = document.querySelector('#formEliminarGrupo');
	if (formEliminar) {
		formEliminar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-eliminar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/grupos&eliminar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Grupo eliminado con éxito:', response.message);

						location.reload();
					} else {
						console.log('Error al eliminar el grupo:', response.message);
						$('#mensaje-error-eliminar').removeClass('d-none').find('.mensaje-texto').text(response.message);
					}
				},
				error: function (xhr, status, error) {
					console.log('Error al guardar los datos');
					console.log('Código de estado:', xhr.status);
					console.log('Mensaje de error:', error);
					console.log('Respuesta del servidor:', xhr.responseText); 
					$('#mensaje-error-eliminar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
				}
			});
		});
	}

	// Limpiar el mensaje de error al cerrar el modal
	var modalEliminarGrupo = document.getElementById('modalEliminarGrupo');
	if (modalEliminarGrupo) {
		modalEliminarGrupo.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-eliminar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}
	
});