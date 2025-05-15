document.addEventListener('DOMContentLoaded', function () {

	const formSeleccionar = document.querySelector('#formSeleccionarOperador');
	if (formSeleccionar) {
		formSeleccionar.addEventListener('submit', function (e) {
			e.preventDefault();

			const formData = new FormData(this);
			const operadorId = formSeleccionar.querySelector('input[name="operador_id"]:checked')?.value;

			if (!operadorId) {
				$('#mensaje-error-seleccionar').removeClass('d-none').find('.mensaje-texto').text('Debe seleccionar un operador.');
				return;
			}

			$('#mensaje-error-seleccionar').addClass('d-none').find('.mensaje-texto').text('');

			$.ajax({
				url: '/trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador&seleccionar',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (response) {
					console.log('Respuesta del servidor:', response);

					if (response.success && response.operador) {
						$('#modalSeleccionarOperador').modal('hide');
						mostrarOperadorSeleccionado(response.operador);
					} else {
						$('#mensaje-error-seleccionar').removeClass('d-none').find('.mensaje-texto').text(response.message || 'Error al seleccionar el operador.');
					}
				},
				error: function (xhr, status, error) {
					console.log('Error:', error);
					$('#mensaje-error-seleccionar').removeClass('d-none').find('.mensaje-texto').text('Error al enviar los datos.');
				}
			});
		});
	}

	// Función para mostrar los datos del operador seleccionado en una tabla
	function mostrarOperadorSeleccionado(operador) {
		const contenedor = document.getElementById('tablaOperadorSeleccionado');

		if (!contenedor) return;

		contenedor.innerHTML = `
			<h5 class="text-primary mb-3">Operador seleccionado:</h5>
			<table class="table table-bordered">
				<thead class="table-secondary">
					<tr>
						<th>ID</th>
						<th>Usuario</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Rol</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>${operador.operador_id}</td>
						<td>${operador.username}</td>
						<td>${operador.nombre_completo}</td>
						<td>${operador.email}</td>
						<td>${operador.rol}</td>
					</tr>
				</tbody>
			</table>
		`;
	}
});
