											<?php if (empty($detalle)): ?>
												<p class="text-muted text-center">Aún no se seleccionó ninguna lista de precios</p>
											<?php else: ?>
												
												<table id="miTablaDetalle" class="display" style="width:100%">
													<thead class="table-primary">
														<tr class="text-light">
															<td class="border text-center">Item ID</td>
															<td class="border">Código</td>
															<td class="border">Descripción</td>
															<td class="border">Precio compra</td>
															<td class="border">Precio venta</td>
															<td class="border">IVA</td>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($detalle as $filaDetalle): ?>
															<tr class="text-start">
																<td class="border text-primary text-center"><?= htmlspecialchars($filaDetalle['item_id']) ?></td>
																<td class="border text-primary"><?= htmlspecialchars($filaDetalle['codigo']) ?></td>
																<td class="border text-primary"><?= htmlspecialchars($filaDetalle['descripcion']) ?></td>
																<td class="border text-primary">
																	<input type="text" class="form-control text-primary" name="precio_compra" id="precio_compra_<?= $filaDetalle['item_id'] ?>" value="<?= htmlspecialchars($filaDetalle['precio_compra']) ?>">
																</td>
																<td class="border text-primary">
																	<input type="text" class="form-control text-primary" name="precio_venta" id="precio_venta_<?= $filaDetalle['item_id'] ?>" value="<?= htmlspecialchars($filaDetalle['precio_venta']) ?>">
																</td>
																<td class="border text-primary">
																	<input type="text" class="form-control text-primary" name="iva_tasa" id="iva_tasa_<?= $filaDetalle['item_id'] ?>" value="<?= htmlspecialchars($filaDetalle['iva_tasa']) ?>">
																</td>
															</tr>
														<?php endforeach; ?>
													</tbody>
												</table>

											<?php endif; ?>

											<div class="d-flex justify-content-end">
												<a href="#" id="btnMostrarEditarListaPrecios"
													class="btn btn-sm btn-success mx-1 my-3"
													data-id="<?= htmlspecialchars($lista_id) ?>">
													<i class="bi bi-check-circle pt-1 me-2"></i>Editar
												</a>
											</div>