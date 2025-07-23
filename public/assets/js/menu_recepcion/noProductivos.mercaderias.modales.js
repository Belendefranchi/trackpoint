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

  /* ##################### MODAL SELECCIÓN DE MERCADERÍA ##################### */

  var modalSeleccionar = document.getElementById('modalSeleccionarMercaderia');
  var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');

  if (modalSeleccionar) {
    modalSeleccionar.addEventListener('hidden.bs.modal', function () {
      if (mensajeErrorSeleccionar) {
        mensajeErrorSeleccionar.classList.add('d-none');
        mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';
      }

      document.querySelectorAll('.seleccionar-mercaderia').forEach(radio => radio.checked = false);

      modalSeleccionar.querySelector('#input-mercaderia-id').value = '';
      modalSeleccionar.querySelector('#input-codigo-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-descripcion-mercaderia').value = '';
    });

    // Manejar el cambio de selección de la mercadería
    document.querySelectorAll('.seleccionar-operador').forEach(radio => {
      radio.addEventListener('change', function () {
        // Cargar datos al formulario cuando se confirma el modal
        document.getElementById('input-mercaderia-id').value = this.dataset.mercaderiaid;
        document.getElementById('input-codigo-mercaderia').value = this.dataset.codigom;
        document.getElementById('input-descripcion-mercaderia').value = this.dataset.descripcionm;
      })
    });

    // Enviar formulario con AJAX
    const formSeleccionar = document.getElementById('formSeleccionarMercaderia');
    if (formSeleccionar) {
      formSeleccionar.addEventListener('submit', function (e) {
        e.preventDefault();

        // Limpiar cualquier mensaje de error antes de hacer la solicitud
        $('#mensaje-error-seleccionar').addClass('d-none').find('.mensaje-texto').text('');

        const radioSeleccionado = document.querySelector('.seleccionar-mercaderia:checked');
        const mercaderiaId = radioSeleccionado?.dataset.mercaderiaid;
        const codigo = radioSeleccionado.dataset.codigom || '';
        const descripcion = radioSeleccionado.dataset.descripcionm || '';

        if (!mercaderiaId) {
          if (mensajeErrorSeleccionar) {
            mensajeErrorSeleccionar.classList.remove('d-none');
            mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Debe seleccionar una mercadería.';
          }
          return;
        }

        const formData = new FormData();
        formData.append('mercaderia_id', mercaderiaId);
        formData.append('codigo_mercaderia', codigo);
        formData.append('descripcion_mercaderia', descripcion);

        $.ajax({
          url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarMercaderia',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              const modal = bootstrap.Modal.getInstance(document.getElementById('modalSeleccionarMercaderia'));
              if (modal) modal.hide();
              location.reload();
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
  }

  /* ##################### BÚSQUEDA POR CÓDIGO ##################### */

  const inputCodigoBusqueda = document.getElementById('codigo_mercaderia');
  const inputDescripcionBusqueda = document.getElementById('descripcion_mercaderia');
  const mensajeBusqueda = document.getElementById('mensaje-busqueda');

  function buscarMercaderiaPorCodigo(codigo) {
    if (codigo.length >= 2) {
      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarCodigoMercaderia',
        method: 'POST',
        data: { 'codigo_mercaderia': codigo },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            inputDescripcionBusqueda.value = response.descripcion_mercaderia || '';
            document.getElementById('input-mercaderia-id').value = response.mercaderia_id || '';
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
          $('#mensaje-busqueda').removeClass('d-none').find('.mensaje-texto').text('Error de conexión al buscar la mercadería.');
        }
      });
    } else {
      inputDescripcionBusqueda.value = '';
      document.getElementById('input-mercaderia-id').value = '';
      mensajeBusqueda.classList.add('d-none');
    }
  }

  inputCodigoBusqueda.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      buscarMercaderiaPorCodigo(this.value.trim());
    }
  });

  /* ##################### AGREGAR MERCADERÍA ##################### */

  const formAgregar = document.querySelector('#formAgregarMercaderia');
  if (formAgregar) {
    formAgregar.addEventListener('submit', function (e) {
      e.preventDefault();
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
          if (response.success) {
            localStorage.setItem('pestanaActiva', $('.nav-link.active').attr('id'));
            location.reload();
          } else {
            $('#mensaje-error-agregar').removeClass('d-none').find('.mensaje-texto').text(response.message);
          }
        },
        error: function (xhr, status, error) {
          $('#mensaje-error-agregar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos.');
        }
      });
    });
  }

  /* ##################### GUARDAR RECEPCIÓN ##################### */

  document.getElementById('btnMostrarConfirmacion').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarGuardar'));
    modal.show();
  });

  document.getElementById('btnConfirmarGuardar').addEventListener('click', function () {
    bootstrap.Modal.getInstance(document.getElementById('modalConfirmarGuardar')).hide();

    $.ajax({
      url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&guardarRecepcion',
      type: 'POST',
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          $('#modalMensajeLabel').text('Recepción guardada');
          $('#textoModalMensaje').text('La recepción fue guardada correctamente.');
        } else {
          $('#modalMensajeLabel').text('Error al guardar');
          $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
        }

        const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeRecepcion'));
        modalMensaje.show();
      },
      error: function () {
        $('#modalMensajeLabel').text('Error inesperado');
        $('#textoModalMensaje').text('Hubo un problema al intentar guardar la recepción.');
        const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeRecepcion'));
        modalMensaje.show();
      }
    });
  });

});
