<?php $detalle = $_SESSION['detalle_presupuesto'] ?? []; ?>

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
				<td class="border">Precio Compra</td>
				<td class="border">Precio Venta</td>
				<td class="border">Subtotal</td>
				<td class="border text-center no-export">Acciones</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($detalle as $filaDetalle): ?>
				<tr class="text-start">
					<td class="border text-primary text-center"><?= $filaDetalle['presupuesto_id']; ?></td>
					<td class="border text-primary"><?= $filaDetalle['codigo_mercaderia']; ?></td>
					<td class="border text-primary"><?= $filaDetalle['descripcion_mercaderia']; ?></td>
					<td class="border text-primary"><?= $filaDetalle['cantidad']; ?></td>
					<td class="border text-primary"><?= $filaDetalle['precio_costo']; ?></td>
					<td class="border text-primary"><?= $filaDetalle['precio_venta']; ?></td>
					<td class="border text-primary"><?= $filaDetalle['subtotal']; ?></td>

					<td class="border text-primary text-center">
						<div class="d-flex no-wrap justify-content-center">
							<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap" data-bs-toggle="modal"
								data-bs-target="#modalEditarMercaderia" data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>"
								data-codigom="<?= htmlspecialchars($filaDetalle['codigo_mercaderia']) ?>"
								data-descripcionm="<?= htmlspecialchars($filaDetalle['descripcion_mercaderia']) ?>"
								data-cantidad="<?= htmlspecialchars($filaDetalle['cantidad']) ?>"
								data-preciov="<?= htmlspecialchars($filaDetalle['precio_venta']) ?>">
								<i class="bi bi-pencil me-2"></i>Editar
							</a>

							<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap" data-bs-toggle="modal"
								data-bs-target="#modalEliminarMercaderia" data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>">
								<i class="bi bi-trash me-2"></i>Eliminar
							</a>
						</div>
					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>