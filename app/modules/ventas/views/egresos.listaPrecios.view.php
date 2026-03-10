<?php
require_once __DIR__ . '/../controllers/egresos.listaPrecios.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';

?>

<script>
	const subtitulo = 'Lista de Precios';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<div class="d-flex justify-content-between align-items-center">
						<h2 class="text-primary">Lista de Precios</h2>
						<a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearListaPrecios">
							<i class="bi-plus-circle me-2"></i>Nueva Lista de Precios
						</a>
					</div>

					<div class="container-fluid mt-4 p-0">

						<div class="card mb-3">
							<div class="card-header bg-light d-flex align-items-center">
								<div class="">
									<ul class="nav nav-underline" id="listaTabs" role="tablist">
										<li class="nav-item" role="presentation">
											<a class="nav-link text-primary active" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen"
												type="button" role="tab" aria-current="page" href="#resumen">Resumen</a>
										</li>
										<li class="nav-item">
											<a class="nav-link text-primary" id="detalle-tab" data-bs-toggle="tab" data-bs-target="#detalle"
												type="button" role="tab" aria-current="page" href="#detalle">Detalle</a>
										</li>
									</ul>
								</div>
								<div class="ms-auto">
									<div class="text-primary">
										<strong id="listaActivo"></strong>
									</div>
								</div>
							</div>
							<div class="card-body p-2">
								<div class="tab-content p-3 border-top-0 rounded-bottom" id="listaTabsContent">

									<div class="tab-pane fade show active" id="resumen" role="tabpanel">
										<div id="resumen-lista">
											<?php include __DIR__ . "/egresos.listaPrecios.resumen.view.php"; ?>
										</div>
									</div>
									<div class="tab-pane fade show" id="detalle" role="tabpanel">
										<div id="detalle-lista">
											<?php include __DIR__ . "/egresos.listaPrecios.detalle.view.php"; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>

				<!-- Modal de creación de lista de precios -->
				<div class="modal fade" id="modalCrearListaPrecios" tabindex="-1" aria-labelledby="modalCrearListaPreciosLabel"
					aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<form method="POST" id="formCrearListaPrecios"
							action="/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&crearLista">
							<div class="modal-content m-5">
								<div class="modal-header table-primary text-white">
									<h5 class="modal-title" id="modalCrearListaPreciosLabel">Crear nueva lista de precios</h5>
									<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
								</div>
								<div class="modal-body">

									<div class="mb-3">
										<div id="mensaje-error-crear" class="alert alert-danger rounded d-none p-2" role="alert">
											<i class="bi bi-exclamation-triangle-fill me-2"></i>
											<span class="mensaje-texto"></span>
											<!-- Mensajes de error que se cargarán de forma dinámica en el modal -->
										</div>
									</div>

									<!-- Datos obligatorios -->
									<div class="card mb-3">
										<div class="card-header bg-light text-primary">
											<strong>Datos obligatorios</strong>
										</div>
										<div class="card-body">
											<div class="mb-3 align-items-center">
												<!-- Proveedor -->
												<div class="row p-2 d-flex align-items-center justify-content-center">
													<label for="crearProveedorLista" class="col-md-5 form-label text-primary">Proveedor</label>
													<div class="col-md-7 ps-0">
														<input type="text" class="form-control text-primary" id="crearProveedorLista" name="proveedor">

													</div>
												</div>
												<!-- Fecha Lista -->
												<div class="row p-2 d-flex align-items-center justify-content-center">
													<label for="crearFechaLista" class="col-md-5 form-label text-primary">Fecha</label>
													<div class="col-md-7 ps-0">
														<input type="date" class="form-control text-primary" id="crearFechaLista" name="fecha_lista">
													</div>
												</div>
												<!-- Moneda -->
												<div class="row p-2 d-flex align-items-center justify-content-center">
													<label for="crearMonedaLista" class="col-md-5 form-label text-primary">Moneda</label>
													<div class="col-md-7 ps-0">
														<select class="form-select text-primary" id="crearMonedaLista" name="moneda">
															<option value="ARS">ARS</option>
															<option value="USD">USD</option>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="submit" class="btn btn-sm btn-success m-2" name="crear_modal"><i
											class="bi bi-check-circle pt-1 me-2"></i>Aceptar</button>
									<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i
											class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</main>
    </div>
  </div>

<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

<script src="/trackpoint/public/assets/js/menu_ventas/egresos.listaPrecios.modales.js"></script>



</body>

</html>