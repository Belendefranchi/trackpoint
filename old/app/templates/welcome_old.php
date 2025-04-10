<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />
  <title>Control de Producción - Industria Porcina</title>
  <script src='https://cdn.tailwindcss.com'></script>
  <script>
    function toggleSubmenu(id) {
      const submenu = document.getElementById(id);
      submenu.classList.toggle('hidden');
    }
  </script>
</head>
<body class='bg-gray-100 h-screen overflow-hidden'>
  <div class='flex h-full'>
    <!-- Sidebar -->
    <aside class='w-64 bg-white shadow-lg overflow-y-auto'>
      <div class='p-4 border-b'>
        <h1 class='text-xl font-bold'>Módulos</h1>
      </div>

      <nav class='px-4 py-2'>
        <!-- Ciclo I -->
        <div class='mt-4'>
          <button onclick='toggleSubmenu("ciclo1")' class='w-full text-left flex items-center justify-between py-2 hover:bg-gray-200'>
            <span>Ciclo I</span>
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
            <span>Ciclo II</span>
            <span>&#x25BC;</span>
          </button>
          <div id='ciclo2' class='hidden pl-4'>
            <ul class='space-y-2'>
              <li><a href='?ciclo=cicloII&module=recepcionMP&page=form' class='block hover:underline'>Recepción de Materia Prima</a></li>
              <li><a href='?ciclo=cicloII&module=depositos&page=form' class='block hover:underline'>Depósitos</a></li>
              <li><a href='#' class='block text-gray-400 cursor-not-allowed'>Cuarteo</a></li>
              <li><a href='#' class='block text-gray-400 cursor-not-allowed'>Desposte</a></li>
              <li><a href='#' class='block text-gray-400 cursor-not-allowed'>Expedición</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </aside>

    <!-- Main content -->
    <div class='flex-1 flex flex-col'>
      <!-- Navbar -->
      <header class='bg-white shadow-md p-4 flex justify-between items-center'>
        <input type='text' placeholder='Buscar...' class='border rounded p-2 w-1/3' />
        <button class='bg-blue-600 text-white px-4 py-2 rounded'>Cuenta</button>
      </header>

      <!-- Module content -->
      <main class="flex-1 overflow-y-auto p-6" id="content">
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
