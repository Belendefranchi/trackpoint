<?php
require_once __DIR__ . '/../controllers/abm.mercaderias.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Mercaderías';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2 text-primary">Mercaderías</h2>
										<a href="#" class="btn btn-sm btn-primary"
											data-bs-toggle="modal" 
											data-bs-target="#modalCrearMercaderia">
											<i class="bi-plus-circle me-2"></i>Nueva Mercadería
										</a>
									</div>
								</td>
							</tr>
							<tr>
								<td class="p-2">
									<table id="miTabla" class="display pt-2 pb-4" style="width:100%">
										<thead class="table-primary">
											<tr class="text-light">
												<td class="border text-center">ID</td>
												<td class="border">Código</td>
												<td class="border">Descripción</td>
												<td class="border">Familia</td>
												<td class="border">Grupo</td>
												<td class="border">Sub Grupo</td>
												<td class="border">Unidad de Medida</td>
												<td class="border">Fecha de creación</td>
												<td class="border">Creado por</td>
												<td class="border">Fecha de edición</td>
												<td class="border">Editado por</td>
												<td class="border">Activo</td>
												<td class="border text-center no-export">Acciones</td>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($mercaderias as $mercaderia): ?>
												<tr class="text-start">
													<td class="border text-primary text-center"><?= htmlspecialchars($mercaderia['mercaderia_id']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($mercaderia['codigo']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($mercaderia['descripcion']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($mercaderia['familia']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($mercaderia['grupo']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($mercaderia['subgrupo']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($mercaderia['unidad_medida']) ?></td>
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
																data-familia="<?= htmlspecialchars($mercaderia['familia']) ?>"
																data-grupo="<?= htmlspecialchars($mercaderia['grupo']) ?>"
																data-subgrupo="<?= htmlspecialchars($mercaderia['subgrupo']) ?>"
																data-unidad="<?= htmlspecialchars($mercaderia['unidad_medida']) ?>"
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
								</td>
							</tr>
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

										<div class="mb-3">
											<label for="crearCodigoMercaderia" class="form-label text-primary">Código</label>
											<input type="text" class="form-control" name="codigo" id="crearCodigoMercaderia">
										</div>

										<div class="mb-3">
											<label for="crearDescripcionMercaderia" class="form-label text-primary">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="crearDescripcionMercaderia">
										</div>

										<div class="mb-3">
											<label for="crearFamiliaMercaderia" class="form-label text-primary">Familia</label>
											<input type="text" class="form-control" name="familia" id="crearFamiliaMercaderia">
										</div>

										<div class="mb-3">
											<label for="crearGrupoMercaderia" class="form-label text-primary">Grupo</label>
											<input type="text" class="form-control" name="grupo" id="crearGrupoMercaderia">
										</div>

										<div class="mb-3">
											<label for="crearSubGrupoMercaderia" class="form-label text-primary">Sub Grupo</label>
											<input type="text" class="form-control" name="subgrupo" id="crearSubGrupoMercaderia">
										</div>

										<div class="mb-3">
											<label for="crearUnidadMedidaMercaderia" class="form-label text-primary">Unidad de Medida</label>
											<input type="text" class="form-control" name="unidad_medida" id="crearUnidadMedidaMercaderia">
										</div>

									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="crear_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
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

										<div class="mb-3">
											<label for="editarCodigoMercaderia" class="form-label text-primary">Código</label>
											<input type="text" class="form-control" name="codigo" id="editarCodigoMercaderia">
										</div>

										<div class="mb-3">
											<label for="editarDescripcionMercaderia" class="form-label text-primary">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="editarDescripcionMercaderia">
										</div>

										<div class="mb-3">
											<label for="editarFamiliaMercaderia" class="form-label text-primary">Familia</label>
											<input type="text" class="form-control" name="familia" id="editarFamiliaMercaderia">
										</div>

										<div class="mb-3">
											<label for="editarGrupoMercaderia" class="form-label text-primary">Grupo</label>
											<input type="text" class="form-control" name="grupo" id="editarGrupoMercaderia">
										</div>

										<div class="mb-3">
											<label for="editarSubgrupoMercaderia" class="form-label text-primary">Sub Grupo</label>
											<input type="text" class="form-control" name="subgrupo" id="editarSubgrupoMercaderia">
										</div>

										<div class="mb-3">
											<label for="editarUnidadMedidaMercaderia" class="form-label text-primary">Unidad de Medida</label>
											<input type="text" class="form-control" name="unidad_medida" id="editarUnidadMedidaMercaderia">
										</div>

										<div class="mb-3">
											<label for="editarActivoMercaderia" class="form-label text-primary">Activo</label>
											<select class="form-select" name="activo" id="editarActivoMercaderia">
												<option value="1">Sí</option>
												<option value="0">No</option>
											</select>
										</div>
									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="editar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Guardar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
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
										<input type="hidden" name="codigo" id="eliminarcodigoMercadería">

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