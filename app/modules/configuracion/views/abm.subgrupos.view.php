<?php
require_once __DIR__ . '/../controllers/abm.subgrupos.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Subgrupos';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg p-4">
					<div class="d-flex justify-content-between align-items-center">
						<h2 class="text-primary">Subgrupos</h2>
						<a href="#" class="btn btn-sm btn-primary"
							data-bs-toggle="modal" 
							data-bs-target="#modalCrearSubgrupo">
							<i class="bi-plus-circle me-2"></i>Nuevo Subgrupo
						</a>
					</div>
					<table id="miTabla" class="display" style="width:100%">
						<thead class="table-primary">
							<tr class="text-light">
								<td class="border text-center">ID</td>
								<td class="border">Código</td>
								<td class="border">Descripción</td>
								<td class="border">Grupo</td>
								<td class="border">Fecha de creación</td>
								<td class="border">Creado por</td>
								<td class="border">Fecha de edición</td>
								<td class="border">Editado por</td>
								<td class="border">Activo</td>
								<td class="border text-center no-export" style="max-width: 150px;">Acciones</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($subgrupos as $subgrupo): ?>
								<tr class="text-start">
									<td class="border text-primary text-center"><?= htmlspecialchars($subgrupo['grupo_id']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($subgrupo['codigo']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($subgrupo['descripcion']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($subgrupo['grupo_id']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($subgrupo['creado_en']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($subgrupo['creado_por']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($subgrupo['editado_en']) ?></td>
									<td class="border text-primary"><?= htmlspecialchars($subgrupo['editado_por']) ?></td>
									<td class="border text-primary"><?= $subgrupo['activo'] == 1 ? 'Si' : 'No' ?></td>
									<td class="border text-primary text-center">
										<div class="d-flex no-wrap">
											<a href="#" class="btn btn-sm btn-warning mx-1 d-flex no-wrap"
												data-bs-toggle="modal" data-bs-target="#modalEditarSubgrupo"
												data-id="<?= htmlspecialchars($subgrupo['grupo_id']) ?>"
												data-codigo="<?= htmlspecialchars($subgrupo['codigo']) ?>"
												data-descripcion="<?= htmlspecialchars($subgrupo['descripcion']) ?>"
												data-activo="<?= htmlspecialchars($subgrupo['activo']) ?>">
												<i class="bi bi-pencil me-2"></i>Editar
											</a>
											<a href="#" class="btn btn-sm btn-danger mx-1 d-flex no-wrap"
												data-bs-toggle="modal" data-bs-target="#modalEliminarGrupo"
												data-id="<?= htmlspecialchars($subgrupo['grupo_id']) ?>"
												data-codigo="<?= htmlspecialchars($subgrupo['codigo']) ?>">
												<i class="bi bi-trash me-2"></i>Eliminar
											</a>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<!-- Modal de creación -->
					<div class="modal fade m-5" id="modalCrearSubgrupo" tabindex="-1" aria-labelledby="modalCrearSubgrupoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formCrearGrupo" action="/trackpoint/public/index.php?route=/configuracion/ABMs/subgrupos&crear">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalCrearSubgrupoLabel">Nuevo subgrupo</h5>
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
											<label for="crearCodigoGrupo" class="form-label text-primary">Código</label>
											<input type="text" class="form-control" name="codigo" id="crearCodigoGrupo">
										</div>

										<div class="mb-3">
											<label for="crearDescripcionGrupo" class="form-label text-primary">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="crearDescripcionGrupo">
										</div>

										<div class="mb-3">
											<label for="crearGrupoSubgrupo" class="form-label text-primary">Grupo</label>
											<select class="form-select" name="grupo_id" id="crearGrupoSubgrupo">
												<?php foreach ($grupos as $grupo): ?>
													<option value="<?= htmlspecialchars($grupo['grupo_id']) ?>"><?= htmlspecialchars($grupo['codigo']) ?></option>
												<?php endforeach; ?>
											</select>
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
					<div class="modal fade m-5" id="modalEditarSubgrupo" tabindex="-1" aria-labelledby="modalEditarSubgrupoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEditarGrupo" action="/trackpoint/public/index.php?route=/configuracion/ABMs/subgrupos&editar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEditarSubgrupoLabel">Editar subgrupo</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="subgrupo_id" id="editarSubgrupoId">

										<div class="mb-3">
											<div id="mensaje-error-editar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<label for="editarCodigoSubgrupo" class="form-label text-primary">Código</label>
											<input type="text" class="form-control" name="codigo" id="editarCodigoSubgrupo">
										</div>

										<div class="mb-3">
											<label for="editarDescripcionSubgrupo" class="form-label text-primary">Descripción</label>
											<input type="text" class="form-control" name="descripcion" id="editarDescripcionSubgrupo">
										</div>

										<div class="mb-3">
											<label for="editarActivoSubgrupo" class="form-label text-primary">Activo</label>
											<select class="form-select" name="activo" id="editarActivoSubgrupo">
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
					<div class="modal fade m-5" id="modalEliminarSubgrupo" tabindex="-1" aria-labelledby="modalEliminarSubgrupoLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" id="formEliminarSubgrupo" action="/trackpoint/public/index.php?route=/configuracion/ABMs/subgrupos&eliminar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalEliminarSubgrupoLabel">Eliminar subgrupo</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="subgrupo_id" id="eliminarSubgrupoId">
										<input type="hidden" name="codigo" id="eliminarCodigoSubgrupo">

										<div class="mb-3">
											<div id="mensaje-error-eliminar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
													<!-- Mensajes de error que se cargaran de forma dinámica en el modal -->
												</div>
										</div>

										<div class="mb-3">
											<p>¿Está seguro que desea eliminar el subgrupo?</p>
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
  <script src="/trackpoint/public/assets/js/menu_configuracion/abm.subgrupos.modales.js"></script>

</body>
</html>