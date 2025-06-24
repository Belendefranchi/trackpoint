<?php
require_once __DIR__ . '/../controllers/noProductivos.mercaderias.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Ingreso de mercaderías';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<table>
						<tr>
							<td>
								<div class="d-flex justify-content-between align-items-center pe-2">
									<h2 class="ms-2 text-primary">Ingreso de mercaderías no productivas</h2>
								</div>
							</td>
						</tr>
						<tr>
							<td>

								<!-- ############################################################################# -->
								<div class="container-fluid mt-4">

									<form action="recepcion_mercaderias.php" method="POST" id="form-recepcion-mercderias">

										<div class="row">

											<div class="">
												<div class="card mb-3">
													<div class="card-body">

														<!-- Fecha Ingreso y Operador -->
														<div class="mb-3 row">
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="fecha_ingreso" class="col-md-4 col-form-label text-primary">Fecha Ingreso</label>
																	<div class="col-md-8 ps-0">
																		<input type="date" class="form-control text-primary" id="fecha_ingreso" name="fecha_ingreso" required>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="operador_id" class="col-md-4 col-form-label text-primary ps-5">Operador</label>
																	<div class="col-md-8 ps-0">
																		<input type="text" class="form-control text-end" id="operador_id" name="operador_id" value="<?php echo $_SESSION['username']; ?>" readonly>
																	</div>
																</div>
															</div>
														</div>

														<!-- Fecha y Nro Remito -->
														<div class="mb-3 row">
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="fecha_remito" class="col-md-4 col-form-label text-primary">Fecha Remito</label>
																	<div class="col-md-8 ps-0">
																		<input type="date" class="form-control text-primary" id="fecha_remito" name="fecha_remito" required>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="nro_remito" class="col-md-4 col-form-label text-primary ps-5">Nro. Remito</label>
																	<div class="col-md-8 ps-0">
																		<input type="text" class="form-control" id="nro_remito" name="nro_remito" required>
																	</div>
																</div>
															</div>
														</div>

														<!-- Proveedor -->
														<div class="mb-3 row align-items-center">
															<label class="col-md-2 col-form-label text-primary">Proveedor</label>
															<div class="col-md-10 ps-0">
																<div class="input-group">
																	<input type="text" class="form-control" name="codigo_proveedor" id="codigo_proveedor" readonly required>
																	<button type="button" class="btn btn-primary" onclick="abrirSelectorProveedor()">
																		<i class="bi bi-search"></i>
																	</button>
																</div>
															</div>
														</div>

														<!-- Código -->
														<div class="mb-3 row align-items-center">
															<label class="col-md-2 col-form-label text-primary">Código</label>
															<div class="col-md-10 ps-0">
																<div class="input-group">
																	<input type="text" class="form-control" name="codigo_producto" id="codigo_producto" readonly required>
																	<button type="button" class="btn btn-primary" onclick="abrirSelectorProducto()">
																		<i class="bi bi-search"></i>
																	</button>
																</div>
															</div>
														</div>

														<!-- Descripción -->
														<div class="mb-3 row align-items-center">
															<label class="col-md-2 col-form-label text-primary">Descripción</label>
															<div class="col-md-10 ps-0">
																<div class="input-group">
																	<input type="text" class="form-control" name="descripcion_producto" id="descripcion_producto" readonly required>
																	<button type="button" class="btn btn-primary" onclick="abrirSelectorDescripcion()">
																		<i class="bi bi-search"></i>
																	</button>
																</div>
															</div>
														</div>

														<!-- Unidades y Peso -->
														<div class="mb-3 row">
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="unidades" class="col-md-4 col-form-label text-primary">Unidades</label>
																	<div class="col-md-8 ps-0">
																		<input type="number" step="1" min="1" class="form-control form-control-lg text-end fw-bold text-primary" name="unidades" id="unidades" value="0" required>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="peso" class="col-md-4 col-form-label text-primary ps-5">Peso</label>
																	<div class="col-md-8 ps-0">
																		<input type="number" step="0.01" min="0" class="form-control form-control-lg text-end fw-bold text-primary" name="peso" id="peso" value="0.00" required>
																	</div>
																</div>
															</div>
														</div>

													</div>

													<div class="card-footer bg-light text-end">
														<button type="submit" class="btn btn-sm btn-primary my-2" id="btn-guardar-mercaderia">
															<i class="bi-plus-circle me-2"></i>Ingresar ítem
														</button>
													</div>
												</div>
											</div>

											<div class="">
												<div class="card mb-3">
													<div class="card-header bg-light text-primary">
														<strong>Ítems ingresados</strong>
													</div>
													<div class="card-body p-2">
														<div id="listado-etiquetas">
															<!-- Aquí se inyectarán las etiquetas emitidas vía JS -->
															<p class="text-muted text-center">Aún no se ingresaron ítems</p>
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