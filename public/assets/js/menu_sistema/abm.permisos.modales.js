document.addEventListener('DOMContentLoaded', function () {
  
  /* ##################### MODAL DE CREACION ##################### */

  // Interceptar el evento de apertura del modal de creación
  var modalCrearPermiso = document.getElementById('modalCrearPermiso');
  if (modalCrearPermiso) {
    modalCrearPermiso.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalCrearPermiso.querySelector('#crearNombrePermiso').value = button.getAttribute('data-nombre');
      modalCrearPermiso.querySelector('#crearDescripcionPermiso').value = button.getAttribute('data-descripcion');

    });
  }

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearPermiso');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/sistema/ABMs/permisos&crear',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Permiso creado con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaPermisos', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear el permiso:', response.message);
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
  var modalCrearPermiso = document.getElementById('modalCrearPermiso');
  if (modalCrearPermiso) {
    modalCrearPermiso.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-crear');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }


/* ##################### MODAL DE EDICIÓN ##################### */

  // Interceptar el evento de apertura del modal de edición
  var modalEditarPermiso = document.getElementById('modalEditarPermiso');
  if (modalEditarPermiso) {
    modalEditarPermiso.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEditarPermiso.querySelector('#editarPermisoId').value = button.getAttribute('data-id');
      modalEditarPermiso.querySelector('#editarNombrePermiso').value = button.getAttribute('data-nombre');
      modalEditarPermiso.querySelector('#editarDescripcionPermiso').value = button.getAttribute('data-descripcion');
      modalEditarPermiso.querySelector('#editarPantallaPermiso').value = button.getAttribute('data-pantalla');
    });
  }

	// Interceptar el envío del formulario con AJAX
	const formEditar = document.querySelector('#formEditarPermiso');
	if (formEditar) {
		formEditar.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/sistema/ABMs/permisos&editar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Permiso modificado con éxito:', response.message);

						const tabla = $('#miTabla').DataTable();
						localStorage.setItem('paginaPermisos', tabla.page());

						location.reload();
					} else {
						console.log('Error al modificar el permiso:', response.message); 
						$('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text(response.message);
					}
				},
				error: function (xhr, status, error) {
					console.log('Código de estado:', xhr.status);
					console.log('Mensaje de error:', error);
					console.log('Respuesta del servidor:', xhr.responseText); 
					$('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
				}
			});
		});
	}

	// Limpiar el mensaje de error al cerrar el modal
	var modalEditarPermiso = document.getElementById('modalEditarPermiso');
	if (modalEditarPermiso) {
		modalEditarPermiso.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-editar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}


/* ##################### MODAL DE ELIMINACIÓN ##################### */

  // Interceptar el evento de apertura del modal de eliminación
  var modalEliminarPermiso = document.getElementById('modalEliminarPermiso');
  if (modalEliminarPermiso) {
    modalEliminarPermiso.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarPermiso.querySelector('#eliminarPermisoId').value = button.getAttribute('data-id');
      modalEliminarPermiso.querySelector('#eliminarNombrePermiso').value = button.getAttribute('data-nombre');
    });
  }

  // Interceptar el envío del formulario con AJAX
  const formEliminar = document.querySelector('#formEliminarPermiso');
  if (formEliminar) {
    formEliminar.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-eliminar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/sistema/ABMs/permisos&eliminar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Permiso eliminado con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaPermisos', tabla.page());

            location.reload();
          } else {
            console.log('Error al eliminar el permiso:', response.message);
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
  var modalEliminarPermiso = document.getElementById('modalEliminarPermiso');
  if (modalEliminarPermiso) {
    modalEliminarPermiso.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-eliminar');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }

});