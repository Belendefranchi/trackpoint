<?php
require_once __DIR__ . '/../controllers/noProductivos.mercaderias.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Ingreso de mercaderías';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<div class="d-flex justify-content-between align-items-center">
						<h2 class="ms-2 text-primary">Ingreso de mercaderías no productivas</h2>
					</div>

					<!-- ############################################################################# -->
					<div class="container-fluid mt-4">

						<div class="row">
							<!-- FORM AGREGAR -->
							<form method="POST" id="formAgregarMercaderia" action="/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&agregarMercaderia">
								<div class="">
									<div class="card mb-3">
										<div class="card-body">

											<!-- Proveedor y Fecha Recepción -->
											<div class="mb-3 row">
												<div class="col-md-6">
													<div class="row align-items-center">
														<label class="form-label col-md-4 text-primary">Proveedor</label>
														<div class="col-md-8 ps-0 d-flex align-items-center">
															<input type="checkbox" name="nombre_proveedor_checkbox" id="nombre_proveedor_checkbox" class="form-check-input me-2" title="Fijar">
															<div class="input-group">
																<?php $proveedorSeleccionado = $_SESSION['proveedor_seleccionado'] ?? null; ?>
																<!-- <input type="hidden" name="proveedor_id" id="proveedor_id"> -->
																<input type="text" class="form-control text-primary" name="proveedor_id" id="proveedor_id" value="<?php echo $proveedorSeleccionado['proveedor_id'] ?? 1; ?>">
																<a href="#" class="btn btn-primary"
																	data-bs-toggle="modal" 
																	data-bs-target="#modalSeleccionarProveedor">
																	<i class="bi bi-search"></i>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="row align-items-center">
														<label for="fecha_recepcion" class="col-md-4 col-form-label text-primary ps-5">Fecha Recepción</label>
														<div class="col-md-8 ps-0 d-flex align-items-center">
															<input type="checkbox" name="fecha_recepcion_checkbox" id="fecha_recepcion_checkbox" class="form-check-input me-2" title="Fijar">
															<input type="date" class="form-control text-primary" id="fecha_recepcion" name="fecha_recepcion">
														</div>
													</div>
												</div>
											</div>

											<!-- Nro Remito y Fecha Remito -->
											<div class="mb-3 row">
												<div class="col-md-6">
													<div class="row align-items-center">
														<label for="nro_remito" class="col-md-4 col-form-label text-primary">Nro. Remito</label>
														<div class="col-md-8 ps-0 d-flex align-items-center">
															<input type="checkbox" name="nro_remito_checkbox" id="nro_remito_checkbox" class="form-check-input me-2" title="Fijar">
															<input type="text" class="form-control text-primary" id="nro_remito" name="nro_remito">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="row align-items-center">
														<label for="fecha_remito" class="col-md-4 col-form-label text-primary ps-5">Fecha Remito</label>
														<div class="col-md-8 ps-0 d-flex align-items-center">
															<input type="checkbox" name="fecha_remito_checkbox" id="fecha_remito_checkbox" class="form-check-input me-2" title="Fijar">
															<input type="date" class="form-control text-primary" id="fecha_remito" name="fecha_remito">
														</div>
													</div>
												</div>
											</div>

											<!-- Código y Descripción -->
											<div class="mb-3 row">
												<div class="col-md-6">
													<div class="row align-items-center">
														<label class="form-label col-md-4 text-primary">Código</label>
														<div class="col-md-8 ps-0 d-flex align-items-center">
															<input type="checkbox" name="codigo_mercaderia_checkbox" id="codigo_mercaderia_checkbox" class="form-check-input me-2" title="Fijar">
															<div class="input-group">
																<?php $mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null; ?>
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
														<label class="form-label col-md-4 text-primary ps-5">Descripción</label>
														<div class="col-md-8 ps-0 d-flex align-items-center">
															<input type="checkbox" name="descripcion_mercaderia_checkbox" id="descripcion_mercaderia_checkbox" class="form-check-input me-2" title="Fijar">
															<div class="input-group">
																<?php $mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null; ?>
																<input type="hidden" name="mercaderia_id" id="mercaderia_id">
																<input type="text" class="form-control text-primary" name="descripcion_mercaderia" id="descripcion_mercaderia" value="<?php echo $mercaderiaSeleccionada['descripcion_mercaderia'] ?? ''; ?>" readonly>
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
														<div class="col-md-8 ps-0 d-flex align-items-center">
															<input type="checkbox" name="unidades_checkbox" id="unidades_checkbox" class="form-check-input me-2" title="Fijar">
															<?php $mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null; ?>
															<input type="number" step="1" min="0" class="form-control form-control-lg text-end fw-bold text-primary" name="unidades" id="unidades" value="<?php echo $mercaderiaSeleccionada['cantidad_propuesta']; ?>">
														</div>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="row align-items-center">
														<label for="peso_neto" class="col-md-4 col-form-label text-primary ps-5">Peso Neto</label>
														<div class="col-md-8 ps-0 d-flex align-items-center">
															<input type="checkbox" name="peso_neto_checkbox" id="peso_neto_checkbox" class="form-check-input me-2" title="Fijar">
															<?php $mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null; ?>
															<input type="number" step="0.01" min="0" class="form-control form-control-lg text-end fw-bold text-primary" name="peso_neto" id="peso_neto" value="<?php echo $mercaderiaSeleccionada['peso_propuesto']; ?>">
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="card-footer bg-light d-flex justify-content-end">
											<div id="mensaje-error-agregar" class="alert alert-danger rounded d-none m-2 p-2" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
												<!-- Mensajes de error que se cargarán de forma dinámica -->
											</div>
											<button type="submit" class="btn btn-sm btn-primary mx-1 my-3" id="btn-guardar-mercaderia">
												<i class="bi-plus-circle me-2"></i>Agregar
											</button>
											<button type="button" class="btn btn-sm btn-secondary mx-1 my-3" id="btn-vaciar-mercaderia">
												<i class="bi bi-x-circle me-2"></i>Vaciar
											</button>
										</div>
									</div>
								</div>
							</form>

							<!-- FORM GUARDAR -->
							<form method="POST" id="formGuardarMercaderia" action="/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&guardarRecepcion">
								<div class="">
									<div class="card mb-3">
										<div class="card-header bg-light">
											<ul class="nav nav-underline" id="recepcionTabs" role="tablist">
												<li class="nav-item" role="presentation">
													<a class="nav-link text-primary active" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab" aria-current="page" href="#resumen">Resumen</a>
												</li>
												<li class="nav-item">
													<a class="nav-link text-primary" id="detalle-tab" data-bs-toggle="tab" data-bs-target="#detalle" type="button" role="tab" aria-current="page" href="#detalle">Detalle</a>
												</li>
											</ul>
										</div>
										<div class="card-body p-2">
											<div class="tab-content p-3 border border-top-0 rounded-bottom" id="recepcionTabsContent">

												<div class="tab-pane fade show active" id="resumen" role="tabpanel">
													<div id="resumen-recepcion">
														<?php if (empty($resumen)): ?>
															<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>
														<?php else: ?>
															<table id="miTablaResumen" class="display" style="width:100%">
																<thead class="table-primary">
																	<tr class="text-light">
																		<td class="border">ID Recepción</td>
																		<td class="border">Fecha Recepción</td>
																		<td class="border">Código</td>
																		<td class="border">Unidades</td>
																		<td class="border">Peso Neto</td>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach ($resumen as $filaResumen): ?>
																		<tr class="text-start">
																			<td class="border text-primary text-center"><?php echo $filaResumen['recepcion_id']; ?></td>
																			<td class="border text-primary text-center"><?php echo $filaResumen['fecha_recepcion']; ?></td>
																			<td class="border text-primary text-center"><?php echo $filaResumen['codigo_mercaderia']; ?></td>
																			<td class="border text-primary text-center"><?php echo $filaResumen['total_unidades']; ?></td>
																			<td class="border text-primary text-center"><?php echo $filaResumen['total_peso_neto']; ?></td>
																		</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
														<?php endif; ?>
													</div>
												</div>
												<div class="tab-pane fade show" id="detalle" role="tabpanel">
													<div id="detalle-recepcion">
														<?php if (empty($detalle)): ?>
															<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>
														<?php else: ?>
															<table id="miTablaDetalle" class="display" style="width:100%">
																<thead class="table-primary">
																	<tr class="text-light">
																		<td class="border text-center">Recepción</td>
																		<td class="border">Código</td>
																		<td class="border">Descripción</td>
																		<td class="border">Proveedor</td>
																		<td class="border">Fecha Recepción</td>
																		<td class="border">Nro Remito</td>
																		<td class="border">Fecha Remito</td>
																		<td class="border">Unidades</td>
																		<td class="border">Peso</td>
																		<td class="border text-center no-export">Acciones</td>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach ($detalle as $filaDetalle): ?>
																		<tr class="text-start">
																			<td class="border text-primary text-center"><?php echo $filaDetalle['recepcion_id']; ?></td>
																			<td class="border text-primary"><?php echo $filaDetalle['codigo_mercaderia']; ?></td>
																			<td class="border text-primary"><?php echo $filaDetalle['descripcion_mercaderia']; ?></td>
																			<td class="border text-primary"><?php echo $filaDetalle['proveedor_id']; ?></td>
																			<td class="border text-primary"><?php echo $filaDetalle['fecha_recepcion']; ?></td>
																			<td class="border text-primary"><?php echo $filaDetalle['nro_remito']; ?></td>
																			<td class="border text-primary"><?php echo $filaDetalle['fecha_remito']; ?></td>
																			<td class="border text-primary"><?php echo $filaDetalle['unidades']; ?></td>
																			<td class="border text-primary"><?php echo $filaDetalle['peso_neto']; ?></td>
																			<td class="border text-primary text-center">
																				<div class="d-flex no-wrap justify-content-center">
																					<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
																						data-bs-toggle="modal"
																						data-bs-target="#modalEditarMercaderia"
																						data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>"
																						data-proveedor="<?= htmlspecialchars($filaDetalle['proveedor_id']) ?>"
																						data-frecepcion="<?= htmlspecialchars($filaDetalle['fecha_recepcion']) ?>"
																						data-remito="<?= htmlspecialchars($filaDetalle['nro_remito']) ?>"
																						data-fremito="<?= htmlspecialchars($filaDetalle['fecha_remito']) ?>"
																						data-unidades="<?= htmlspecialchars($filaDetalle['unidades']) ?>"
																						data-peso="<?= htmlspecialchars($filaDetalle['peso_neto']) ?>">
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
																data-descripcionm="<?= htmlspecialchars($mercaderia['descripcion']) ?>"
																data-cantidadm="<?= htmlspecialchars($mercaderia['cantidad_propuesta']) ?>"
																data-pesom="<?= htmlspecialchars($mercaderia['peso_propuesto']) ?>">
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
									<input type="hidden" name="unidades" id="input-cantidad-propuesta">
									<input type="hidden" name="peso_neto" id="input-peso-propuesto">
								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="submit" class="btn btn-sm btn-success m-2" name="seleccionar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Aceptar</button>
									<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Modal de edición de mercadería -->
				<div class="modal fade m-5" id="modalEditarMercaderia" tabindex="-1" aria-labelledby="modalEditarMercaderiaLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<form method="POST" id="formEditarMercaderia" action="/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&editarMercaderia">
							<div class="modal-content m-5">
								<div class="modal-header table-primary text-white">
									<h5 class="modal-title" id="modalEditarMercaderiaLabel">Editar mercadería</h5>
									<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
								</div>
								<div class="modal-body">
									<input type="hidden" name="item_id" id="editarItemId">

									<div class="mb-3">
										<div id="mensaje-error-editar" class="alert alert-danger rounded d-none" role="alert">
											<i class="bi bi-exclamation-triangle-fill me-2"></i>
											<span class="mensaje-texto"></span>
												<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
										</div>
									</div>

									<div class="mb-3">
										<label for="editarProveedorMercaderia" class="form-label text-primary">Proveedor</label>
										<input type="text" class="form-control" name="proveedor_id" id="editarProveedorMercaderia">
									</div>

									<div class="mb-3">
										<label for="editarFechaRecepcionMercaderia" class="form-label text-primary">Fecha Recepción</label>
										<input type="date" class="form-control" name="fecha_recepcion" id="editarFechaRecepcionMercaderia">
									</div>

									<div class="mb-3">
										<label for="editarNroRemitoMercaderia" class="form-label text-primary">Nro. Remito</label>
										<input type="text" class="form-control" name="nro_remito" id="editarNroRemitoMercaderia">
									</div>

									<div class="mb-3">
										<label for="editarFechaRemitoMercaderia" class="form-label text-primary">Fecha Remito</label>
										<input type="date" class="form-control" name="fecha_remito" id="editarFechaRemitoMercaderia">
									</div>
									
									<div class="mb-3">
										<label for="editarUnidadesMercaderia" class="form-label text-primary">Unidades</label>
										<input type="number" class="form-control" name="unidades" id="editarUnidadesMercaderia">
									</div>
									
									<div class="mb-3">
										<label for="editarPesoNetoMercaderia" class="form-label text-primary">Peso Neto</label>
										<input type="number" class="form-control" name="peso_neto" id="editarPesoNetoMercaderia">
									</div>

									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Modal de eliminación de mercadería -->
				<div class="modal fade m-5" id="modalEliminarMercaderia" tabindex="-1" aria-labelledby="modalEliminarMercaderiaLabel" aria-hidden="true">
					<div class="modal-dialog">
						<form method="POST" id="formEliminarMercaderia" action="/trackpoint/public/index.php?route=/recepcion/noProductivos/ingreso_mercaderia&eliminarMercaderia">
							<div class="modal-content shadow">
								<div class="modal-header table-primary text-white">
									<h5 class="modal-title" id="modalEliminarMercaderiaLabel">Eliminar mercadería</h5>
									<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
								</div>
								<div class="modal-body">
									<input type="hidden" name="item_id" id="eliminarItemId">

									<div class="mb-3">
										<div id="mensaje-error-eliminar" class="alert alert-danger rounded d-none" role="alert">
											<i class="bi bi-exclamation-triangle-fill me-2"></i>
											<span class="mensaje-texto"></span>
												<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
										</div>
									</div>

									<div class="mb-3">
										<p>¿Está seguro que desea eliminar la mercadería?</p>
										<p>Esta acción no se puede deshacer.</p>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="submit" class="btn btn-sm btn-danger m-2" name="eliminar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Eliminar</button>
									<button type="button" class="btn btn-sm btn-secondary m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Modal de confirmación de recepción -->
				<div class="modal fade m-5" id="modalGuardarRecepcion" tabindex="-1" aria-labelledby="modalGuardarRecepcionLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content shadow">
							<div class="modal-header table-primary text-white">
								<h5 class="modal-title" id="modalGuardarRecepcionLabel">Confirmar recepción</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
							</div>
							<?php if (empty($detalle)): ?>
								<div class="modal-body text-center">
									<div class="mb-3">
										<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
								</div>
							<?php else: ?>
								<div class="modal-body text-center">
									<div class="mb-3">
										<p class="text-muted text-center">¿Estás seguro de que querés guardar la recepción?</p>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="button" class="btn btn-sm btn-success" id="btnConfirmarGuardar"><i class="bi bi-check-circle pt-1 me-2"></i>Confirmar</button>
									<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<!-- Modal de cancelación de recepción -->
				<div class="modal fade m-5" id="modalCancelarRecepcion" tabindex="-1" aria-labelledby="modalCancelarRecepcionLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content shadow">
							<div class="modal-header table-primary text-white">
								<h5 class="modal-title" id="modalCancelarRecepcionLabel">Cancelar recepción</h5>
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
							</div>
							<?php if (empty($detalle)): ?>
								<div class="modal-body text-center">
									<div class="mb-3">
										<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
								</div>
							<?php else: ?>
								<div class="modal-body text-center">
									<div class="mb-3">
										<p class="text-muted text-center">¿Estás seguro de que querés cancelar la recepción?</p>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-center p-2">
									<button type="button" class="btn btn-sm btn-success" id="btnConfirmarCancelar"><i class="bi bi-check-circle pt-1 me-2"></i>Confirmar</button>
									<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<!-- Modal mensaje resultado -->
				<div class="modal fade m-5" id="modalMensajeRecepcion" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
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

	<script src="/trackpoint/public/assets/js/menu_recepcion/menu.recepcion.js"></script>
	<script src="/trackpoint/public/assets/js/menu_recepcion/noProductivos.mercaderias.modales.js"></script>

</body>
</html>