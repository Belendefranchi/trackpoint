<?php 
$detalle = $_SESSION['detalle_presupuesto'] ?? [];
/* echo '<pre>';
print_r($_SESSION);
echo '</pre>'; */

?>

<?php if (empty($detalle)): ?>

	<p class="text-muted text-center">Aún no se ingresaron listas de precios</p>

<?php else: ?>

	<!-- ENCABEZADO -->
	<div class="container-fluid mb-2">
		<div class="row p-2 bg-primary text-white fw-bold rounded-4">
			<div class="col">Presupuesto Nº</div>
			<div class="col">Código</div>
			<div class="col-4">Descripción</div>
			<div class="col-1">Cantidad</div>
			<div class="col-1">Precio Compra</div>
			<div class="col-1">Precio Venta</div>
			<div class="col-1">Margen</div>
			<div class="col">Subtotal</div>
			<div class="col-1 text-center">Acciones</div>
		</div>
	</div>

	<!-- FILAS -->
	<div class="container-fluid p-0" id="detalle-lista">

		<?php foreach ($detalle as $filaDetalle): ?>

			<div class="card tabla-card mb-2 shadow-sm rounded-4 fila-detalle" id="fila-detalle-<?= (int)$filaDetalle['item_id']; ?>" data-item-id="<?= (int)$filaDetalle['item_id']; ?>">
				<div class="card-body py-2">
					<div class="row text-primary align-items-center">
						<div class="col text-center"><?= $filaDetalle['lista_id']; ?></div>
						<div class="col"><?= $filaDetalle['codigo_mercaderia']; ?></div>
						<div class="col-4"><?= $filaDetalle['descripcion_mercaderia']; ?></div>
						<div class="col-1"><?= $filaDetalle['cantidad']; ?></div>
						<div class="col-1">
							<dl class="row d-flex align-items-center mb-0">
								<dt class="col-sm-3 mb-0">$</dt>	
								<dd class="col-sm-9 mb-0"><?= $filaDetalle['precio_compra']; ?></dd>
							</dl>
						</div>
						<div class="col-1">
							<dl class="row d-flex align-items-center mb-0">
								<dt class="col-sm-3 mb-0">$</dt>	
								<dd class="col-sm-9 mb-0"><?= $filaDetalle['precio_venta']; ?></dd>
							</dl>
						</div>
						<div class="col">
							<dl class="row d-flex align-items-center mb-0">
								<dt class="col-sm-3 mb-0">$</dt>	
								<dd class="col-sm-9 mb-0"><?= $filaDetalle['precio_venta'] - $filaDetalle['precio_compra']; ?></dd>
							</dl>
						</div>
						<div class="col">
							<dl class="row d-flex align-items-center mb-0">
								<dt class="col-sm-3 mb-0">$</dt>	
								<dd class="col-sm-9 mb-0"><?= $filaDetalle['subtotal']; ?></dd>
							</dl>
						</div>

						<!-- ACCIONES -->
						<div class="col-1 text-center">
							<div class="d-flex justify-content-center">
								<button
									type="button"
									class="btn btn-sm btn-warning mx-1 d-flex rounded-5 btn-editar-mercaderia"
									data-bs-toggle="modal"
									data-bs-target="#modalEditarMercaderia"
									data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>"
									data-codigom="<?= htmlspecialchars($filaDetalle['codigo_mercaderia']) ?>"
									data-descripcionm="<?= htmlspecialchars($filaDetalle['descripcion_mercaderia']) ?>"
									data-cantidad="<?= htmlspecialchars($filaDetalle['cantidad']) ?>"
									data-preciocompram="<?= htmlspecialchars($filaDetalle['precio_compra']) ?>"
									data-precioventam="<?= htmlspecialchars($filaDetalle['precio_venta']) ?>"
								>
									<i class="bi bi-pencil"></i>
								</button>

								<button
									type="button"
									class="btn btn-sm btn-danger mx-1 d-flex rounded-5 btn-eliminar-mercaderia"
									data-bs-toggle="modal"
									data-bs-target="#modalEliminarMercaderia"
									data-id="<?= htmlspecialchars($filaDetalle['item_id']) ?>"
								>
									<i class="bi bi-trash"></i>
								</button>

							</div>
						</div>

					</div>
				</div>
			</div>

		<?php endforeach; ?>
	</div>

<?php endif; ?>
<div class="d-flex justify-content-end">
<!-- 	<button type="button" class="btn btn-sm btn-success mx-1 my-3" name="guardar_modal"
	id="btnMostrarConfirmacion">
		<i class="bi bi-check-circle pt-1 me-2"></i>Generar
	</button> -->

	<a href="#" id="btnMostrarGenerarPresupuesto"
	class="btn btn-sm btn-success mx-1 my-3"
	data-bs-toggle="modal"
	data-bs-target="#modalGenerarPresupuesto"
	data-id="<?= htmlspecialchars($filaDetalle['LISTA_id']) ?>">
	<i class="bi bi-check-circle pt-1 me-2"></i>Editar
</a>
</div>