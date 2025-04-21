<h1 class="display-6">
  <?= ucfirst($nav['currentModule']) ?> &raquo; <?= ucfirst($nav['currentPage']) ?>
</h1>

<?php if ($nav['currentModule'] === 'configuracion'): ?>
  <!-- Mostrar sidebar de configuración -->
<?php elseif ($nav['currentModule'] === 'produccion'): ?>
  <!-- Mostrar otro menú -->
<?php endif; ?>

