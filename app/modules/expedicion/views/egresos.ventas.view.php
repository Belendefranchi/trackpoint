<?php
require_once __DIR__ . '/../controllers/egresos.ventas.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Ventas';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<table>
						<tr>
							<td>
								<div class="d-flex justify-content-between align-items-center pe-2">
									<h2 class="ms-2 text-primary">Ventas</h2>
								</div>
							</td>
						</tr>
						<tr>
							<td>

								<!-- ############################################################################# -->
								<div class="container-fluid mt-4">

									<form action="guardar_etiqueta.php" method="POST" id="form-produccion">

											<!-- Parte superior: información general -->
											<div class="card mb-3">
												<div class="card-body">

													<div class="mb-3 row align-items-center"><!-- ######################### -->
														<div class="col-md-6">
															<div class="row align-items-center">
																<label for="fecha_produccion" class="col-md-4 form-label text-primary">Fecha</label>
																<div class="col-md-8 ps-0">
																	<input type="date" class="form-control text-primary" id="fecha_produccion" name="fecha_produccion" required>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="row align-items-center">
																<label for="turno" class="col-md-4 form-label text-primary">Turno</label>
																<div class="col-md-8 ps-0">
																	<input type="text" class="form-control text-primary" id="turno" name="turno" required>
																</div>
															</div>
														</div>
													</div><!-- ######################### -->

													<div class="mb-3 row align-items-center">

														<div class="col-md-6">
															<div class="row align-items-center">
																<label for="codigo_mercaderia" class="col-md-4 form-label text-primary">Producto</label>
																<div class="col-md-8 ps-0 d-flex align-items-center">
																	<div class="input-group">
																		<div class="d-flex flex-column w-100">
																			<input type="text" class="form-control text-primary" name="codigo_mercaderia" id="codigo_mercaderia" value="<?php echo $mercaderiaSeleccionada['codigo_mercaderia'] ?? ''; ?>">
																			<div id="mensaje-busqueda" class="alert alert-danger rounded d-none mt-2 p-2" role="alert">
																				<i class="bi bi-exclamation-triangle-fill me-2"></i>
																				<span class="mensaje-texto"></span>
																				<!-- Mensajes de error que se cargarán de forma dinámica -->
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<div class="col-md-6">
															<div class="row align-items-center">
																<label for="unidades" class="col-md-4 col-form-label text-primary">Unidades</label>
																<div class="col-md-8 ps-0">
																	<input type="number" step="1" min="1" class="form-control form-control text-end fw-bold" name="unidades" id="unidades" value="1" required>
																</div>
															</div>
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
							</td>
						</tr>
					</table>
				</div>

				<!-- Modal de selección de mercadería -->
				<div class="modal fade m-5" id="modalSeleccionarMercaderia" tabindex="-1" aria-labelledby="modalSeleccionarMercaderiaLabel" aria-hidden="true">
					<div class="modal-dialog d-flex">
						<form method="POST" id="formSeleccionarMercaderia" action="/trackpoint/public/index.php?route=/produccion/salida/etqSecSinSeleccion&seleccionarMercaderia">
							<div class="modal-content m-5">
								<div class="modal-header table-primary text-white">
									<h5 class="modal-title" id="modalSeleccionarMercaderiaLabel">Seleccionar mercadería</h5>
									<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
								</div>
								<div class="modal-body">

									<div class="mb-3">
										<div id="mensaje-error-seleccionar-mercaderia" class="alert alert-danger rounded d-none" role="alert">
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
											</tbody>
										</table>
									</div>

									<!-- Campos ocultos para enviar en el form -->
									<input type="text" name="mercaderia_id" id="input-mercaderia-id">
									<input type="text" name="codigo-mercaderia" id="input-codigo-mercaderia">
									<input type="text" name="descripcion-mercaderia" id="input-descripcion-mercaderia">
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

	<script src="/trackpoint/public/assets/js/menu_produccion/menu.produccion.js"></script>
	<script src="/trackpoint/public/assets/js/produccion/salida.etqSecSinSeleccion.modales.js"></script>

</body>
</html>