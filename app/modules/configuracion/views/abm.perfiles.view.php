<?php
require_once __DIR__ . '/../controllers/abm.perfiles.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4">
	<div class="d-flex justify-content-between align-items-center pe-2">
		<h2 class="m-2">Perfiles</h2>
		<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&crear" class="btn btn-primary btn-sm ms-4"><i class="bi bi-plus-circle me-2"></i>Nuevo perfil</a>
	</div>
	<?php if (isset($_GET['crear'])): ?>
	<?php if (isset($message)): ?>
		<div class="alert alert-danger rounded m-2" role="alert">
			<strong>Error: </strong>
			<span class="block sm:inline"><?= htmlspecialchars($message) ?></span>
		</div>
	<?php endif; ?>

	<!-- Modo creación -->
	<table class="m-2">
		<thead class="table-primary">
			<tr class="text-center text-light">
				<td class="p-2 border">ID</td>
				<td class="p-2 border">Perfil</td>
				<td class="p-2 border">Descripción</td>
				<td class="p-2 border">Acciones</td>
			</tr>
		</thead>
		<tbody>
			<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&crear">
				<tr class="text-center border-t bg-gray-100">
					<td class="p-1 border">#</td>
					<td class="p-1 border">
						<input type="text" name="nombre" value="" required class="m-1">
					</td>
					<td class="p-1 border">
						<input type="text" name="descripcion" value="" required class="m-1">
					</td>
					<td class="p-1 border">
						<button type="submit" name="crear" class="btn btn-sm btn-success me-1">
							<i class="bi bi-check-circle m-1"></i>
						</button>
						<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles" class="btn btn-sm btn-danger me-1">
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
				<td class="p-2 border">Perfil</td>
				<td class="p-2 border">Descripción</td>
				<td class="p-2 border">Fecha de creación</td>
				<td class="p-2 border">Creado por</td>
				<td class="p-2 border">Fecha de edición</td>
				<td class="p-2 border">Editado por</td>
				<td class="p-2 border">Activo</td>
				<td class="p-2 border">Acciones</td>
			</tr>
	</thead>
	<tbody>
		<?php foreach ($perfiles as $perfil): ?>
			<?php if (isset($_GET['editar']) && $_GET['editar'] == $perfil['perfil_id']): ?>
				<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&editar=<?= $perfil['perfil_id'] ?>">
					<tr id="fila<?= $perfil['perfil_id'] ?>" class="text-center border-t bg-gray-100">
						<td class="p-2 border">
							<?= $perfil['perfil_id'] ?>
						</td>
						<td class="p-2 border">
							<input type="text" name="nombre" value="<?= htmlspecialchars($perfil['nombre']) ?>" required class="m-1">
						</td>
						<td class="p-2 border">
							<input type="text" name="descripcion" value="<?= htmlspecialchars($perfil['descripcion']) ?>" required class="m-1">
						</td>
						<td class="p-2 border">
							<?= $perfil['creado_en'] ?>
						</td>
						<td class="p-2 border">
							<?= $perfil['creado_por'] ?>
						</td>
						<td class="p-2 border">
							<?= $perfil['editado_en'] ?>
						</td>
						<td class="p-2 border">
							<?= $perfil['editado_por'] ?>
						</td>
						<td class="p-2 border">
							<select name="activo" required>
								<option value="1" <?= $perfil['activo'] === '1' ? 'selected' : '' ?>>Sí</option>
								<option value="0" <?= $perfil['activo'] === '0' ? 'selected' : '' ?>>No</option>
							</select>
						</td>
						<td class="p-2 border">
							<input type="hidden" name="perfil_id" value="<?= $perfil['perfil_id'] ?>">
							<button type="submit" name="editar" class="btn btn-sm btn-success me-1">
								<i class="bi bi-check-circle m-1"></i>
							</button>
							<a href="index.php?route=/configuracion/ABMs/perfiles#fila<?= $perfil['perfil_id'] //si hay muchas filas, al cancelar vuelve a la fila donde estaba?>" class="btn btn-sm btn-danger me-1">
								<i class="bi bi-x-circle m-1"></i>
							</a>
						</td>
					</tr>
				</form>
				<?php else: ?>
					<!-- Modo visual  -->
					<tr class="text-center border-t">
						<td class="p-2 border"><?= htmlspecialchars($perfil['perfil_id']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['nombre']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['descripcion']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['creado_en']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['creado_por']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['editado_en']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['editado_por']) ?></td>
						<td class="p-2 border"><?= $perfil['activo'] == 1 ? 'Si' : 'No' ?></td>
						<td class="p-2 border">
								<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&eliminar=<?= $perfil['perfil_id'] ?>">
									<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&editar=<?= $perfil['perfil_id'] ?>" class="btn btn-sm btn-warning me-1">
										<i class="bi bi-pencil me-2"></i>Editar
									</a>
									<input type="hidden" name="perfil_id" value="<?= $perfil['perfil_id'] ?>">
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
