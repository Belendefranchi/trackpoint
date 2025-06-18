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

								<!-- ############################################################################# -->
								<div class="container-fluid mt-4">

									<form action="guardar_etiqueta.php" method="POST" id="form-produccion">

										<div class="row">
											<!-- Columna izquierda: trazabilidad -->
											<div class="col-md-6">
												<div class="card mb-3">
<!-- 													<div class="card-header bg-light">
														<strong>Trazabilidad</strong>
													</div> -->
													<div class="card-body">

														<input type="hidden" name="operador_id" value="<?= $_SESSION['operador_id'] ?? '' ?>">

														<div class="mb-3 d-flex flex-row">
															<div class="w-100 pe-2">
																<label for="fecha_produccion" class="form-label">Fecha Producción</label>
																<input type="date" class="form-control" name="fecha_produccion" id="fecha_produccion" required>
															</div>
															<div class="w-100 ps-2">
																<label for="lote" class="form-label">Lote</label>
																<input type="text" class="form-control" name="lote" id="lote" required>
															</div>
														</div>

														<div class="mb-3 d-flex flex-row">
															<div class="w-100 pe-2">
																<label for="fecha_faena" class="form-label">Fecha Faena</label>
																<input type="date" class="form-control" name="fecha_faena" id="fecha_faena" required>
															</div>
															<div class="w-100 ps-2">
																<label for="tropa" class="form-label">Tropa</label>
																<input type="text" class="form-control" name="tropa" id="tropa" required>
															</div>
														</div>

														<div class="mb-3">
															<label for="turno" class="form-label">Turno</label>
															<select class="form-select" name="turno" id="turno">
																<option value="">Seleccionar</option>
																<option value="mañana">Mañana</option>
																<option value="tarde">Tarde</option>
																<option value="noche">Noche</option>
															</select>
														</div>

														<div class="mb-3">
															<label class="form-label">Proceso</label>
															<div class="input-group">
																<input type="text" class="form-control" name="codigo_proceso" id="codigo_proceso" readonly required>
																<button type="button" class="btn btn-primary" onclick="abrirSelectorProceso()"><i class="bi bi-search"></i></button>
															</div>
														</div>

														<div class="mb-3">
															<label class="form-label">Producto</label>
															<div class="input-group">
																<input type="text" class="form-control" name="codigo_producto" id="codigo_producto" readonly required>
																<button type="button" class="btn btn-primary" onclick="abrirSelectorProducto()"><i class="bi bi-search"></i></button>
															</div>
														</div>

													</div>
												</div>
											</div>

											<!-- Columna derecha -->
											<div class="col-md-6">

												<!-- Parte superior: Datos físicos -->
												<div class="card mb-3">
<!-- 													<div class="card-header bg-light">
														<strong>Datos Físicos</strong>
													</div> -->
													<div class="card-body">
														<div class="row g-3">
															<div class="col-md-6">
																<label for="unidades" class="form-label">Unidades</label>
																<input type="number" step="1" min="1" class="form-control form-control-lg text-end fw-bold" name="unidades" id="unidades" value="1" required>
															</div>

															<div class="col-md-6">
																<label for="cantidad" class="form-label">Cajas</label>
																<input type="number" step="1" min="1" class="form-control form-control-lg text-end fw-bold" name="cantidad" id="cantidad" value="1" required>
															</div>

															<div class="col-md-6">
																<label for="tara_pri" class="form-label">Tara Primaria</label>
																<input type="number" step="0.01" min="0.00" class="form-control form-control-lg text-end fw-bold" name="tara_pri" id="tara_pri" value="0.00" required>
															</div>

															<div class="col-md-6">
																<label for="tara_sec" class="form-label">Tara Secundaria</label>
																<input type="number" step="0.01" min="0.00" class="form-control form-control-lg text-end fw-bold" name="tara_sec" id="tara_sec" value="0.00" required>
															</div>
																
															<div class="col-md-6">
																<input class="" type="radio" name="modo_peso" id="modo_neto" value="neto" checked>
																<label for="peso_neto" class="form-label">Peso Neto</label>
																<input type="number" step="0.01" min="0.00" class="form-control form-control-lg text-end fw-bold" name="peso_neto" id="peso_neto" value="0.00" required>
															</div>
																
															<div class="col-md-6">
																<input class="" type="radio" name="modo_peso" id="modo_bruto" value="bruto">
																<label for="peso_bruto" class="form-label">Peso Bruto</label>
																<input type="number" step="0.01" min="0.00" class="form-control form-control-lg text-end fw-bold" name="peso_bruto" id="peso_bruto" value="0.00" required>
															</div>
														</div>

														<div class="mt-4">
															<button type="submit" class="btn btn-primary btn-lg">Emitir Etiqueta</button>
														</div>
													</div>
												</div>

												<!-- Parte inferior: listado en tiempo real -->
												<div class="card">
													<div class="card-header bg-light">
														<strong>Etiquetas Emitidas</strong>
													</div>
													<div class="card-body p-2">
														<div id="listado-etiquetas" style="max-height: 300px; overflow-y: auto;">
															<!-- Aquí se inyectarán las etiquetas emitidas vía JS -->
															<p class="text-muted">Aún no se emitieron etiquetas.</p>
														</div>
													</div>
												</div>

											</div>
										</div>

									</form>
								</div>
								<!-- ######################################################################## -->
							</td>
						</tr>
					</table>
				</div>

			</main>
		</div>
	</div>

	<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>
	<script>


		window.addEventListener('DOMContentLoaded', function () {
				const hoy = new Date().toISOString().split('T')[0];
				document.getElementById('fecha_faena').value = hoy;
				document.getElementById('fecha_produccion').value = hoy;
		});


		document.getElementById('unidades').addEventListener('input', function () {
			this.value = this.value.replace(/\D/g, ''); // Elimina cualquier cosa que no sea dígito
		});

		document.getElementById('cantidad').addEventListener('input', function () {
			this.value = this.value.replace(/\D/g, ''); // Elimina cualquier cosa que no sea dígito
		});

		function getFloat(id) {
				return parseFloat(document.getElementById(id).value) || 0;
		}

		function actualizarCamposActivos() {
				const modo = document.querySelector('input[name="modo_peso"]:checked').value;
				const inputNeto = document.getElementById('peso_neto');
				const inputBruto = document.getElementById('peso_bruto');

				if (modo === 'neto') {
						inputNeto.removeAttribute('readonly');
						inputNeto.classList.remove('input-disabled-style');
						inputNeto.classList.remove('bg-light');
						inputNeto.classList.add('bg-primary-subtle');
						
						inputBruto.setAttribute('readonly', 'readonly');
						inputBruto.classList.remove('bg-primary-subtle');
						inputBruto.classList.add('input-disabled-style');
						inputBruto.classList.add('bg-light');

				} else {
						inputBruto.removeAttribute('readonly');
						inputBruto.classList.remove('input-disabled-style');
						inputBruto.classList.remove('bg-light');
						inputBruto.classList.add('bg-primary-subtle');
						
						inputNeto.setAttribute('readonly', 'readonly');
						inputNeto.classList.remove('bg-primary-subtle');
						inputNeto.classList.add('input-disabled-style');
						inputNeto.classList.add('bg-light');

				}
		}

		function calcularSegunModo() {
				const modo = document.querySelector('input[name="modo_peso"]:checked').value;
				const taraPri = getFloat('tara_pri');
				const taraSec = getFloat('tara_sec');

				if (modo === 'neto') {
						const neto = getFloat('peso_neto');
						const bruto = neto + taraPri + taraSec;
						document.getElementById('peso_bruto').value = bruto.toFixed(2);
				} else if (modo === 'bruto') {
						const bruto = getFloat('peso_bruto');
						const neto = bruto - taraPri - taraSec;
						document.getElementById('peso_neto').value = neto.toFixed(2);
				}
		}

		// Escuchar cambios
		['peso_neto', 'peso_bruto', 'tara_pri', 'tara_sec'].forEach(id => {
				document.getElementById(id).addEventListener('input', calcularSegunModo);
		});

		document.querySelectorAll('input[name="modo_peso"]').forEach(radio => {
				radio.addEventListener('change', () => {
						actualizarCamposActivos();
						calcularSegunModo();
				});
		});

		// Inicializar al cargar
		window.addEventListener('DOMContentLoaded', () => {
				actualizarCamposActivos();
				calcularSegunModo();
		});



	</script>
	<!-- Script DataTables y modales -->
<!-- 	<script src="/trackpoint/public/assets/js/menu_produccion/menu.produccion.js"></script> -->

</body>
</html>