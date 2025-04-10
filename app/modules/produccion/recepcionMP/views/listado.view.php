<?php // views/modules/recepcion/views/listado.view.php ?>
<div class="bg-white p-6 rounded shadow overflow-y-auto max-h-[80vh]">
  <h2 class="text-2xl font-semibold mb-4">Listado de Registros - Recepción de MP</h2>
  <?php if (!empty($registros)): ?>
    <ul class="space-y-4">
      <?php foreach ($registros as $registro): ?>
        <li class="p-4 bg-gray-100 rounded shadow">
          <p><strong>Clasificación:</strong> <?= htmlspecialchars($registro['clasificacion']) ?></p>
          <p><strong>Peso:</strong> <?= htmlspecialchars($registro['peso']) ?> kg</p>
          <p><strong>Tropa:</strong> <?= htmlspecialchars($registro['tropa']) ?></p>
          <p><strong>Origen:</strong> <?= htmlspecialchars($registro['origen']) ?></p>
          <p><strong>Transporte:</strong> <?= htmlspecialchars($registro['transporte']) ?></p>
          <p><strong>Remito:</strong> <?= htmlspecialchars($registro['remito']) ?></p>
          <p><strong>Certificado Sanitario:</strong> <?= htmlspecialchars($registro['certificado']) ?></p>
          <p><strong>Info Legal:</strong> <?= nl2br(htmlspecialchars($registro['info_legal'])) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-gray-500">No hay registros aún.</p>
  <?php endif; ?>
</div>
