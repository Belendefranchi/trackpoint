<?php
require_once __DIR__ . '/../controllers/egresos.presupuestos.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';

?>

<script>
	const subtitulo = 'Presupuestos';
</script>

<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
	<div class="d-flex justify-content-between align-items-center">
		<h2 class="text-primary">Presupuestos</h2>
		<a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearPresupuesto">
			<i class="bi-plus-circle me-2"></i>Nuevo Presupuesto
		</a>
	</div>


	<!-- ############################################################################# -->
	<div class="container-fluid mt-4 p-0">

		<!-- FORM AGREGAR -->
		<form method="POST" id="formAgregarMercaderia"
			action="/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&agregarMercaderia">
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
										<input type="text" class="form-control text-primary" name="codigo_mercaderia" id="codigo_mercaderia"
											value="<?php echo $mercaderiaSeleccionada['codigo_mercaderia'] ?? ''; ?>">
										<a href="#" class="btn btn-primary" data-bs-toggle="modal"
											data-bs-target="#modalSeleccionarMercaderia">
											<i class="bi bi-search"></i>
										</a>
									</div>
									<input type="hidden" name="mercaderia_id" id="mercaderia_id">
									<input type="hidden" name="descripcion_mercaderia" id="descripcion_mercaderia">
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
									<input type="number" step="1" min="1" class="form-control form-control text-end fw-bold text-primary"
										name="cantidad" id="cantidad" value="1">
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="row p-2 d-flex align-items-center justify-content-start">
								<label for="precio_venta" class="col-md-5 col-form-label text-primary">Precio Venta</label>
								<div class="col-md-7">
									<input type="number" step="1" min="1" class="form-control form-control text-end fw-bold text-primary"
										name="precio_venta" id="precio_venta" value="1">
								</div>
							</div>
						</div>
						<input type="hidden" name="presupuesto_id" id="presupuesto_id">
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
		<form method="POST" id="formGenerarPresupuesto"
			action="/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&generarPresupuesto">
			<div class="card mb-3">
				<div class="card-header bg-light d-flex align-items-center">
					<div class="">
						<ul class="nav nav-underline" id="presupuestoTabs" role="tablist">
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
							<strong id="presupuestoActivo"></strong>
						</div>
					</div>
				</div>
				<div class="card-body p-2">
					<div class="tab-content p-3 border-top-0 rounded-bottom" id="presupuestoTabsContent">

						<div class="tab-pane fade show active" id="resumen" role="tabpanel">
							<div id="resumen-presupuesto">
								<?php if (empty($resumen)): ?>
									<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>
								<?php else: ?>
									<!--
													<table id="miTablaResumen" class="display" style="width:100%">
														<thead class="table-primary">
															<tr class="text-light">
																<td class="border text-center">Seleccionar</td>
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
																	<td class="border text-primary text-center">
																		<input type="radio" name="seleccion_presupuesto"
																			class="form-check-input seleccionar-presupuesto"
																			data-presupuestoid="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>"
																			data-empresa="<?= htmlspecialchars($filaResumen['empresa_id']) ?>"
																			data-sucursal="<?= htmlspecialchars($filaResumen['sucursal_id']) ?>"
																			data-rubro="<?= htmlspecialchars($filaResumen['rubro_id']) ?>"
																			data-fechap="<?= htmlspecialchars($filaResumen['fecha_presupuesto']) ?>"
																			data-fechav="<?= htmlspecialchars($filaResumen['fecha_vencimiento']) ?>"
																			data-cliente="<?= htmlspecialchars($filaResumen['cliente_id']) ?>"
																			data-direccionc="<?= htmlspecialchars($filaResumen['direccion_cliente']) ?>"
																			data-contactoc="<?= htmlspecialchars($filaResumen['contacto_nombre']) ?>">
																	</td>
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
																				data-bs-target="#modalEditarPresupuesto"
																				data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>"
																				data-empresa="<?= htmlspecialchars($filaResumen['empresa_id']) ?>"
																				data-sucursal="<?= htmlspecialchars($filaResumen['sucursal_id']) ?>"
																				data-rubro="<?= htmlspecialchars($filaResumen['rubro_id']) ?>"
																				data-fechap="<?= htmlspecialchars($filaResumen['fecha_presupuesto']) ?>"
																				data-fechav="<?= htmlspecialchars($filaResumen['fecha_vencimiento']) ?>"
																				data-cliente="<?= htmlspecialchars($filaResumen['cliente_id']) ?>"
																				data-direccionc="<?= htmlspecialchars($filaResumen['direccion_cliente']) ?>"
																				data-contactoc="<?= htmlspecialchars($filaResumen['contacto_nombre']) ?>">
																				<i class="bi bi-pencil me-2"></i>Editar
																			</a>
																			<a href="#" id="btnMostrarEliminarPresupuesto" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
																				data-bs-toggle="modal"
																				data-bs-target="#modalEliminarPresupuesto"
																				data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>">
																				<i class="bi bi-trash me-2"></i>Eliminar
																			</a>
																		</div>
																	</td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table> -->

									<!-- ENCABEZADO -->
									<div class="container-fluid">
										<div class="row p-2 text-primary fw-bold rounded mb-2">
											<div class="col text-center">Seleccionar</div>
											<div class="col">Presupuesto Nº</div>
											<div class="col">Empresa</div>
											<div class="col">Sucursal</div>
											<div class="col">Rubro</div>
											<div class="col">Fecha Presupuesto</div>
											<div class="col">Fecha Vencimiento</div>
											<div class="col">Cliente</div>
											<div class="col">Dirección</div>
											<div class="col">Contacto</div>
											<div class="col">Cantidad</div>
											<div class="col">Total</div>
											<div class="col text-center">Acciones</div>
										</div>
									</div>


									<!-- FILAS -->
									<div class="container-fluid">
										<?php foreach ($resumen as $filaResumen): ?>
											<div class="card fila-card mb-2 shadow-sm border-0 rounded-5">
												<div class="card-body py-2">
													<div class="row text-primary align-items-center">

														<!-- Selección -->
														<div class="col text-center">
															<input type="radio" name="seleccion_presupuesto"
																class="form-check-input seleccionar-presupuesto"
																data-presupuestoid="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>">
														</div>

														<!-- Campos -->
														<div class="col"><?= $filaResumen['presupuesto_id'] ?></div>
														<div class="col"><?= $filaResumen['empresa_id'] ?></div>
														<div class="col"><?= $filaResumen['sucursal_id'] ?></div>
														<div class="col"><?= $filaResumen['rubro_id'] ?></div>
														<div class="col"><?= $filaResumen['fecha_presupuesto'] ?></div>
														<div class="col"><?= $filaResumen['fecha_vencimiento'] ?></div>
														<div class="col"><?= $filaResumen['cliente_id'] ?></div>
														<div class="col"><?= $filaResumen['direccion_cliente'] ?></div>
														<div class="col"><?= $filaResumen['contacto_nombre'] ?></div>
														<div class="col"><?= $filaResumen['cantidad'] ?></div>
														<div class="col"><?= $filaResumen['total'] ?></div>

														<!-- Acciones -->
														<div class="col text-center">
															<a href="#" class="btn btn-sm btn-warning mx-1 rounded-5" data-bs-toggle="modal"
																data-bs-target="#modalEditarPresupuesto"
																data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>"
																data-empresa="<?= htmlspecialchars($filaResumen['empresa_id']) ?>"
																data-sucursal="<?= htmlspecialchars($filaResumen['sucursal_id']) ?>"
																data-rubro="<?= htmlspecialchars($filaResumen['rubro_id']) ?>"
																data-fechap="<?= htmlspecialchars($filaResumen['fecha_presupuesto']) ?>"
																data-fechav="<?= htmlspecialchars($filaResumen['fecha_vencimiento']) ?>"
																data-cliente="<?= htmlspecialchars($filaResumen['cliente_id']) ?>"
																data-direccionc="<?= htmlspecialchars($filaResumen['direccion_cliente']) ?>"
																data-contactoc="<?= htmlspecialchars($filaResumen['contacto_nombre']) ?>">
																<i class="bi bi-pencil"></i>
															</a>

															<a href="#" class="btn btn-sm btn-danger mx-1 rounded-5" data-bs-toggle="modal"
																data-bs-target="#modalEliminarPresupuesto"
																data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>">
																<i class="bi bi-trash"></i>
															</a>
														</div>

													</div>
												</div>
											</div>
										<?php endforeach; ?>

									</div>

								<?php endif; ?>
							</div>
						</div>
						<div class="tab-pane fade show" id="detalle" role="tabpanel">
							<div id="detalle-presupuesto">
								<?php include __DIR__ . "/egresos.presupuestos.detalle.view.php"; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer bg-light d-flex justify-content-end">
					<button type="button" class="btn btn-sm btn-success mx-1 my-3" name="guardar_modal"
						id="btnMostrarConfirmacion">
						<i class="bi bi-check-circle pt-1 me-2"></i>Generar
					</button>
				</div>
		</form>

	</div>
</div>

<!-- Modal de creación de presupuesto -->
<div class="modal fade" id="modalCrearPresupuesto" tabindex="-1" aria-labelledby="modalCrearPresupuestoLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<form method="POST" id="formCrearPresupuesto"
			action="/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&crearPresupuesto">
			<div class="modal-content m-5">
				<div class="modal-header table-primary text-white">
					<h5 class="modal-title" id="modalCrearPresupuestoLabel">Crear nuevo presupuesto</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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
								<!-- Empresa -->
								<div class="row p-2 d-flex align-items-center justify-content-center">
									<label for="crearEmpresaPresupuesto" class="col-md-5 form-label text-primary">Empresa</label>
									<div class="col-md-7 ps-0">
										<select class="form-select text-primary" id="crearEmpresaPresupuesto" name="empresa_id">
											<option value="1">Empresa 1</option>
										</select>
									</div>
								</div>
								<!-- Sucursal Empresa -->
								<div class="row p-2 d-flex align-items-center justify-content-center">
									<label for="crearSucursalPresupuesto" class="col-md-5 form-label text-primary">Sucursal</label>
									<div class="col-md-7 ps-0">
										<select class="form-select text-primary" id="crearSucursalPresupuesto" name="sucursal_id">
											<option value="1">Sucursal 1</option>
										</select>
									</div>
								</div>
								<!-- Rubro -->
								<div class="row p-2 d-flex align-items-center justify-content-center">
									<label for="crearRubroPresupuesto" class="col-md-5 form-label text-primary">Rubro</label>
									<div class="col-md-7 ps-0">
										<select class="form-select text-primary" id="crearRubroPresupuesto" name="rubro_id">
											<option value="1">Rubro 1</option>
										</select>
									</div>
								</div>
								<!-- Nro. Presupuesto -->
								<div class="row p-2 d-flex align-items-center justify-content-center">
									<label for="crearPresupuestoId" class="col-md-5 form-label text-primary">Presupuesto Nº</label>
									<div class="col-md-7 ps-0">
										<?php if (empty($resumen[0]['presupuesto_id'])): ?>
											<input type="text" class="form-control text-primary text-end" id="crearPresupuestoId"
												name="presupuesto_id" value="Seleccione un presupuesto" disabled>
										<?php else: ?>
											<input type="text" class="form-control text-primary text-end" id="crearPresupuestoId"
												name="presupuesto_id" value="<?php echo $resumen[0]['presupuesto_id']; ?>" disabled>
										<?php endif; ?>
									</div>
								</div>
								<!-- Fecha Emisión -->
								<div class="row p-2 d-flex align-items-center justify-content-center">
									<label for="crearFechaPresupuesto" class="col-md-5 form-label text-primary">Fecha Presupuesto</label>
									<div class="col-md-7 ps-0">
										<input type="date" class="form-control text-primary" id="crearFechaPresupuesto"
											name="fecha_presupuesto">
									</div>
								</div>
								<!-- Fecha Vencimiento -->
								<div class="row p-2 d-flex align-items-center justify-content-center">
									<label for="crearFechaVencimientoPresupuesto" class="col-md-5 form-label text-primary">Fecha
										Vencimiento</label>
									<div class="col-md-7 ps-0">
										<input type="date" class="form-control text-primary" id="crearFechaVencimientoPresupuesto"
											name="fecha_vencimiento">
									</div>
								</div>
							</div>

							<div class="mb-3 align-items-center">
								<!-- Cliente -->
								<div class="row p-2 d-flex align-items-center justify-content-center">
									<label for="crearClientePresupuesto" class="col-md-3 form-label text-primary">Cliente</label>
									<div class="col-md-9 ps-0">
										<select class="form-select text-primary" id="crearClientePresupuesto" name="cliente_id">
											<option value="1">Cliente 1</option>
											<option value="2">Cliente 2</option>
										</select>
									</div>
									<input type="hidden" name="cliente_id" id="cliente_id">
									<input type="hidden" name="contacto_nombre" id="contacto_nombre">
								</div>
								<!-- Dirección Cliente -->
								<div class="row p-2 d-flex align-items-center justify-content-center">
									<label for="crearDireccionCliente" class="col-md-3 form-label text-primary">Dirección</label>
									<div class="col-md-9 ps-0">
										<select class="form-select text-primary" id="crearDireccionCliente" name="direccion_cliente">
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

<!-- Modal de edición de presupuesto -->
<div class="modal fade" id="modalEditarPresupuesto" tabindex="-1" aria-labelledby="modalEditarPresupuestoLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<form method="POST" id="formEditarPresupuesto"
			action="/trackpoint/public/index.php?route=/expedicio/egresos/presupuestos&editarPresupuesto">
			<div class="modal-content m-5">
				<div class="modal-header table-primary text-white">
					<h5 class="modal-title" id="modalEditarPresupuestoLabel">Editar presupuesto</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="presupuesto_id" id="editarPresupuestoId">

					<div class="mb-3">
						<div id="mensaje-error-editar-presupuesto" class="alert alert-danger rounded d-none" role="alert">
							<i class="bi bi-exclamation-triangle-fill me-2"></i>
							<span class="mensaje-texto"></span>
							<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
						</div>
					</div>

					<div class="mb-3">
						<label for="editarEmpresaPresupuesto" class="form-label text-primary">Empresa</label>
						<select class="form-select text-primary" name="empresa_id" id="editarEmpresaPresupuesto">
							<option value="1">Empresa 1</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="editarSucursalPresupuesto" class="form-label text-primary">Sucursal</label>
						<select class="form-select text-primary" name="sucursal_id" id="editarSucursalPresupuesto">
							<option value="1">Sucursal 1</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="editarRubroPresupuesto" class="form-label text-primary">Rubro</label>
						<select class="form-select text-primary" name="rubro_id" id="editarRubroPresupuesto">
							<option value="1">Rubro 1</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="editarFechaPresupuesto" class="form-label text-primary">Fecha Presupuesto</label>
						<input type="date" class="form-control text-primary" name="fecha_presupuesto" id="editarFechaPresupuesto">
					</div>

					<div class="mb-3">
						<label for="editarFechaVencimientoPresupuesto" class="form-label text-primary">Fecha Vencimiento</label>
						<input type="date" class="form-control text-primary" name="fecha_vencimiento"
							id="editarFechaVencimientoPresupuesto">
					</div>

					<div class="mb-3">
						<label for="editarClientePresupuesto" class="form-label text-primary">Cliente</label>
						<select class="form-select text-primary" name="cliente_id" id="editarClientePresupuesto">
							<option value="1">Cliente 1</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="editarDireccionClientePresupuesto" class="form-label text-primary">Dirección Cliente</label>
						<select class="form-select text-primary" name="direccion_cliente" id="editarDireccionClientePresupuesto">
							<option value="direccion1">Dirección 1</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="editarContactoClientePresupuesto" class="form-label text-primary">Contacto Cliente</label>
						<input type="text" class="form-control text-primary" name="contacto_nombre"
							id="editarContactoClientePresupuesto">
					</div>

					<div class="modal-footer d-flex justify-content-center p-2">
						<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal"><i
								class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
						<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i
								class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal de eliminación de presupuesto -->
<div class="modal fade m-5" id="modalEliminarPresupuesto" tabindex="-1" aria-labelledby="modalEliminarPresupuestoLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<form method="POST" id="formEliminarPresupuesto"
			action="/trackpoint/public/index.php?route=/expedicio/egresos/presupuestos&eliminarPresupuesto">
			<div class="modal-content shadow">
				<div class="modal-header table-primary text-white">
					<h5 class="modal-title" id="modalEliminarPresupuestoLabel">Eliminar presupuesto</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<?php if (empty($resumen)): ?>
					<div class="modal-body text-center">
						<div class="mb-3">
							<p class="text-muted text-center">Aún no hay presupuestos pendientes</p>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center p-2">
						<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					</div>
				<?php else: ?>
					<div class="modal-body text-center">
						<input type="hidden" name="presupuesto_id" id="eliminarPresupuestoId">

						<div class="mb-3">
							<div id="mensaje-error-eliminar-presupuesto" class="alert alert-danger rounded d-none" role="alert">
								<i class="bi bi-exclamation-triangle-fill me-2"></i>
								<span class="mensaje-texto"></span>
								<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
							</div>
						</div>

						<div class="mb-3">
							<p>¿Estás seguro de que querés eliminar el presupuesto?</p>
							<p>Esta acción no se puede deshacer</p>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center p-2">
						<button type="button" class="btn btn-sm btn-success" id="btnConfirmarEliminar"><i
								class="bi bi-check-circle pt-1 me-2"></i>Confirmar</button>
						<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i
								class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
					</div>
				<?php endif; ?>
			</div>
		</form>
	</div>
</div>

<!-- Modal de generación de presupuesto -->
<div class="modal fade" id="modalGenerarPresupuesto" tabindex="-1" aria-labelledby="modalGenerarPresupuestoLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content shadow">
			<div class="modal-header table-primary text-white">
				<h5 class="modal-title" id="modalGenerarPresupuestoLabel">Confirmar generación de presupuesto</h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
			</div>
			<?php if (empty($detalle)): ?>
				<div class="modal-body text-center">
					<div class="mb-3">
						<p class="text-muted text-center">Aún no hay presupuestos pendientes.</p>
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
					<button type="button" class="btn btn-sm btn-success" id="btnConfirmarGuardar"><i
							class="bi bi-check-circle pt-1 me-2"></i>Confirmar</button>
					<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i
							class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- Modal de selección de mercadería -->
<div class="modal fade" id="modalSeleccionarMercaderia" tabindex="-1" aria-labelledby="modalSeleccionarMercaderiaLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<form method="POST" id="formSeleccionarMercaderia"
			action="/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&seleccionarMercaderia">
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
												<input type="radio" name="seleccion_mercaderia" class="form-check-input seleccionar-mercaderia"
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
					<button type="submit" class="btn btn-sm btn-success m-2" name="seleccionar_modal"><i
							class="bi bi-check-circle pt-1 me-2"></i>Aceptar</button>
					<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i
							class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
				</div>
			</div>

		</form>
	</div>
</div>

<!-- Modal de edición de mercadería -->
<div class="modal fade" id="modalEditarMercaderia" tabindex="-1" aria-labelledby="modalEditarMercaderiaLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<form method="POST" id="formEditarMercaderia"
			action="/trackpoint/public/index.php?route=/expedicion/egresos/presupuestos&editarMercaderia">
			<div class="modal-content m-5">
				<div class="modal-header table-primary text-white">
					<h5 class="modal-title" id="modalEditarMercaderiaLabel">Editar mercadería</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="item_id" id="editarItemId">

					<div class="mb-3">
						<div id="mensaje-error-editar-mercaderia" class="alert alert-danger rounded d-none" role="alert">
							<i class="bi bi-exclamation-triangle-fill me-2"></i>
							<span class="mensaje-texto"></span>
							<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
						</div>
					</div>

					<div class="mb-3">
						<label for="editarCodigoMercaderia" class="form-label text-primary">Código</label>
						<select class="form-select" name="codigo_mercaderia" id="editarCodigoMercaderia">
							<?php if (empty($mercaderias)): ?>
								<option value="">No hay mercaderías disponibles</option>
							<?php else: ?>
								<!-- <option value=""></option> -->
								<?php foreach ($mercaderias as $mercaderia): ?>
									<option value="<?= htmlspecialchars($mercaderia['codigo']) ?>">
										<?= htmlspecialchars($mercaderia['codigo']) ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>

					<div class="mb-3">
						<label for="editarDescripcionMercaderia" class="form-label text-primary">Descripción</label>
						<div id="editarDescripcionMercaderiaContenedor">
							<input type="text" class="form-control text-primary" name="descripcion_mercaderia"
								id="editarDescripcionMercaderia">
						</div>
					</div>

					<div class="mb-3">
						<label for="editarCantidadMercaderia" class="form-label text-primary">Cantidad</label>
						<input type="number" class="form-control" name="cantidad" id="editarCantidadMercaderia">
					</div>

					<div class="mb-3">
						<label for="editarPrecioMercaderia" class="form-label text-primary">Precio Venta</label>
						<input type="number" class="form-control" name="precio_venta" id="editarPrecioMercaderia">
					</div>

					<div class="modal-footer d-flex justify-content-center p-2">
						<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal"><i
								class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
						<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i
								class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal de eliminación de mercadería -->
<div class="modal fade" id="modalEliminarMercaderia" tabindex="-1" aria-labelledby="modalEliminarMercaderiaLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<form method="POST" id="formEliminarMercaderia"
			action="/trackpoint/public/index.php?route=/expedicio/egresos/presupuestos&eliminarMercaderia">
			<div class="modal-content shadow">
				<div class="modal-header table-primary text-white">
					<h5 class="modal-title" id="modalEliminarMercaderiaLabel">Eliminar mercadería</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="item_id" id="eliminarItemId">

					<div class="mb-3">
						<div id="mensaje-error-eliminar-mercaderia" class="alert alert-danger rounded d-none" role="alert">
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
					<button type="submit" class="btn btn-sm btn-danger m-2" name="eliminar_modal"><i
							class="bi bi-check-circle pt-1 me-2"></i>Eliminar</button>
					<button type="button" class="btn btn-sm btn-secondary m-2" data-bs-dismiss="modal"><i
							class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal mensaje resultado -->
<div class="modal fade" id="modalMensajePresupuesto" tabindex="-1" aria-labelledby="modalMensajeLabel"
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

<script>
	window.addEventListener('DOMContentLoaded', function () {
		const hoy = new Date().toISOString().split('T')[0];
		document.getElementById('crearFechaPresupuesto').value = hoy;
		document.getElementById('crearFechaVencimientoPresupuesto').value = hoy;
	});
</script>

<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

<script src="/trackpoint/public/assets/js/datatables.js"></script>
<script src="/trackpoint/public/assets/js/menu_expedicion/menu.expedicion.js"></script>
<script src="/trackpoint/public/assets/js/menu_expedicion/egresos.presupuestos.modales.js"></script>

</body>

</html>