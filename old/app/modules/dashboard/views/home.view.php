<?php // app/modules/dashboard/views/home.view.php ?>
<div class="p-6">
  <h1 class="text-2xl font-bold text-[#22265D] mb-6">Dashboard General</h1>

  <?php
  $userName = $_SESSION['user_name'] ?? 'Usuario';
?>

  <div class="mb-6 flex items-center gap-4">
  <!-- Avatar -->
  <div class="w-12 h-12 rounded-full bg-[#22265D] flex items-center justify-center text-white font-bold text-lg shadow">
    <?= strtoupper(substr($userName, 0, 1)) ?>
  </div>

  <!-- Texto de bienvenida -->
  <div>
    <h2 class="text-xl font-semibold text-[#22265D]">Bienvenido, <?= htmlspecialchars($userName) ?> 👋</h2>
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


