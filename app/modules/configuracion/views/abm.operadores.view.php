<?php
require_once __DIR__ . '/../controllers/abm.operadores.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<div class="bg-white rounded-2xl shadow-lg mt-2 p-4">
	<h2 class="text-xl font-bold text-[#22265D] m-4">Operadores</h2>
	<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear" class="btn btn-primary btn-sm fw-bold hover:underline ms-4"><i class="bi bi-plus-circle me-2"></i>Nuevo operador</a>
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
					<th class="p-2 border">Usuario</th>
					<th class="p-2 border">Contraseña</th>
					<th class="p-2 border">Nombre</th>
					<th class="p-2 border">Email</th>
					<th class="p-2 border">Rol</th>
					<th class="p-2 border">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear">
					<tr class="text-center border-t bg-gray-100">
						<td class="p-1 border">#</td>
						<td class="p-1 border">
							<input type="text" name="username" value="" required class="m-1">
						</td>
						<td class="p-1 border">
							<input type="password" name="password" value="" required class="m-1">
						</td>
						<td class="p-1 border">
							<input type="text" name="nombre_completo" value="" required class="m-1">
						</td>
						<td class="p-1 border">
							<input type="email" name="email" value="" required class="m-1">
						</td>
						<td class="p-1 border">
							<select name="rol" required class="">
								<?php foreach (roles as $valor => $nombre): ?>
									<option value="<?= $valor ?>" <?= $valor ? 'selected' : '' ?>>
										<?= $nombre ?>
									</option>
								<?php endforeach; ?>
							</select>
						</td>
						<td class="p-1 border">
							<button type="submit" name="crear" class="btn btn-sm btn-success me-1">
								<i class="bi bi-check-circle m-1"></i>
							</button>
							<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores" class="btn btn-sm btn-danger me-1">
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
				<th class="p-2 border">Usuario</th>
				<th class="p-2 border">Contraseña</th>
				<th class="p-2 border">Nombre</th>
				<th class="p-2 border">Email</th>
				<th class="p-2 border">Rol</th>
				<th class="p-2 border">Fecha de creación</th>
				<th class="p-2 border">Activo</th>
				<th class="p-2 border">Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($operadores as $operador): ?>
				<?php if (isset($_GET['editar']) && $_GET['editar'] == $operador['id']): ?>
					<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar=<?= $operador['id'] ?>">
						<tr id="fila<?= $operador['id'] ?>" class="text-center border-t bg-gray-100">
							<td class="p-2 border">
								<?= $operador['id'] ?>
							</td>
							<td class="p-2 border">
								<?= $operador['username'] ?>
							</td>
							<td class="p-2 border">
								***
							</td>
							<td class="p-2 border">
								<input type="text" name="nombre_completo" value="<?= htmlspecialchars($operador['nombre_completo']) ?>" required>
							</td>
							<td class="p-2 border">
								<input type="email" name="email" value="<?= htmlspecialchars($operador['email']) ?>" required>
							</td>
							<td class="p-2 border">
								<select name="rol" required>
									<?php foreach (roles as $valor => $nombre): ?>
										<option value="<?= $valor ?>" <?= $operador['rol'] === $valor ? 'selected' : '' ?>>
											<?= $nombre ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>
							<td class="p-2 border">
								<?= $operador['creado_en'] ?>
							</td>
							<td class="p-2 border">
								<select name="activo" required>
									<option value="1" <?= $operador['activo'] === '1' ? 'selected' : '' ?>>Sí</option>
									<option value="0" <?= $operador['activo'] === '0' ? 'selected' : '' ?>>No</option>
								</select>
							</td>
							<td class="p-2 border">
								<input type="hidden" name="id" value="<?= $operador['id'] ?>">
								<button type="submit" name="editar" class="btn btn-sm btn-success me-1">
									<i class="bi bi-check-circle m-1"></i>
								</button>
								<a href="index.php?route=/configuracion/ABMs/operadores#fila<?= $operador['id'] //si hay muchas filas, al cancelar vuelve a la fila donde estaba?>" class="btn btn-sm btn-danger me-1">
									<i class="bi bi-x-circle m-1"></i>
								</a>
							</td>
						</tr>
					</form>
				<?php else: ?>
					<!-- Modo visual  -->
					<tr class="text-center border-t">
						<td class="p-2 border"><?= htmlspecialchars($operador['id']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($operador['username']) ?></td>
						<td class="p-2 border">***</td>
						<td class="p-2 border"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($operador['email']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($operador['rol']) ?></td>
						<td class="p-2 border"><?= htmlspecialchars($operador['creado_en']) ?></td>
						<td class="p-2 border"><?= $operador['activo'] == 1 ? 'Si' : 'No' ?></td>
						<td class="p-2 border">
							<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&eliminar=<?= $operador['id'] ?>">
								<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar=<?= $operador['id'] ?>" class="btn btn-sm btn-warning me-1">
									<i class="bi bi-pencil me-2"></i>Editar
								</a>
								<input type="hidden" name="id" value="<?= $operador['id'] ?>">
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
