<?php $detalle = $_SESSION['detalle_presupuesto'] ?? []; ?>

<?php if (empty($detalle)): ?>

	<p class="text-muted text-center">Aún no se ingresaron mercaderías</p>

<?php else: ?>

	<!-- ENCABEZADO -->
	<div class="container-fluid mb-2">
		<div class="row bg-primary text-white fw-bold py-2 rounded">
			<div class="col text-center">Presupuesto Nº</div>
			<div class="col">Código</div>
			<div class="col">Descripción</div>
			<div class="col">Cantidad</div>
			<div class="col">Precio Compra</div>
			<div class="col">Precio Venta</div>
			<div class="col">Subtotal</div>
			<div class="col text-center">Acciones</div>
		</div>
	</div>

	<!-- FILAS -->
	<div class="container-fluid">
		<?php foreach ($detalle as $filaDetalle): ?>

			<div class="card mb-2 shadow-sm">
				<div class="card-body py-2">
					<div class="row align-items-center">

						<div class="col text-center text-primary fw-semibold"><?= $filaDetalle['presupuesto_id']; ?></div>
						<div class="col text-primary"><?= $filaDetalle['codigo_mercaderia']; ?></div>
						<div class="col text-primary"><?= $filaDetalle['descripcion_mercaderia']; ?></div>
						<div class="col text-primary"><?= $filaDetalle['cantidad']; ?></div>
						<div class="col text-primary"><?= $filaDetalle['precio_costo']; ?></div>
						<div class="col text-primary"><?= $filaDetalle['precio_venta']; ?></div>
						<div class="col text-primary"><?= $filaDetalle['subtotal']; ?></div>

						<!-- ACCIONES -->
						<div class="col text-center">
							<div class="d-flex justify-content-center">

								<a href="#" class="btn btn-sm btn-warning mx-1 d-flex align-items-center" data-bs-toggle="modal"
									data-bs-target="#modalEditarMercaderia" data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>"
									data-codigom="<?= htmlspecialchars($filaDetalle['codigo_mercaderia']) ?>"
									data-descripcionm="<?= htmlspecialchars($filaDetalle['descripcion_mercaderia']) ?>"
									data-cantidad="<?= htmlspecialchars($filaDetalle['cantidad']) ?>"
									data-preciov="<?= htmlspecialchars($filaDetalle['precio_venta']) ?>">
									<i class="bi bi-pencil me-1"></i>Editar
								</a>

								<a href="#" class="btn btn-sm btn-danger mx-1 d-flex align-items-center" data-bs-toggle="modal"
									data-bs-target="#modalEliminarMercaderia" data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>">
									<i class="bi bi-trash me-1"></i>Eliminar
								</a>

							</div>
						</div>

					</div>
				</div>
			</div>

		<?php endforeach; ?>
	</div>

<?php endif; ?>