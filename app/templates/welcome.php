<?php /* require_once '../app/middleware/auth.middleware.php'; */ ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Control de Producción - Industria Porcina</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleSubmenu(id) {
      const submenu = document.getElementById(id);
      submenu.classList.toggle('hidden');
    }
  </script>
</head>
<body class="bg-[#D3EBF9] min-h-screen">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg p-4">
      <!-- Logo -->
      <div class="flex justify-center mb-6">
        <img src="../app/data/images/logo_fondo_trasnparente.png" alt="Logo" class="h-20" />
      </div>
      <!-- Menú -->
      <nav class="space-y-4">
        <!-- Ciclo I -->
        <div class='mt-4'>
          <button onclick='toggleSubmenu("ciclo1")' class='w-full text-left flex items-center justify-between py-2 hover:bg-gray-200'>
            <span class="text-[#22265D] font-semibold mb-2">Ciclo I</span>
            <span>&#x25BC;</span>
          </button>
          <div id='ciclo1' class='hidden pl-4'>
            <ul class='space-y-2'>
              <li><a href='#' class='block text-gray-400 cursor-not-allowed'>Recepción de Hacienda</a></li>
              <li><a href='#' class='block text-gray-400 cursor-not-allowed'>Lista de Matanza</a></li>
              <li><a href='#' class='block text-gray-400 cursor-not-allowed'>Faena</a></li>
            </ul>
          </div>
        </div>
        <!-- Ciclo II -->
        <div>
          <button onclick='toggleSubmenu("ciclo2")' class='w-full text-left flex items-center justify-between py-2 hover:bg-gray-200'>
            <span class="text-[#22265D] font-semibold mb-2">Ciclo II</span>
            <span>&#x25BC;</span>
          </button>
          <div id='ciclo2' class='hidden pl-4'>
            <ul class="space-y-2">
              <li><a href="?module=recepcionMP&page=form" class="block px-3 py-2 rounded hover:bg-[#00B0E6] hover:text-white">Recepción MP</a></li>
              <li><a href="?module=depositos&page=form" class="block px-3 py-2 rounded hover:bg-[#00B0E6] hover:text-white">Depósitos</a></li>
              <li><span class="block px-3 py-2 rounded text-gray-400 cursor-not-allowed">Cuarteo</span></li>
              <li><span class="block px-3 py-2 rounded text-gray-400 cursor-not-allowed">Desposte</span></li>
              <li><span class="block px-3 py-2 rounded text-gray-400 cursor-not-allowed">Expedición</span></li>
            </ul>
          </div>
        </div>
      </nav>
    </aside>

    <!-- Contenido principal -->
    <div class="flex-1 flex flex-col">
      <!-- Encabezado -->
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-[#22265D]">Control de Producción</h1>
        <!-- <button class="bg-[#22265D] text-white px-4 py-2 rounded hover:bg-[#00B0E6]">Cuenta</button> -->
        <a href="../app/modules/auth/logout.php" class="text-[#22265D]-500 hover:underline">Cerrar sesión</a>
      </header>

      <!-- Contenido dinámico -->
      <main class="p-6 flex-1 overflow-y-auto">
      <?php
          if ($viewPath && file_exists($viewPath)) {
              require_once $viewPath;
          } else {
              echo "<div class='text-gray-500 text-center mt-20'>
                      <h2 class='text-2xl font-bold'>Seleccione un módulo para comenzar</h2>
                    </div>";
          }
        ?>
      </main>
    </div>
  </div>

</body>
</html>
