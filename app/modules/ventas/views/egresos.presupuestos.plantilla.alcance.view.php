<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/trackpoint/public/assets/css/alcance.style.css">
	<link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_blanco.png" type="image/x-icon" />

	<title>Alcance</title>

</head>

<body>
	<?php
	$presupuesto_id = $_POST['presupuesto_id'] ?? '';
	$fecha_presupuesto = $_POST['fecha_presupuesto'] ?? '';
	$cliente_nombre = $_POST['cliente_nombre'] ?? '';
	$cliente_direccion = $_POST['cliente_direccion'] ?? '';
	$cliente_contacto = $_POST['cliente_contacto'] ?? '';
	$plazo_entrega = $_POST['plazo_entrega'] ?? '';

	$opciones = [

		[
			'check' => 'opcion_camaras',
			'texto' => 'Tendido de cables UTP para cámaras.',
			'cantidad' => trim($_POST['cantidad_camaras'] ?? ''),
			'label' => 'Tendido de cableado UTP para ' . trim($_POST['cantidad_camaras'] ?? '') . ' cámaras.'
		],

		[
			'check' => 'opcion_control_acceso',
			'texto' => 'Tendido de cables UTP para control de acceso.',
			'cantidad' => trim($_POST['cantidad_control_acceso'] ?? ''),
			'label' => 'Tendido de cableado UTP para ' . trim($_POST['cantidad_control_acceso'] ?? '') . ' controles de acceso.'
		],

		[
			'check' => 'opcion_cerradura',
			'texto' => 'Tendido de cables UTP para control de cerradura eléctrica.',
			'cantidad' => trim($_POST['cantidad_cerraduras'] ?? ''),
			'label' => 'Tendido de cableado UTP para ' . trim($_POST['cantidad_cerraduras'] ?? '') . ' cerraduras eléctricas.'
		],

		[
			'check' => 'opcion_patchpanel',
			'texto' => 'Conexión a patchpanel.',
			'cantidad' => trim($_POST['cantidad_patchpanel'] ?? ''),
			'label' => 'Conexión de ' . trim($_POST['cantidad_patchpanel'] ?? '') . ' cables UTP al patch panel en uno de sus extremos.'
		],

		[
			'check' => 'opcion_fichas',
			'texto' => 'Armado de fichas RJ45 en cables UTP.',
			'cantidad' => trim($_POST['cantidad_fichas'] ?? ''),
			'label' => 'Armado de fichas RJ45 en ' . trim($_POST['cantidad_fichas'] ?? '') . ' cables UTP.'
		],

		[
			'check' => 'opcion_rack',
			'texto' => 'Armado e instalación de rack mural.',
			'cantidad' => trim($_POST['cantidad_rack'] ?? ''),
			'label' => 'Armado y sujeción física de rack.
									Instalación de línea de tensión con disyuntor térmico.
									Instalación de bandejas deslizables.'
		],

		[
			'check' => 'opcion_testeo',
			'texto' => 'Testeos de conectividad.',
			'cantidad' => trim($_POST['cantidad_testeo'] ?? ''),
			'label' => 'Cantidad de testeos'
		]

	];
	?>

	<div class="documento">

		<!-- ENCABEZADO -->
		<div class="header">

			<div class="logo-box">
				<img src="/trackpoint/public/assets/images/logo_fondo_blanco.png" alt="Logo">
			</div>

			<div class="center-box">
				<h1>PUNTO SEGURO</h1>
				<p>SERVICIOS IT &amp; SOPORTE TÉCNICO</p>
			</div>

			<div class="right-box">
				<div class="fecha">
					<?= htmlspecialchars($fecha_presupuesto) ?>
				</div>
				<div class="numero">N°
					<?= htmlspecialchars($presupuesto_id) ?>
				</div>
			</div>

		</div>

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

			<ul>
				<?php foreach ($opciones as $opcion): ?>
					<?php if (!empty($_POST[$opcion['check']])): ?>
						<li>
							<?= htmlspecialchars($opcion['texto']) ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>

			<div class="paragraph">
				Quedamos a su disposición para brindar cualquier información adicional que consideren necesaria. Los saludamos atentamente.
			</div>

			<div>
				<img src="/trackpoint/public/assets/images/firma.png" alt="Firma" class="signature">
			</div>

			<div class="section-title">
				ALCANCE DE LA PROPUESTA
			</div>

			<div class="section-subtitle">
				1. CABLEADO UTP + CONEXIÓN A PATCH PANEL
			</div>
			<div class="section-subtitle">
				2. ARMADO + INSTALACIÓN RACK MURAL
			</div>

			<?php foreach ($opciones as $opcion): ?>

				<?php if (!empty($_POST[$opcion['check']])): ?>

					<?php if (!empty($opcion['cantidad'])): ?>

						<div class="paragraph">
							•
							<?= htmlspecialchars($opcion['label']) ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>

			<div class="section-title">
				PLAZOS DE ENTREGA
			</div>
			
			<div class="paragraph">
				El plazo de entrega para la ejecución de los trabajos es de
				<?= htmlspecialchars($plazo_entrega) ?> días hábiles, contados a partir de la fecha de aprobación del presupuesto.
		</div>

	</div>

</body>

</html>