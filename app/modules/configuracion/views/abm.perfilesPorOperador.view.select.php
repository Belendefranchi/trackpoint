<?php
require_once __DIR__ . '/../controllers/abm.perfilesPorOperador.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<script>
  const subtitulo = 'Perfiles por Operador';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4 table-responsive">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2">Perfiles por Operador</h2>
										<!-- Tabla de Operadores -->
										<form method="GET" id="formOperador" action="/trackpoint/public/index.php?route=/configuracion/ABMs/operadores">
											<label for="operador_id">Seleccione un Operador:</label>
											<select name="operador_id" id="operador_id" onchange="this.form.submit()">
												<option value="">-- Seleccionar --</option>
												<?php foreach ($operadores as $operador): ?>
													<option value="<?= $operador['operador_id'] ?>" <?= $operadorId == $operador['operador_id'] ? 'selected' : '' ?>>
															<?= htmlspecialchars($operador['username']) ?>
													</option>
												<?php endforeach; ?>
											</select>
										</form>
									</div>
								</td>
							</tr>
							<tr>

	<?php if ($operadorId): ?>
    <form method="POST">
      <input type="hidden" name="operador_id" value="<?= $operadorId ?>">
			<table class="table">
				<thead>
					<tr>
						<th>Perfil</th>
						<th>Asignado</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($perfiles as $perfil): ?>
						<tr>
							<td><?= htmlspecialchars($perfil['nombre']) ?></td>
							<td>
								<input
									type="checkbox"
									name="perfiles[]"
									value="<?= $perfil['id'] ?>"
									<?= in_array($perfil['id'], array_column($perfilesAsignados, 'perfil_id')) ? 'checked' : '' ?>
								>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
	<?php endif; ?>
</div>
