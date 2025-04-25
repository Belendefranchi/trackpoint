<?php
require_once __DIR__ . '/../controllers/abm.permisos.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<div class="bg-white rounded-2xl shadow-lg mt-2 p-4">
	<h2 class="text-xl font-bold text-[#22265D] m-4">Permisos</h2>
	<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&crear" class="btn btn-primary btn-sm fw-bold hover:underline ms-4"><i class="bi bi-plus-circle me-2"></i>Nuevo permiso</a>
	<?php if (isset($_GET['crear'])): ?>
	<?php if (isset($message)): ?>
		<div class="alert alert-danger rounded m-4" role="alert">
			<strong class="font-bold">Error: </strong>
			<span class="block sm:inline"><?= htmlspecialchars($message) ?></span>
		</div>
	<?php endif; ?>
	<?php if (isset($successMessage)): ?>
		<div class="alert alert-info rounded m-4" role="alert">
			<strong class="font-bold">Éxito: </strong>
			<span class="block sm:inline"><?= htmlspecialchars($successMessage) ?></span>
		</div>
	<?php endif; ?>
	<!-- Modo creación -->
	<table class="m-4">
		<thead class="table-primary">
			<tr class="text-center text-light">
				<th class="p-2 border">ID</th>
				<th class="p-2 border">Permiso</th>
				<th class="p-2 border">Descripción</th>
				<th class="p-2 border">Pantalla</th>
				<th class="p-2 border">Acciones</th>
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
	<table class="m-4">
		<thead class="table-primary">
			<tr class="text-center text-light">
				<th class="p-2 border">ID</th>
				<th class="p-2 border">Permiso</th>
				<th class="p-2 border">Descripción</th>
				<th class="p-2 border">Pantalla</th>
				<th class="p-2 border">Fecha de creación</th>
				<th class="p-2 border">Acciones</th>
			</tr>
	</thead>
	<tbody>
		<?php foreach ($permisos as $permiso): ?>
			<?php if (isset($_GET['editar']) && $_GET['editar'] == $permiso['id']): ?>
				<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&editar=<?= $permiso['id'] ?>">
					<tr id="fila<?= $permiso['id'] ?>" class="text-center border-t bg-gray-100">
						<td class="p-2 border">
							<?= $permiso['id'] ?>
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
							<input type="hidden" name="id" value="<?= $permiso['id'] ?>">
							<button type="submit" name="editar" class="btn btn-sm btn-success me-1">
								<i class="bi bi-check-circle m-1"></i>
							</button>
							<a href="index.php?route=/configuracion/ABMs/permisos#fila<?= $permiso['id'] //si hay muchas filas, al cancelar vuelve a la fila donde estaba?>" class="btn btn-sm btn-danger me-1">
								<i class="bi bi-x-circle m-1"></i>
							</a>
						</td>
					</tr>
				</form>
				<?php else: ?>
					<!-- Modo visual  -->
					<tr class="text-center border-t">
						<td class="p-2 border"><?= htmlspecialchars($permiso['id']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['nombre']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['descripcion']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['pantalla']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($permiso['creado_en']) ?></td>
						<td class="p-2 border">
								<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&eliminar=<?= $permiso['id'] ?>">
									<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&editar=<?= $permiso['id'] ?>" class="btn btn-sm btn-warning me-1">
										<i class="bi bi-pencil me-2"></i>Editar
									</a>
									<input type="hidden" name="id" value="<?= $permiso['id'] ?>">
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
