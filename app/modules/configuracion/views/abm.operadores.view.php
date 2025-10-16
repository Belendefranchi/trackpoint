<?php
require_once __DIR__ . '/../controllers/abm.operadores.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Operadores';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<div class="d-flex justify-content-between align-items-center">
						<h2 class="text-primary">Operadores</h2>
						<a href="#" class="btn btn-sm btn-primary"
							data-bs-toggle="modal" 
							data-bs-target="#modalCrearOperador">
							<i class="bi-plus-circle me-2"></i>Nuevo Operador
						</a>
					</div>
					<table id="miTabla" class="display" style="width:100%">
						<thead class="table-primary">
							<tr class="text-light">
								<td class="border text-center">ID</td>
								<td class="border">Operador</td>
								<td class="border">Nombre y Apellido</td>
								<td class="border">Email</td>
								<td class="border">Rol</td>
								<td class="border">Fecha de creación</td>
								<td class="border">Creado por</td>
								<td class="border">Fecha de edición</td>
								<td class="border">Editado por</td>
								<td class="border">Activo</td>
								<td class="border text-center no-export" style="max-width: 150px;">Acciones</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($operadores as $operador): ?>
								<tr class="text-start">
									<td class="border text-primary text-center"><?= htmlspecialchars($operador['operador_id']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($operador['username']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($operador['email']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($operador['rol']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($operador['creado_en']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($operador['creado_por']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($operador['editado_en']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($operador['editado_por']) ?></td>
									<td class="border text-primary"><?= $operador['activo'] == 1 ? 'Si' : 'No' ?></td>
									<td class="border text-primary text-center">
										<?php if ($operador['username'] === superadmin): ?>
										<div class="d-flex no-wrap">
											<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap">
												<i class="bi bi-pencil me-2"></i>Editar
											</a>
											<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap">
												<i class="bi bi-trash me-2"></i>Eliminar
											</a>
										</div>
										<?php else: ?>
										<div class="d-flex no-wrap">
											<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
												data-bs-toggle="modal" 
												data-bs-target="#modalEditarOperador"
												data-id="<?= htmlspecialchars($operador['operador_id']) ?>"
												data-username="<?= htmlspecialchars($operador['username']) ?>"
												data-nombre="<?= htmlspecialchars($operador['nombre_completo']) ?>"
												data-email="<?= htmlspecialchars($operador['email']) ?>"
												data-rol="<?= htmlspecialchars($operador['rol']) ?>"
												data-activo="<?= htmlspecialchars($operador['activo']) ?>">
												<i class="bi bi-pencil me-2"></i>Editar
											</a>
											<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
												data-bs-toggle="modal"
												data-bs-target="#modalEliminarOperador"
												data-id="<?= htmlspecialchars($operador['operador_id']) ?>"
												data-username="<?= htmlspecialchars($operador['username']) ?>">
												<i class="bi bi-trash me-2"></i>Eliminar
											</a>
										</div>
										<?php endif ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<!-- Modal de creación -->
					<div class="modal fade m-5" id="modalCrearOperador" tabindex="-1" aria-labelledby="modalCrearOperadorLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formCrearOperador" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalCrearOperadorLabel">Nuevo operador</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">

										<div class="mb-3">
											<div id="mensaje-error-crear" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
												<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<label for="crearUsernameOperador" class="form-label text-primary">Operador</label>
											<input type="text" class="form-control" name="username" id="crearUsernameOperador">
										</div>

										<div class="mb-3">
											<label for="crearNombreOperador" class="form-label text-primary">Nombre y Apellido</label>
											<input type="text" class="form-control" name="nombre_completo" id="crearNombreOperador">
										</div>

										<div class="mb-3">
											<label for="crearEmailOperador" class="form-label text-primary">Email</label>
											<input type="email" class="form-control" name="email" id="crearEmailOperador">
										</div>

										<div class="mb-3">
											<label for="crearPasswordOperador" class="form-label text-primary">Contraseña</label>
											<input type="password" class="form-control" name="password" id="crearPasswordOperador">
										</div>

										<div class="mb-3">
											<label for="crearRolOperador" class="form-label text-primary">Rol</label>
											<select class="form-select" name="rol" id="crearRolOperador">
												<option value="admin">Administrador</option>
												<option value="operador">Operador</option>
											</select>
										</div>

									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="crear_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<!-- Modal de edición -->
					<div class="modal fade m-5" id="modalEditarOperador" tabindex="-1" aria-labelledby="modalEditarOperadorLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEditarOperador" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEditarOperadorLabel">Editar operador</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="operador_id" id="editarOperadorId">

										<div class="mb-3">
											<div id="mensaje-error-editar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<label for="editarUsernameOperador" class="form-label text-primary">Operador</label>
											<input type="text" class="form-control" name="username" id="editarUsernameOperador">
										</div>

										<div class="mb-3">
											<label for="editarNombreOperador" class="form-label text-primary">Nombre y Apellido</label>
											<input type="text" class="form-control" name="nombre_completo" id="editarNombreOperador">
										</div>

										<div class="mb-3">
											<label for="editarEmailOperador" class="form-label text-primary">Email</label>
											<input type="email" class="form-control" name="email" id="editarEmailOperador">
										</div>

										<div class="mb-3">
											<label for="editarRolOperador" class="form-label text-primary">Rol</label>
											<select class="form-select" name="rol" id="editarRolOperador">
												<option value="admin">Administrador</option>
												<option value="operador">Operador</option>
											</select>
										</div>

										<div class="mb-3">
											<label for="editarActivoOperador" class="form-label text-primary">Activo</label>
											<select class="form-select" name="activo" id="editarActivoOperador">
												<option value="1">Sí</option>
												<option value="0">No</option>
											</select>
										</div>
									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<!-- Modal de eliminación -->
					<div class="modal fade m-5" id="modalEliminarOperador" tabindex="-1" aria-labelledby="modalEliminarOperadorLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEliminarOperador" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&eliminar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEliminarOperadorLabel">Eliminar operador</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="operador_id" id="eliminarOperadorId">
										<input type="hidden" name="username" id="eliminarUsernameOperador">

										<div class="mb-3">
											<div id="mensaje-error-eliminar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
												</div>
										</div>

										<div class="mb-3">
											<p>¿Está seguro que desea eliminar el perfil?</p>
											<p>Esta acción no se puede deshacer.</p>
										</div>
									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-danger m-2" name="eliminar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Eliminar</button>
										<button type="button" class="btn btn-sm btn-secondary m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
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
  <script src="/trackpoint/public/assets/js/datatables.js"></script>
  <script src="/trackpoint/public/assets/js/menu_configuracion/menu.configuracion.js"></script>
  <script src="/trackpoint/public/assets/js/menu_configuracion/abm.operadores.modales.js"></script>

</body>
</html>