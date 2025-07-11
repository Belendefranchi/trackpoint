<?php
require_once __DIR__ . '/../controllers/salida.etqSecSinSeleccion.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Etiquetas secundarias sin selección de stock';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<table>
						<tr>
							<td>
								<div class="d-flex justify-content-between align-items-center pe-2">
									<h2 class="ms-2 text-primary">Emisión de etiquetas secundarias sin selección de stock</h2>
								</div>
							</td>
						</tr>
						<tr>
							<td>

								<!-- ############################################################################# -->
								<div class="container-fluid mt-4">

									<form action="guardar_etiqueta.php" method="POST" id="form-produccion">

										<div class="row">
											<!-- Columna izquierda: trazabilidad -->
											<div class="col-md-6 ps-0 pe-3">
												<div class="card mb-3">
													<div class="card-body">
														
														<div class="mb-3 row align-items-center">
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="fecha_produccion" class="col-md-6 col-form-label text-primary">Fecha Producción</label>
																	<div class="col-md-6 ps-0">
																		<input type="date" class="form-control text-primary" id="fecha_produccion" name="fecha_produccion" required>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="lote" class="col-md-4 col-form-label ps-4 text-primary">Lote</label>
																	<div class="col-md-8 ps-0">
																		<input type="text" class="form-control text-primary" id="lote" name="lote" required>
																	</div>
																</div>
															</div>
														</div>

														<div class="mb-3 row align-items-center">
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="fecha_faena" class="col-md-6 col-form-label text-primary">Fecha Faena</label>
																	<div class="col-md-6 ps-0">
																		<input type="date" class="form-control text-primary" id="fecha_faena" name="fecha_faena" required>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="tropa" class="col-md-4 col-form-label ps-4 text-primary">Tropa</label>
																	<div class="col-md-8 ps-0">
																		<input type="text" class="form-control" id="tropa" name="tropa" required>
																	</div>
																</div>
															</div>
														</div>

														<div class="mb-3 row align-items-center">
															<div class="col-md-6">
																<div class="d-flex flex-row align-items-center">
																	<label for="usuario_faena" class="col-md-4 col-form-label me-1 text-primary">Usuario Faena</label>
																	<div class="input-group">
																		<input type="text" class="form-control" name="usuario_faena" id="usuario_faena" readonly required>
																		<a href="#" class="btn btn-primary"
																			data-bs-toggle="modal" 
																			data-bs-target="#modalSeleccionarUsuario">
																			<i class="bi bi-search"></i>
																		</a>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="operador_id" class="col-md-4 col-form-label ps-4 text-primary">Operador</label>
																	<div class="col-md-8 ps-0">
																		<input type="text" class="form-control text-end" id="operador_id" name="operador_id" value="<?php echo $_SESSION['username']; ?>" readonly>
																	</div>
																</div>
															</div>
														</div>

														<div class="mb-3 d-flex flex-row align-items-center">
															<label class="form-label col-md-2 text-primary">Proceso</label>
															<div class="input-group">
																<?php $procesoSeleccionado = $_SESSION['proceso_seleccionado'] ?? null; ?>
																<input type="text" class="form-control" name="codigo_proceso" id="codigo_proceso" value="<?php echo $procesoSeleccionado ? htmlspecialchars($procesoSeleccionado['codigo']) : ''; ?>" readonly required>
																<a href="#" class="btn btn-primary"
																	data-bs-toggle="modal" 
																	data-bs-target="#modalSeleccionarProceso">
																	<i class="bi bi-search"></i>
																</a>
															</div>
														</div>

														<div class="mb-3 d-flex flex-row align-items-center">
															<label class="form-label col-md-2 text-primary">Mercadería</label>
															<div class="input-group">
																<?php $mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null; ?>
																<input type="text" class="form-control" name="codigo_mercaderia" id="codigo_mercaderia" value="<?php echo $mercaderiaSeleccionada ? htmlspecialchars($mercaderiaSeleccionada['codigo']) : ''; ?>" readonly required>
																<a href="#" class="btn btn-primary"
																	data-bs-toggle="modal" 
																	data-bs-target="#modalSeleccionarMercaderia">
																	<i class="bi bi-search"></i>
																</a>
															</div>
														</div>

													</div>
												</div>
											</div>

											<!-- Columna derecha -->
											<div class="col-md-6 ps-3 pe-0">

												<!-- Parte superior: Datos físicos -->
												<div class="card mb-3">
													<div class="card-body">

														<div class="mb-3 row align-items-center">
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="unidades" class="col-md-4 col-form-label text-primary">Unidades</label>
																	<div class="col-md-8 ps-0">
																		<input type="number" step="1" min="1" class="form-control form-control-lg text-end fw-bold" name="unidades" id="unidades" value="1" required>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="cantidad" class="col-md-4 col-form-label text-primary">Cantidad</label>
																	<div class="col-md-8 ps-0">
																		<input type="number" step="1" min="1" class="form-control form-control-lg text-end fw-bold" name="cantidad" id="cantidad" value="1" required>
																	</div>
																</div>
															</div>
														</div>

														<div class="row g-3 align-items-center">
															<!-- Tara primaria -->
															<div class="col-md-3">
																<label for="tara_pri" class="form-label text-primary">Tara Primaria</label>
																<input type="number" step="0.01" min="0.00" class="form-control form-control-lg text-end fw-bold text-primary" name="tara_pri" id="tara_pri" value="0.00" required>
															</div>
															<!-- Tara secundaria -->
															<div class="col-md-3">
																<label for="tara_sec" class="form-label text-primary">Tara Secundaria</label>
																<input type="number" step="0.01" min="0.00" class="form-control form-control-lg text-end fw-bold text-primary" name="tara_sec" id="tara_sec" value="0.00" required>
															</div>
															<!-- Peso neto con radio -->
															<div class="col-md-3">
																<input type="radio" name="modo_peso" id="modo_neto" value="neto" checked>
																<label for="modo_neto" class="form-label text-primary">Peso Neto</label>
																<input type="number" step="0.01" min="0.00" class="form-control form-control-lg text-end fw-bold" name="peso_neto" id="peso_neto" value="0.00" required>
															</div>
															<!-- Peso bruto con radio -->
															<div class="col-md-3">
																<input type="radio" name="modo_peso" id="modo_bruto" value="bruto">
																<label for="modo_bruto" class="form-label text-primary">Peso Bruto</label>
																<input type="number" step="0.01" min="0.00" class="form-control form-control-lg text-end fw-bold" name="peso_bruto" id="peso_bruto" value="0.00" required>
															</div>
														</div>

													</div>
												</div>

												<!-- Parte inferior: listado en tiempo real -->
												<div class="card">
													<div class="card-header bg-light text-primary">
														<strong>Etiquetas Emitidas</strong>
													</div>
													<div class="card-body p-2">
														<div id="listado-etiquetas" style="max-height: 300px; overflow-y: auto;">
															<!-- Aquí se inyectarán las etiquetas emitidas vía JS -->
															<p class="text-muted text-center">Aún no se emitieron etiquetas</p>
														</div>
													</div>
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

				<!-- Modal de selección de proceso -->
				<div class="modal fade m-5" id="modalSeleccionarProceso" tabindex="-1" aria-labelledby="modalSeleccionarProcesoLabel" aria-hidden="true">
					<div class="modal-dialog d-flex">
						<form method="POST" id="formSeleccionarProceso" action="/trackpoint/public/index.php?route=/produccion/salida/etqSecSinSeleccion&seleccionarProceso">
							<div class="modal-content m-5">
								<div class="modal-header table-primary text-white">
									<h5 class="modal-title" id="modalSeleccionarProcesoLabel">Seleccionar proceso</h5>
									<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
								</div>
								<div class="modal-body">

									<div class="mb-3">
										<div id="mensaje-error-seleccionar-proceso" class="alert alert-danger rounded d-none" role="alert">
											<i class="bi bi-exclamation-triangle-fill me-2"></i>
											<span class="mensaje-texto"></span>
											<!-- Mensajes de error que se cargarán de forma dinámica en el modal -->
										</div>
									</div>

									<div class="mb-3">
										<table id="miTablaEnModalProceso" class="display pt-2 pb-4" style="width:100%">
											<thead class="table-primary">
												<tr class="text-light">
													<td class="border text-center">ID</td>
													<td class="border">Código</td>
													<td class="border">Descripción</td>
													<td class="border"><i class="bi-check-circle me-2"></i></td>
												</tr>
											</thead>
											<tbody>
											<?php foreach ($procesos as $proceso): ?>
													<tr class="text-start">
														<td class="border text-primary"><?= htmlspecialchars($proceso['proceso_id']) ?></td>
														<td class="border text-primary"><?= htmlspecialchars($proceso['codigo']) ?></td>
														<td class="border text-primary"><?= htmlspecialchars($proceso['descripcion']) ?></td>
														<td class="border text-primary">
															<input type="radio" name="seleccion_proceso"
																class="form-check-input seleccionar-proceso"
																data-procesoid="<?= htmlspecialchars($proceso['proceso_id']) ?>"
																data-codigop="<?= htmlspecialchars($proceso['codigo']) ?>"
																data-descripcionp="<?= htmlspecialchars($proceso['descripcion']) ?>">
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>

									<!-- Campos ocultos para enviar en el form -->
									<input type="text" name="proceso_id" id="input-proceso-id">
									<input type="text" name="codigo-proceso" id="input-codigo-proceso">
									<input type="text" name="descripcion-proceso" id="input-descripcion-proceso">
								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="submit" class="btn btn-sm btn-success m-2" name="proceso_seleccionar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Aceptar</button>
									<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
								</div>
							</div>
						</form>
					</div>
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