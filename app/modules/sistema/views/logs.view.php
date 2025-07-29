<?php
require_once __DIR__ . '/../controllers/logs.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Logs del Sistema';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4 table-responsive">
					<div class="d-flex justify-content-between align-items-center pe-2">
						<h2 class="text-primary">Logs del Sistema</h2>
					</div>
          <table id="miTablaConCheckbox" class="display pt-2 pb-4" style="width:100%">
						<thead class="table-primary">
							<tr class="text-light">
								<td class="border">Perfil</td>
								<td class="border">Habilitado</td>
								<td class="border"><i class="bi-check-circle me-2"></i>Acciones</td>
							</tr>
						</thead>
						<tbody>
              <?php foreach ($tipos as $tipo): ?>
                <tr>
                  <td class="border text-primary"><?= htmlspecialchars($tipo['tipo']) ?></td>
                  <td class="border text-primary"><?= htmlspecialchars($tipo['habilitado']) ?></td>
                  <td class="border text-center">
                    <?php if ($tipo['habilitado']): ?>
                      <button class="btn btn-sm btn-danger" onclick="deshabilitarTipo('<?= htmlspecialchars($tipo['tipo']) ?>')">
                        <i class="bi-x-circle"></i>
                      </button>
                    <?php else: ?>
                      <button class="btn btn-sm btn-success" onclick="habilitarTipo('<?= htmlspecialchars($tipo['tipo']) ?>')">
                        <i class="bi-check-circle"></i>
                      </button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </main>
    </div>
  </div>
	
	<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

  <!-- Script DataTables y modales -->
  <script src="/trackpoint/public/assets/js/menu_sistema/menu.sistema.js"></script>
  <script src="/trackpoint/public/assets/js/menu_sistema/logs.modales.js"></script>

</body>
</html>

