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

									<form method="POST" id="formIngresarMercaderia" action="">

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
																		<input type="text" class="form-control" id="nro_remito" name="nro_remito">
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="fecha_remito" class="col-md-4 col-form-label text-primary ps-5">Fecha Remito</label>
																	<div class="col-md-8 ps-0">
																		<input type="date" class="form-control text-primary" id="fecha_remito" name="fecha_remito">
																	</div>
																</div>
															</div>
														</div>

														<!-- Código y Descripción -->
														<div class="mb-3 row align-items-center">

															<div class="col-md-6">
																<div class="row align-items-center">

																	<label class="form-label col-md-4 text-primary">Código</label>
																	<div class="col-md-8 ps-0">
																		<div class="input-group">
																			<?php $mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null; ?>
																			
																			<input type="text" class="form-control text-primary" name="codigo_mercaderia" id="codigo_mercaderia" value="<?php echo $mercaderiaSeleccionada['codigo'] ?? ''; ?>" required>
																			
<!-- 																			<a href="#" class="btn btn-primary"
																			data-bs-toggle="modal"
																			data-bs-target="#modalSeleccionarMercaderia">
																				<i class="bi bi-search"></i> -->
																			</a>
																		</div>
																	</div>
																</div>
															</div>

															<div class="col-md-6">
																<div class="row align-items-center">
																	
																	<label class="form-label col-md-4 text-primary ps-5">Descripción</label>
																	<div class="col-md-8 ps-0">
																		<div class="input-group">
																			<?php $mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null; ?>
																			<input type="text" class="form-control text-primary" name="descripcion-mercaderia" value="<?php echo $mercaderiaSeleccionada['descripcion'] ?? ''; ?>" readonly required>
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

														<!-- Unidades y Peso -->
														<div class="mb-3 row">
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="unidades" class="col-md-4 col-form-label text-primary">Unidades</label>
																	<div class="col-md-8 ps-0">
																		<input type="number" step="1" min="0" class="form-control form-control-lg text-end fw-bold text-primary" name="unidades" id="unidades" value="0">
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row align-items-center">
																	<label for="peso" class="col-md-4 col-form-label text-primary ps-5">Peso</label>
																	<div class="col-md-8 ps-0">
																		<input type="number" step="0.01" min="0" class="form-control form-control-lg text-end fw-bold text-primary" name="peso" id="peso" value="0.00">
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
														<button type="submit" class="btn btn-sm btn-success my-2 me-1" name="editar_modal" >
															<i class="bi bi-check-circle pt-1 me-2"></i>Guardar
														</button>
														<button type="button" class="btn btn-sm btn-danger my-2" id="btn-limpiar-listado">
															<i class="bi-trash me-2"></i>Eliminar
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

				<!-- Modal de selección de mercadería -->
				<div class="modal fade m-5" id="modalSeleccionarMercaderia" tabindex="-1" aria-labelledby="modalSeleccionarMercaderiaLabel" aria-hidden="true">
					<div class="modal-dialog d-flex">
						<form method="POST" id="formSeleccionarMercaderia" action="/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&seleccionarMercaderia">
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
									<input type="hidden" name="mercaderia_id" id="input-mercaderia-id">
									<input type="hidden" name="codigo-mercaderia" id="input-codigo-mercaderia">
									<input type="hidden" name="descripcion-mercaderia" id="input-descripcion-mercaderia">
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

	<script src="/trackpoint/public/assets/js/menu_recepcion/menu.recepcion.js"></script>
	<script src="/trackpoint/public/assets/js/menu_recepcion/noProductivos.mercaderias.modales.js"></script>


</body>
</html>