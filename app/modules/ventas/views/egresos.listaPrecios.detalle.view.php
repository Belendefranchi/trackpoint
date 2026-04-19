											<?php if (empty($detalle)): ?>
												<p class="text-muted text-center">Aún no se seleccionó ninguna lista de precios</p>
											<?php else: ?>
												<?php if ($lista_tipo === 'Compra'): ?>
													<form method="POST" id="formGuardarListaPrecios" action="/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&guardarLista">
														<input type="hidden" name="lista_id" value="<?= $lista_id ?>">
														<table id="miTablaDetalle" class="display" style="width:100%">
															<thead class="table-primary">
																<tr class="text-light">
																	<td class="border text-center">Item ID</td>
																	<td class="border">Código</td>
																	<td class="border">Descripción</td>
																	<td class="border">Precio compra</td>
																	<td class="border">IVA</td>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($detalle as $filaDetalle): ?>
																	<tr class="text-start">
																		<td class="border text-center"><?= $filaDetalle['item_id'] ?></td>
																		<td class="border"><?= htmlspecialchars($filaDetalle['codigo']) ?></td>
																		<td class="border"><?= htmlspecialchars($filaDetalle['descripcion']) ?></td>
																		<td class="border"><input class="form-control bg-light" name="items[<?= $filaDetalle['item_id'] ?>][precio_compra]" value="<?= $filaDetalle['precio_compra'] ?>"></td>
																		<td class="border"><input class="form-control bg-light" name="items[<?= $filaDetalle['item_id'] ?>][iva_tasa]" value="<?= $filaDetalle['iva_tasa'] ?>"></td>
																		<td class=""><input type="hidden" name="items[<?= $filaDetalle['item_id'] ?>][mercaderia_id]" value="<?= $filaDetalle['mercaderia_id'] ?>"></td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													</form>
													<div class="d-flex justify-content-end">
														<a href="#" id="btnMostrarGuardarListaPrecios" class="btn btn-sm btn-success mx-1 my-3 btnMostrarGuardarListaPrecios" data-id="<?= htmlspecialchars($lista_id) ?>">
															<i class="bi bi-check-circle pt-1 me-2"></i>Guardar
														</a>
													</div>
												<?php else: ?>
													<div class="row p-2 mb-4 d-flex align-items-center justify-content-start">
														<label for="" class="col-md-3 form-label text-primary">Lista de Precios de compra</label>
														<div class="col-md-3 ps-0">
															<select class="form-select text-primary" id="selectListaCompra" name="lista_compra_id">
																<?php if (empty($listas)): ?>
																	<option value="">No hay listas de precios disponibles</option>
																<?php else: ?>
																		<option value="">Seleccione una lista</option>
																	<?php foreach ($listas as $lista): ?>
																		<option value="<?= htmlspecialchars($lista['lista_id']) ?>"><?= htmlspecialchars($lista['nombre']) ?></option>
																	<?php endforeach; ?>
																<?php endif; ?>
															</select>
														</div>
													</div>
													<form method="POST" id="formGuardarListaPrecios" action="/trackpoint/public/index.php?route=/ventas/egresos/listaPrecios&guardarLista">
														<input type="hidden" name="lista_id" value="<?= $lista_id ?>">
														<table id="miTablaDetalle" class="display" style="width:100%">
															<thead class="table-primary">
																<tr class="text-light">
																	<td class="border text-center">Item ID</td>
																	<td class="border">Código</td>
																	<td class="border">Descripción</td>
																	<td class="border">Precio compra</td>
																	<td class="border">Precio venta</td>
																	<td class="border">IVA</td>
																	<td class="border">Margen</td>
																	<td class=""></td>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($detalle as $filaDetalle): ?>
																	<tr class="text-start">
																		<td class="border text-center"><?= $filaDetalle['item_id'] ?></td>
																		<td class="border"><?= htmlspecialchars($filaDetalle['codigo']) ?></td>
																		<td class="border"><?= htmlspecialchars($filaDetalle['descripcion']) ?></td>
																		<td class="border precio-compra" data-mercaderia-id="<?= $filaDetalle['mercaderia_id'] ?>"></td>
																		<td class="border"><input class="form-control bg-light precio-venta" name="items[<?= $filaDetalle['item_id'] ?>][precio_venta]" value="<?= $filaDetalle['precio_venta'] ?>"></td>
																		<td class="border"><input class="form-control bg-light iva-tasa" name="items[<?= $filaDetalle['item_id'] ?>][iva_tasa]" value="<?= $filaDetalle['iva_tasa'] ?>"></td>
																		<td class="border margen"></td>
																		<td class=""><input type="hidden" name="items[<?= $filaDetalle['item_id'] ?>][mercaderia_id]" value="<?= $filaDetalle['mercaderia_id'] ?>"></td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													</form>
													<div class="d-flex justify-content-end">
														<a href="#" id="btnMostrarGuardarListaPrecios" class="btn btn-sm btn-success mx-1 my-3 btnMostrarGuardarListaPrecios" data-id="<?= htmlspecialchars($lista_id) ?>">
															<i class="bi bi-check-circle pt-1 me-2"></i>Guardar
														</a>
													</div>
												<?php endif; ?>
											<?php endif; ?>