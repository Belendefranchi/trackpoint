<?php

	$presupuesto_id = $_POST['presupuesto_id'] ?? '';
	$fecha_presupuesto = $_POST['fecha_presupuesto'] ?? '';
	$cliente_nombre = $_POST['cliente_nombre'] ?? '';
	$cliente_direccion = $_POST['cliente_direccion'] ?? '';
	$cliente_contacto = $_POST['cliente_contacto'] ?? '';
	$plazo_entrega = $_POST['plazo_entrega'] ?? '';

	$categoriaCableado = [
		'opcion_camaras',
		'opcion_control_acceso',
		'opcion_cerradura',
		'opcion_fichas',
		'opcion_testeo'
	];

	$categoriaRack = [
		'opcion_rack',
		'opcion_patchpanel',
		'opcion_conexion_patchpanel',
		'opcion_linea_tension',
		'opcion_bandejas'
	];

	$mostrarCableado = false;
	$mostrarRack = false;

	foreach ($categoriaCableado as $check) {
		if (!empty($_POST[$check])) {
			$mostrarCableado = true;
			break;
		}
	}

	foreach ($categoriaRack as $check) {
		if (!empty($_POST[$check])) {
			$mostrarRack = true;
			break;
		}
	}

	$opciones = [
		[
			'check' => 'opcion_camaras',
			'texto' => 'Tendido de cables UTP para cámaras.',
			'cantidad' => trim($_POST['cantidad_camaras'] ?? ''),
			'label' => $_POST['cantidad_camaras'] === "1"
				? 'Tendido de cableado UTP para 1 cámara.'
				: 'Tendido de cableado UTP para ' . trim($_POST['cantidad_camaras'] ?? '') . ' cámaras.'
		],
		[
			'check' => 'opcion_control_acceso',
			'texto' => 'Tendido de cables UTP para control de acceso.',
			'cantidad' => trim($_POST['cantidad_control_acceso'] ?? ''),
			'label' => $_POST['cantidad_control_acceso'] === "1"
				? 'Tendido de cableado UTP para 1 control de acceso.'
				: 'Tendido de cableado UTP para ' . trim($_POST['cantidad_control_acceso'] ?? '') . ' controles de acceso.'
		],
		[
			'check' => 'opcion_cerradura',
			'texto' => 'Tendido de cables UTP para control de cerradura eléctrica.',
			'cantidad' => trim($_POST['cantidad_cerraduras'] ?? ''),
			'label' => $_POST['cantidad_cerraduras'] === "1"
				? 'Tendido de cableado UTP para 1 cerradura eléctrica.'
				: 'Tendido de cableado UTP para ' . trim($_POST['cantidad_cerraduras'] ?? '') . ' cerraduras eléctricas.'
		],
		[
			'check' => 'opcion_fichas',
			'texto' => '',
			'cantidad' => trim($_POST['cantidad_fichas'] ?? ''),
			'label' => $_POST['cantidad_fichas'] === "1"
				? 'Armado de ficha RJ45 en 1 cable UTP.'
				: 'Armado de fichas RJ45 en ' . trim($_POST['cantidad_fichas'] ?? '') . ' cables UTP.'
		],
		[
			'check' => 'opcion_rack',
			'texto' => 'Armado e instalación de rack mural.',
			'cantidad' => trim($_POST['cantidad_rack'] ?? ''),
			'label' => $_POST['cantidad_rack'] === "1"
				? 'Armado y sujeción física de 1 rack mural.'
				: 'Armado y sujeción física de  ' . trim($_POST['cantidad_rack'] ?? '') . ' racks murales.'
		],
		[
			'check' => 'opcion_patchpanel',
			'texto' => '',
			'cantidad' => trim($_POST['cantidad_patchpanel'] ?? ''),
			'label' => $_POST['cantidad_patchpanel'] === "1"
				? 'Instalación de 1 patch panel.'
				: 'Instalación de ' . trim($_POST['cantidad_patchpanel'] ?? '') . ' patchpanels.'
		],
		[
			'check' => 'opcion_conexion_patchpanel',
			'texto' => '',
			'cantidad' => trim($_POST['cantidad_conexion_patchpanel'] ?? ''),
			'label' => $_POST['cantidad_conexion_patchpanel'] === "1"
				? 'Conexión de 1 cable UTP al patch panel en uno de sus extremos.'
				: 'Conexión de ' . trim($_POST['cantidad_conexion_patchpanel'] ?? '') . ' cables UTP al patch panel en uno de sus extremos.'
		],
		[
			'check' => 'opcion_linea_tension',
			'texto' => '',
			'cantidad' => trim($_POST['cantidad_linea_tension'] ?? ''),
			'label' => $_POST['cantidad_linea_tension'] === "1"
				? 'Instalación de 1 línea de tensión con disyuntor térmico.'
				: 'Instalación de ' . trim($_POST['cantidad_linea_tension'] ?? '') . ' líneas de tensión con disyuntor térmico.'
		],
		[
			'check' => 'opcion_bandejas',
			'texto' => '',
			'cantidad' => trim($_POST['cantidad_bandejas'] ?? ''),
			'label' => $_POST['cantidad_bandejas'] === "1"
				? 'Instalación de 1 bandeja deslizable.'
				: 'Instalación de ' . trim($_POST['cantidad_bandejas'] ?? '') . ' bandejas deslizables.'
		],
		[
			'check' => 'opcion_testeo',
			'texto' => '',
			'cantidad' => trim($_POST['cantidad_testeo'] ?? ''),
			'label' => 'Testeo de continuidad y verificación del correcto funcionamiento de los cables.'
		]
	];

	?>

	<div class="documento">

		<table width="100%" border="0" cellspacing="0" cellpadding="10" style="border:1.5px solid #5aa9e6">
			<tr>
				<td width="18%" align="center" valign="middle" style="border-right:1.5px solid #5aa9e6">
					<img src="<?= $logoBase64 ?>" alt="Logo" width="50">
				</td>

				<td width="64%" align="center" valign="middle" style="border-right:1.5px solid #5aa9e6">
					<h1 style="margin:0; color: #2d2d69; font-size: x-large;">PUNTO SEGURO</h1>
					<p style="margin:5px 0 0 0; color: #5aa9e6; font-size: small; font-weight: bold;">SERVICIOS IT &amp; SOPORTE TÉCNICO</p>
				</td>

				<td width="18%" align="center" valign="middle">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center">
								<?= htmlspecialchars($fecha_presupuesto) ?>
							</td>
						</tr>
						<tr>
							<td align="center">
								N° <?= htmlspecialchars($presupuesto_id) ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!-- CONTENIDO -->
		<div class="content">

			<div class="section-title">
				DATOS DEL CLIENTE
			</div>
			<div style="padding-bottom: 10px;">
				<strong>Razón Social:</strong>
				<?= htmlspecialchars($cliente_nombre) ?>
			</div>

			<div style="padding-bottom: 10px;">
				<strong>Dirección de instalación:</strong>
				<?= htmlspecialchars($cliente_direccion) ?>
			</div>

			<div style="padding-bottom: 10px;">
				<strong>Contacto:</strong>
				<?= htmlspecialchars($cliente_contacto) ?>
			</div>

			<div class="section-title">
				PROPUESTA COMERCIAL
			</div>

			<div class="paragraph">
				De nuestra mayor consideración:
			</div>

			<div class="paragraph">
				Por medio de la presente, ponemos a su consideración nuestra propuesta para:
			</div>

			<?php foreach ($opciones as $opcion): ?>
				<?php if (!empty($opcion['texto']) && !empty($_POST[$opcion['check']])): ?>
					<div style="padding-left:20px">
						<span style="font-size: 1.5rem;">•</span>
						<?= htmlspecialchars($opcion['texto']) ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			<br>
			<div class="paragraph">
				Quedamos a su disposición para brindar cualquier información adicional que consideren necesaria. Los saludamos
				atentamente.
			</div>

			<div>
				<img src="<?= $firmaBase64 ?>" alt="Firma" class="signature">
			</div>

			<div class="section-title">
				ALCANCE DE LA PROPUESTA
			</div>

			<?php if ($mostrarCableado): ?>

				<div class="section-subtitle">
					1. CABLEADO UTP + ARMADO DE FICHAS
				</div>

				<?php foreach ($opciones as $opcion): ?>

					<?php if (
						in_array($opcion['check'], $categoriaCableado, true)
						&& !empty($_POST[$opcion['check']])
					): ?>

						<div style="padding-left:20px">
							<span style="font-size: 1.5rem;">•</span>
							<?= htmlspecialchars($opcion['label']) ?>
						</div>

					<?php endif; ?>

				<?php endforeach; ?>

			<?php endif; ?>

			<?php if ($mostrarRack): ?>

				<div class="section-subtitle">
					2. ARMADO + INSTALACIÓN RACK MURAL
				</div>

				<?php foreach ($opciones as $opcion): ?>

					<?php if (
						in_array($opcion['check'], $categoriaRack, true)
						&& !empty($_POST[$opcion['check']])
					): ?>

						<div style="padding-left:20px">
							<span style="font-size: 1.5rem;">•</span>
							<?= htmlspecialchars($opcion['label']) ?>
						</div>

					<?php endif; ?>

				<?php endforeach; ?>

			<?php endif; ?>

			<div class="section-title">
				PLAZOS DE ENTREGA
			</div>

			<div class="paragraph">
				El plazo de entrega para la ejecución de los trabajos es de
				<?= htmlspecialchars($plazo_entrega) ?> días hábiles, contados a partir de la fecha de aprobación del
				presupuesto.
			</div>

		</div>