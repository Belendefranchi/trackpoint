<?php
require_once __DIR__ . '/../controllers/abm.procesos.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Procesos Productivos';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2 text-primary">Procesos Productivos</h2>
										<a href="#" class="btn btn-sm btn-primary"
											data-bs-toggle="modal" 
											data-bs-target="#modalCrearProceso">
											<i class="bi-plus-circle me-2"></i>Nuevo Proceso
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
												<td class="border">Fecha de creación</td>
												<td class="border">Creado por</td>
												<td class="border">Fecha de edición</td>
												<td class="border">Editado por</td>
												<td class="border">Activo</td>
												<td class="border text-center no-export">Acciones</td>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($procesos as $proceso): ?>
												<tr class="text-start">
													<td class="border text-primary text-center"><?= htmlspecialchars($proceso['proceso_id']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($proceso['codigo']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($proceso['descripcion']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($proceso['creado_en']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($proceso['creado_por']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($proceso['editado_en']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($proceso['editado_por']) ?></td>
													<td class="border text-primary"><?= $proceso['activo'] == 1 ? 'Si' : 'No' ?></td>
													<td class="border text-primary text-center">
														<div class="d-flex no-wrap">
															<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap">
																<i class="bi bi-pencil me-2"></i>Editar
															</a>
															<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap">
																<i class="bi bi-trash me-2"></i>Eliminar
															</a>
														</div>
														<div class="d-flex no-wrap">
															<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
																data-bs-toggle="modal" 
																data-bs-target="#modalEditarProceso"
																data-id="<?= htmlspecialchars($proceso['proceso_id']) ?>"
																data-codigo="<?= htmlspecialchars($proceso['codigo']) ?>"
																data-nombre="<?= htmlspecialchars($proceso['descripcion']) ?>"
																data-activo="<?= htmlspecialchars($proceso['activo']) ?>">
																<i class="bi bi-pencil me-2"></i>Editar
															</a>
															<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
																data-bs-toggle="modal"
																data-bs-target="#modalEliminarProceso"
																data-id="<?= htmlspecialchars($proceso['proceso_id']) ?>"
																data-codigo="<?= htmlspecialchars($proceso['codigo']) ?>">
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
					<div class="modal fade m-5" id="modalCrearProceso" tabindex="-1" aria-labelledby="modalCrearProcesoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formCrearProceso" action="/trackpoint/public/index.php?route=/produccion/ABMs/procesos&crear">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalCrearProcesoLabel">Nueva Proceso</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">

										<div class="mb-3">
											<div id="mensaje-error-crear" class="alert alert-danger rounded d-none" grupoe="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
												<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<label for="crearCodigoProceso" class="form-label text-primary">Código</label>
											<input type="text" class="form-control" name="codigo" id="crearCodigoProceso">
										</div>

										<div class="mb-3">
											<label for="crearDescripcionProceso" class="form-label text-primary">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="crearDescripcionProceso">
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
					<div class="modal fade m-5" id="modalEditarProceso" tabindex="-1" aria-labelledby="modalEditarProcesoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEditarproceso" action="/trackpoint/public/index.php?route=/produccion/ABMs/procesos&editar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEditarProcesoLabel">Editar Proceso</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="proceso_id" id="editarProcesoId">

										<div class="mb-3">
											<div id="mensaje-error-editar" class="alert alert-danger rounded d-none" grupoe="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<label for="editarCodigoProceso" class="form-label text-primary">Código</label>
											<input type="text" class="form-control" name="codigo" id="editarCodigoProceso">
										</div>

										<div class="mb-3">
											<label for="editarDescripcionProceso" class="form-label text-primary">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="editarDescripcionProceso">
										</div>

										<div class="mb-3">
											<label for="editarActivoProceso" class="form-label text-primary">Activo</label>
											<select class="form-select" name="activo" id="editarActivoProceso">
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
					<div class="modal fade m-5" id="modalEliminarProceso" tabindex="-1" aria-labelledby="modalEliminarProcesoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEliminarProceso" action="/trackpoint/public/index.php?route=/produccion/ABMs/procesos&eliminar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEliminarProcesoLabel">Eliminar Proceso</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="proceso_id" id="eliminarProcesoId">
										<input type="hidden" name="codigo" id="eliminarCodigoProceso">

										<div class="mb-3">
											<div id="mensaje-error-eliminar" class="alert alert-danger rounded d-none" grupoe="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
												</div>
										</div>

										<div class="mb-3">
											<p>¿Está seguro que desea eliminar el proceso?</p>
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
  <script src="/trackpoint/public/assets/js/menu_produccion/abm.procesos.modales.js"></script>

</body>
</html>