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

														<!-- Proveedor y Fecha Ingreso -->
														<div class="mb-3 row">
															
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label class="col-md-4 col-form-label text-primary">Proveedor</label>
																	<div class="col-md-8 ps-0">
																		<div class="input-group">
																			<input type="text" class="form-control" name="codigo_proveedor" id="codigo_proveedor" readonly required>
																			<button type="button" class="btn btn-primary" onclick="abrirSelectorProveedor()">
																				<i class="bi bi-search"></i>
																			</button>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="fecha_ingreso" class="col-md-4 col-form-label text-primary ps-5">Fecha Ingreso</label>
																	<div class="col-md-8 ps-0">
																		<input type="date" class="form-control text-primary" id="fecha_ingreso" name="fecha_ingreso" required>
																	</div>
																</div>
															</div>
														</div>

														<!-- Nro Remito y Fecha Remito -->
														<div class="mb-3 row">
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="nro_remito" class="col-md-4 col-form-label text-primary">Nro. Remito</label>
																	<div class="col-md-8 ps-0">
																		<input type="text" class="form-control" id="nro_remito" name="nro_remito" required>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="fecha_remito" class="col-md-4 col-form-label text-primary ps-5">Fecha Remito</label>
																	<div class="col-md-8 ps-0">
																		<input type="date" class="form-control text-primary" id="fecha_remito" name="fecha_remito" required>
																	</div>
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
															<i class="bi-plus-circle me-2"></i>Agregar
														</button>
													</div>
												</div>
											</div>

											<div class="">
												<div class="card mb-3">
													<div class="card-header bg-light text-primary">
														<strong>Detalle</strong>
													</div>
													<div class="card-body p-2">
														<div id="listado-etiquetas">
															<!-- Aquí se inyectarán las etiquetas emitidas vía JS -->
															<!-- <p class="text-muted text-center">Aún no se ingresaron mercaderías</p> -->
															<table id="miTablaEnModal" class="display" style="width:100%">
																<thead class="table-primary">
																	<tr class="text-light">
																		<td class="border">Código</td>
																		<td class="border">Descripción</td>
																		<td class="border">Unidades</td>
																		<td class="border">Peso</td>
																		<td class="border text-center no-export" style="max-width: 150px;">Acciones</td>
																	</tr>
																</thead>
																<tbody>
																	<tr class="text-start">
																		<td class="border text-primary text-center">M001</td>
																		<td class="border text-primary text-center">Descripción de la mercadería</td>
																		<td class="border text-primary text-center">100 u</td>
																		<td class="border text-primary text-center">1000 kg</td>
																		<td class="border text-primary text-center">
																			<div class="d-flex no-wrap justify-content-center">
																				<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap">
																					<i class="bi bi-pencil me-2"></i>Editar
																				</a>
																				<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap">
																					<i class="bi bi-trash me-2"></i>Eliminar
																				</a>
																			</div>
																		</td>
																	</tr>
																	<tr class="text-start">
																		<td class="border text-primary text-center">M002</td>
																		<td class="border text-primary text-center">Descripción de la mercadería</td>
																		<td class="border text-primary text-center">200 u</td>
																		<td class="border text-primary text-center">2000 kg</td>
																		<td class="border text-primary text-center">
																			<div class="d-flex no-wrap justify-content-center">
																				<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap">
																					<i class="bi bi-pencil me-2"></i>Editar
																				</a>
																				<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap">
																					<i class="bi bi-trash me-2"></i>Eliminar
																				</a>
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="card-footer bg-light text-end">
														<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal" >
															<i class="bi bi-check-circle pt-1 me-2"></i>Guardar
														</button>
														<button type="button" class="btn btn-sm btn-danger my-2" id="btn-limpiar-listado">
															<i class="bi-trash me-2"></i>Vaciar
														</button>
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

	<script src="/trackpoint/public/assets/js/menu_recepcion/menu.recepcion.js"></script>

</body>
</html>