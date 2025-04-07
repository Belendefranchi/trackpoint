<?php // views/modules/depositos/views/listado.view.php ?>

<div class="bg-white p-6 rounded shadow overflow-y-auto">
  <h2 class="text-2xl font-semibold mb-4">Listado de Stock en Depósitos</h2>

  <?php if (!empty($registros)): ?>
    <table class="min-w-full table-auto border border-gray-200">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border">Producto</th>
          <th class="px-4 py-2 border">Cantidad</th>
          <th class="px-4 py-2 border">Ubicación</th>
          <th class="px-4 py-2 border">Condición</th>
          <th class="px-4 py-2 border">Fecha de Ingreso</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($registros as $registro): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 border"><?= htmlspecialchars($registro['producto']) ?></td>
            <td class="px-4 py-2 border"><?= htmlspecialchars($registro['cantidad']) ?></td>
            <td class="px-4 py-2 border"><?= htmlspecialchars($registro['ubicacion']) ?></td>
            <td class="px-4 py-2 border"><?= htmlspecialchars($registro['condicion']) ?></td>
            <td class="px-4 py-2 border"><?= htmlspecialchars($registro['fecha_ingreso']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-gray-500">No hay productos en stock actualmente.</p>
  <?php endif; ?>
</div>
