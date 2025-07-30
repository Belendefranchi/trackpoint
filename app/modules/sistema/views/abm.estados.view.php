<?php
require_once __DIR__ . '/../controllers/abm.estados.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Estados';
</script>

<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4 table-responsive">
  <div class="d-flex justify-content-between align-items-center pe-2">
    <h2 class="text-primary">Estados</h2>
  </div>
  <table id="miTablaConCheckbox" class="display pt-2 pb-4" style="width:100%">
    <thead class="table-primary">
      <tr class="text-light">
        <td class="border">Código</td>
        <td class="border">Descripción</td>
        <td class="border">Habilitado</td>
        <td class="border no-export"><i class="bi-check-circle me-2"></i>Acciones</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($estados as $estado): ?>
        <tr>
          <td class="border text-primary"><?= htmlspecialchars($estado['estado']) ?></td>
          <td class="border text-primary"><?= htmlspecialchars($estado['descripcion']) ?></td>
          <td class="border text-primary"><?= $estado['habilitado'] ? 'Sí' : 'No' ?></td>
          <td class="border text-center">
            <?php if ($estado['habilitado']): ?>
              <form method="POST" class="formDeshabilitar" action="/trackpoint/public/index.php?route=/sistema/ABMs/estados&deshabilitar">
                <input type="hidden" name="estado" value="<?= htmlspecialchars($estado['estado']) ?>">
                <button type="submit" class="btn btn-sm btn-danger">
                  <i class="bi-x-circle"></i>
                </button>
              </form>
            <?php else: ?>
              <form method="POST" class="formHabilitar" action="/trackpoint/public/index.php?route=/sistema/ABMs/estados&habilitar">
                <input type="hidden" name="estado" value="<?= htmlspecialchars($estado['estado']) ?>">
                <button type="submit" class="btn btn-sm btn-success">
                  <i class="bi-check-circle"></i>
                </button>
              </form>
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

<script src="/trackpoint/public/assets/js/menu_sistema/menu.sistema.js"></script>
