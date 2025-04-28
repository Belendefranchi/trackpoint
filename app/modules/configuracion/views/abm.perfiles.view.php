<?php
require_once __DIR__ . '/../controllers/abm.perfiles.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4">
	<h2 class="m-4">Perfiles</h2>
	<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&crear" class="btn btn-primary btn-sm fw-bold hover:underline ms-4"><i class="bi bi-plus-circle me-2"></i>Nuevo perfil</a>
	<?php if (isset($_GET['crear'])): ?>
	<?php if (isset($message)): ?>
		<div class="alert alert-danger rounded m-4" role="alert">
			<strong class="font-bold">Error: </strong>
			<span class="block sm:inline"><?= htmlspecialchars($message) ?></span>
		</div>
	<?php endif; ?>

	<!-- Modo creación -->
	<table class="m-4">
		<thead class="table-primary">
			<tr class="text-center text-light">
				<th class="p-2 border">ID</th>
				<th class="p-2 border">Perfil</th>
				<th class="p-2 border">Descripción</th>
				<th class="p-2 border">Acciones</th>
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
	<table class="m-4">
		<thead class="table-primary">
			<tr class="text-center text-light">
				<th class="p-2 border">ID</th>
				<th class="p-2 border">Perfil</th>
				<th class="p-2 border">Descripción</th>
				<th class="p-2 border">Fecha de creación</th>
				<th class="p-2 border">Fecha de actualización</th>
				<th class="p-2 border">Activo</th>
				<th class="p-2 border">Acciones</th>
			</tr>
	</thead>
	<tbody>
		<?php foreach ($perfiles as $perfil): ?>
			<?php if (isset($_GET['editar']) && $_GET['editar'] == $perfil['id']): ?>
				<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&editar=<?= $perfil['id'] ?>">
					<tr id="fila<?= $perfil['id'] ?>" class="text-center border-t bg-gray-100">
						<td class="p-2 border">
							<?= $perfil['id'] ?>
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
							<?= $perfil['actualizado_en'] ?>
						</td>
						<td class="p-2 border">
							<select name="activo" required>
								<option value="1" <?= $perfil['activo'] === '1' ? 'selected' : '' ?>>Sí</option>
								<option value="0" <?= $perfil['activo'] === '0' ? 'selected' : '' ?>>No</option>
							</select>
						</td>
						<td class="p-2 border">
							<input type="hidden" name="id" value="<?= $perfil['id'] ?>">
							<button type="submit" name="editar" class="btn btn-sm btn-success me-1">
								<i class="bi bi-check-circle m-1"></i>
							</button>
							<a href="index.php?route=/configuracion/ABMs/perfiles#fila<?= $perfil['id'] //si hay muchas filas, al cancelar vuelve a la fila donde estaba?>" class="btn btn-sm btn-danger me-1">
								<i class="bi bi-x-circle m-1"></i>
							</a>
						</td>
					</tr>
				</form>
				<?php else: ?>
					<!-- Modo visual  -->
					<tr class="text-center border-t">
						<td class="p-2 border"><?= htmlspecialchars($perfil['id']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['nombre']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['descripcion']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['creado_en']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($perfil['actualizado_en']) ?></td>
						<td class="p-2 border"><?= $perfil['activo'] == 1 ? 'Si' : 'No' ?></td>
						<td class="p-2 border">
								<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&eliminar=<?= $perfil['id'] ?>">
									<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&editar=<?= $perfil['id'] ?>" class="btn btn-sm btn-warning me-1">
										<i class="bi bi-pencil me-2"></i>Editar
									</a>
									<input type="hidden" name="id" value="<?= $perfil['id'] ?>">
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
