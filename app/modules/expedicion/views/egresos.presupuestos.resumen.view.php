								<?php if (empty($resumen)): ?>
									<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>
								<?php else: ?>

									<!-- <table id="miTablaResumen" class="display" style="width:100%">
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
															data-presupuestoid="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>">
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
														<div class="d-flex flex-nowrap justify-content-center">
															<a href="#" class="btn btn-sm btn-warning mx-1 d-flex flex-nowrap" data-bs-toggle="modal"
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
															<a href="#" id="btnMostrarEliminarPresupuesto"
																class="btn btn-sm btn-danger mx-1 d-flex flex-nowrap" data-bs-toggle="modal"
																data-bs-target="#modalEliminarPresupuesto"
																data-id="<?= htmlspecialchars($filaResumen['presupuesto_id']) ?>">
																<i class="bi bi-trash me-2"></i>Eliminar
															</a>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
									<br> -->

									<!-- ENCABEZADO -->
									<div class="container-fluid">
										<div class="row p-2 bg-primary text-white fw-bold rounded-4 mb-2">
											<div class="col"></div>
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
									<div class="container-fluid p-0">
										<?php foreach ($resumen as $filaResumen): ?>
											<div class="card tabla-card mb-2 shadow-sm rounded-4">
												<div class="card-body py-2">
													<div class="row text-primary align-items-center">

														<!-- Selección -->
														<div class="col">
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
														<div class="col d-flex flex-nowrap justify-content-center">
															<a href="#" class="btn btn-sm btn-warning mx-1 d-flex flex-nowrap rounded-5"
																data-bs-toggle="modal" data-bs-target="#modalEditarPresupuesto"
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
															<a href="#" id="btnMostrarEliminarPresupuesto"
																class="btn btn-sm btn-danger mx-1 d-flex flex-nowrap rounded-5" data-bs-toggle="modal"
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