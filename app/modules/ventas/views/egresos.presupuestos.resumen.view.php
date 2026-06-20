								<?php if (empty($resumen)): ?>
									<p class="text-muted text-center">Aún no se crearon presupuestos</p>
								<?php else: ?>

									<!-- ENCABEZADO -->
									<div class="container-fluid p-0">
										<div class="card tabla-card mb-2 shadow-sm rounded-4 bg-primary">
											<div class="card-body py-2">
												<div class="row text-white align-items-center">
													<div class="col-auto">Sel.</div>
													<div class="col-auto">Nº</div>
													<div class="col">Empresa</div>
													<div class="col">Sucursal</div>
													<div class="col">Fecha</div>
													<div class="col">Vencimiento</div>
													<div class="col">Cliente</div>
													<div class="col">Dirección</div>
													<div class="col">Contacto</div>
													<div class="col">Cantidad</div>
													<div class="col">Total</div>
													<div class="col">Lista</div>
													<div class="col text-center" style="width: 145mm Important!;">Acciones</div>
												</div>
											</div>
										</div>
									</div>

									<!-- FILAS -->
									<div class="container-fluid p-0">
										<?php foreach ($resumen as $filaResumen): ?>
											<div class="card tabla-card mb-2 shadow-sm rounded-4">
												<div class="card-body py-2">
													<div class="row text-primary align-items-center">

														<!-- Selección -->
														<div class="col-auto px-3">
															<input type="radio" name="seleccion_presupuesto"
																class="form-check-input seleccionar-presupuesto"
																data-presupuestoid="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>"
																data-listaid="<?= htmlspecialchars($filaResumen['lista_id']) ?>">
														</div>

														<!-- Campos -->
														<div class="col-auto px-3"><?= $filaResumen['presupuesto_id'] ?></div>
														<div class="col"><?= $filaResumen['empresa_nombre'] ?></div>
														<div class="col"><?= $filaResumen['sucursal_nombre'] ?></div>
														<div class="col"><?= $filaResumen['fecha_presupuesto'] ?></div>
														<div class="col"><?= $filaResumen['fecha_vencimiento'] ?></div>
														<div class="col"><?= $filaResumen['cliente_nombre'] ?></div>
														<div class="col"><?= $filaResumen['cliente_direccion'] ?></div>
														<div class="col"><?= $filaResumen['cliente_contacto'] ?></div>
														<div class="col"><?= $filaResumen['cantidad'] ?></div>
														<div class="col">
															<dl class="row d-flex align-items-center mb-0">
																<dt class="col-sm-3 mb-0">$</dt>
																<dd class="col-sm-9 mb-0"><?= $filaResumen['total'] ?></dd>
															</dl>
														</div>
														<div class="col"><?= $filaResumen['lista_nombre'] ?></div>
														<!-- Acciones -->
														<div class="col d-flex gap-2 flex-nowrap justify-content-center">
															<!-- BOTON DE EDITAR -->
															<button type="button" class="btn btn-sm btn-warning d-flex flex-nowrap rounded-circle"
																data-bs-toggle="modal"
																data-bs-target="#modalEditarPresupuesto"
																data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>"
																data-empresa="<?= htmlspecialchars($filaResumen['empresa_nombre']) ?>"
																data-sucursal="<?= htmlspecialchars($filaResumen['sucursal_nombre']) ?>"
																data-rubro="<?= htmlspecialchars($filaResumen['rubro_nombre']) ?>"
																data-fechap="<?= htmlspecialchars($filaResumen['fecha_presupuesto']) ?>"
																data-fechav="<?= htmlspecialchars($filaResumen['fecha_vencimiento']) ?>"
																data-cliente="<?= htmlspecialchars($filaResumen['cliente_nombre']) ?>"
																data-direccionc="<?= htmlspecialchars($filaResumen['cliente_direccion']) ?>"
																data-contactoc="<?= htmlspecialchars($filaResumen['cliente_contacto']) ?>"
																data-lista="<?= htmlspecialchars($filaResumen['lista_id']) ?>">
																<i class="bi bi-pencil"></i>
															</button>
															<!-- BOTON DE ELIMINAR -->
															<button type="button" class="btn btn-sm btn-danger d-flex flex-nowrap rounded-circle"
																data-bs-toggle="modal"
																data-bs-target="#modalEliminarPresupuesto"
																data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>">
																<i class="bi bi-trash"></i>
															</button>
															<!-- BOTON DE GENERAR ALCANCE -->
															<button type="button" class="btn btn-sm btn-success d-flex flex-nowrap rounded-circle"
																data-bs-toggle="modal"
																data-bs-target="#modalGenerarAlcance"
																data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>"
																data-fechap="<?= htmlspecialchars($filaResumen['fecha_presupuesto']) ?>"
																data-cliente="<?= htmlspecialchars($filaResumen['cliente_nombre']) ?>"
																data-direccionc="<?= htmlspecialchars($filaResumen['cliente_direccion']) ?>"
																data-contactoc="<?= htmlspecialchars($filaResumen['cliente_contacto']) ?>">
																<i class="bi bi-filetype-pdf"></i>
															</button>
														</div>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									</div>

								<?php endif; ?>