<?php
require_once __DIR__ . '/../controllers/abm.operadores.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4">
	<table class="text-center">
		<tr>
			<td>
				<div class="d-flex justify-content-between align-items-center pe-2">
					<h2 class="ms-3">Operadores</h2>
					<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear" class="btn btn-primary btn-sm me-2"><i class="bi bi-plus-circle me-2"></i>Nuevo operador</a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="px-2">
				<?php if (isset($_GET['crear'])): ?>
				<?php if (isset($message)): ?>
					<div class="alert alert-danger rounded m-2" role="alert">
						<strong>Error: </strong>
						<span class="block sm:inline"><?= htmlspecialchars($message) ?></span>
					</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td class="p-2">
				<!-- Modo creación -->
				<table class="m-2">
					<thead class="table-primary">
						<tr class="text-light">
							<td class="p-2 border">ID</td>
							<td class="p-2 border">Usuario</td>
							<td class="p-2 border">Contraseña</td>
							<td class="p-2 border">Nombre</td>
							<td class="p-2 border">Email</td>
							<td class="p-2 border">Rol</td>
							<td class="p-2 border">Acciones</td>
						</tr>
					</thead>
					<tbody>
						<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&crear">
							<tr class="bg-gray-100">
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
				<table class="m-2">
					<thead class="table-primary">
						<tr class="text-light">
							<td class="p-2 border">ID</td>
							<td class="p-2 border">Usuario</td>
							<td class="p-2 border">Nombre</td>
							<td class="p-2 border">Email</td>
							<td class="p-2 border">Rol</td>
							<td class="p-2 border">Fecha de creación</td>
							<td class="p-2 border">Creado por</td>
							<td class="p-2 border">Fecha de edición</td>
							<td class="p-2 border">Editado por</td>
							<td class="p-2 border">Activo</td>
							<td class="p-2 border">Acciones</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($operadores as $operador): ?>
							<?php if (isset($_GET['editar']) && $_GET['editar'] == $operador['operador_id']): ?>
								<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar=<?= $operador['operador_id'] ?>">
									<tr id="fila<?= $operador['operador_id'] ?>" class="bg-gray-100">
										<td class="p-2 border">
											<?= $operador['operador_id'] ?>
										</td>
										<td class="p-2 border">
										<?= $operador['username'] ?>
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
											<?= $operador['creado_por'] ?>
										</td>
										<td class="p-2 border">
											<?= $operador['editado_en'] ?>
										</td>
										<td class="p-2 border">
											<?= $operador['editado_por'] ?>
										</td>
										<td class="p-2 border">
											<select name="activo" required>
												<option value="1" <?= $operador['activo'] === '1' ? 'selected' : '' ?>>Sí</option>
												<option value="0" <?= $operador['activo'] === '0' ? 'selected' : '' ?>>No</option>
											</select>
										</td>
										<td class="p-2 border">
											<input type="hidden" name="operador_id" value="<?= $operador['operador_id'] ?>">
											<button type="submit" name="editar" class="btn btn-sm btn-success me-1">
												<i class="bi bi-check-circle m-1"></i>
											</button>
											<a href="index.php?route=/configuracion/ABMs/operadores#fila<?= $operador['operador_id'] //si hay muchas filas, al cancelar vuelve a la fila donde estaba?>" class="btn btn-sm btn-danger me-1">
												<i class="bi bi-x-circle m-1"></i>
											</a>
										</td>
									</tr>
								</form>
							<?php else: ?>
								<!-- Modo visual  -->
								<tr>
									<td class="p-2 border text-center"><?= htmlspecialchars($operador['operador_id']) ?></td>
									<td class="p-2 border text-center"><?= htmlspecialchars($operador['username']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['email']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['rol']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['creado_en']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['creado_por']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['editado_en']) ?></td>
									<td class="p-2 border"><?= htmlspecialchars($operador['editado_por']) ?></td>
									<td class="p-2 border text-center"><?= $operador['activo'] == 1 ? 'Si' : 'No' ?></td>
									<td class="p-2 border">
										<form method="POST" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&eliminar=<?= $operador['operador_id'] ?>">
											<a href="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores&editar=<?= $operador['operador_id'] ?>" class="btn btn-sm btn-warning me-1">
												<i class="bi bi-pencil me-2"></i>Editar
											</a>
											<input type="hidden" name="operador_id" value="<?= $operador['operador_id'] ?>">
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
			</td>
		</tr>
	</table>
</div>