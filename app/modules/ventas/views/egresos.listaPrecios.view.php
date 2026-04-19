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
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
							aria-label="Cerrar"></button>
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
									<!-- Tipo -->
									<div class="row p-2 d-flex align-items-center justify-content-center">
										<label for="crearTipoLista" class="col-md-5 form-label text-primary">Tipo</label>
										<div class="col-md-7 ps-0">
											<select class="form-select text-primary" id="crearTipoLista" name="tipo">
												<option value="Compra">Compra</option>
												<option value="Venta">Venta</option>
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

	<!-- Modal de edición de lista de precios -->
	<div class="modal fade" id="modalEditarListaPrecios" tabindex="-1" aria-labelledby="modalEditarListaPreciosLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<form method="POST" id="formEditarListaPrecios"
				action="/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&editarLista">
				<div class="modal-content m-5">
					<div class="modal-header table-primary text-white">
						<h5 class="modal-title" id="modalEditarListaPreciosLabel">Editar lista de precios</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
							aria-label="Cerrar"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="lista_id" id="editarListaPreciosId">
						<div class="mb-3">
							<div id="mensaje-error-editar" class="alert alert-danger rounded d-none p-2" role="alert">
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
										<label for="editarProveedorLista" class="col-md-5 form-label text-primary">Proveedor</label>
										<div class="col-md-7 ps-0">
											<input type="text" class="form-control text-primary" id="editarProveedorLista" name="proveedor">
										</div>
									</div>
									<!-- Fecha Lista -->
									<div class="row p-2 d-flex align-items-center justify-content-center">
										<label for="editarFechaLista" class="col-md-5 form-label text-primary">Fecha</label>
										<div class="col-md-7 ps-0">
											<input type="date" class="form-control text-primary" id="editarFechaLista" name="fecha_lista">
										</div>
									</div>
									<!-- Moneda -->
									<div class="row p-2 d-flex align-items-center justify-content-center">
										<label for="editarMonedaLista" class="col-md-5 form-label text-primary">Moneda</label>
										<div class="col-md-7 ps-0">
											<select class="form-select text-primary" id="editarMonedaLista" name="moneda">
												<option value="ARS">ARS</option>
												<option value="USD">USD</option>
											</select>
										</div>
									</div>
									<!-- Tipo -->
									<div class="row p-2 d-flex align-items-center justify-content-center">
										<label for="editarTipoLista" class="col-md-5 form-label text-primary">Tipo</label>
										<div class="col-md-7 ps-0">
											<select class="form-select text-primary" id="editarTipoLista" name="tipo">
												<option value="Compra">Compra</option>
												<option value="Venta">Venta</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer d-flex justify-content-center p-2">
						<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal"><i
								class="bi bi-check-circle pt-1 me-2"></i>Aceptar</button>
						<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i
								class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Modal de eliminación de presupuesto -->
	<div class="modal fade" id="modalEliminarListaPrecios" tabindex="-1" aria-labelledby="modalEliminarListaPreciosLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<form method="POST" id="formEliminarListaPrecios"
				action="/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&eliminarLista">
				<div class="modal-content shadow">
					<div class="modal-header table-primary text-white">
						<h5 class="modal-title" id="modalEliminarListaPreciosLabel">Eliminar lista de precios</h5>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
							aria-label="Cerrar"></button>
					</div>
					<?php if (empty($resumen)): ?>
						<div class="modal-body text-center">
							<div class="mb-3">
								<p class="text-muted text-center">Aún no hay listas de precios pendientes</p>
							</div>
						</div>
						<div class="modal-footer d-flex justify-content-center p-2">
							<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						</div>
					<?php else: ?>
						<div class="modal-body text-center">
							<input type="hidden" name="lista_id" id="eliminarListaPreciosId">

							<div class="mb-3">
								<div id="mensaje-error-eliminar" class="alert alert-danger rounded d-none" role="alert">
									<i class="bi bi-exclamation-triangle-fill me-2"></i>
									<span class="mensaje-texto"></span>
									<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
								</div>
							</div>

							<div class="mb-3">
								<p>¿Estás seguro de que querés eliminar la lista de precios?</p>
								<p>Esta acción no se puede deshacer</p>
							</div>
						</div>
						<div class="modal-footer d-flex justify-content-center p-2">
							<button type="button" class="btn btn-sm btn-success" id="btnConfirmarEliminar">
								<i class="bi bi-check-circle pt-1 me-2"></i>Confirmar
							</button>
							<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
								<i class="bi bi-x-circle pt-1 me-2"></i>Cancelar
							</button>
						</div>
					<?php endif; ?>
				</div>
			</form>
		</div>
	</div>

	<!-- Modal mensaje resultado -->
	<div class="modal fade" id="modalMensajeListaPrecios" tabindex="-1" aria-labelledby="modalMensajeLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow">
				<div class="modal-header table-primary text-white">
					<h5 class="modal-title" id="modalMensajeLabel">Resultado de la operación</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body text-center">
					<div class="mb-3">
						<p class="text-muted text-center" id="textoModalMensaje"></p>
					</div>
				</div>
				<div class="modal-footer justify-content-center">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	</main>
</div>
</div>

<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

<script src="/trackpoint/public/assets/js/menu_ventas/egresos.listaPrecios.modales.js"></script>
<script src="/trackpoint/public/assets/js/menu_ventas/egresos.listaPrecios.modales.apertura.js"></script>
<script src="/trackpoint/public/assets/js/datatables.js"></script>





</body>

</html>