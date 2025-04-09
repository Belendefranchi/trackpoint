<?php // views/modules/depositos/views/form.view.php ?>
<div class="flex gap-6">
  <form method="post" action="?module=depositos&page=form" class="w-1/2 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Gestión de Depósitos</h2>

    <div class="mb-4">
      <label for="ubicacion" class="block font-medium">Ubicación del Producto:</label>
      <input type="text" id="ubicacion" name="ubicacion" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="condiciones" class="block font-medium">Condiciones de Almacenamiento:</label>
      <input type="text" id="condiciones" name="condiciones" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="rotacion" class="block font-medium">Rotación de Stock:</label>
      <input type="text" id="rotacion" name="rotacion" class="w-full border rounded p-2" required />
    </div>

    <div class="mb-4">
      <label for="inventario" class="block font-medium">Control de Inventario:</label>
      <textarea id="inventario" name="inventario" class="w-full border rounded p-2" rows="3" required></textarea>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
  </form>

  <!-- Panel derecho de registros -->
  <aside class="w-1/2 bg-white p-6 rounded shadow overflow-y-auto max-h-[80vh]">
    <h2 class="text-xl font-semibold mb-4">Registros Ingresados</h2>
    <?php if (!empty($registros)): ?>
      <ul class="space-y-4">
        <?php foreach ($registros as $registro): ?>
          <li class="p-4 bg-gray-100 rounded shadow">
            <p><strong>Ubicación:</strong> <?= htmlspecialchars($registro['ubicacion']) ?></p>
            <p><strong>Condiciones:</strong> <?= htmlspecialchars($registro['condiciones']) ?></p>
            <p><strong>Rotación:</strong> <?= htmlspecialchars($registro['rotacion']) ?></p>
            <p><strong>Inventario:</strong> <?= htmlspecialchars($registro['inventario']) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="text-gray-500">No hay registros aún.</p>
    <?php endif; ?>
  </aside>
</div>