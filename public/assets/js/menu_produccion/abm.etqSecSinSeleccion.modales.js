document.addEventListener('DOMContentLoaded', function () {

  /* ##################### MODAL DE SELECCIÓN ##################### */

	// Interceptar el evento de apertura del modal de selección
	var formSeleccionarProducto = document.getElementById('formSeleccionarProducto');
	if(formSeleccionarProducto){
		formSeleccionarProducto.addEventListener('submit', function(e) {
			
			const seleccionado = document.querySelector('input[name="seleccion_producto"]:checked');
			
			if (!seleccionado) {
				e.preventDefault(); // evitar envío del form

				// Limpiar cualquier mensaje de error antes de hacer la solicitud
				$('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');
		
				const contenedor = document.getElementById('mensaje-error-seleccionar');
				const mensaje = contenedor.querySelector('.mensaje-texto');
				mensaje.textContent = 'Error: Por favor seleccione un producto';
				contenedor.classList.remove('d-none');
				contenedor.classList.add('show');

				// Tomar valores desde los campos ocultos
				const productoId = document.getElementById('input-producto-id').value;
				const codigo = document.getElementById('input-codigo').value;
				const descripcion = document.getElementById('input-descripcion').value;

				// Mostrar la tabla con los datos del producto
				document.getElementById('tabla-producto-seleccionado-container').style.display = 'block';
				document.getElementById('col-producto-id').textContent = productoId;
				document.getElementById('col-codigo').textContent = codigo;
				document.getElementById('col-descripcion').textContent = descripcion;
				return false;
			}
		});
	}

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarProducto = document.getElementById('modalSeleccionarProducto');
	
	if (modalSeleccionarProducto) {
		modalSeleccionarProducto.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-seleccionar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}

	// Manejar el cambio de selección del producto
	document.querySelectorAll('.seleccionar-producto').forEach(radio => {
		radio.addEventListener('change', function () {

			// Cargar datos al formulario cuando se confirma el modal
			document.getElementById('input-producto-id').value = this.dataset.productoid;
			document.getElementById('input-codigo').value = this.dataset.codigo;
			document.getElementById('input-descripcion').value = this.dataset.descripcion;
			document.getElementById('input-email').value = this.dataset.email;
			document.getElementById('input-rol').value = this.dataset.rol;

			// Obtener perfiles asignados al producto con $.ajax
			const productoId = this.dataset.productoid;

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorproducto&seleccionar',
				type: 'POST',
				data: { producto_id: productoId },
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						// Desmarcar todos los checkboxes
						document.querySelectorAll('.checkbox-perfil').forEach(cb => cb.checked = false);

						// Marcar solo los que corresponden
						response.perfiles.forEach(perfilId => {
							const checkbox = document.querySelector(`.checkbox-perfil[data-perfil-id="${perfilId}"]`);
							if (checkbox) checkbox.checked = true;
						});
					} else {
						console.log('Error al obtener el perfil:', response.message);
            $('#mensaje-error-crear').removeClass('d-none').find('.mensaje-texto').text(response.message);
					}
				},
				error: function(xhr, status, error) {
					console.log('Código de estado:', xhr.status);
					console.log('Mensaje de error:', error);
					$('#mensaje-error-editar').removeClass('d-none').find('.mensaje-texto').text('Hubo un error al intentar guardar los datos');
				}
				
			});
		});
	});

	$(document).ready(function () {
		$('#miTablaConCheckbox').on('change', '.checkbox-perfil', function () {
			const perfilId = $(this).data('perfil_id');
			const estaTildado = $(this).is(':checked');
			const productoId = $('#producto_id').val();

			console.log({
				producto_id: productoId,
				perfil_id: perfilId,
				asignar: estaTildado ? 1 : 0
			});
	
			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorproducto&asignar',
				method: 'POST',
				dataType: 'json',
				data: {
					producto_id: productoId,
					perfil_id: perfilId,
					asignar: estaTildado ? 1 : 0
				},
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						console.log('Perfil actualizado correctamente');
					} else {
						console.error('Error del servidor:', response.message);
					}
				},
				error: function (xhr, status, error) {
					console.error('Error en AJAX:', error);
				}
			});
		});
	});	

});
