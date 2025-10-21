<?php
require_once __DIR__ . '/../controllers/egresos.ventas.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
	const subtitulo = 'Ventas';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">

					<div class="d-flex justify-content-between align-items-center pe-2">
						<h2 class="ms-2 text-primary">Ventas diarias</h2>
					</div>


					<!-- ############################################################################# -->
					<div class="container-fluid mt-4">

						<form action="" method="POST" id="form-produccion">

								<div class="card mb-3">
									<div class="card-body">

										<div class="mb-3 row align-items-center">
											<!-- Cliente -->
											<div class="col-md-6">
												<div class="row align-items-center">
													<label for="cliente_id" class="col-md-2 form-label text-primary">Cliente</label>
													<div class="col-md-10 ps-0 d-flex align-items-center">
														<div class="input-group">
															<?php $clienteSeleccionado = $_SESSION['cliente_seleccionado'] ?? null; ?>
															<!-- <input type="hidden" name="cliente_id" id="cliente_id"> -->
															<input type="text" class="form-control text-primary" name="cliente_id" id="cliente_id" value="<?php echo $clienteSeleccionado['cliente_id'] ?? null; ?>">
															<a href="#" class="btn btn-primary"
																data-bs-toggle="modal" 
																data-bs-target="#modalSeleccionarCliente">
																<i class="bi bi-search"></i>
															</a>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="input-group">
													<div>
														<input type="checkbox" class="form-check-input ms-3" name="requiere_factura" id="requiere_factura">
													</div>
													<label for="requiere_factura" class="form-label ms-3 mb-0">Requiere factura</label>
												</div>
											</div>

											<!-- Turno -->
											<div class="col-md-2">
												<div class="row align-items-center">
													<label for="turno" class="col-md-4 form-label text-primary">Turno</label>
													<div class="col-md-8 ps-0">
														<select class="form-select text-primary" id="turno" name="turno">
															<option value="Mañana">Mañana</option>
															<option value="Tarde">Tarde</option>
															<option value="Noche">Noche</option>
														</select>
													</div>
												</div>
											</div>

											<!-- Fecha -->
											<div class="col-md-2">
												<div class="row align-items-center">
													<label for="fecha" class="col-md-4 form-label text-primary">Fecha</label>
													<div class="col-md-8 ps-0">
														<input type="date" class="form-control text-primary" id="fecha" name="fecha">
													</div>
												</div>
											</div>
										</div>

										<div class="mb-3 row align-items-center">
											<!-- Código de barras -->
											<div class="col-md-6 me-auto">
												<div class="row align-items-center">
													<label for="codigo_mercaderia" class="col-md-2 form-label text-primary">Código</label>
													<div class="col-md-10 ps-0 d-flex align-items-center">
														<div class="d-flex flex-column w-100">
															<div class="input-group">
																<input type="hidden" name="mercaderia_id" id="mercaderia_id">
																<input type="text" class="form-control text-primary" name="codigo_mercaderia" id="codigo_mercaderia" value="<?php echo $mercaderiaSeleccionada['codigo_mercaderia'] ?? ''; ?>">
																<a href="#" class="btn btn-primary"
																	data-bs-toggle="modal" 
																	data-bs-target="#modalSeleccionarMercaderia">
																	<i class="bi bi-search"></i>
																</a>
															</div>
															<div id="mensaje-busqueda" class="alert alert-danger rounded d-none mt-2 p-2" role="alert">
																<i class="bi bi-exclamation-triangle-fill me-2"></i>
																<span class="mensaje-texto"></span>
																<!-- Mensajes de error que se cargarán de forma dinámica -->
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- Cantidad -->
											<div class="col-md-2">
												<div class="row align-items-center">
													<label for="cantidad" class="col-md-4 col-form-label text-primary">Cantidad</label>
													<div class="col-md-8 ps-0">
														<input type="number" step="1" min="1" class="form-control form-control text-end fw-bold" name="cantidad" id="cantidad" value="1">
													</div>
												</div>
											</div>
											<!-- Botón Agregar -->
											<div class="col-md-2 d-flex justify-content-end">
												<button type="submit" class="col-md-4 btn btn-sm btn-primary" id="btn-guardar-mercaderia">
													<i class="bi-plus-circle me-2"></i>Agregar
												</button>
											</div>

										</div>

									</div>
								</div>


								<!-- Parte inferior: listado en tiempo real -->
								<div class="card">
									<div class="card-header bg-light text-primary">
										<strong>Ticket nro. 1</strong>
									</div>
									<div class="card-body p-2">
										<div id="listado-etiquetas" style="max-height: 300px; overflow-y: auto;">
											<!-- Aquí se inyectarán las etiquetas emitidas vía JS -->
											<p class="text-muted text-center">Aún no se seleccionaron productos</p>
										</div>
									</div>
								</div>

						</form>
					</div>
					<!-- ######################################################################## -->

				</div>

				<!-- Modal de selección de mercadería -->
				<div class="modal fade m-5" id="modalSeleccionarMercaderia" tabindex="-1" aria-labelledby="modalSeleccionarMercaderiaLabel" aria-hidden="true">
					<div class="modal-dialog d-flex">
						<form method="POST" id="formSeleccionarMercaderia" action="/trackpoint/public/index.php?route=/expedicion/egresos/ventas&seleccionarMercaderia">
							<div class="modal-content m-5">
								<div class="modal-header table-primary text-white">
									<h5 class="modal-title" id="modalSeleccionarMercaderiaLabel">Seleccionar mercadería</h5>
									<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
								</div>
								<div class="modal-body">

									<div class="mb-3">
										<div id="mensaje-error-seleccionar" class="alert alert-danger rounded d-none p-2" role="alert">
											<i class="bi bi-exclamation-triangle-fill me-2"></i>
											<span class="mensaje-texto"></span>
											<!-- Mensajes de error que se cargarán de forma dinámica en el modal -->
										</div>
									</div>

									<div class="mb-3">
										<table id="miTablaEnModalMercaderia" class="display pt-2 pb-4" style="width:100%">
											<thead class="table-primary">
												<tr class="text-light">
													<td class="border text-center">ID</td>
													<td class="border">Código</td>
													<td class="border">Descripción</td>
													<td class="border"><i class="bi-check-circle me-2"></i></td>
												</tr>
											</thead>
											<tbody>
												<?php if (empty($mercaderias)): ?>
													<tr>
														<td colspan="4" class="text-center">No hay mercaderías disponibles</td>
													</tr>
												<?php else: ?>
													<?php foreach ($mercaderias as $mercaderia): ?>
														<tr class="text-start">
															<td class="border text-primary"><?= htmlspecialchars($mercaderia['mercaderia_id']) ?></td>
															<td class="border text-primary"><?= htmlspecialchars($mercaderia['codigo']) ?></td>
															<td class="border text-primary"><?= htmlspecialchars($mercaderia['descripcion']) ?></td>
															<td class="border text-primary">
																<input type="radio" name="seleccion_mercaderia"
																	class="form-check-input seleccionar-mercaderia"
																	data-mercaderiaid="<?= htmlspecialchars($mercaderia['mercaderia_id']) ?>"
																	data-codigom="<?= htmlspecialchars($mercaderia['codigo']) ?>"
																	data-descripcionm="<?= htmlspecialchars($mercaderia['descripcion']) ?>">
															</td>
														</tr>
													<?php endforeach; ?>
												<?php endif; ?>
											</tbody>
										</table>
									</div>

									<!-- Campos ocultos para enviar en el form -->
									<input type="hidden" name="mercaderia_id" id="input-mercaderia-id">
									<input type="hidden" name="codigo_mercaderia" id="input-codigo-mercaderia">
									<input type="hidden" name="descripcion_mercaderia" id="input-descripcion-mercaderia">
								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="submit" class="btn btn-sm btn-success m-2" name="seleccionar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Aceptar</button>
									<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</main>
		</div>
	</div>

	<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

	<script src="/trackpoint/public/assets/js/menu_expedicion/menu.expedicion.js"></script>
	<script src="/trackpoint/public/assets/js/menu_expedicion/egresos.ventas.modales.js"></script>

</body>
</html>