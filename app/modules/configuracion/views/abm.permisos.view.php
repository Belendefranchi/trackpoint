<?php
require_once __DIR__ . '/../controllers/abm.permisos.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4">
	<div class="d-flex justify-content-between align-items-center pe-4">
		<h2 class="m-4">Permisos</h2>
		<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&crear" class="btn btn-primary btn-sm ms-4"><i class="bi bi-plus-circle me-2"></i>Nuevo permiso</a>
	</div>
	<?php if (isset($_GET['crear'])): ?>
	<?php if (isset($message)): ?>
		<div class="alert alert-danger rounded m-4" role="alert">
			<strong>Error: </strong>
			<span class="block sm:inline"><?= htmlspecialchars($message) ?></span>
		</div>
	<?php endif; ?>

	<!-- Modo creación -->
	<table class="m-2">
		<thead class="table-primary">
			<tr class="text-center text-light">
				<td class="p-2 border">ID</td>
				<td class="p-2 border">Permiso</td>
				<td class="p-2 border">Descripción</td>
				<td class="p-2 border">Pantalla</td>
				<td class="p-2 border">Acciones</td>
			</tr>
		</thead>
		<tbody>
			<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&crear">
				<tr class="text-center border-t bg-gray-100">
					<td class="p-1 border">#</td>
					<td class="p-1 border">
						<input type="text" name="nombre" value="" required class="m-1">
					</td>
					<td class="p-1 border">
						<input type="text" name="descripcion" value="" required class="m-1">
					</td>
					<td class="p-1 border">
						<input type="text" name="pantalla" value="" required class="m-1">
					</td>
					<td class="p-1 border">
						<button type="submit" name="crear" class="btn btn-sm btn-success me-1">
							<i class="bi bi-check-circle m-1"></i>
						</button>
						<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos" class="btn btn-sm btn-danger me-1">
							<i class="bi bi-x-circle m-1"></i>
						</a>
					</td>
				</tr>
			</form>
		</tbody>
	</table>
	<?php endif; ?>
	<!-- Modo edición -->
	<table class="m-2">
		<thead class="table-primary">
			<tr class="text-center text-light">
				<td class="p-2 border">ID</td>
				<td class="p-2 border">Permiso</td>
				<td class="p-2 border">Descripción</td>
				<td class="p-2 border">Pantalla</td>
				<td class="p-2 border">Fecha de creación</td>
				<td class="p-2 border">Creado por</td>
				<td class="p-2 border">Fecha de edición</td>
				<td class="p-2 border">Editado por</td>
				<td class="p-2 border">Acciones</td>
			</tr>
		</thead>
	<tbody>
		<?php foreach ($permisos as $permiso): ?>
			<?php if (isset($_GET['editar']) && $_GET['editar'] == $permiso['permiso_id']): ?>
				<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&editar=<?= $permiso['permiso_id'] ?>">
					<tr id="fila<?= $permiso['permiso_id'] ?>" class="text-center border-t bg-gray-100">
						<td class="p-2 border">
							<?= $permiso['permiso_id'] ?>
						</td>
						<td class="p-2 border">
							<input type="text" name="nombre" value="<?= htmlspecialchars($permiso['nombre']) ?>" required class="m-1">
						</td>
						<td class="p-2 border">
							<input type="text" name="descripcion" value="<?= htmlspecialchars($permiso['descripcion']) ?>" required class="m-1">
						</td>
						<td class="p-2 border">
							<input type="text" name="pantalla" value="<?= htmlspecialchars($permiso['pantalla']) ?>" required class="m-1">
						</td>
						<td class="p-2 border">
							<?= $permiso['creado_en'] ?>
						</td>
						<td class="p-2 border">
							<?= $permiso['creado_por'] ?>
						</td>
						<td class="p-2 border">
							<?= $permiso['editado_en'] ?>
						</td>
						<td class="p-2 border">
							<?= $permiso['editado_por'] ?>
						</td>
						<td class="p-2 border">
							<input type="hidden" name="permiso_id" value="<?= $permiso['permiso_id'] ?>">
							<button type="submit" name="editar" class="btn btn-sm btn-success me-1">
								<i class="bi bi-check-circle m-1"></i>
							</button>
							<a href="index.php?route=/configuracion/ABMs/permisos#fila<?= $permiso['permiso_id'] //si hay muchas filas, al cancelar vuelve a la fila donde estaba?>" class="btn btn-sm btn-danger me-1">
								<i class="bi bi-x-circle m-1"></i>
							</a>
						</td>
					</tr>
				</form>
				<?php else: ?>
					<!-- Modo visual  -->
					<tr class="text-center border-t">
						<td class="p-2 border"><?= htmlspecialchars($permiso['permiso_id']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['nombre']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['descripcion']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['pantalla']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['creado_en']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['creado_por']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['editado_en']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['editado_por']) ?></td>
						<td class="p-2 border">
								<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&eliminar=<?= $permiso['permiso_id'] ?>">
									<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&editar=<?= $permiso['permiso_id'] ?>" class="btn btn-sm btn-warning me-1">
										<i class="bi bi-pencil me-2"></i>Editar
									</a>
									<input type="hidden" name="permiso_id" value="<?= $permiso['permiso_id'] ?>">
									<button type="submit" name="eliminar" class="btn btn-sm btn-danger">
										<i class="bi bi-trash me-2"></i>Eliminar
									</button>
								</form>
							</td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
