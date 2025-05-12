document.addEventListener('DOMContentLoaded', function () {

	/* ##################### MODAL DE CREACION ##################### */

	// Interceptar el evento de apertura del modal de creación
	var modalCrearOperador = document.getElementById('modalCrearOperador');
	if (modalCrearOperador) {
		modalCrearOperador.addEventListener('show.bs.modal', function (event) {
			var button = event.relatedTarget;

			modalCrearOperador.querySelector('#crearNombreOperador').value = button.getAttribute('data-nombre');
			modalCrearOperador.querySelector('#crearEmailOperador').value = button.getAttribute('data-email');
			modalCrearOperador.querySelector('#crearUsernameOperador').value = button.getAttribute('data-username');
			modalCrearOperador.querySelector('#crearPasswordOperador').value = button.getAttribute('data-password');
			modalCrearOperador.querySelector('#crearRolOperador').value = button.getAttribute('data-rol');
		});
	}

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearOperador');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Operador creado con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaOperadores', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear el operador:', response.message);
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
		var modalCrearOperador = document.getElementById('modalCrearOperador');
		if (modalCrearOperador) {
			modalCrearOperador.addEventListener('hidden.bs.modal', function () {
				var mensajeError = document.getElementById('mensaje-error-crear');
				if (mensajeError) {
					mensajeError.classList.add('d-none'); // Ocultar el div
					mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
				}
			});
		}


/* ##################### MODAL DE EDICIÓN ##################### */

	// Interceptar el evento de apertura del modal de edición
	var modalEditarOperador = document.getElementById('modalEditarOperador');
	if (modalEditarOperador) {
		modalEditarOperador.addEventListener('show.bs.modal', function (event) {
			var button = event.relatedTarget;

			if (!button) {
				console.warn('No se pudo obtener el botón que abrió el modal.');
				return;
			}
			console.log('Botón disparador:', button);
			console.log('data-id:', button.getAttribute('data-id'));
			console.log('data-nombre:', button.getAttribute('data-nombre'));


			modalEditarOperador.querySelector('#editarOperadorId').value = button.getAttribute('data-id');
			modalEditarOperador.querySelector('#editarNombreOperador').value = button.getAttribute('data-nombre');
			modalEditarOperador.querySelector('#editarEmailOperador').value = button.getAttribute('data-email');
			modalEditarOperador.querySelector('#editarUsernameOperador').value = button.getAttribute('data-username');
			modalEditarOperador.querySelector('#editarRolOperador').value = button.getAttribute('data-rol');
			modalEditarOperador.querySelector('#editarActivoOperador').value = button.getAttribute('data-activo');
		});
	}

	// Interceptar el envío del formulario con AJAX
	const formEditarOperador = document.querySelector('#formEditarOperador');
	if (formEditarOperador) {
		formEditarOperador.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Operador modificado con éxito:', response.message);

						const tabla = $('#miTabla').DataTable();
						localStorage.setItem('paginaOperadores', tabla.page());

						location.reload();
					} else {
						console.log('Error al modificar el operador:', response.message); 
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
	var modalEditarOperador = document.getElementById('modalEditarOperador');
	if (modalEditarOperador) {
		modalEditarOperador.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-editar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}


/* ##################### MODAL DE ELIMINACIÓN ##################### */

	// Interceptar el evento de apertura del modal de eliminación
  var modalEliminarOperador = document.getElementById('modalEliminarOperador');
  if (modalEliminarOperador) {
    modalEliminarOperador.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarOperador.querySelector('#eliminarOperadorId').value = button.getAttribute('data-id');
      modalEliminarOperador.querySelector('#eliminarUsernameOperador').value = button.getAttribute('data-username');
    });
  }

	// Interceptar el envío del formulario con AJAX
	const formEliminar = document.querySelector('#formEliminarOperador');
	if (formEliminar) {
		formEliminar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-eliminar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&eliminar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Operador eliminado con éxito:', response.message);

						const tabla = $('#miTabla').DataTable();
						localStorage.setItem('paginaOperadores', tabla.page());

						location.reload();
					} else {
						console.log('Error al crear el perfil:', response.message);
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
	var modalEliminarOperador = document.getElementById('modalEliminarOperador');
	if (modalEliminarOperador) {
		modalEliminarOperador.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-eliminar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}
	
});