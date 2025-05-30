<?php
require_once __DIR__ . '/../controllers/abm.permisosPorPerfil.controller.php';
require_once __DIR__ . '/../../../../core/config/constants.php';
?>

<script>
  const subtitulo = 'Permisos por perfil';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4 table-responsive">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2 text-primary">Permisos por Perfil</h2>
										<a href="#" class="btn btn-sm btn-primary"
											data-bs-toggle="modal" 
											data-bs-target="#modalSeleccionarPerfil">
											<i class="bi-check-circle me-2"></i>Seleccionar perfil
										</a>
									</div>
									<div>
										<h6 id="perfilSeleccionado" class="text-secondary mt-3"></h6>
									</div>
								</td>
							</tr>
							<tr>
								<td class="p-2">
									<!-- Tabla de Perfil seleccionado -->
									<?php if (isset($_SESSION['perfil_seleccionado'])): ?>
										<?php $perfilSeleccionado = $_SESSION['perfil_seleccionado']; ?>
										<script>
											const objetoSeleccionado = "<?= $perfilSeleccionado['nombre'] ?>";
										</script>
										<div class="mt-4">
											<table class="display pt-2 pb-4" style="width:100%">
												<thead class="table-primary">
													<tr class="text-light">
														<td class="border text-center">ID</td>
														<td class="border">Perfil</td>
														<td class="border">Descripción</td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="border text-primary text-center"><?= htmlspecialchars($perfilSeleccionado['perfil_id']) ?></td>
														<td class="border text-primary"><?= htmlspecialchars($perfilSeleccionado['nombre']) ?></td>
														<td class="border text-primary"><?= htmlspecialchars($perfilSeleccionado['descripcion']) ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									<?php endif; ?>
								</td>
							</tr>

							<tr>
								<td class="p-2">
									<!-- Tabla de Permisos -->
									<table id="miTablaConCheckbox" class="display pt-2 pb-4" style="width:100%">
										<thead class="table-primary">
											<tr class="text-light">
												<td class="border text-center">ID</td>
												<td class="border">Permiso</td>
												<td class="border">Descripción</td>
												<td class="border">Pantalla</td>
												<td class="border"><i class="bi-check-circle me-2"></i></td>
											</tr>
										</thead>
										<tbody>
											<?php $permisosAsignados = $permisosAsignados ?? []; ?>
											<?php foreach ($permisos as $permiso): ?>
												<?php $checked = in_array($permiso['permiso_id'], $permisosAsignados) ? 'checked' : ''; ?>
												<tr class="" data-permiso-id="<?= htmlspecialchars($permiso['permiso_id']) ?>">
													<td class="border text-primary text-center"><?= htmlspecialchars($permiso['permiso_id']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($permiso['nombre']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($permiso['descripcion']) ?></td>
													<td class="border text-primary"><?= htmlspecialchars($permiso['pantalla']) ?></td>
													<td class="border text-primary">
														<input type="checkbox" class="form-check-input checkbox-permiso check-export" data-permiso_id="<?= htmlspecialchars($permiso['permiso_id']) ?>"<?= $checked ?>>
														<input type="hidden" id="perfil_id" value="<?=$perfilSeleccionado['perfil_id']?>">
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</td>
							</tr>
					</table>

					<!-- Modal de selección de perfil -->
					<div class="modal fade m-5" id="modalSeleccionarPerfil" tabindex="-1" aria-labelledby="modalSeleccionarPerfilLabel" aria-hidden="true">
						<div class="modal-dialog d-flex">
							<form method="POST" id="formSeleccionarPerfil" action="/trackpoint/public/index.php?route=/configuracion/ABMs/permisosPorPerfil&seleccionar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalSeleccionarPerfilLabel">Seleccionar perfil</h5>
										<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
									</div>
									<div class="modal-body">

										<div class="mb-3">
											<div id="mensaje-error-seleccionar" class="alert alert-danger rounded d-none" role="alert">
												<i class="bi bi-exclamation-triangle-fill me-2"></i>
												<span class="mensaje-texto"></span>
												<!-- Mensajes de error que se cargarán de forma dinámica en el modal -->
											</div>
										</div>

										<div class="mb-3">
											<table id="miTablaEnModal" class="display pt-2 pb-4" style="width:100%">
												<thead class="table-primary">
													<tr class="text-light">
														<td class="border text-center">ID</td>
														<td class="border">Perfil</td>
														<td class="border">Descripción</td>
														<td class="border"><i class="bi-check-circle me-2"></i></td>
													</tr>
												</thead>
												<tbody>
												<?php foreach ($perfiles as $perfil): ?>
														<tr class="text-start">
															<td class="border text-primary"><?= htmlspecialchars($perfil['perfil_id']) ?></td>
															<td class="border text-primary"><?= htmlspecialchars($perfil['nombre']) ?></td>
															<td class="border text-primary"><?= htmlspecialchars($perfil['descripcion']) ?></td>
															<td class="border text-primary">
																<input type="radio" name="seleccion_perfil"
																	class="form-check-input seleccionar-perfil"
																	data-perfilid="<?= htmlspecialchars($perfil['perfil_id']) ?>"
																	data-nombre="<?= htmlspecialchars($perfil['nombre']) ?>"
																	data-descripcion="<?= htmlspecialchars($perfil['descripcion']) ?>">
															</td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>

										<!-- Campos ocultos para enviar en el form -->
										<input type="hidden" name="perfil_id" id="input-perfil-id">
										<input type="hidden" name="nombre" id="input-nombre">
										<input type="hidden" name="descripcion" id="input-descripcion">
									</div>
									<div class="modal-footer d-flex justify-content-center p-2">
										<button type="submit" class="btn btn-sm btn-success m-2" name="seleccionar_modal" ><i class="bi bi-check-circle pt-1 me-2"></i>Aceptar</button>
										<button type="button" class="btn btn-sm btn-danger m-2" data-bs-dismiss="modal"><i class="bi bi-x-circle pt-1 me-2"></i>Cancelar</button>
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
  <script src="/trackpoint/public/assets/js/menu_configuracion/abm.permisosPorPerfil.modales.js"></script>

</body>
</html>