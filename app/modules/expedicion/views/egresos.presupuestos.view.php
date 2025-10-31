<?php
require_once __DIR__ . '/../controllers/egresos.presupuestos.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
	const subtitulo = 'Presupuestos';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">

					<div class="d-flex justify-content-between pe-2">
						<h2 class="ms-2 text-primary">Presupuestos</h2>
					</div>


					<!-- ############################################################################# -->
					<div class="container-fluid mt-4">

						<!-- FORM AGREGAR -->
						<form method="POST" id="formAgregarMercaderia" action="/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&agregarMercaderia">
							
							<!-- Datos obligatorios -->
							<div class="card mb-3">
								<div class="card-header bg-light text-primary">
									<strong>Datos obligatorios</strong>
								</div>
								<div class="card-body">
									<div class="mb-3 row align-items-center">
										<div class="col-md-6">
											<!-- Empresa -->
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="empresa_id" class="col-md-6 form-label text-primary">Empresa</label>
												<div class="col-md-6 ps-0">
													<select class="form-select text-primary" id="empresa_id" name="empresa_id">
														<option value="1">Empresa 1</option>
													</select>
												</div>
											</div>
											<!-- Sucursal Empresa -->
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="sucursal_id" class="col-md-6 form-label text-primary">Sucursal</label>
												<div class="col-md-6 ps-0">
													<select class="form-select text-primary" id="sucursal_id" name="sucursal_id">
														<option value="1">Sucursal 1</option>
													</select>
												</div>
											</div>
											<!-- Rubro -->
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="rubro_id" class="col-md-6 form-label text-primary">Rubro</label>
												<div class="col-md-6 ps-0">
													<select class="form-select text-primary" id="rubro_id" name="rubro_id">
														<option value="1">Rubro 1</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<!-- Nro. Presupuesto -->
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="presupuesto_id" class="col-md-6 form-label text-primary">Presupuesto Nº</label>
												<div class="col-md-6 ps-0">
													<input type="text" class="form-control text-primary" id="presupuesto_id" name="presupuesto_id" value="<?php echo $resumen[0]['presupuesto_id']; ?>" disabled>
												</div>
											</div>
											<!-- Fecha Emisión -->
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="fecha_presupuesto" class="col-md-6 form-label text-primary">Fecha Presupuesto</label>
												<div class="col-md-6 ps-0">
													<input type="date" class="form-control text-primary" id="fecha_presupuesto" name="fecha_presupuesto">
												</div>
											</div>
											<!-- Fecha Vencimiento -->
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="fecha_vencimiento" class="col-md-6 form-label text-primary">Fecha Vencimiento</label>
												<div class="col-md-6 ps-0">
													<input type="date" class="form-control text-primary" id="fecha_vencimiento" name="fecha_vencimiento">
												</div>
											</div>
										</div>
									</div>

									<div class="mb-3 row align-items-center">
										<!-- Cliente -->
										<div class="col-md-6">
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="cliente_id" class="col-md-2 form-label text-primary">Cliente</label>
												<div class="col-md-10 ps-0">
													<div class="input-group">
														<?php $clienteSeleccionado = $_SESSION['cliente_seleccionado'] ?? null; ?>
														<input type="text" class="form-control text-primary" name="cliente_id" id="cliente_id" value="<?php echo $clienteSeleccionado['cliente_id'] ?? null; ?>">
														<a href="#" class="btn btn-primary"
														data-bs-toggle="modal" 
														data-bs-target="#modalSeleccionarCliente">
														<i class="bi bi-search"></i>
													</a>
												</div>
												<input type="hidden" name="cliente_id" id="cliente_id">
												</div>
											</div>
										</div>
										<!-- Dirección Cliente -->
										<div class="col-md-6">
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="direccion_cliente" class="col-md-2 form-label text-primary">Dirección</label>
												<div class="col-md-10 ps-0">
													<select class="form-select text-primary" id="direccion_cliente" name="direccion_cliente">
														<option value="direccion1">Dirección 1</option>
														<option value="direccion2">Dirección 2</option>
														<option value="direccion3">Dirección 3</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Selección de productos o servicios -->
							<div class="card mb-3">
								<div class="card-header bg-light text-primary">
									<strong>Selección de Productos o Servicios</strong>
								</div>
								<div class="card-body">
									<div class="mb-3 row align-items-center">
										<!-- Código de barras -->
										<div class="col-md-6">
											<div class="row p-2 d-flex align-items-center justify-content-center">
												<label for="codigo_mercaderia" class="col-md-2 form-label text-primary">Producto</label>
												<div class="col-md-10 ps-0">
														<div class="input-group">
															<input type="text" class="form-control text-primary" name="codigo_mercaderia" id="codigo_mercaderia" value="<?php echo $mercaderiaSeleccionada['codigo_mercaderia'] ?? ''; ?>">
															<a href="#" class="btn btn-primary"
															data-bs-toggle="modal" 
															data-bs-target="#modalSeleccionarMercaderia">
															<i class="bi bi-search"></i>
															</a>
														</div>
														<input type="hidden" name="mercaderia_id" id="mercaderia_id">
														<div id="mensaje-busqueda" class="alert alert-danger rounded d-none mt-2 p-2" role="alert">
															<i class="bi bi-exclamation-triangle-fill me-2"></i>
															<span class="mensaje-texto"></span>
															<!-- Mensajes de error que se cargarán de forma dinámica -->
														</div>
												</div>
											</div>
										</div>
										<!-- Cantidad -->
										<div class="col-md-2">
											<div class="row p-2 d-flex align-items-center justify-content-start">
												<label for="cantidad" class="col-md-5 col-form-label text-primary">Cantidad</label>
												<div class="col-md-7">
													<input type="number" step="1" min="1" class="form-control form-control text-end fw-bold" name="cantidad" id="cantidad" value="1">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row p-2 d-flex align-items-center justify-content-start">
												<label for="precio_venta" class="col-md-5 col-form-label text-primary">Precio Venta</label>
												<div class="col-md-7">
													<input type="number" step="1" min="1" class="form-control form-control text-end fw-bold" name="precio_venta" id="precio_venta" value="1">
												</div>
											</div>
										</div>
										<!-- Botón Agregar -->
										<div class="col-md-2 d-flex justify-content-end">
											<button type="submit" class="btn btn-sm btn-primary mx-1 my-3" id="btn-guardar-mercaderia">
												<i class="bi-plus-circle me-2"></i>Agregar
											</button>
											<button type="button" class="btn btn-sm btn-secondary mx-1 my-3" id="btn-vaciar-mercaderia">
												<i class="bi bi-x-circle me-2"></i>Vaciar
											</button>
										</div>

									</div>
								</div>
							</div>
						</form>

						<!-- FORM GENERAR -->
						<form method="POST" id="formGenerarPresupuesto" action="/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&generarPresupuesto">
							<div class="">
								<div class="card mb-3">
									<div class="card-header bg-light">
										<ul class="nav nav-underline" id="presupuestoTabs" role="tablist">
											<li class="nav-item" role="presentation">
												<a class="nav-link text-primary active" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab" aria-current="page" href="#resumen">Resumen</a>
											</li>
											<li class="nav-item">
												<a class="nav-link text-primary" id="detalle-tab" data-bs-toggle="tab" data-bs-target="#detalle" type="button" role="tab" aria-current="page" href="#detalle">Detalle</a>
											</li>
										</ul>
									</div>
									<div class="card-body p-2">
										<div class="tab-content p-3 border border-top-0 rounded-bottom" id="presupuestoTabsContent">

											<div class="tab-pane fade show active" id="resumen" role="tabpanel">
												<div id="resumen-presupuesto">
													<?php if (empty($resumen)): ?>
														<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>
													<?php else: ?>
														<table id="miTablaResumen" class="display" style="width:100%">
															<thead class="table-primary">
																<tr class="text-light">
																	<!-- <td class="border text-center">Seleccionar</td> -->
																	<td class="border">Presupuesto Nº</td>
																	<td class="border">Empresa</td>
																	<td class="border">Sucursal</td>
																	<td class="border">Rubro</td>
																	<td class="border">Fecha Presupuesto</td>
																	<td class="border">Fecha Vencimiento</td>
																	<td class="border">Cliente</td>
																	<td class="border">Dirección Cliente</td>
																	<td class="border">Contacto Cliente</td>
																	<td class="border">Cantidad</td>
																	<td class="border">Total</td>
																	<td class="border text-center no-export">Acciones</td>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($resumen as $filaResumen): ?>
																	<tr class="text-start">
																		<td class="border text-primary text-center"><?php echo $filaResumen['presupuesto_id']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['empresa_id']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['sucursal_id']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['rubro_id']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['fecha_presupuesto']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['fecha_vencimiento']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['cliente_id']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['direccion_cliente']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['contacto_nombre']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['cantidad']; ?></td>
																		<td class="border text-primary text-center"><?php echo $filaResumen['total']; ?></td>
																		<td class="border text-primary text-center">
																			<div class="d-flex no-wrap justify-content-center">
																				<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
																					data-bs-toggle="modal"
																					data-bs-target="#modalEditarMercaderia"
																					data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>"
																					data-empresa="<?= htmlspecialchars($filaResumen['empresa_id']) ?>"
																					data-sucursal="<?= htmlspecialchars($filaResumen['sucursal_id']) ?>"
																					data-rubro="<?= htmlspecialchars($filaResumen['rubro_id']) ?>"
																					data-fechap="<?= htmlspecialchars($filaResumen['fecha_presupuesto']) ?>"
																					data-fechav="<?= htmlspecialchars($filaResumen['fecha_vencimiento']) ?>"
																					data-cliente="<?= htmlspecialchars($filaResumen['cliente_id']) ?>"
																					data-direccion="<?= htmlspecialchars($filaResumen['direccion_cliente']) ?>"
																					data-contacto="<?= htmlspecialchars($filaResumen['contacto_nombre']) ?>">
																					<i class="bi bi-pencil me-2"></i>Editar
																				</a>
																				<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
																					data-bs-toggle="modal"
																					data-bs-target="#modalEliminarMercaderia"
																					data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>">
																					<i class="bi bi-trash me-2"></i>Eliminar
																				</a>
																			</div>
																		</td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													<?php endif; ?>
												</div>
											</div>
											<div class="tab-pane fade show" id="detalle" role="tabpanel">
												<div id="detalle-presupuesto">
													<?php if (empty($detalle)): ?>
														<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>
													<?php else: ?>
														<table id="miTablaDetalle" class="display" style="width:100%">
															<thead class="table-primary">
																<tr class="text-light">
																	<td class="border text-center">Presupuesto Nº</td>
																	<td class="border">Código</td>
																	<td class="border">Descripción</td>
																	<td class="border">Cantidad</td>
																	<td class="border">Precio Costo</td>
																	<td class="border">Precio Venta</td>
																	<td class="border">Subtotal</td>
																	<td class="border text-center no-export">Acciones</td>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($detalle as $filaDetalle): ?>
																	<tr class="text-start">
																		<td class="border text-primary text-center"><?php echo $filaDetalle['presupuesto_id']; ?></td>
																		<td class="border text-primary"><?php echo $filaDetalle['codigo_mercaderia']; ?></td>
																		<td class="border text-primary"><?php echo $filaDetalle['descripcion_mercaderia']; ?></td>
																		<td class="border text-primary"><?php echo $filaDetalle['cantidad']; ?></td>
																		<td class="border text-primary"><?php echo $filaDetalle['precio_costo']; ?></td>
																		<td class="border text-primary"><?php echo $filaDetalle['precio_venta']; ?></td>
																		<td class="border text-primary"><?php echo $filaDetalle['subtotal']; ?></td>
																		<td class="border text-primary text-center">
																			<div class="d-flex no-wrap justify-content-center">
																				<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
																					data-bs-toggle="modal"
																					data-bs-target="#modalEditarMercaderia"
																					data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>"
																					data-codigom="<?= htmlspecialchars($filaDetalle['codigo_mercaderia']) ?>"
																					data-descripcionm="<?= htmlspecialchars($filaDetalle['descripcion_mercaderia']) ?>"
																					data-cantidad="<?= htmlspecialchars($filaDetalle['cantidad']) ?>"
																					data-preciov="<?= htmlspecialchars($filaDetalle['precio_venta']) ?>">
																					<i class="bi bi-pencil me-2"></i>Editar
																				</a>
																				<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
																					data-bs-toggle="modal"
																					data-bs-target="#modalEliminarMercaderia"
																					data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>">
																					<i class="bi bi-trash me-2"></i>Eliminar
																				</a>
																			</div>
																		</td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer bg-light d-flex justify-content-end">
										<button type="button" class="btn btn-sm btn-success mx-1 my-3" name="guardar_modal" id="btnMostrarConfirmacion">
											<i class="bi bi-check-circle pt-1 me-2"></i>Guardar
										</button>
										<button type="button" class="btn btn-sm btn-danger mx-1 my-3" name="cancelar_modal" id="btnMostrarCancelarRecepcion">
											<i class="bi bi-x-circle me-2"></i>Cancelar
										</button>
								</div>
							</div>
						</form>

					</div>
				</div>

				<!-- Modal de selección de mercadería -->
				<div class="modal fade m-5" id="modalSeleccionarMercaderia" tabindex="-1" aria-labelledby="modalSeleccionarMercaderiaLabel" aria-hidden="true">
					<div class="modal-dialog d-flex">
						<form method="POST" id="formSeleccionarMercaderia" action="/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&seleccionarMercaderia">
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

  <script src="/trackpoint/public/assets/js/datatables.js"></script>
	<script src="/trackpoint/public/assets/js/menu_expedicion/menu.expedicion.js"></script>
	<script src="/trackpoint/public/assets/js/menu_expedicion/egresos.presupuestos.modales.js"></script>

</body>
</html>