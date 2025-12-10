<?php $detalle = $_SESSION['detalle_presupuesto'] ?? []; ?>

<?php if (empty($detalle)): ?>

	<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>

<?php else: ?>

	<!-- 	<table id="miTablaDetalle" class="display" style="width:100%">
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
		<br> -->

	<!-- ENCABEZADO -->
	<div class="container-fluid mb-2">
		<div class="row p-2 bg-primary text-white fw-bold rounded-4">
			<div class="col-1">Presupuesto Nº</div>
			<div class="col">Código</div>
			<div class="col-4">Descripción</div>
			<div class="col-1">Cantidad</div>
			<div class="col-1">Precio Compra</div>
			<div class="col-1">Precio Venta</div>
			<div class="col">Subtotal</div>
			<div class="col-1 text-center">Acciones</div>
		</div>
	</div>

	<!-- FILAS -->
	<div class="container-fluid p-0">
		<?php foreach ($detalle as $filaDetalle): ?>

			<div class="card tabla-card mb-2 shadow-sm rounded-4">
				<div class="card-body py-2">
					<div class="row text-primary align-items-center">

						<div class="col-1 text-center"><?= $filaDetalle['presupuesto_id']; ?></div>
						<div class="col"><?= $filaDetalle['codigo_mercaderia']; ?></div>
						<div class="col-4"><?= $filaDetalle['descripcion_mercaderia']; ?></div>
						<div class="col-1"><?= $filaDetalle['cantidad']; ?></div>
						<div class="col-1">$ <?= $filaDetalle['precio_costo']; ?></div>
						<div class="col-1">$ <?= $filaDetalle['precio_venta']; ?></div>
						<div class="col">$ <?= $filaDetalle['subtotal']; ?></div>

						<!-- ACCIONES -->
						<div class="col-1 text-center">
							<div class="d-flex justify-content-center">

								<a href="" class="btn btn-sm btn-warning mx-1 d-flex rounded-5" data-bs-toggle="modal"
									data-bs-target="#modalEditarMercaderia" data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>"
									data-codigom="<?= htmlspecialchars($filaDetalle['codigo_mercaderia']) ?>"
									data-descripcionm="<?= htmlspecialchars($filaDetalle['descripcion_mercaderia']) ?>"
									data-cantidad="<?= htmlspecialchars($filaDetalle['cantidad']) ?>"
									data-preciov="<?= htmlspecialchars($filaDetalle['precio_venta']) ?>">
									<i class="bi bi-pencil"></i>
								</a>

								<a href="" class="btn btn-sm btn-danger mx-1 d-flex rounded-5" data-bs-toggle="modal"
									data-bs-target="#modalEliminarMercaderia" data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>">
									<i class="bi bi-trash"></i>
								</a>

							</div>
						</div>

					</div>
				</div>
			</div>

		<?php endforeach; ?>
	</div>

<?php endif; ?>