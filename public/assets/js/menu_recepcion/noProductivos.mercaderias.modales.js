document.addEventListener('DOMContentLoaded', function () {

	/* ##################### MODAL DE SELECCIÓN MERCADERÍA ##################### */

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarMercaderia = document.getElementById('modalSeleccionarMercaderia');

	if (modalSeleccionarMercaderia) {
		modalSeleccionarMercaderia.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-seleccionar-mercaderia');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}

	// Manejar el cambio de selección de la mercadería
	document.querySelectorAll('.seleccionar-mercaderia').forEach(radio => {
		radio.addEventListener('change', function () {

			// Cargar datos al formulario cuando se confirma el modal
			document.getElementById('input-mercaderia-id').value = this.dataset.mercaderiaid;
			document.getElementById('input-codigo-mercaderia').value = this.dataset.codigom;
			document.getElementById('input-descripcion-mercaderia').value = this.dataset.descripcionm;

		});
	});

	const inputCodigo = document.getElementById('codigo_mercaderia');
  const inputDescripcion = document.getElementById('descripcion_mercaderia');
  const mensajeBusqueda = document.getElementById('mensaje-busqueda');

  inputCodigo.addEventListener('keyup', function () {
    const codigo = this.value.trim();

    if (codigo.length >= 2) {
      $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarCodigoMercaderia',
        method: 'POST',
        data: { codigo_mercaderia: codigo },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            inputDescripcion.value = response.descripcion;
            mensajeBusqueda.textContent = '';
          } else {
            inputDescripcion.value = '';
            mensajeBusqueda.textContent = 'Mercadería no encontrada.';
          }
        },
        error: function () {
          console.error('Error al buscar mercadería.');
        }
      });
    } else {
      inputDescripcion.value = '';
      mensajeBusqueda.textContent = '';
    }
  });

  // Completar los campos si seleccionan desde el modal
  document.querySelectorAll('.seleccionar-mercaderia').forEach(radio => {
    radio.addEventListener('change', function () {
      document.getElementById('input-mercaderia-id').value = this.dataset.mercaderiaid;
      document.getElementById('input-codigo-mercaderia').value = this.dataset.codigom;
      document.getElementById('input-descripcion-mercaderia').value = this.dataset.descripcionm;
    });
  });

});