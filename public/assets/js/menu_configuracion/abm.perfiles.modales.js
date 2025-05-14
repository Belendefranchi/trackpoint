document.addEventListener('DOMContentLoaded', function () {
  
  /* ##################### MODAL DE CREACION ##################### */

  // Interceptar el evento de apertura del modal de creación
  var modalCrearPerfil = document.getElementById('modalCrearPerfil');
  if (modalCrearPerfil) {
    modalCrearPerfil.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalCrearPerfil.querySelector('#crearNombrePerfil').value = button.getAttribute('data-nombre');
      modalCrearPerfil.querySelector('#crearDescripcionPerfil').value = button.getAttribute('data-descripcion');

    });
  }

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearPerfil');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&crear',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Perfil creado con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaPerfiles', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear el perfil:', response.message);
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
  var modalCrearPerfil = document.getElementById('modalCrearPerfil');
  if (modalCrearPerfil) {
    modalCrearPerfil.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-crear');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }


/* ##################### MODAL DE EDICIÓN ##################### */

  // Interceptar el evento de apertura del modal de edición
  var modalEditarPerfil = document.getElementById('modalEditarPerfil');
  if (modalEditarPerfil) {
    modalEditarPerfil.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEditarPerfil.querySelector('#editarPerfilId').value = button.getAttribute('data-id');
      modalEditarPerfil.querySelector('#editarNombrePerfil').value = button.getAttribute('data-nombre');
      modalEditarPerfil.querySelector('#editarDescripcionPerfil').value = button.getAttribute('data-descripcion');
      modalEditarPerfil.querySelector('#editarActivoPerfil').value = button.getAttribute('data-activo');
    });
  }

    // Interceptar el envío del formulario con AJAX
    const formEditar = document.querySelector('#formEditarPerfil');
    if (formEditar) {
      formEditar.addEventListener('submit', function (e) {
        e.preventDefault();
  
        // Limpiar cualquier mensaje de error antes de hacer la solicitud
        $('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');
  
        const formData = new FormData(this);
  
        $.ajax({
          url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&editar',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function (response) {
            console.log('Respuesta del servidor:', response);
  
            if (response.success) {
              console.log('Perfil modificado con éxito:', response.message);
  
              const tabla = $('#miTabla').DataTable();
              localStorage.setItem('paginaPerfiles', tabla.page());
  
              location.reload();
            } else {
              console.log('Error al modificar el perfil:', response.message); 
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
    var modalEditarPerfil = document.getElementById('modalEditarPerfil');
    if (modalEditarPerfil) {
      modalEditarPerfil.addEventListener('hidden.bs.modal', function () {
        var mensajeError = document.getElementById('mensaje-error-editar');
        if (mensajeError) {
          mensajeError.classList.add('d-none'); // Ocultar el div
          mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
        }
      });
    }


/* ##################### MODAL DE ELIMINACIÓN ##################### */

  // Interceptar el evento de apertura del modal de eliminación
  var modalEliminarPerfil = document.getElementById('modalEliminarPerfil');
  if (modalEliminarPerfil) {
    modalEliminarPerfil.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarPerfil.querySelector('#eliminarPerfilId').value = button.getAttribute('data-id');
      modalEliminarPerfil.querySelector('#eliminarNombrePerfil').value = button.getAttribute('data-nombre');
    });
  }

  // Interceptar el envío del formulario con AJAX
  const formEliminar = document.querySelector('#formEliminarPerfil');
  if (formEliminar) {
    formEliminar.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-eliminar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&eliminar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Perfil eliminado con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaPerfiles', tabla.page());

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
  var modalEliminarPerfil = document.getElementById('modalEliminarPerfil');
  if (modalEliminarPerfil) {
    modalEliminarPerfil.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-eliminar');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }

});