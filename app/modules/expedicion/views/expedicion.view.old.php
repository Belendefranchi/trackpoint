<?php
require_once __DIR__ . '/../../../../core/middleware/auth.middleware.php';
require_once __DIR__ . '/../../../layouts/layout.view.php';
/* require_once __DIR__ . '/../controllers/expedicion.controller.php'; */

cargarVistaHead();
cargarVistaNavbarStart();
?>

<div class="col-6 d-flex justify-content-start align-items-center">
  <ul class="nav nav-tabs">
    <li class="nav-item">
     <a class="nav-link text-light" href="/trackpoint/public/ingresos">INGRESO A PLANTA</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="/trackpoint/public/produccion">PRODUCCIÓN</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="/trackpoint/public/depositos">DEPÓSITOS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="/trackpoint/public/expedicion" aria-current="page">EXPEDICIÓN</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="/trackpoint/public/reportes">REPORTES</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-light" href="/trackpoint/public/configuracion">CONFIGURACIÓN</a>
    </li>
  </ul>
</div>

<?php
cargarVistaNavbarEnd();
cargarVistaAsideStart();
?>

  <a class="nav-link text-dark fw-semibold <?= $abmsActive ?>" data-bs-toggle="collapse" href="#submenuDespachos" role="button" aria-expanded="<?= $abmsOpen ? 'true' : 'false' ?>" aria-controls="submenuDespachos">
    Despachos
  </a>
  <div class="collapse ps-3 <?= $abmsOpen ?>" id="submenuDespachos">
    <a class="nav-link <?= $activeItems['nuevo'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/configuracion/ABMs/operadores">Nuevo Despacho</a>
    <a class="nav-link <?= $activeItems['reimpresion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/expedicion/despachos/reimpresion">Reimpresión de Despachos</a>
    <a class="nav-link <?= $activeItems['eliminacion'] ? 'active-lateral' : 'text-muted' ?>" href="/trackpoint/public/expedicion/despachos/eliminacion">Eliminación de Despachos</a>
  </div>
</nav>
</aside>

<?php
cargarVistaMain();