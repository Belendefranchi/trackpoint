<?php
require_once __DIR__ . '/../controllers/abm.operadores.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';
?>

<script>
  const subtitulo = 'Operadores';
</script>

<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4">
	<table>
			<tr>
				<td>
					<div class="d-flex justify-content-between align-items-center pe-2">
						<h2 class="ms-2">Operadores</h2>
						<a href="#" class="btn btn-sm btn-primary"
							data-bs-toggle="modal" 
							data-bs-target="#modalCrearOperador" 
							data-nombre=""
							data-username=""
							data-password=""
							data-email=""
							data-rol="">
							<i class="bi-plus-circle me-2"></i>Nuevo Operador
						</a>
					</div>
				</td>
			</tr>
			<tr>
				<td class="p-2">
					<table id="miTabla" class="display pt-2 pb-4" style="width:100%">
						<thead class="table-primary">
							<tr class="text-light">
								<th class="p-2 border text-center">ID</th>
								<th class="p-2 border text-center">Usuario</th>
								<th class="p-2 border text-center">Nombre</th>
								<th class="p-2 border text-center">Email</th>
								<th class="p-2 border text-center">Rol</th>
								<th class="p-2 border text-center">Creado en</th>
								<th class="p-2 border text-center">Creado por</th>
								<th class="p-2 border text-center">Editado en</th>
								<th class="p-2 border text-center">Editado por</th>
								<th class="p-2 border text-center">Activo</th>
								<th class="p-2 border text-center no-export">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($operadores as $operador): ?>
								<tr class="text-start">
									<td class="p-2 border text-center"><?= htmlspecialchars($operador['operador_id']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['username']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['email']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['rol']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['creado_en']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['creado_por']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['editado_en']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['editado_por']) ?></td>
									<td class="p-2 border text-center"><?= $operador['activo'] == 1 ? 'Si' : 'No' ?></td>
									<td class="p-2 border">
										<div class="d-flex no-wrap">
											<a href="#" class="btn btn-sm btn-warning me-1 d-flex no-wrap"
												data-bs-toggle="modal" 
												data-bs-target="#modalEditarOperador" 
												data-id="<?= $operador['operador_id'] ?>"
												data-nombre="<?= htmlspecialchars($operador['nombre_completo']) ?>"
												data-username="<?= htmlspecialchars($operador['username']) ?>"
												data-descripcion="<?= htmlspecialchars($operador['email']) ?>"
												data-rol="<?= htmlspecialchars($operador['rol']) ?>"
												data-activo="<?= $operador['activo'] ?>">
												<i class="bi bi-pencil me-2"></i>Editar
											</a>
											<a href="#" class="btn btn-sm btn-danger me-1 d-flex no-wrap"
												data-bs-toggle="modal"
												data-bs-target="#modalEliminarOperador"
												data-id="<?= $operador['operador_id'] ?>"
												data-username="<?= $operador['username'] ?>">
												<i class="bi bi-trash me-2"></i>Eliminar
											</a>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</td>
			</tr>
	</table>

	<!-- Modal de creación -->
	<div class="modal fade m-5" id="modalCrearOperador" tabindex="-1" aria-labelledby="modalCrearOperadorLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear">
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
							<label for="crearNombreOperador" class="form-label">Nombre Completo</label>
							<input type="text" class="form-control" name="nombre" id="crearNombreOperador">
						</div>

						<div class="mb-3">
							<label for="crearUsuarioOperador" class="form-label">Usuario</label>
							<input type="text" class="form-control" name="usuario" id="crearUsuarioOperador">
						</div>

						<div class="mb-3">
							<label for="crearPasswordOperador" class="form-label">Contraseña</label>
							<input type="password" class="form-control" name="usuario" id="crearPasswordOperador">
						</div>

						<div class="mb-3">
							<label for="crearEmailOperador" class="form-label">Email</label>
							<input type="text" class="form-control" name="email" id="crearEmailOperador">
					</div>
					
						<div class="mb-3">
							<label for="crearRolOperador" class="form-label">Rol</label>
							<select class="form-select" name="rol" id="crearRolOperador" required>
								<option value="">Seleccione un rol</option>
								<option value="administrador">Administrador</option>
								<option value="operador">Operador</option>
							</select>
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
			<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar">
				<div class="modal-content m-5">
					<div class="modal-header table-primary text-white">
						<h5 class="modal-title" id="modalEditarOperadorLabel">Editar operador</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="operador_id" id="editarOperadorId">

						<div class="mb-3">
							<label for="editarNombreOperador" class="form-label">Nombre completo</label>
							<input type="text" class="form-control" name="nombre" id="editarNombreOperador" required>
						</div>

						<div class="mb-3">
							<label for="editarDescripcionOperador" class="form-label">Email</label>
							<input type="text" class="form-control" name="descripcion" id="editarDescripcionOperador" required>
						</div>

						<div class="mb-3">
							<label for="editarActivoOperador" class="form-label">Activo</label>
							<select class="form-select" name="activo" id="editarActivoOperador" required>
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
			<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&eliminar">
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
							<p>¿Está seguro que desea eliminar el operador?</p>
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