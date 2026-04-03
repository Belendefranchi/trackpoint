											<?php if (empty($resumen)): ?>
												<p class="text-muted text-center">Aún no se ingresaron listas de precios</p>
											<?php else: ?>
												
												<table id="miTablaResumen" class="display" style="width:100%">
													<thead class="table-primary">
														<tr class="text-light">
															<td class="border text-center">Sel.</td>
															<td class="border text-center">ID</td>
															<td class="border">Fecha</td>
															<td class="border">Tipo</td>
															<td class="border">Nombre</td>
															<td class="border">Proveedor</td>
															<td class="border">Moneda</td>
															<td class="border text-center no-export" style="max-width: 150px;">Acciones</td>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($resumen as $filaResumen): ?>
															<tr class="text-start tabla-lista">
																<td class="border text-center">
																	<input type="radio" name="seleccion_lista" class="form-check-input seleccionar-lista" data-listaid="<?= htmlspecialchars($filaResumen['lista_id']) ?>" data-nombre="<?= htmlspecialchars($filaResumen['nombre']) ?>">
																</td>
																<td class="border text-primary text-center"><?= htmlspecialchars($filaResumen['lista_id']) ?></td>
																<td class="border text-primary"><?= htmlspecialchars($filaResumen['fecha_lista']) ?></td>
																<td class="border text-primary"><?= htmlspecialchars($filaResumen['tipo']) ?></td>
																<td class="border text-primary"><?= htmlspecialchars($filaResumen['nombre']) ?></td>
																<td class="border text-primary"><?= htmlspecialchars($filaResumen['proveedor']) ?></td>
																<td class="border text-primary"><?= htmlspecialchars($filaResumen['moneda']) ?></td>
																<td class="border text-primary text-center">
																	<div class="col d-flex flex-nowrap justify-content-center">
																		<a href="#" role="button" class="btn btn-sm btn-warning mx-1 d-flex flex-nowrap"
																			data-bs-toggle="modal" 
																			data-bs-target="#modalEditarListaPrecios"
																			data-id="<?= htmlspecialchars($filaResumen['lista_id']) ?>"
																			data-fecha="<?= htmlspecialchars($filaResumen['fecha_lista']) ?>"
																			data-tipo="<?= htmlspecialchars($filaResumen['tipo']) ?>"
																			data-proveedor="<?= htmlspecialchars($filaResumen['proveedor']) ?>"
																			data-moneda="<?= htmlspecialchars($filaResumen['moneda']) ?>">
																			<i class="bi bi-pencil me-2"></i>Editar
																		</a>
																		<a href="#" id="btnMostrarEliminarListaPrecios" role="button" class="btn btn-sm btn-danger mx-1 d-flex flex-nowrap"
																			data-bs-toggle="modal"
																			data-bs-target="#modalEliminarListaPrecios"
																			data-id="<?= htmlspecialchars($filaResumen['lista_id']) ?>">
																			<i class="bi bi-trash me-2"></i>Eliminar
																		</a>
<!-- 																		<a href="#" role="button" class="btn btn-sm btn-success mx-1 d-flex flex-nowrap rounded-5 btn-ver-lista"
																			data-id="<?= htmlspecialchars($filaResumen['lista_id']) ?>">
																			<i class="bi bi-eye"></i>
																		</a> -->
																	</div>
																</td>
															</tr>
														<?php endforeach; ?>
													</tbody>
												</table>

											<?php endif; ?>