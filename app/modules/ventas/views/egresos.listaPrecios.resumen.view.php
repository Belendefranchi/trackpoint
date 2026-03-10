								<?php if (empty($resumen)): ?>
									<p class="text-muted text-center">Aún no se ingresaron listas de precios</p>
								<?php else: ?>
									
									<table id="miTabla" class="display" style="width:100%">
										<thead class="table-primary">
											<tr class="text-light">
												<td class="border text-center">ID</td>
												<td class="border">Fecha</td>
												<td class="border">Proveedor</td>
												<td class="border">Moneda</td>
												<td class="border text-center no-export" style="max-width: 150px;">Acciones</td>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($resumen as $filaResumen): ?>
												<tr class="text-start">
													<td class="border text-primary text-center"><?= htmlspecialchars($filaResumen['lista_id']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($filaResumen['fecha_lista']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($filaResumen['proveedor']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($filaResumen['moneda']) ?></td>
													<td class="border text-primary text-center">
														<div class="col d-flex flex-nowrap justify-content-center">
															<a href="#" role="button" class="btn btn-sm btn-warning mx-1 d-flex flex-nowrap rounded-5"
																data-bs-toggle="modal" 
																data-bs-target="#modalEditarlista"
																data-id="<?= htmlspecialchars($filaResumen['lista_id']) ?>"
																data-fecha="<?= htmlspecialchars($filaResumen['fecha_lista']) ?>"
																data-proveedor="<?= htmlspecialchars($filaResumen['proveedor']) ?>"
																data-moneda="<?= htmlspecialchars($filaResumen['moneda']) ?>">
																<i class="bi bi-pencil"></i>
															</a>
															<a href="#" id="btnMostrarEliminarLista" role="button" class="btn btn-sm btn-danger mx-1 d-flex flex-nowrap rounded-5"
																data-bs-toggle="modal"
																data-bs-target="#modalEliminarLista"
																data-ide="<?= htmlspecialchars($filaResumen['lista_id']) ?>">
																<i class="bi bi-trash"></i>
															</a>
															<a href="#" id="btnMostrarVerLista" role="button" class="btn btn-sm btn-success mx-1 d-flex flex-nowrap rounded-5"
																data-bs-toggle="modal"
																data-bs-target="#modalVerLista"
																data-id="<?= htmlspecialchars($filaResumen['lista_id']) ?>">
																<i class="bi bi-eye"></i>
															</a>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>

								<?php endif; ?>