<?php
require_once __DIR__ . '/../../middleware/auth.middleware.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon">
  
  <?php
    require_once __DIR__ . '/../controllers/home.controller.php';
  ?>
</head>
<body class="bg-[#D3EBF9] min-h-screen flex items-center justify-center">
<div class="p-6">
  <a href="/trackpoint/public/logout" class="block text-[#00B0E6] hover:underline">Cerrar sesión</a>

  <h1 class="text-2xl font-bold text-[#22265D] mb-6">Dashboard General</h1>

  <div class="mb-6 flex items-center gap-4">
  <!-- Avatar -->
  <div class="w-12 h-12 rounded-full bg-[#22265D] flex items-center justify-center text-white font-bold text-lg shadow">
  </div>

  <!-- Texto de bienvenida -->
  <div>
    <h2 class="text-xl font-semibold text-[#22265D]">Hola <?= htmlspecialchars($_SESSION['nombre_completo']); ?></h2>
    <p class="text-gray-600 text-sm">Resumen general de la producción</p>
  </div>
</div>

  <!-- Tarjetas resumen -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow p-4">
      <p class="text-[#00B0E6] font-semibold">Producción Hoy</p>
      <p class="text-3xl font-bold text-[#22265D]">120</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4">
      <p class="text-[#00B0E6] font-semibold">Lotes en Depósito</p>
      <p class="text-3xl font-bold text-[#22265D]">35</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4">
      <p class="text-[#00B0E6] font-semibold">Pendientes</p>
      <p class="text-3xl font-bold text-[#22265D]">8</p>
    </div>
  </div>

<!-- Gráficos -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div class="bg-white rounded-xl shadow p-4">
    <h2 class="text-md font-semibold mb-4 text-[#22265D]">Producción Semanal</h2>
    <div class="h-48 flex items-center justify-center">
    <canvas id="graficoProduccion" class="w-full h-64"></canvas>

    </div>
  </div>

  <div class="bg-white rounded-xl shadow p-4">
    <h2 class="text-md font-semibold mb-4 text-[#22265D]">Ingresos por Área</h2>
    <div class="h-48 flex items-center justify-center">
    <canvas id="graficoIngresos" class="w-full h-64"></canvas>

    </div>
  </div>
</div>



<!-- Script de Chart.js -->
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const canvasProduccion = document.getElementById('graficoProduccion');
    const canvasIngresos = document.getElementById('graficoIngresos');

    if (canvasProduccion) {
      const ctx1 = canvasProduccion.getContext('2d');
      new Chart(ctx1, {
        type: 'bar',
        data: {
          labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
          datasets: [{
            label: 'Kg procesados',
            data: [1200, 950, 1300, 1000, 1100],
            backgroundColor: '#00B0E6',
            borderRadius: 5
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'right',
              labels: {
                color: '#22265D'
              }
            }
          },
          scales: {
            y: { beginAtZero: true, ticks: { color: '#22265D' } },
            x: { ticks: { color: '#22265D' } }
          }
        }
      });
    }

    if (canvasIngresos) {
      const ctx2 = canvasIngresos.getContext('2d');
      new Chart(ctx2, {
        type: 'pie',
        data: {
          labels: ['Recepción', 'Depósitos', 'Cuarteo', 'Desposte'],
          datasets: [{
            label: 'Ingresos',
            data: [5000, 3000, 2000, 4000],
            backgroundColor: ['#00B0E6', '#22265D', '#D3EBF9', '#4FD1C5']
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'right',
              labels: {
                color: '#22265D'
              }
            }
          }
        }
      });
    }
  });
</script>

