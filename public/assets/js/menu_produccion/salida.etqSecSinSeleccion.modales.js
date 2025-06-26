document.addEventListener('DOMContentLoaded', function () {

  /* ##################### MODAL DE SELECCIÓN PROCESO ##################### */

// Interceptar el evento de apertura del modal de selección
	var formSeleccionarProceso = document.getElementById('formSeleccionarProceso');
	if(formSeleccionarProceso){
		formSeleccionarProceso.addEventListener('submit', function(e) {

			const seleccionado = document.querySelector('input[name="seleccion_proceso"]:checked');

			if (!seleccionado) {
				e.preventDefault(); // evitar envío del form

				// Limpiar cualquier mensaje de error antes de hacer la solicitud
				$('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');
		
				const contenedor = document.getElementById('mensaje-error-seleccionar');
				const mensaje = contenedor.querySelector('.mensaje-texto');
				mensaje.textContent = 'Error: Por favor seleccione un proceso';
				contenedor.classList.remove('d-none');
				contenedor.classList.add('show');

				// Tomar valores desde los campos ocultos
				const procesoId = document.getElementById('input-proceso-id').value;
				const codigo = document.getElementById('input-codigo').value;
				const descripcion = document.getElementById('input-descripcion').value;

				// Mostrar la tabla con los datos del proceso
				document.getElementById('tabla-proceso-seleccionado-container').style.display = 'block';
				document.getElementById('col-proceso-id').textContent = procesoId;
				document.getElementById('col-codigo').textContent = codigo;
				document.getElementById('col-descripcion').textContent = descripcion;
				return false;
			}
		});
	}

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarProceso = document.getElementById('modalSeleccionarProceso');

	if (modalSeleccionarProceso) {
		modalSeleccionarProceso.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-seleccionar');
			if (mensajeError) {
				mensajeError.classList.add('d-none'); // Ocultar el div
				mensajeError.querySelector('.mensaje-texto').textContent = ''; // Limpiar el texto
			}
		});
	}

	// Manejar el cambio de selección de la mercadería
	document.querySelectorAll('.seleccionar-proceso').forEach(radio => {
		radio.addEventListener('change', function () {

			// Cargar datos al formulario cuando se confirma el modal
			document.getElementById('input-proceso-id').value = this.dataset.procesoid;
			document.getElementById('input-codigo').value = this.dataset.codigo;
			document.getElementById('input-descripcion').value = this.dataset.descripcion;

		});
	});

	

	/* ##################### MODAL DE SELECCIÓN MERCADERÍA ##################### */

	// Interceptar el evento de apertura del modal de selección
	var formSeleccionarMercaderia = document.getElementById('formSeleccionarMercaderia');
	if(formSeleccionarMercaderia){
		formSeleccionarMercaderia.addEventListener('submit', function(e) {

			const seleccionado = document.querySelector('input[name="seleccion_mercaderia"]:checked');

			if (!seleccionado) {
				e.preventDefault(); // evitar envío del form

				// Limpiar cualquier mensaje de error antes de hacer la solicitud
				$('#mensaje-error-crear').addClass('d-none').find('.mensaje-texto').text('');
		
				const contenedor = document.getElementById('mensaje-error-seleccionar');
				const mensaje = contenedor.querySelector('.mensaje-texto');
				mensaje.textContent = 'Error: Por favor seleccione una mercadería';
				contenedor.classList.remove('d-none');
				contenedor.classList.add('show');

				// Tomar valores desde los campos ocultos
				const mercaderiaId = document.getElementById('input-mercaderia-id').value;
				const codigo = document.getElementById('input-codigo').value;
				const descripcion = document.getElementById('input-descripcion').value;

				// Mostrar la tabla con los datos de la mercadería
				document.getElementById('tabla-mercaderia-seleccionada-container').style.display = 'block';
				document.getElementById('col-mercaderia-id').textContent = mercaderiaId;
				document.getElementById('col-codigo').textContent = codigo;
				document.getElementById('col-descripcion').textContent = descripcion;
				return false;
			}
		});
	}

	// Limpiar el mensaje de error al cerrar el modal
	var modalSeleccionarMercaderia = document.getElementById('modalSeleccionarMercaderia');

	if (modalSeleccionarMercaderia) {
		modalSeleccionarMercaderia.addEventListener('hidden.bs.modal', function () {
			var mensajeError = document.getElementById('mensaje-error-seleccionar');
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
			document.getElementById('input-codigo').value = this.dataset.codigo;
			document.getElementById('input-descripcion').value = this.dataset.descripcion;

		});
	});

});
