<?php
require_once __DIR__ . '/../controllers/abm.perfiles.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';
?>

<script>
  const subtitulo = 'Perfiles';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2 text-primary">Perfiles</h2>
										<a href="#" class="btn btn-sm btn-primary"
											data-bs-toggle="modal" 
											data-bs-target="#modalCrearPerfil">
											<i class="bi-plus-circle me-2"></i>Nuevo Perfil
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
												<td class="border text-center">Perfil</td>
												<td class="border text-center">Descripción</td>
												<td class="border text-center">Fecha de creación</td>
												<td class="border text-center">Creado por</td>
												<td class="border text-center">Fecha de edición</td>
												<td class="border text-center">Editado por</td>
												<td class="border text-center">Activo</td>
												<td class="border text-center no-export">Acciones</td>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($perfiles as $perfil): ?>
												<tr class="text-start">
													<td class="border text-center"><?= htmlspecialchars($perfil['perfil_id']) ?></td>
													<td class="border"><?= htmlspecialchars($perfil['nombre']) ?></td>
													<td class="border"><?= htmlspecialchars($perfil['descripcion']) ?></td>
													<td class="border"><?= htmlspecialchars($perfil['creado_en']) ?></td>
													<td class="border"><?= htmlspecialchars($perfil['creado_por']) ?></td>
													<td class="border"><?= htmlspecialchars($perfil['editado_en']) ?></td>
													<td class="border"><?= htmlspecialchars($perfil['editado_por']) ?></td>
													<td class="border text-center"><?= $perfil['activo'] == 1 ? 'Si' : 'No' ?></td>
													<td class="border">
														<div class="d-flex no-wrap">
															<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
																data-bs-toggle="modal" 
																data-bs-target="#modalEditarPerfil"
																data-id="<?= htmlspecialchars($perfil['perfil_id']) ?>"
																data-nombre="<?= htmlspecialchars($perfil['nombre']) ?>"
																data-descripcion="<?= htmlspecialchars($perfil['descripcion']) ?>"
																data-activo="<?= htmlspecialchars($perfil['activo']) ?>">
																<i class="bi bi-pencil me-2"></i>Editar
															</a>
															<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
																data-bs-toggle="modal"
																data-bs-target="#modalEliminarPerfil"
																data-id="<?= htmlspecialchars($perfil['perfil_id']) ?>"
																data-nombre="<?= htmlspecialchars($perfil['nombre']) ?>">
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
					<div class="modal fade m-5" id="modalCrearPerfil" tabindex="-1" aria-labelledby="modalCrearPerfilLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formCrearPerfil" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&crear">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalCrearPerfilLabel">Nuevo perfil</h5>
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
											<label for="crearNombrePerfil" class="form-label">Nombre</label>
											<input type="text" class="form-control" name="nombre" id="crearNombrePerfil">
										</div>

										<div class="mb-3">
											<label for="crearDescripcionPerfil" class="form-label">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="crearDescripcionPerfil">
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
					<div class="modal fade m-5" id="modalEditarPerfil" tabindex="-1" aria-labelledby="modalEditarPerfilLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEditarPerfil" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&editar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEditarPerfilLabel">Editar perfil</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="perfil_id" id="editarPerfilId">

										<div class="mb-3">
											<div id="mensaje-error-editar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<label for="editarNombrePerfil" class="form-label">Nombre</label>
											<input type="text" class="form-control" name="nombre" id="editarNombrePerfil">
										</div>

										<div class="mb-3">
											<label for="editarDescripcionPerfil" class="form-label">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="editarDescripcionPerfil">
										</div>

										<div class="mb-3">
											<label for="editarActivoPerfil" class="form-label">Activo</label>
											<select class="form-select" name="activo" id="editarActivoPerfil">
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
					<div class="modal fade m-5" id="modalEliminarPerfil" tabindex="-1" aria-labelledby="modalEliminarPerfilLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEliminarPerfil" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfiles&eliminar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEliminarPerfilLabel">Eliminar perfil</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="perfil_id" id="eliminarPerfilId">
										<input type="hidden" name="nombre" id="eliminarNombrePerfil">

										<div class="mb-3">
											<div id="mensaje-error-eliminar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
												</div>
										</div>

										<div class="mb-3">
											<p>¿Está seguro que desea eliminar el perfil?</p>
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
  <script src="/trackpoint/public/assets/js/menu_configuracion/menu.configuracion.DataTables.js"></script>
  <script src="/trackpoint/public/assets/js/menu_configuracion/abm.perfiles.modales.js"></script>

</body>
</html>