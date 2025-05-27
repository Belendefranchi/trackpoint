<?php
require_once __DIR__ . '/../controllers/abm.permisos.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Permisos';
</script>

<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2 text-primary">Permisos</h2>
										<a href="#" class="btn btn-sm btn-primary"
											data-bs-toggle="modal" 
											data-bs-target="#modalCrearPermiso">
											<i class="bi-plus-circle me-2"></i>Nuevo Permiso
										</a>
									</div>
								</td>
							</tr>
							<tr>
								<td class="p-2">
									<table id="miTabla" class="display pt-2 pb-4" style="width:100%">
										<thead class="table-primary">
											<tr class="text-light">
												<td class="border">ID</td>
												<td class="border">Permiso</td>
												<td class="border">Descripción</td>
												<td class="border">Pantalla</td>
												<td class="border">Fecha de creación</td>
												<td class="border">Creado por</td>
												<td class="border">Fecha de edición</td>
												<td class="border">Editado por</td>
												<td class="border">Acciones</td>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($permisos as $permiso): ?>
												<tr class="text-start">
													<td class="border text-center"><?= htmlspecialchars($permiso['permiso_id']) ?></td>
													<td class="border"><?= htmlspecialchars($permiso['nombre']) ?></td>
													<td class="border"><?= htmlspecialchars($permiso['descripcion']) ?></td>
													<td class="border"><?= htmlspecialchars($permiso['pantalla']) ?></td>
													<td class="border"><?= htmlspecialchars($permiso['creado_en']) ?></td>
													<td class="border"><?= htmlspecialchars($permiso['creado_por']) ?></td>
													<td class="border"><?= htmlspecialchars($permiso['editado_en']) ?></td>
													<td class="border"><?= htmlspecialchars($permiso['editado_por']) ?></td>
													<td class="border text-center">
														<div class="d-flex no-wrap">
															<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
																data-bs-toggle="modal" 
																data-bs-target="#modalEditarPermiso"
																data-id="<?= htmlspecialchars($permiso['permiso_id']) ?>"
																data-nombre="<?= htmlspecialchars($permiso['nombre']) ?>"
																data-descripcion="<?= htmlspecialchars($permiso['descripcion']) ?>"
																data-pantalla="<?= htmlspecialchars($permiso['pantalla']) ?>">
																<i class="bi bi-pencil me-2"></i>Editar
															</a>
															<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
																data-bs-toggle="modal"
																data-bs-target="#modalEliminarPermiso"
																data-id="<?= htmlspecialchars($permiso['permiso_id']) ?>"
																data-nombre="<?= htmlspecialchars($permiso['nombre']) ?>">
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
					<div class="modal fade m-5" id="modalCrearPermiso" tabindex="-1" aria-labelledby="modalCrearPermisoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formCrearPermiso" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&crear">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalCrearPermisoLabel">Nuevo permiso</h5>
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
											<label for="crearNombrePermiso" class="form-label">Nombre</label>
											<input type="text" class="form-control" name="nombre" id="crearNombrePermiso">
										</div>

										<div class="mb-3">
											<label for="crearDescripcionPermiso" class="form-label">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="crearDescripcionPermiso">
										</div>

										<div class="mb-3">
											<label for="crearPantallaPermiso" class="form-label">Pantalla</label>
											<input type="text" class="form-control" name="pantalla" id="crearPantallaPermiso">
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
					<div class="modal fade m-5" id="modalEditarPermiso" tabindex="-1" aria-labelledby="modalEditarPermisoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEditarPermiso" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&editar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEditarPermisoLabel">Editar permiso</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="permiso_id" id="editarPermisoId">

										<div class="mb-3">
											<div id="mensaje-error-editar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<label for="editarNombrePermiso" class="form-label">Nombre</label>
											<input type="text" class="form-control" name="nombre" id="editarNombrePermiso">
										</div>

										<div class="mb-3">
											<label for="editarDescripcionPermiso" class="form-label">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="editarDescripcionPermiso">
										</div>

										<div class="mb-3">
										<label for="editarPantallaPermiso" class="form-label">Pantalla</label>
										<input type="text" class="form-control" name="pantalla" id="editarPantallaPermiso">
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
					<div class="modal fade m-5" id="modalEliminarPermiso" tabindex="-1" aria-labelledby="modalEliminarPermisoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEliminarPermiso" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisos&eliminar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEliminarPermisoLabel">Eliminar permiso</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="permiso_id" id="eliminarPermisoId">
										<input type="hidden" name="nombre" id="eliminarNombrePermiso">

										<div class="mb-3">
											<div id="mensaje-error-eliminar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
												</div>
										</div>

										<div class="mb-3">
											<p>¿Está seguro que desea eliminar el permiso?</p>
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
  <script src="/trackpoint/public/assets/js/menu_configuracion/menu.configuracion.js"></script>
  <script src="/trackpoint/public/assets/js/menu_configuracion/abm.permisos.modales.js"></script>

</body>
</html>