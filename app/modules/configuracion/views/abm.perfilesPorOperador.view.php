<?php
require_once __DIR__ . '/../controllers/abm.perfilesPorOperador.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<script>
  const subtitulo = 'Perfiles';
</script>

<!-- <form method="POST"> -->
				<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4 table-responsive">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2 text-primary">Perfiles por Operador</h2>
										<a href="#" class="btn btn-sm btn-primary"
											data-bs-toggle="modal" 
											data-bs-target="#modalSeleccionarOperador" 
											data-nombre=""
											data-descripcion="">
											<i class="bi-check-circle me-2"></i>Seleccionar operador
										</a>
									</div>
								</td>
							</tr>
<!-- 							<tr>
								<td class="p-2">
									<div class="d-flex align-items-center">
										<select name="operador_id" id="operador_id" class="form-select">
											<option value="">&nbsp;Seleccione un Operador&nbsp;</option>
											<?php foreach ($operadores as $operador): ?>
												<option value="<?= $operador['operador_id'] ?>" ?>
													<?= htmlspecialchars($operador['username']) ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</td>
							</tr> -->

							<tr>
								<td class="p-2">
									<!-- Tabla de Perfiles -->
									<table id="miTabla" class="display pt-2 pb-4" style="width:100%">
										<thead class="table-primary">
											<tr class="text-light">
												<th class="p-2 border"></th>
												<th class="p-2 border">ID</th>
												<th class="p-2 border">Perfil</th>
												<th class="p-2 border">Descripción</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($perfiles as $perfil): ?>
												<tr class="text-center" data-perfil-id="<?= htmlspecialchars($perfil['perfil_id']) ?>">
													<td class="p-2 border text-center">
														<input type="checkbox" class="form-check-input" id="perfil_<?= htmlspecialchars($perfil['perfil_id']) ?>" name="perfil_id[]" value="<?= htmlspecialchars($perfil['perfil_id']) ?>">
													</td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['perfil_id']) ?></td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['nombre']) ?></td>
													<td class="p-2 border"><?= htmlspecialchars($perfil['descripcion']) ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td class="p-2">
									<!-- Botón de Asignar -->
									<div class="text-center mt-4">
										<button id="asignarBtn" class="btn btn-primary">
											Asignar Perfiles
										</button>
									</div>
								</div>
							</td>
						</tr>
					</table>

					<!-- Modal de selección -->
					<div class="modal fade m-5" id="modalSeleccionarOperador" tabindex="-1" aria-labelledby="modalSeleccionarOperadorLabel" aria-hidden="true">
						<div class="modal-dialog d-flex">
							<form method="POST" id="formSeleccionarOperador" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalSeleccionarOperadorLabel">Seleccionar operador</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">

										<div class="mb-3">
											<div id="mensaje-error-seleccionar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
												<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<table id="miTabla" class="display pt-2 pb-4" style="width:100%">
												<thead class="table-primary">
													<tr class="text-light">
														<td class="p-2 border text-center"><i class="bi-check-circle me-2"></i></td>
														<td class="p-2 border">ID</td>
														<td class="p-2 border">Usuario</td>
														<td class="p-2 border">Nombre</td>
														<td class="p-2 border">Email</td>
														<td class="p-2 border">Rol</td>
													</tr>
												</thead>
												<tbody>
												<?php foreach ($operadores as $operador): ?>
														<tr class="text-start" data-operador-id="<?= htmlspecialchars($operador['operador_id']) ?>" style="cursor: pointer;">
															<td class="p-2 border text-center">
																<input type="radio" class="form-check-input" id="operador_<?= htmlspecialchars($operador['operador_id']) ?>" name="operador_id[]" value="<?= htmlspecialchars($operador['operador_id']) ?>">
															</td>
															<td class="p-2 border text-center"><?= htmlspecialchars($operador['operador_id']) ?></td>
															<td class="p-2 border"><?= htmlspecialchars($operador['username']) ?></td>
															<td class="p-2 border"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
															<td class="p-2 border"><?= htmlspecialchars($operador['email']) ?></td>
															<td class="p-2 border"><?= htmlspecialchars($operador['rol']) ?></td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>

									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="crear_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Aceptar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

			</main>
    </div>
  </div>
	
	<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

  <!-- Script DataTables y modales -->
  <script src="/trackpoint/public/assets/js/menu_configuracion/menu.configuracion.DataTables.js"></script>
  <script src="/trackpoint/public/assets/js/menu_configuracion/abm.perfilesPorOperador.modales.js"></script>

</body>
</html>

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
