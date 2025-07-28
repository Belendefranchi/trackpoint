<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/config/constants.php';


try {
    $conn = getConnection();
    $stmt = $conn->query("SELECT tipo, habilitado FROM logs_tipos_habilitados ORDER BY tipo");
    $tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error al cargar configuración: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Configuración de Logs</title>
  <link href="/public/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Configuración de tipos de log</h2>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Configuración actualizada correctamente.</div>
  <?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Ocurrió un error al actualizar.</div>
  <?php endif; ?>

  <form method="POST" action="logs.controller.php">
    <div class="form-group">
      <?php foreach ($tipos as $tipo): ?>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="tipos[]" id="chk_<?= $tipo['tipo'] ?>"
                value="<?= $tipo['tipo'] ?>" <?= $tipo['habilitado'] ? 'checked' : '' ?>>
          <label class="form-check-label" for="chk_<?= $tipo['tipo'] ?>">
            <?= htmlspecialchars($tipo['tipo']) ?>
          </label>
        </div>
      <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
  </form>
</body>
</html>
