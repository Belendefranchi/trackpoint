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

});


$('#codigo_mercaderia').on('change', function() {
    const codigo = $(this).val();
    $.ajax({
        url: '/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarCodigoMercaderia',
        method: 'POST',
        data: { codigo_mercaderia: codigo },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#codigo_mercaderia').val(response.codigo);
            } else {
                alert('Mercadería no encontrada');
            }
        },
        error: function() {
            alert('Error en la búsqueda');
        }
    });
});
