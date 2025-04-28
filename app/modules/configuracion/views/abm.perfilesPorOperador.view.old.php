<?php
require_once __DIR__ . '/../controllers/abm.perfilesPorOperador.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4 table-responsive">
	<h2 class="m-4">Perfiles por Operador</h2>
	<!-- Tabla de Operadores -->
	<table class="m-4 table table-hover" id="operadoresTable">
		<thead class="table-primary" style="background-color: #22265D;">
			<tr class="text-center text-light">
				<th class="p-2 border">ID</th>
				<th class="p-2 border">Usuario</th>
				<th class="p-2 border">Nombre</th>
				<th class="p-2 border">Email</th>
				<th class="p-2 border">Rol</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($operadores as $operador): ?>
				<tr class="text-center" data-operador-id="<?= htmlspecialchars($operador['id']) ?>" style="cursor: pointer;">
					<td class="p-2 border text-start"><?= htmlspecialchars($operador['id']) ?></td>
					<td class="p-2 border text-start"><?= htmlspecialchars($operador['username']) ?></td>
					<td class="p-2 border text-start"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
					<td class="p-2 border text-start"><?= htmlspecialchars($operador['email']) ?></td>
					<td class="p-2 border text-start"><?= htmlspecialchars($operador['rol']) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Tabla de Perfiles -->
	<table class="m-4 table table-hover" id="perfilesTable">
		<thead class="table-primary">
			<tr class="text-center text-light">
				<th class="p-2 border">ID</th>
				<th class="p-2 border">Perfil</th>
				<th class="p-2 border">Descripción</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($perfiles as $perfil): ?>
				<tr class="text-center" data-perfil-id="<?= htmlspecialchars($perfil['id']) ?>" style="cursor: pointer;">
					<td class="p-2 border text-start"><?= htmlspecialchars($perfil['id']) ?></td>
					<td class="p-2 border text-start"><?= htmlspecialchars($perfil['nombre']) ?></td>
					<td class="p-2 border text-start"><?= htmlspecialchars($perfil['descripcion']) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Botón de Asignar -->
	<div class="text-center mt-4">
		<button id="asignarBtn" class="btn btn-primary">
			Asignar Perfiles
		</button>
	</div>
</div>

<!-- Script para manejar selección -->
<!-- <script>
	document.addEventListener('DOMContentLoaded', function () {
			let selectedOperador = null;
			let selectedPerfiles = new Set();

			// Función para obtener los perfiles del operador seleccionado
			function obtenerPerfilesPorOperador(operadorId) {
					fetch('/trackpoint/public/api.php?accion=obtener_perfiles_por_operador&id=' + operadorId)
							.then(response => response.json())
							.then(data => {
									if (data.error) {
											console.error('Error al obtener perfiles:', data.error);
											return;
									}
									// Pinta las filas correspondientes a los perfiles del operador
									pintarPerfilesSeleccionados(data.perfiles);
							})
							.catch(error => {
									console.error('Error al hacer la petición AJAX:', error);
							});
			}

			// Función para pintar los perfiles seleccionados
			function pintarPerfilesSeleccionados(perfiles) {
					// Limpiar las filas de perfil seleccionadas
					document.querySelectorAll('#perfilesTable tr').forEach(row => {
							row.classList.remove('table-active');
					});

					// Pintar las filas correspondientes a los perfiles del operador
					document.querySelectorAll('#perfilesTable tr').forEach(row => {
							const perfilId = row.getAttribute('data-perfil-id');
							if (perfilId && perfiles.includes(parseInt(perfilId))) {
									row.classList.add('table-active');
							}
					});
			}

			// Seleccionar operador
			document.querySelectorAll('#operadoresTable tr').forEach(row => {
					row.addEventListener('click', function () {
							const operadorId = this.getAttribute('data-operador-id');
							if (selectedOperador !== operadorId) {
									selectedOperador = operadorId;

									// Limpiar selección previa de perfiles
									selectedPerfiles.clear();

									// Obtener los perfiles del operador seleccionado
									obtenerPerfilesPorOperador(operadorId);

									// Actualizar la clase activa en la tabla de operadores
									document.querySelectorAll('#operadoresTable tr').forEach(r => {
											r.classList.remove('table-active');
									});
									this.classList.add('table-active');
							}
					});
			});

			// Selección de perfiles
			document.querySelectorAll('#perfilesTable tr').forEach(row => {
					row.addEventListener('click', function () {
							const perfilId = this.getAttribute('data-perfil-id');
							if (perfilId) {
									// Agregar o quitar el perfil de la selección
									if (selectedPerfiles.has(parseInt(perfilId))) {
											selectedPerfiles.delete(parseInt(perfilId));
											this.classList.remove('table-active');
									} else {
											selectedPerfiles.add(parseInt(perfilId));
											this.classList.add('table-active');
									}
							}
					});
			});

			// Guardar los cambios
			document.getElementById('guardarCambios').addEventListener('click', function () {
					if (selectedOperador) {
						fetch('/trackpoint/public/api.php?accion=guardar_perfiles_por_operador', {
    					method: 'POST',
    					body: formData
						})
							.then(response => response.json())
							.then(data => {
									if (data.success) {
											alert('Perfiles actualizados con éxito.');
									} else {
											console.error('Error al asignar perfiles:', data.error);
									}
							})
							.catch(error => {
									console.error('Error al hacer la petición AJAX para guardar cambios:', error);
							});
					} else {
							alert('Por favor seleccione un operador.');
					}
			});
	});
</script> -->
