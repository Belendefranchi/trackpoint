<?php
require_once __DIR__ . '/../controllers/abm.perfilesPorOperador.controller.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once __DIR__ . '/../../../../core/permisos.php';

?>

<script>
  const subtitulo = 'Perfiles por Operador';
</script>

				<div class="bg-white bg-body-tertiary rounded shadow-lg mt-2 p-4 table-responsive">
					<table>
							<tr>
								<td>
									<div class="d-flex justify-content-between align-items-center pe-2">
										<h2 class="ms-2 text-primary">Perfiles por Operador</h2>
										<a href="#" class="btn btn-sm btn-primary"
											data-bs-toggle="modal" 
											data-bs-target="#modalSeleccionarOperador">
											<i class="bi-check-circle me-2"></i>Seleccionar operador
										</a>
									</div>
									<div>
										<h6 id="operadorSeleccionado" class="text-secondary mt-3"></h6>
									</div>
								</td>
							</tr>
							<tr>
								<td class="p-2">
									<!-- Tabla de Operador seleccionado -->
									<?php if (isset($_SESSION['operador_seleccionado'])): ?>
										<?php $operadorSeleccionado = $_SESSION['operador_seleccionado']; ?>
										<div class="mt-4">
											<table class="display pt-2 pb-4" style="width:100%">
												<thead class="table-primary">
													<tr class="text-light">
														<td class="border text-center">ID</td>
														<td class="border">Operador</td>
														<td class="border">Nombre y Apellido</td>
														<td class="border">Email</td>
														<td class="border">Rol</td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="border text-center"><?= htmlspecialchars($operadorSeleccionado['operador_id']) ?></td>
														<td class="border"><?= htmlspecialchars($operadorSeleccionado['username']) ?></td>
														<td class="border"><?= htmlspecialchars($operadorSeleccionado['nombre_completo']) ?></td>
														<td class="border"><?= htmlspecialchars($operadorSeleccionado['email']) ?></td>
														<td class="border"><?= htmlspecialchars($operadorSeleccionado['rol']) ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									<?php endif; ?>
								</td>
							</tr>

							<tr>
								<td class="p-2">
									<!-- Tabla de Perfiles -->
									<table id="miTabla" class="display pt-2 pb-4" style="width:100%">
										<thead class="table-primary">
											<tr class="text-light">
												<td class="border text-center">ID</td>
												<td class="border">Perfil</td>
												<td class="border">Descripción</td>
												<td class="border"><i class="bi-check-circle me-2"></i></td>
											</tr>
										</thead>
										<tbody>
											<?php $perfilesAsignados = $perfilesAsignados ?? []; ?>
											<?php foreach ($perfiles as $perfil): ?>
												<?php $checked = in_array($perfil['perfil_id'], $perfilesAsignados) ? 'checked' : ''; ?>
												<tr class="" data-perfil-id="<?= htmlspecialchars($perfil['perfil_id']) ?>">
													<td class="border text-center"><?= htmlspecialchars($perfil['perfil_id']) ?></td>
													<td class="border"><?= htmlspecialchars($perfil['nombre']) ?></td>
													<td class="border"><?= htmlspecialchars($perfil['descripcion']) ?></td>
													<td class="border">
														<input type="checkbox" class="form-check-input checkbox-perfil" data-perfil_id="<?= htmlspecialchars($perfil['perfil_id']) ?>"<?= $checked ?>>
														<input type="hidden" id="operador_id" value="<?=$operadorSeleccionado['operador_id']?>">
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</td>
							</tr>
					</table>

					<!-- Modal de selección de operador -->
					<div class="modal fade m-5" id="modalSeleccionarOperador" tabindex="-1" aria-labelledby="modalSeleccionarOperadorLabel" aria-hidden="true">
						<div class="modal-dialog d-flex">
							<form method="POST" id="formSeleccionarOperador" action="/trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador&seleccionar">
								<div class="modal-content m-5">
									<div class="modal-header table-primary text-white">
										<h5 class="modal-title" id="modalSeleccionarOperadorLabel">Seleccionar operador</h5>
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
														<td class="border">Usuario</td>
														<td class="border">Nombre</td>
														<td class="border">Email</td>
														<td class="border">Rol</td>
														<td class="border"><i class="bi-check-circle me-2"></i></td>
													</tr>
												</thead>
												<tbody>
												<?php foreach ($operadores as $operador): ?>
														<tr class="text-start">
															<td class="border"><?= htmlspecialchars($operador['operador_id']) ?></td>
															<td class="border"><?= htmlspecialchars($operador['username']) ?></td>
															<td class="border"><?= htmlspecialchars($operador['nombre_completo']) ?></td>
															<td class="border"><?= htmlspecialchars($operador['email']) ?></td>
															<td class="border"><?= htmlspecialchars($operador['rol']) ?></td>
															<td class="border">
																<input type="radio" name="seleccion_operador"
																	class="form-check-input seleccionar-operador"
																	data-operadorid="<?= htmlspecialchars($operador['operador_id']) ?>"
																	data-username="<?= htmlspecialchars($operador['username']) ?>"
																	data-nombre="<?= htmlspecialchars($operador['nombre_completo']) ?>"
																	data-email="<?= htmlspecialchars($operador['email']) ?>"
																	data-rol="<?= htmlspecialchars($operador['rol']) ?>">
															</td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>

										<!-- Campos ocultos para enviar en el form -->
										<input type="hidden" name="operador_id" id="input-operador-id">
										<input type="hidden" name="username" id="input-username">
										<input type="hidden" name="nombre_completo" id="input-nombre">
										<input type="hidden" name="email" id="input-email">
										<input type="hidden" name="rol" id="input-rol">
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
  <script src="/trackpoint/public/assets/js/menu_configuracion/abm.perfilesPorOperador.modales.js"></script>

</body>
</html>