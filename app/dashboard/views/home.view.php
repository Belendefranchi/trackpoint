<?php require_once __DIR__ . '/../../../middleware/auth.middleware.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

  <!-- Bootstrap -->
  <link href="/trackpoint/public/assets/css/bootstrap.min.css" rel="stylesheet" />
  <script src="/trackpoint/public/assets/bootstrap.min.js" defer></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="/trackpoint/public/css/style.css">
  <link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_transparente.png" type="image/x-icon">

  <?php require_once __DIR__ . '/../controllers/home.controller.php'; ?>
</head>
<body style="background-color: #D3EBF9;" class="d-flex align-items-center justify-content-center min-vh-100">
<div class="container py-5">
  <a href="/trackpoint/public/logout" class="text-decoration-none text-info d-block mb-3">Cerrar sesión</a>

  <h1 class="text-primary fw-bold mb-4">Dashboard General</h1>

  <div class="d-flex align-items-center gap-3 mb-4">
    <!-- Avatar -->
    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow" style="width: 48px; height: 48px;">
      <?= strtoupper(substr($_SESSION['nombre_completo'], 0, 1)) ?>
    </div>

    <!-- Texto bienvenida -->
    <div>
      <h2 class="h5 fw-semibold text-primary">Hola <?= htmlspecialchars($_SESSION['nombre_completo']); ?></h2>
      <p class="text-muted small">Resumen general de la producción</p>
    </div>
  </div>

  <!-- Tarjetas resumen -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <p class="text-info fw-semibold">Producción Hoy</p>
          <h3 class="fw-bold text-primary">120</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <p class="text-info fw-semibold">Lotes en Depósito</p>
          <h3 class="fw-bold text-primary">35</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <p class="text-info fw-semibold">Pendientes</p>
          <h3 class="fw-bold text-primary">8</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- Gráficos -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-primary">Producción Semanal</h5>
          <canvas id="graficoProduccion" height="200"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-primary">Ingresos por Área</h5>
          <canvas id="graficoIngresos" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
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
</body>
</html>
