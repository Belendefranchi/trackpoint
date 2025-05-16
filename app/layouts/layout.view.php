<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TrackPoint</title>

  <!-- Bootstrap 5 base -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/bootstrap.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/icons/font/bootstrap-icons.css" />

  <!-- DataTables con integración Bootstrap 5 -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/dataTables.bootstrap5.min.css" />

  <!-- Extensiones de DataTables integradas con Bootstrap 5 -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/buttons.bootstrap5.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/colReorder.bootstrap5.min.css" />
  
  <!-- DataTables -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="/trackpoint/public/assets/css/plugins/jquery.dataTables.colResize.css" />

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/trackpoint/public/assets/css/style.css">
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_blanco.png" type="image/x-icon" />
</head>

<body style="background-color: #f4f7fc;">
<script>
  if (localStorage.getItem('sidebar-collapsed') === 'true') {
    document.documentElement.classList.add('sidebar-collapsed');
  }
</script>

  <!-- Navbar -->
  <nav class="navbar navbar-dark shadow-custom" style="background-color: #22265D;">
    <div class="container-fluid">
      
      <div class="col-2 d-flex align-items-center justify-content-start px-3">
        <a class="navbar-brand d-flex align-items-center gap-2 text-white" href="/trackpoint/">
          <img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="Logo" width="30" height="30" />
          TrackPoint
        </a>
      </div>