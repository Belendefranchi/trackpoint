<?php
http_response_code(403);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>No permitido</title>
  <link href="/trackpoint/public/assets/css/plugins/bootstrap.min.css" rel="stylesheet" />
  <link href="/trackpoint/public/assets/css/style.css" rel="stylesheet" />
  <link rel="icon" href="/trackpoint/public/assets/images/favicon.ico" type="image/x-icon">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
  <div class="text-center">
    <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="No permitido" style="height: 100px;" class="mb-4 opacity-75">
    <h1 class="text-primary">No tenés permiso para acceder a esta pantalla</h1>
    <p class="text-muted">Solicita acceso al administrador del sistema.</p>
    <a onClick="window.history.go(-1);" class="btn btn-primary mt-4">Volver</a>
  </div>
</body>
</html>
