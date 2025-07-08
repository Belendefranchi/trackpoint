<?php
require_once __DIR__ . '/../controllers/abm.mercaderias.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Mercaderías';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<div class="d-flex justify-content-between align-items-center">
						<h2 class="text-primary">Mercaderías</h2>
						<a href="#" class="btn btn-sm btn-primary"
							data-bs-toggle="modal" 
							data-bs-target="#modalCrearMercaderia">
							<i class="bi-plus-circle me-2"></i>Nueva Mercadería
						</a>
					</div>
					<table id="miTabla" class="display" style="width:100%">
						<thead class="table-primary">
							<tr class="text-light">
								<td class="border text-center">ID</td>
								<td class="border">Código</td>
								<td class="border">Descripción</td>
								<td class="border">Unidad de Medida</td>
								<td class="border">Grupo</td>
								<td class="border">Subgrupo</td>
								<td class="border">Envase</td>
								<!-- <td class="border">Envase Secundario</td> -->
								<td class="border">Marca</td>
								<td class="border">Cantidad Propuesta</td>
								<td class="border">Peso Propuesto</td>
								<td class="border">Peso Mínimo</td>
								<td class="border">Peso Máximo</td>
								<td class="border">Etiqueta</td>
								<td class="border">Fecha de creación</td>
								<td class="border">Creado por</td>
								<td class="border">Fecha de edición</td>
								<td class="border">Editado por</td>
								<td class="border">Activo</td>
								<td class="border text-center no-export" style="max-width: 150px;">Acciones</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($mercaderias as $mercaderia): ?>
								<tr class="text-start">
									<td class="border text-primary text-center"><?= htmlspecialchars($mercaderia['mercaderia_id']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['codigo']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['descripcion']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['unidad_medida']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['grupo']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['subgrupo']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['envase_pri']) ?></td>
									<!-- <td class="border text-primary"><?= htmlspecialchars($mercaderia['envase_sec']) ?></td> -->
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['marca']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['cantidad_propuesta']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['peso_propuesto']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['peso_min']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['peso_max']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['etiqueta_sec']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['creado_en']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['creado_por']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['editado_en']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($mercaderia['editado_por']) ?></td>
									<td class="border text-primary"><?= $mercaderia['activo'] == 1 ? 'Si' : 'No' ?></td>
									<td class="border text-primary text-center">
										<div class="d-flex no-wrap">
											<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
												data-bs-toggle="modal" 
												data-bs-target="#modalEditarMercaderia"
												data-id="<?= htmlspecialchars($mercaderia['mercaderia_id']) ?>"
												data-codigo="<?= htmlspecialchars($mercaderia['codigo']) ?>"
												data-descripcion="<?= htmlspecialchars($mercaderia['descripcion']) ?>"
												data-unidad="<?= htmlspecialchars($mercaderia['unidad_medida']) ?>"
												data-grupo="<?= htmlspecialchars($mercaderia['grupo']) ?>"
												data-subgrupo="<?= htmlspecialchars($mercaderia['subgrupo']) ?>"
												data-cantidadprop="<?= htmlspecialchars($mercaderia['cantidad_propuesta']) ?>"
												data-pesoprop="<?= htmlspecialchars($mercaderia['peso_propuesto']) ?>"
												data-pesomin="<?= htmlspecialchars($mercaderia['peso_min']) ?>"
												data-pesomax="<?= htmlspecialchars($mercaderia['peso_max']) ?>"
												data-envasepri="<?= htmlspecialchars($mercaderia['envase_pri']) ?>"
												data-envasesec="<?= htmlspecialchars($mercaderia['envase_sec']) ?>"
												data-marca="<?= htmlspecialchars($mercaderia['marca']) ?>"
												data-etiquetasec="<?= htmlspecialchars($mercaderia['etiqueta_sec']) ?>"
												data-activo="<?= htmlspecialchars($mercaderia['activo']) ?>">
												<i class="bi bi-pencil me-2"></i>Editar
											</a>
											<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
												data-bs-toggle="modal"
												data-bs-target="#modalEliminarMercaderia"
												data-id="<?= htmlspecialchars($mercaderia['mercaderia_id']) ?>"
												data-codigo="<?= htmlspecialchars($mercaderia['codigo']) ?>">
												<i class="bi bi-trash me-2"></i>Eliminar
											</a>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<!-- Modal de creación -->
					<div class="modal fade m-5" id="modalCrearMercaderia" tabindex="-1" aria-labelledby="modalCrearMercaderiaLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formCrearMercaderia" action="/trackpoint/public/index.php?route=/produccion/ABMs/mercaderias&crear">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalCrearMercaderiaLabel">Nueva Mercadería</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">

										<div class="mb-3">
											<div id="mensaje-error-crear" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
												<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<ul class="nav nav-tabs">
											<li class="nav-item">
												<a class="nav-link active p-2 text-primary" aria-current="page" id="datos-obligatorios-tab" data-bs-toggle="tab" href="#datos-obligatorios">Datos obligatorios</a>
											</li>
											<li class="nav-item">
												<a class="nav-link p-2 text-primary" id="datos-adicionales-tab" data-bs-toggle="tab" href="#datos-adicionales">Datos adicionales</a>
											</li>
											<!--<li class="nav-item">
												<a class="nav-link p-2 text-primary" id="datos-externos-tab" data-bs-toggle="tab" href="#datos-externos">Datos externos</a>
											</li> -->
										</ul>

										<div class="tab-content">
											<div class="tab-pane fade show active" id="datos-obligatorios" role="tabpanel" aria-labelledby="datos-obligatorios-tab">
												<div class="mb-3 pt-2">
													<label for="crearCodigoMercaderia" class="form-label text-primary">Código</label>
													<input type="text" class="form-control" name="codigo" id="crearCodigoMercaderia">
												</div>
											
												<div class="mb-3">
													<label for="crearDescripcionMercaderia" class="form-label text-primary">Descripción</label>
													<input type="text" class="form-control" name="descripcion" id="crearDescripcionMercaderia">
												</div>

												<div class="mb-3">
													<label for="crearUnidadMedidaMercaderia" class="form-label text-primary">Unidad de Medida</label>
													<select class="form-select" name="unidad_medida" id="crearUnidadMedidaMercaderia">
														<option value="Kg">Kg</option>
														<option value="Unidades">Unidades</option>
													</select>
												</div>
											</div>

											<div class="tab-pane fade" id="datos-adicionales" role="tabpanel" aria-labelledby="datos-adicionales-tab">
												<div class="mb-3 row align-items-center pt-2">
													<div class="col-md-6">
														<label for="crearGrupoMercaderia" class="form-label text-primary">Grupo</label>
														<input type="text" class="form-control" name="grupo" id="crearGrupoMercaderia">
													</div>
													<div class="col-md-6">
														<label for="crearSubgrupoMercaderia" class="form-label text-primary">Sub Grupo</label>
														<input type="text" class="form-control" name="subgrupo" id="crearSubgrupoMercaderia">
													</div>
												</div>
												<div class="mb-3 row align-items-center">
													<div class="col-md-6">
														<label for="crearEnvasePriMercaderia" class="form-label text-primary">Envase</label>
														<input type="text" class="form-control" name="envase_pri" id="crearEnvasePriMercaderia">
													</div>
													<div class="col-md-6">
														<label for="crearEnvaseSecMercaderia" class="form-label text-primary">Envase Secundario</label>
														<input type="text" class="form-control" name="envase_sec" id="crearEnvaseSecMercaderia">
													</div>
													<div class="col-md-6">
														<label for="crearMarcaMercaderia" class="form-label text-primary">Marca</label>
														<input type="text" class="form-control" name="marca" id="crearMarcaMercaderia">
													</div>
												</div>
												<div class="mb-3 row align-items-center">
													<div class="col-md-6">
														<label for="crearCantidadPropuestaMercaderia" class="form-label text-primary">Cantidad Propuesta</label>
														<input type="number" class="form-control" name="cantidad_propuesta" id="crearCantidadPropuestaMercaderia">
													</div>
													<div class="col-md-6">
														<label for="crearPesoPropuestoMercaderia" class="form-label text-primary">Peso Propuesto</label>
														<input type="number" class="form-control" name="peso_propuesto" id="crearPesoPropuestoMercaderia">
													</div>
												</div>
												<div class="mb-3 row align-items-center">
													<div class="col-md-6">
														<label for="crearPesoMinMercaderia" class="form-label text-primary">Peso Mínimo</label>
														<input type="number" class="form-control" name="peso_min" id="crearPesoMinMercaderia">
													</div>
													<div class="col-md-6">
														<label for="crearPesoMaxMercaderia" class="form-label text-primary">Peso Máximo</label>
														<input type="number" class="form-control" name="peso_max" id="crearPesoMaxMercaderia">
													</div>
												</div>
												<div class="mb-3 align-items-center">
													<label for="crearEtiquetaSecMercaderia" class="form-label text-primary">Etiqueta</label>
													<input type="text" class="form-control" name="etiqueta_sec" id="crearEtiquetaSecMercaderia">
												</div>
											</div>
										</div>
										<div class="modal-footer d-flex justify-content-center p-2">
											<button type="submit" class="btn btn-sm btn-success m-2" name="crear_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
											<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>

					<!-- Modal de edición -->
					<div class="modal fade m-5" id="modalEditarMercaderia" tabindex="-1" aria-labelledby="modalEditarMercaderiaLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEditarMercaderia" action="/trackpoint/public/index.php?route=/produccion/ABMs/mercaderias&editar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEditarMercaderiaLabel">Editar mercadería</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="mercaderia_id" id="editarMercaderiaId">

										<div class="mb-3">
											<div id="mensaje-error-editar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<ul class="nav nav-tabs">
											<li class="nav-item">
												<a class="nav-link active p-2 text-primary" aria-current="page" id="datos-obligatorios-tab" data-bs-toggle="tab" href="#datos-obligatorios">Datos obligatorios</a>
											</li>
											<li class="nav-item">
												<a class="nav-link p-2 text-primary" id="datos-adicionales-tab" data-bs-toggle="tab" href="#datos-adicionales">Datos adicionales</a>
											</li>
											<!--<li class="nav-item">
												<a class="nav-link p-2 text-primary" id="datos-externos-tab" data-bs-toggle="tab" href="#datos-externos">Datos externos</a>
											</li> -->
										</ul>

										<div class="tab-content">
											<div class="tab-pane fade show active" id="datos-obligatorios" role="tabpanel" aria-labelledby="datos-obligatorios-tab">
												<div class="mb-3 pt-2">
													<label for="editarCodigoMercaderia" class="form-label text-primary">Código</label>
													<input type="text" class="form-control" name="codigo" id="editarCodigoMercaderia">
												</div>
											
												<div class="mb-3">
													<label for="editarDescripcionMercaderia" class="form-label text-primary">Descripción</label>
													<input type="text" class="form-control" name="descripcion" id="editarDescripcionMercaderia">
												</div>

												<div class="mb-3">
													<label for="editarUnidadMedidaMercaderia" class="form-label text-primary">Unidad de Medida</label>
													<select class="form-select" name="unidad_medida" id="editarUnidadMedidaMercaderia">
														<option value="Kg">Kg</option>
														<option value="Unidades">Unidades</option>
													</select>
												</div>
												<div class="mb-3">
													<label for="editarActivoMercaderia" class="form-label text-primary">Activo</label>
													<select class="form-select" name="activo" id="editarActivoMercaderia">
														<option value="1">Sí</option>
														<option value="0">No</option>
													</select>
												</div>
											</div>

											<div class="tab-pane fade" id="datos-adicionales" role="tabpanel" aria-labelledby="datos-adicionales-tab">
												<div class="mb-3 row align-items-center pt-2">
													<div class="col-md-6">
														<label for="editarGrupoMercaderia" class="form-label text-primary">Grupo</label>
														<input type="text" class="form-control" name="grupo" id="editarGrupoMercaderia">
													</div>
													<div class="col-md-6">
														<label for="editarSubgrupoMercaderia" class="form-label text-primary">Sub Grupo</label>
														<input type="text" class="form-control" name="subgrupo" id="editarSubgrupoMercaderia">
													</div>
												</div>
												<div class="mb-3 row align-items-center pt-2">
													<div class="col-md-6">
														<label for="editarEnvasePriMercaderia" class="form-label text-primary">Envase</label>
														<input type="text" class="form-control" name="envase_pri" id="editarEnvasePriMercaderia">
													</div>
													<div class="col-md-6">
														<label for="editarEnvaseSecMercaderia" class="form-label text-primary">Envase Secundario</label>
														<input type="text" class="form-control" name="envase_sec" id="editarEnvaseSecMercaderia">
													</div>
													<div class="col-md-6">
														<label for="editarMarcaMercaderia" class="form-label text-primary">Marca</label>
														<input type="text" class="form-control" name="marca" id="editarMarcaMercaderia">
													</div>
												</div>
												<div class="mb-3 row align-items-center pt-2">
													<div class="col-md-6">
														<label for="editarCantidadPropuestaMercaderia" class="form-label text-primary">Cantidad Propuesta</label>
														<input type="number" class="form-control" name="cantidad_propuesta" id="editarCantidadPropuestaMercaderia">
													</div>
													<div class="col-md-6">
														<label for="editarPesoPropuestoMercaderia" class="form-label text-primary">Peso Propuesto</label>
														<input type="number" class="form-control" name="peso_propuesto" id="editarPesoPropuestoMercaderia">
													</div>
												</div>
												<div class="mb-3 row align-items-center pt-2">
													<div class="col-md-6">
														<label for="editarPesoMinMercaderia" class="form-label text-primary">Peso Mínimo</label>
														<input type="number" class="form-control" name="peso_min" id="editarPesoMinMercaderia">
													</div>
													<div class="col-md-6">
														<label for="editarPesoMaxMercaderia" class="form-label text-primary">Peso Máximo</label>
														<input type="number" class="form-control" name="peso_max" id="editarPesoMaxMercaderia">
													</div>
												</div>
												<div class="mb-3 align-items-center pt-2">
													<label for="editarEtiquetaSecMercaderia" class="form-label text-primary">Etiqueta</label>
													<input type="text" class="form-control" name="etiqueta_sec" id="editarEtiquetaSecMercaderia">
												</div>
											</div>
										</div>
										<div class="modal-footer d-flex justify-content-center p-2">
											<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
											<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>

					<!-- Modal de eliminación -->
					<div class="modal fade m-5" id="modalEliminarMercaderia" tabindex="-1" aria-labelledby="modalEliminarMercaderiaLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEliminarMercaderia" action="/trackpoint/public/index.php?route=/produccion/ABMs/mercaderias&eliminar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEliminarMercaderiaLabel">Eliminar mercadería</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="mercaderia_id" id="eliminarMercaderiaId">
										<input type="hidden" name="codigo" id="eliminarCodigoMercadería">

										<div class="mb-3">
											<div id="mensaje-error-eliminar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
												</div>
										</div>

										<div class="mb-3">
											<p>¿Está seguro que desea eliminar la mercadería?</p>
											<p>Esta acción no se puede deshacer.</p>
										</div>
									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-danger m-2" name="eliminar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Eliminar</button>
										<button type="button" class="btn btn-sm btn-secondary m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

			</main>
    </div>
  </div>
	
	<?php require_once __DIR__ . '/../../../layouts/layout.scripts.php'; ?>

  <!-- Script DataTables y modales -->
  <script src="/trackpoint/public/assets/js/menu_produccion/menu.produccion.js"></script>
  <script src="/trackpoint/public/assets/js/menu_produccion/abm.mercaderias.modales.js"></script>

</body>
</html>