// Guardar pestaña activa en localStorage
const recepcionTabs = document.querySelectorAll('#recepcionTabsContent .tab-pane');

recepcionTabs.forEach(tab => {
  tab.addEventListener('shown.bs.tab', function (e) {
    const tabId = e.target.id;
    localStorage.setItem('pestanaRecepcionActiva', tabId);
  });
});

document.addEventListener('DOMContentLoaded', function () {

  // Restaurar pestaña activa al cargar
  const lastTab = localStorage.getItem('pestanaRecepcionActiva');

  if (lastTab) {
    const trigger = document.querySelector(`a[data-bs-toggle="tab"][href="#${lastTab}"]`);
    if (trigger) {
      new bootstrap.Tab(trigger).show();
    }
  }

  /* ##################### MODAL: SELECCIÓN DE MERCADERÍA ##################### */

  const modalSeleccionar = document.getElementById('modalSeleccionarMercaderia');
  const formSeleccionar = document.getElementById('formSeleccionarMercaderia');
  const mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');

  const inputId = document.getElementById('input-mercaderia-id');
  const inputCodigo = document.getElementById('input-codigo-mercaderia');
  const inputDescripcion = document.getElementById('input-descripcion-mercaderia');

  // Ocultar mensaje de error, desmarcar radios al cerrar el modal y limpiar inputs
  if (modalSeleccionar) {
    modalSeleccionar.addEventListener('hidden.bs.modal', function () {
      if (mensajeErrorSeleccionar) {
        mensajeErrorSeleccionar.classList.add('d-none');
        mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';
      }

      document.querySelectorAll('.seleccionar-mercaderia').forEach(radio => {
        radio.checked = false;
      });

      document.getElementById('input-mercaderia-id').value = '';
      document.getElementById('input-codigo-mercaderia').value = '';
      document.getElementById('input-descripcion-mercaderia').value = '';
    });
  }

  // Cargar datos en inputs ocultos al seleccionar una mercadería
  document.querySelectorAll('.seleccionar-mercaderia').forEach(radio => {
    radio.addEventListener('change', function () {
      inputId.value = this.dataset.mercaderiaid;
      inputCodigo.value = this.dataset.codigom;
      inputDescripcion.value = this.dataset.descripcionm;
    });
  });

  // Enviar formulario del modal por AJAX
  if (formSeleccionar) {
    formSeleccionar.addEventListener('submit', function (e) {
      e.preventDefault();

      mensajeErrorSeleccionar.classList.add('d-none');
      mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';

      const mercaderiaId = inputId.value;
      const codigo = inputCodigo.value;
      const descripcion = inputDescripcion.value;

      if (!mercaderiaId) {
        mensajeErrorSeleccionar.classList.remove('d-none');
        mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Debe seleccionar una mercadería.';
        return;
      }

      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarMercaderia',
        method: 'POST',
        data: {
          mercaderia_id: mercaderiaId,
          codigo_mercaderia: codigo,
          descripcion_mercaderia: descripcion
        },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            const modal = bootstrap.Modal.getInstance(modalSeleccionar);
            if (modal) modal.hide();
              // Recargar la vista principal para reflejar los datos de $_SESSION
              location.reload();
              // Cargar valores directamente
              /* document.getElementById('codigo_mercaderia').value = codigo;
              document.getElementById('descripcion_mercaderia').value = descripcion; */
          } else {
            mensajeErrorSeleccionar.classList.remove('d-none');
            mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = response.message || 'Error al seleccionar.';
          }
        },
        error: function () {
          mensajeErrorSeleccionar.classList.remove('d-none');
          mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Error de conexión al intentar seleccionar la mercadería.';
        }
      });
    });
  }

  /* ##################### BÚSQUEDA POR CÓDIGO ##################### */

  const inputCodigoBusqueda = document.getElementById('codigo_mercaderia');
  const inputDescripcionBusqueda = document.getElementById('descripcion_mercaderia');
  const mensajeBusqueda = document.getElementById('mensaje-busqueda');

  // Función reutilizable para buscar mercadería
  function buscarMercaderiaPorCodigo(codigo) {
    if (codigo.length >= 2) {
      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarCodigoMercaderia',
        method: 'POST',
        data: { 'codigo_mercaderia': codigo },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            inputDescripcionBusqueda.value = response.descripcion_mercaderia || response.descripcion || '';
            document.getElementById('input-mercaderia-id').value = response.mercaderia_id || '';
            mensajeBusqueda.textContent = '';
            mensajeBusqueda.classList.add('d-none');
          } else {
            inputDescripcionBusqueda.value = '';
            document.getElementById('input-mercaderia-id').value = '';
            $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function () {
          inputDescripcionBusqueda.value = '';
          document.getElementById('input-mercaderia-id').value = '';
          $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text(response.message);
        }
      });
    } else {
      inputDescripcionBusqueda.value = '';
      document.getElementById('input-mercaderia-id').value = '';
      mensajeBusqueda.textContent = '';
      mensajeBusqueda.classList.add('d-none');
    }
  }

  // Buscar mientras escribe
/*   inputCodigoBusqueda.addEventListener('keyup', function (e) {
    if (e.key !== 'Enter') {
      buscarMercaderiaPorCodigo(this.value.trim());
    }
  }); */

  // Confirmar búsqueda con Enter
  inputCodigoBusqueda.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault(); // Evita que se envíe el formulario al presionar Enter
      buscarMercaderiaPorCodigo(this.value.trim());
    }
  });


  /* ##################### AGREGAR MERCADERÍA ##################### */

  // Interceptar el envío del formulario con AJAX
  const formAgregar = document.querySelector('#formAgregarMercaderia');
  if (formAgregar) {
    formAgregar.addEventListener('submit', function (e) {
      e.preventDefault();

      // Limpiar cualquier mensaje de error antes de hacer la solicitud
      $('#mensaje-error-agregar').addClass('d-none').find('.mensaje-texto').text('');

      const formData = new FormData(this);

      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&agregarMercaderia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          console.log('Respuesta del servidor:', response);

          if (response.success) {
            console.log('Mercadería agregada con éxito:', response.message);
            localStorage.setItem('pestanaActiva', $('.nav-link.active').attr('id'));
            location.reload();
          } else {
            console.log('Error al agregar la mercadería:', response.message);
            $('#mensaje-error-agregar').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText); 
          $('#mensaje-error-agregar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  /* ##################### GUARDAR MERCADERÍA ##################### */

  // Mostrar el modal al hacer clic
  document.getElementById('btnMostrarConfirmacion').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarGuardar'));
    modal.show();
  });

  document.getElementById('btnConfirmarGuardar').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarGuardar'));
    modal.show();
  });

document.getElementById('btnConfirmarGuardar').addEventListener('click', function () {
  // Cierra el modal
  bootstrap.Modal.getInstance(document.getElementById('modalConfirmarGuardar')).hide();

  // Hacer la llamada AJAX para guardar la recepción
  $.ajax({
    url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&guardarRecepcion',
    type: 'POST',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        // Cerrar modal de confirmación
        const modalConfirmar = bootstrap.Modal.getInstance(document.getElementById('modalConfirmarG6uardar'));
        if (modalConfirmar) {
          modalConfirmar.hide();
        }
        $('#modalMensajeLabel').text('Recepción guardada');
        $('#textoModalMensaje').text('La recepción fue guardada correctamente.');
      } else {
        $('#modalMensajeLabel').text('Error al guardar');
        $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
      }
      
      // Mostrar el modal
      const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeRecepcion'));
      modalMensaje.show();
    },
    error: function (xhr, status, error) {
      console.error('Error al guardar la recepción:', error);
      alert('Error inesperado al guardar la recepción.');
    }
  });
});




});
