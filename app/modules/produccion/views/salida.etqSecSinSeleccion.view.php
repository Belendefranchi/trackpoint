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
																		<button type="button" class="btn btn-primary" onclick="abrirSelectorUsuario()"><i class="bi bi-search"></i></button>
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
																<input type="text" class="form-control" name="codigo_proceso" id="codigo_proceso" readonly required>
																<button type="button" class="btn btn-primary" onclick="abrirSelectorProceso()"><i class="bi bi-search"></i></button>
															</div>
														</div>

														<div class="mb-3 d-flex flex-row align-items-center">
															<label class="form-label col-md-2" text-primary>Producto</label>
															<div class="input-group">
																<input type="text" class="form-control" name="codigo_producto" id="codigo_producto" readonly required>
																<button type="button" class="btn btn-primary" onclick="abrirSelectorProducto()"><i class="bi bi-search"></i></button>
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
																<input type="radio" name="modo_peso" id="modo_bruto" value="bruto" checked>
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

			</main>
		</div>
	</div>

	<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

	<script src="/trackpoint/public/assets/js/menu_produccion/menu.produccion.js"></script>

</body>
</html>