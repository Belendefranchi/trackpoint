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
						<h2 class="ms-2">Perfiles</h2>
						<a href="#" class="btn btn-sm btn-primary"
							data-bs-toggle="modal" 
							data-bs-target="#modalCrear" 
							data-nombre=""
							data-descripcion="">
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
												data-bs-target="#modalEditar" 
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
												data-bs-target="#modalEliminar"
												data-id="<?= $operador['operador_id'] ?>">
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
	<?php
		if (isset($_SESSION['message'])) {
			$message = $_SESSION['message'];
			unset($_SESSION['message']); // Limpiamos para que no persista
		}
	?>

	<!-- Modal de creación -->
	<div class="modal fade m-5" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear">
				<div class="modal-content m-5">
					<div class="modal-header table-primary text-white">
						<h5 class="modal-title" id="modalCrearLabel">Nuevo operador</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="operador_id" id="crearOperadorId">
						
						<div class="mb-3">
							<?php if (isset($message)): ?>
								<div class="alert alert-danger rounded m-2" role="alert">
									<strong>Error: </strong>
									<span class="block sm:inline"><?= htmlspecialchars($message) ?></span>
								</div>
							<?php endif; ?>
						</div>
					
						<div class="mb-3">
							<label for="crearNombre" class="form-label">Nombre Completo</label>
							<input type="text" class="form-control" name="nombre" id="crearNombre">
						</div>

						<div class="mb-3">
							<label for="crearUsuario" class="form-label">Usuario</label>
							<input type="text" class="form-control" name="usuario" id="crearUsuario">
						</div>

						<div class="mb-3">
							<label for="crearEmail" class="form-label">Email</label>
							<input type="text" class="form-control" name="email" id="crearEmail">
					</div>
					
						<div class="mb-3">
							<label for="crearRol" class="form-label">Rol</label>
							<select class="form-select" name="rol" id="crearRol" required>
								<option value="">Seleccione un rol</option>
								<?php foreach ($roles as $rol): ?>
									<option value="<?= htmlspecialchars($rol['rol_id']) ?>"><?= htmlspecialchars($rol['nombre']) ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="mb-3">
							<label for="crearActivo" class="form-label 
					<div class="modal-footer d-flex justify-content-center p-2">
						<button type="submit" class="btn btn-sm btn-success m-2" name="crear_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
						<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Modal de edición -->
	<div class="modal fade m-5" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar">
				<div class="modal-content m-5">
					<div class="modal-header table-primary text-white">
						<h5 class="modal-title" id="modalEditarLabel">Editar operador</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="operador_id" id="editarOperadorId">

						<div class="mb-3">
							<label for="editarNombre" class="form-label">Nombre completo</label>
							<input type="text" class="form-control" name="nombre" id="editarNombre" required>
						</div>

						<div class="mb-3">
							<label for="editarDescripcion" class="form-label">Email</label>
							<input type="text" class="form-control" name="descripcion" id="editarDescripcion" required>
						</div>

						<div class="mb-3">
							<label for="editarActivo" class="form-label">Activo</label>
							<select class="form-select" name="activo" id="editarActivo" required>
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
	<div class="modal fade m-5" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&eliminar">
				<div class="modal-content m-5">
					<div class="modal-header table-primary text-white">
						<h5 class="modal-title" id="modalEliminarLabel">Eliminar operador</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="operador_id" id="eliminarOperadorId">
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
