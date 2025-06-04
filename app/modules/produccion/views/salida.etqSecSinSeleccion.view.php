<?php
require_once __DIR__ . '/../controllers/salida.etqSecSinSeleccion.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Etiquetas secundarias sin selección de stock';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2 text-primary">Emisión de etiquetas secundarias sin selección de stock</h2>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<form method="POST" id="form" action="/trackpoint/public/index.php?route=/produccion/salida/etqSecSinSeleccion">
											<div class="input-group mb-3">
												<label for="fecha_produccion"></label>
												<input type="date" class="form-control" name="fecha_produccion" id="fecha_produccion" placeholder="Fecha de producción">
												<button class="btn btn-primary" type="submit" name="buscar_etiqueta_secundaria"><i class="bi bi-search"></i></button>
											</div>
										</form>
									</div>
								</td>
								
				</div>

			</main>
		</div>
	</div>

	<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

	<!-- Script DataTables y modales -->
<!-- 	<script src="/trackpoint/public/assets/js/menu_produccion/menu.produccion.js"></script> -->

</body>
</html>