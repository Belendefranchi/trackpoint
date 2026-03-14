window.addEventListener('load', function () {
	localStorage.removeItem('listaSeleccionada');
});

// --- VARIABLES GLOBALES ---
let presupuestoSeleccionado = null;

document.addEventListener('DOMContentLoaded', function () {

	/* ###################### MODAL DE CREACIÓN DE LISTAS DE PRECIOS ###################### */

	// Interceptar el envío del formulario con AJAX
	const formCrear = document.querySelector('#formCrearListaPrecios');
	if (formCrear) {
		formCrear.addEventListener('submit', function (e) {
			e.preventDefault();

			// Limpiar cualquier mensaje de error antes de hacer la solicitud
			$('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');

			const formData = new FormData(this);

			$.ajax({
				url: '/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&crearLista',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success) {
						console.log('Lista de precios creada con éxito:', response.message);

						const tabla = $('#miTablaResumen').DataTable();
						localStorage.setItem('paginaListaPrecios', tabla.page());

						location.reload();
					} else {
						console.log('Error al crear la lista de precios:', response.message);
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
  var modalCrearListaPrecios = document.getElementById('modalCrearListaPrecios');
  modalCrearListaPrecios.addEventListener('hidden.bs.modal', function () {
    var mensajeError = document.getElementById('mensaje-error-crear');
    if (mensajeError) {
      mensajeError.classList.add('d-none'); // Ocultar el div
      mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
    }
  });


  /* ###################### ELIMINAR LISTA DE PRECIOS ###################### */
  const btnConfirmarEliminar = document.getElementById('btnConfirmarEliminar');
  if (btnConfirmarEliminar) {
    btnConfirmarEliminar.addEventListener('click', function () {
      bootstrap.Modal.getInstance(document.getElementById('modalEliminarListaPrecios')).hide();

      $.ajax({
        url: '/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&eliminarLista',
        type: 'POST',
        data: { 'lista_id': document.getElementById('eliminarListaPreciosId').value },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            console.log(response)
            $('#modalMensajeLabel').text('Lista de precios eliminada');
            $('#textoModalMensaje').text('La lista de precios fue eliminada correctamente.');
          } else {
            $('#modalMensajeLabel').text('Error al cancelar');
            $('#textoModalMensaje').text(response.message || 'Ocurrió un error inesperado.');
          }

          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeListaPrecios'));
          modalMensaje.show();

          // Esperar a que el modal se cierre para recargar
          const modalElement = document.getElementById('modalMensajeListaPrecios');
          modalElement.addEventListener('hidden.bs.modal', function () {
            location.reload();
          }, { once: true });

        },
        error: function (xhr, status, error) {
          console.log('Error al guardar los datos');
          console.log('Código de estado:', xhr.status);
          console.log('Mensaje de error:', error);
          console.log('Respuesta del servidor:', xhr.responseText);
          $('#modalMensajeLabel').text('Error inesperado');
          $('#textoModalMensaje').text('Hubo un problema al intentar eliminar la lista de precios.');
          const modalMensaje = new bootstrap.Modal(document.getElementById('modalMensajeListaPrecios'));
          modalMensaje.show();
        }
      });
    });
  }

  /* ###################### MODAL SELECCIONAR MERCADERIA ###################### */
	var modalSeleccionar = document.getElementById('modalSeleccionarMercaderia');
  var mensajeErrorSeleccionar = document.getElementById('mensaje-error-seleccionar');

  if (modalSeleccionar) {

    // Listener para vaciar selección cuando se cierra el modal
    modalSeleccionar.addEventListener('hidden.bs.modal', function () {
      // Limpia el mensaje de error
      if (mensajeErrorSeleccionar) {
        mensajeErrorSeleccionar.classList.add('d-none');
        mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = '';
      }
      // Limpia los inputs hidden del modal
      modalSeleccionar.querySelector('#input-mercaderia-id').value = '';
      modalSeleccionar.querySelector('#input-codigo-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-descripcion-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-precio-compra-mercaderia').value = '';
      modalSeleccionar.querySelector('#input-precio-venta-mercaderia').value = '';

    });

    const inputMercaderiaIdModal = document.getElementById('mercaderia_id');
    const inputCodigoModal = document.getElementById('codigo_mercaderia');
    const inputDescripcionModal = document.getElementById('descripcion_mercaderia');
    const inputPrecioCompraModal = document.getElementById('precio_compra_mercaderia');
    const inputPrecioVentaModal = document.getElementById('precio_venta_mercaderia');


    // Enviar formulario con AJAX para seleccionar mercadería
    const formSeleccionar = document.getElementById('formSeleccionarMercaderia');
    if (formSeleccionar) {
      formSeleccionar.addEventListener('submit', function (e) {
        e.preventDefault();

        // Limpiar cualquier mensaje de error antes de hacer la solicitud
        $('#mensaje-error-seleccionar').addClass('d-none').find('.mensaje-texto').text('');

        // Obtener el radio seleccionado y sus datos
        const radioSeleccionado = document.querySelector('.seleccionar-mercaderia:checked');
        const mercaderiaId = radioSeleccionado?.dataset.mercaderiaid || '';
        const codigo = radioSeleccionado?.dataset.codigom || '';
        const descripcion = radioSeleccionado?.dataset.descripcionm || '';
        const precioCompra = radioSeleccionado?.dataset.preciocompram || '1';
        const precioVenta = radioSeleccionado?.dataset.precioventam || '1';

        // Validar que se haya seleccionado una mercadería
        if (!mercaderiaId) {
          if (mensajeErrorSeleccionar) {
            mensajeErrorSeleccionar.classList.remove('d-none');
            mensajeErrorSeleccionar.querySelector('.mensaje-texto').textContent = 'Debe seleccionar una mercadería.';
          }
          return;
        }

        // Crear objeto FormData para agregar los datos de la mercadería a los dataset
        const formData = new FormData();
        formData.append('mercaderia_id', mercaderiaId);
        formData.append('codigo_mercaderia', codigo);
        formData.append('descripcion_mercaderia', descripcion);
        formData.append('precio_compra_mercaderia', precioCompra);
        formData.append('precio_venta_mercaderia', precioVenta);


        // Hacer la solicitud AJAX para pasar los datos de mercadería a la vista
        $.ajax({
          url: '/trackpoint/public/index.php?route=/ventas/egresos/presupuestos&seleccionarMercaderia',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function (response) {
            if (response.success) {

              console.log('Datos de la mercadería seleccionada - descripción:', {
                id: response.mercaderia_id,
                codigo: response.codigo_mercaderia,
                descripcion: response.descripcion_mercaderia,
                precio_compra: response.precio_compra_mercaderia,
                precio_venta: response.precio_venta_mercaderia
              });

              // Actualizar los inputs del form con los datos de la mercadería seleccionada
              inputMercaderiaIdModal.value = response.mercaderia_id;
              inputCodigoModal.value = response.codigo_mercaderia;
              inputDescripcionModal.value = response.descripcion_mercaderia;
              inputPrecioCompraModal.value = response.precio_compra_mercaderia;
              inputPrecioVentaModal.value = response.precio_venta_mercaderia;

              // Cerrar el modal
              const modal = bootstrap.Modal.getInstance(document.getElementById('modalSeleccionarMercaderia'));
              if (modal) modal.hide();
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


});