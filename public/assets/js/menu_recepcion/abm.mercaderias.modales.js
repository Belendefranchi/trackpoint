document.addEventListener('DOMContentLoaded', function () {
  
  /* ##################### MODAL DE CREACION ##################### */

  // Interceptar el evento de apertura del modal de creación
  var modalCrearMercaderia = document.getElementById('modalCrearMercaderia');
  if (modalCrearMercaderia) {
    modalCrearMercaderia.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalCrearMercaderia.querySelector('#crearCodigoMercaderia').value = button.getAttribute('data-codigo');
      modalCrearMercaderia.querySelector('#crearDescripcionMercaderia').value = button.getAttribute('data-descripcion');
      modalCrearMercaderia.querySelector('#crearUnidadMedidaMercaderia').value = button.getAttribute('data-unidad');
      modalCrearMercaderia.querySelector('#crearGrupoMercaderia').value = button.getAttribute('data-grupo');
      modalCrearMercaderia.querySelector('#crearSubgrupoMercaderia').value = button.getAttribute('data-subgrupo');
      modalCrearMercaderia.querySelector('#crearEnvasePriMercaderia').value = button.getAttribute('data-envasepri');
      modalCrearMercaderia.querySelector('#crearEnvaseSecMercaderia').value = button.getAttribute('data-envasesec');
      modalCrearMercaderia.querySelector('#crearMarcaMercaderia').value = button.getAttribute('data-marca');
      modalCrearMercaderia.querySelector('#crearCantidadPropuestaMercaderia').value = button.getAttribute('data-cantidadprop');
      modalCrearMercaderia.querySelector('#crearPesoPropuestoMercaderia').value = button.getAttribute('data-pesoprop');
      modalCrearMercaderia.querySelector('#crearPesoMinMercaderia').value = button.getAttribute('data-pesomin');
      modalCrearMercaderia.querySelector('#crearPesoMaxMercaderia').value = button.getAttribute('data-pesomax');
      modalCrearMercaderia.querySelector('#crearEtiquetaSecMercaderia').value = button.getAttribute('data-etiquetasec');
    });
  }

  // Interceptar el envío del formulario con AJAX
  const formCrear = document.querySelector('#formCrearMercaderia');
  if (formCrear) {
    formCrear.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/ABMs/mercaderias&crear',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería creada con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaMercaderias', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear la mercadería:', response.message);
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
  var modalCrearMercaderia = document.getElementById('modalCrearMercaderia');
  if (modalCrearMercaderia) {
    modalCrearMercaderia.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-crear');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }


/* ##################### MODAL DE EDICIÓN ##################### */

  // Interceptar el evento de apertura del modal de edición
  var modalEditarMercaderia = document.getElementById('modalEditarMercaderia');
  if (modalEditarMercaderia) {
    modalEditarMercaderia.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEditarMercaderia.querySelector('#editarMercaderiaId').value = button.getAttribute('data-id');
      modalEditarMercaderia.querySelector('#editarCodigoMercaderia').value = button.getAttribute('data-codigo');
      modalEditarMercaderia.querySelector('#editarDescripcionMercaderia').value = button.getAttribute('data-descripcion');
      modalEditarMercaderia.querySelector('#editarUnidadMedidaMercaderia').value = button.getAttribute('data-unidad');
      modalEditarMercaderia.querySelector('#editarGrupoMercaderia').value = button.getAttribute('data-grupo');
      modalEditarMercaderia.querySelector('#editarSubgrupoMercaderia').value = button.getAttribute('data-subgrupo');
      modalEditarMercaderia.querySelector('#editarEnvasePriMercaderia').value = button.getAttribute('data-envasepri');
      modalEditarMercaderia.querySelector('#editarEnvaseSecMercaderia').value = button.getAttribute('data-envasesec');
      modalEditarMercaderia.querySelector('#editarMarcaMercaderia').value = button.getAttribute('data-marca');
      modalEditarMercaderia.querySelector('#editarCantidadPropuestaMercaderia').value = button.getAttribute('data-cantidadprop');
      modalEditarMercaderia.querySelector('#editarPesoPropuestoMercaderia').value = button.getAttribute('data-pesoprop');
      modalEditarMercaderia.querySelector('#editarPesoMinMercaderia').value = button.getAttribute('data-pesomin');
      modalEditarMercaderia.querySelector('#editarPesoMaxMercaderia').value = button.getAttribute('data-pesomax');
      modalEditarMercaderia.querySelector('#editarEtiquetaSecMercaderia').value = button.getAttribute('data-etiquetasec');
      modalEditarMercaderia.querySelector('#editarActivoMercaderia').value = button.getAttribute('data-activo');
    });
  }

  // Interceptar el envío del formulario con AJAX
  const formEditar = document.querySelector('#formEditarMercaderia');
  if (formEditar) {
    formEditar.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-editar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/ABMs/mercaderias&editar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería modificada con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaMercaderias', tabla.page());

            location.reload();
          } else {
            console.log('Error al modificar la mercadería:', response.message); 
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
  var modalEditarMercaderia = document.getElementById('modalEditarMercaderia');
  if (modalEditarMercaderia) {
    modalEditarMercaderia.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-editar');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }


/* ##################### MODAL DE ELIMINACIÓN ##################### */

  // Interceptar el evento de apertura del modal de eliminación
  var modalEliminarMercaderia = document.getElementById('modalEliminarMercaderia');
  if (modalEliminarMercaderia) {
    modalEliminarMercaderia.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;

      modalEliminarMercaderia.querySelector('#eliminarMercaderiaId').value = button.getAttribute('data-id');
      modalEliminarMercaderia.querySelector('#eliminarCodigoMercaderia').value = button.getAttribute('data-codigo');
    });
  }

  // Interceptar el envío del formulario con AJAX
  const formEliminar = document.querySelector('#formEliminarMercaderia');
  if (formEliminar) {
    formEliminar.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-eliminar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/ABMs/mercaderias&eliminar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería eliminada con éxito:', response.message);

            const tabla = $('#miTabla').DataTable();
            localStorage.setItem('paginaMercaderias', tabla.page());

            location.reload();
          } else {
            console.log('Error al crear la mercadería:', response.message);
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
  var modalEliminarMercaderia = document.getElementById('modalEliminarMercaderia');
  if (modalEliminarMercaderia) {
    modalEliminarMercaderia.addEventListener('hidden.bs.modal', function () {
      var mensajeError = document.getElementById('mensaje-error-eliminar');
      if (mensajeError) {
        mensajeError.classList.add('d-none'); // Ocultar el div
        mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
      }
    });
  }

});