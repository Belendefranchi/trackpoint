document.addEventListener('DOMContentLoaded', function () {
  
  /* ##################### MODAL DE CREACION ##################### */

  // Interceptar el evento de apertura del modal de creación
  var modalCrearProceso = document.getElementById('modalCrearProceso');
  if (modalCrearProceso) {
    modalCrearProceso.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalCrearProceso.querySelector('#crearCodigoProceso').value = button.getAttribute('data-codigo');
      modalCrearProceso.querySelector('#crearDescripcionProceso').value = button.getAttribute('data-descripcion');

    });
  }

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearProceso');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/produccion/ABMs/procesos&crear',
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
            localStorage.setItem('paginaProcesos', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear el proceso:', response.message);
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
  var modalCrearProceso = document.getElementById('modalCrearProceso');
  if (modalCrearProceso) {
    modalCrearProceso.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-crear');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }


/* ##################### MODAL DE EDICIÓN ##################### */

  // Interceptar el evento de apertura del modal de edición
  var modalEditarProceso = document.getElementById('modalEditarProceso');
  if (modalEditarProceso) {
    modalEditarProceso.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEditarProceso.querySelector('#editarProcesoId').value = button.getAttribute('data-id');
      modalEditarProceso.querySelector('#editarCodigoProceso').value = button.getAttribute('data-codigo');
      modalEditarProceso.querySelector('#editarDescripcionProceso').value = button.getAttribute('data-descripcion');
      modalEditarProceso.querySelector('#editarActivoProceso').value = button.getAttribute('data-activo');
    });
  }

    // Interceptar el envío del formulario con AJAX
    const formEditar = document.querySelector('#formEditarProceso');
    if (formEditar) {
      formEditar.addEventListener('submit', function (e) {
        e.preventDefault();
  
        // Limpiar cualquier mensaje de error antes de hacer la solicitud
        $('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');
  
        const formData = new FormData(this);
  
        $.ajax({
          url: '/trackpoint/public/index.php?route=/produccion/ABMs/procesos&editar',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function (response) {
            console.log('Respuesta del servidor:', response);
  
            if (response.success) {
              console.log('Proceso modificado con éxito:', response.message);
  
              const tabla = $('#miTabla').DataTable();
              localStorage.setItem('paginaProcesos', tabla.page());

              location.reload();
            } else {
              console.log('Error al modificar el proceso:', response.message);
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
    var modalEditarProceso = document.getElementById('modalEditarProceso');
    if (modalEditarProceso) {
      modalEditarProceso.addEventListener('hidden.bs.modal', function () {
        var mensajeError = document.getElementById('mensaje-error-editar');
        if (mensajeError) {
          mensajeError.classList.add('d-none'); // Ocultar el div
          mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
        }
      });
    }


/* ##################### MODAL DE ELIMINACIÓN ##################### */

  // Interceptar el evento de apertura del modal de eliminación
  var modalEliminarProceso = document.getElementById('modalEliminarProceso');
  if (modalEliminarProceso) {
    modalEliminarProceso.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarProceso.querySelector('#eliminarProcesoId').value = button.getAttribute('data-id');
      modalEliminarProceso.querySelector('#eliminarCodigoProceso').value = button.getAttribute('data-codigo');
    });
  }

  // Interceptar el envío del formulario con AJAX
  const formEliminar = document.querySelector('#formEliminarProceso');
  if (formEliminar) {
    formEliminar.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-eliminar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/configuracion/ABMs/procesos&eliminar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Proceso eliminado con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaProcesos', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear el proceso:', response.message);
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
  var modalEliminarProceso = document.getElementById('modalEliminarProceso');
  if (modalEliminarProceso) {
    modalEliminarProceso.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-eliminar');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }

});