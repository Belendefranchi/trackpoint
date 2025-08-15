document.addEventListener('DOMContentLoaded', function () {

	/* ##################### MODAL DE CREACION ##################### */

	// Interceptar el evento de apertura del modal de creación
	var modalCrearSubgrupo = document.getElementById('modalCrearSubgrupo');
	if (modalCrearSubgrupo) {
		modalCrearSubgrupo.addEventListener('show.bs.modal', function (event) {
			var button = event.relatedTarget;

			modalCrearSubgrupo.querySelector('#crearCodigoSubgrupo').value = button.getAttribute('data-codigo');
			modalCrearSubgrupo.querySelector('#crearDescripcionSubgrupo').value = button.getAttribute('data-descripcion');
		});
	}

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearSubgrupo');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/subgrupos&crear',
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
            localStorage.setItem('paginaSubgrupos', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear el subgrupo:', response.message);
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
	var modalCrearSubgrupo = document.getElementById('modalCrearSubgrupo');
	if (modalCrearSubgrupo) {
		modalCrearSubgrupo.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-crear');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}


/* ##################### MODAL DE EDICIÓN ##################### */

	// Interceptar el evento de apertura del modal de edición
	var modalEditarSubgrupo = document.getElementById('modalEditarSubgrupo');
	if (modalEditarSubgrupo) {
		modalEditarSubgrupo.addEventListener('show.bs.modal', function (event) {
			console.log('Modal abrir - event.relatedTarget:', event.relatedTarget);
			const button = event.relatedTarget;

			if (!button) {
				console.warn('No se detectó el botón que activó el modal.');
				return;
			}

			modalEditarSubgrupo.querySelector('#editarSubgrupoId').value = button.getAttribute('data-id');
			modalEditarSubgrupo.querySelector('#editarCodigoSubgrupo').value = button.getAttribute('data-codigo');
			modalEditarSubgrupo.querySelector('#editarDescripcionSubgrupo').value = button.getAttribute('data-descripcion');
			modalEditarSubgrupo.querySelector('#editarActivoSubgrupo').value = button.getAttribute('data-activo');
		});
	}

	// Interceptar el envío del formulario con AJAX
	const formEditar = document.querySelector('#formEditarSubgrupo');
	if (formEditar) {
		formEditar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/subgrupos&editar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Subgrupo modificado con éxito:', response.message);

						const tabla = $('#miTabla').DataTable();
						localStorage.setItem('paginaSubgrupos', tabla.page());

						location.reload();
					} else {
						console.log('Error al modificar el subgrupo:', response.message); 
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
	var modalEditarSubgrupo = document.getElementById('modalEditarSubgrupo');
	if (modalEditarSubgrupo) {
		modalEditarSubgrupo.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-editar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}


/* ##################### MODAL DE ELIMINACIÓN ##################### */

	// Interceptar el evento de apertura del modal de eliminación
  var modalEliminarSubgrupo = document.getElementById('modalEliminarSubgrupo');
  if (modalEliminarSubgrupo) {
    modalEliminarSubgrupo.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarSubgrupo.querySelector('#eliminarSubgrupoId').value = button.getAttribute('data-id');
      modalEliminarSubgrupo.querySelector('#eliminarCodigoSubgrupo').value = button.getAttribute('data-codigo');
    });
  }

	// Interceptar el envío del formulario con AJAX
	const formEliminar = document.querySelector('#formEliminarSubgrupo');
	if (formEliminar) {
		formEliminar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-eliminar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/subgrupos&eliminar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Grupo eliminado con éxito:', response.message);

						const tabla = $('#miTabla').DataTable();
						localStorage.setItem('paginaSubgrupos', tabla.page());

						location.reload();
					} else {
						console.log('Error al crear el subgrupo:', response.message);
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
	var modalEliminarSubgrupo = document.getElementById('modalEliminarSubgrupo');
	if (modalEliminarSubgrupo) {
		modalEliminarSubgrupo.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-eliminar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}
	
});