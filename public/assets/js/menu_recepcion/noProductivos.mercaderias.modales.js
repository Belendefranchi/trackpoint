document.addEventListener('DOMContentLoaded', function () {

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
            mensajeBusqueda.textContent = 'Mercadería no encontrada.';
            mensajeBusqueda.classList.remove('d-none');
          }
        },
        error: function () {
          inputDescripcionBusqueda.value = '';
          document.getElementById('input-mercaderia-id').value = '';
          mensajeBusqueda.textContent = 'Error al buscar mercadería.';
          mensajeBusqueda.classList.remove('d-none');
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

});

  /* ##################### AGREGAR MERCADERÍA ##################### */

  const mensajeErrorAgregar = document.getElementById('mensaje-error-agregar');
  const formAgregar = document.getElementById('formAgregarMercaderia');

  function mostrarMensajeErrorAgregar(mensaje) {
    mensajeErrorAgregar.classList.remove('d-none');
    mensajeErrorAgregar.querySelector('.mensaje-texto').textContent = mensaje;
  }

