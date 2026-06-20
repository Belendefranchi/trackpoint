<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/trackpoint/public/assets/css/presupuesto.style.css">
	<link rel="icon" href="/trackpoint/public/assets/images/logo_fondo_blanco.png" type="image/x-icon" />

	<?php foreach ($resumenPresupuesto as $filaResumen): ?>
	<title>Presupuesto Nº <?= $filaResumen['presupuesto_id'] ?? '' ?></title>
	<?php endforeach; ?>

</head>

<body>
	<header>
		<table>
			<tr>
				<td></td>
			</tr>
		</table>
	</header>
	
	<main>
		<?php foreach ($resumenPresupuesto as $filaResumen): ?>

			<table style="width:100%; border-collapse:collapse;">
				<tr>
					<!-- LOGO EMPRESA -->
					<td style="width:50%; vertical-align:center; text-align:left; padding-bottom:4mm;">
						<img src="/trackpoint/public/assets/images/logo_completo2.png" alt="Logo Empresa">
					</td>
					<!-- NRO PRESUPUESTO -->
					<td style="width:50%; vertical-align:center; text-align:right; font-size:16px; color: #24265d; padding-bottom:2mm;">
						<div style="font-size:32px; font-weight:900;">
							PRESUPUESTO
						</div>

						<div style="font-size:22px; font-weight:bold;">
							Nº 002 - <?= $filaResumen['presupuesto_id'] ?? 'Nº Presupuesto' ?>
						</div>
					</td>
				</tr>
				<tr>
					<!-- CLIENTE -->
					<td style="width:50%; vertical-align:top;">
						<div style="font-size:14px; font-weight:bold; color: #24265d;">
							CLIENTE
						</div>

						<div style="font-size:12px; margin-top:2mm; color: #737373;">
							<?= $filaResumen['cliente_nombre'] ?? 'Nombre Cliente' ?><br>
							<?= $filaResumen['cliente_direccion'] ?? 'Dirección Cliente' ?>
						</div>
					</td>
					<!-- FECHAS -->
					<td style="width:50%; vertical-align:center; text-align: right;">
						<table style="border-collapse:collapse; text-align: right;">
							<tr style="font-size:14px; font-weight:bold; text-align: right;">
								<td style="width:70%; color: #24265d; padding: 0mm;">FECHA:</td>
								<td style="color: #737373; padding: 0mm;">
									<?= $filaResumen['fecha_presupuesto'] ?>
								</td>
							</tr>
							<tr style="font-size:14px; font-weight:bold; text-align: right;">
								<td style="width:70%; color: #24265d; padding: 0mm;">VENCIMIENTO:</td>
								<td style="color: #737373; padding: 0mm;">
									<?= $filaResumen['fecha_vencimiento'] ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<!-- PERSONA DE CONTACTO -->
					<td style="width:50%; vertical-align:top;">
						<div style="font-size:14px; font-weight:bold; color: #24265d;">
							PERSONA DE CONTACTO
						</div>

						<div style="font-size:12px; color: #737373; margin-top:2mm;">
							<?= $filaResumen['contacto_cliente'] ?? 'Nombre Cliente' ?><br>
							<?= $filaResumen['cliente_telefono'] ?? 'Teléfono Cliente' ?>
						</div>
					</td>
					<!-- DATOS DE PAGO -->
					<td style="width:50%; font-size:14px; font-weight:bold; text-align:right; vertical-align:top;">
						<div style="color: #24265d;">
							DATOS DE PAGO
						</div>

						<div style="color: #737373; margin-top:2mm;">
							BANCO GALICIA<br>
							PUNTOSEGURO.AR
						</div>
					</td>
				</tr>
			</table>

			<!-- DETALLE -->
			<div class="tabla-detalle">

				<table style="font-size:12px; border-collapse: collapse;" class="tabla-detalle">
					<thead>
						<tr style="color: white;">
							<td style="width:  5%; background-color: #51AEE5; text-align:center;">#</td>
							<td style="width: 45%; background-color: #51AEE5; text-align:center;">DESCRIPCIÓN</td>
							<td style="width: 20%; background-color: #51AEE5; text-align:center;">PRECIO</td>
							<td style="width: 10%; background-color: #51AEE5; text-align:center;">CANTIDAD</td>
							<td style="width: 20%; background-color: #51AEE5; text-align:center;">TOTAL</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($mercaderias as $i => $item): ?>
							<tr style="color: #737373;">
								<td style="width: 5%; text-align:center;"><?= $i + 1 ?></td>
								<td style="width: 45%; text-align:left;"><?= $item['descripcion_mercaderia'] ?></td>
								<td style="width: 20%; text-align:center;">$ <?= number_format($item['precio_venta'], 2, ',', '.') ?></td>
								<td style="width: 10%; text-align:center;"><?= $item['cantidad'] ?></td>
								<td style="width: 20%; text-align:center;">$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<div class="tabla-totales">
				<table>
					<tr>
						<td>
							
						</td>
						<td style="width: 45%; padding-bottom: 0; padding-top: 0;">
							<div class="bloque-totales">
								<table style="width: 100%; font-size:12px;">
									<tr style="color: #737373;">
										<td style="padding: 4mm;">Subtotal</td>
										<td style="text-align: right; padding: 4mm;">$ <?= number_format($filaResumen['total'], 2, ',', '.') ?></td>
									</tr>
									<tr style="color: white;">
										<td style="background-color: #51AEE5; padding: 4mm;">TOTAL</td>
										<td style="background-color: #51AEE5; padding: 4mm; text-align: right;">$ <?= number_format($filaResumen['total'], 2, ',', '.') ?></td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="bloque-final">
				<table>
					<tr>
						<td style="width: 50%; vertical-align: bottom; padding-top: 0;">
							<div style="font-size:14px; font-weight:bold; color: #24265d; text-align:left;">
								CONDICIONES DE PAGO
							</div>
							<div style="font-size:12px; font-weight:bold; color: #737373; margin-top:2mm; text-align:left;">
								Pago contra entrega.<br>
								CONTADO
							</div><br>

							<div style="font-size:14px; font-weight:bold; color: #24265d; text-align:left;">
								OTROS DETALLES
							</div>
							<div style="font-size:12px; font-weight:bold; color: #737373; margin-top:2mm; text-align:left;">
								El presente presupuesto se acompaña de<br>
								una hoja con las aclaraciones sobre su<br>
								alcance.<br>
								Cualquier solicitud adicional no incluida<br>
								en el mismo, así como los materiales<br>
								derivados, será presupuestada por<br>
								separado.<br>
								Se otorga una garantía de treinta (30) días<br>
								sobre los trabajos realizados.
							</div><br>

							<div style="font-size:14px; font-weight:bold; color: #24265d; text-align:left;">
								VENDEDOR
							</div>
							<div style="font-size:12px; font-weight:bold; color: #737373; margin-top:2mm; text-align:left;">
								JUAN<br>
								11 6527 2617
							</div>
						</td>

						<td style="width: 50%; vertical-align: bottom; padding-top: 0;">
							<div style="background-color: #ecf9ff; padding: 6mm;">
								<!-- DATOS PUNTO CONECTADO -->
								<table style="width:100%; font-size: 14px; font-weight:bold; color: #737373;">
									<tr>
										<td style="padding: 1mm;">
											<img src="/trackpoint/public/assets/images/arroba.png">
										</td>
										<td style="padding: 2mm; text-align:left;">
											INFO@PUNTOCONECTADO.COM.AR
										</td>
									</tr>
									<tr>
										<td style="padding: 1mm;">
										<img src="/trackpoint/public/assets/images/telefono.png">
										</td>
										<td style="padding: 2mm; text-align:left;">
											11 6527 2617 | 2281 51 0754
										</td>
									</tr>

									<tr>
										<td style="padding: 1mm;">
											<img src="/trackpoint/public/assets/images/ubicacion.png">
										</td>
										<td style="padding: 2mm; text-align:left;">
											LOS POLVORINES & AZUL
										</td>
									</tr>

									<tr>
										<td style="padding: 1mm;">
											<img src="/trackpoint/public/assets/images/web.png">
										</td>
										<td style="padding: 2mm; text-align:left;">
											WWW.PUNTOCONECTADO.COM.AR
										</td>
									</tr>

									<tr>
										<td style="padding: 1mm;">
											<img src="/trackpoint/public/assets/images/instagram.png">
										</td>
										<td style="padding: 2mm; text-align:left;">
											PUNTOCONECTADO.COM.AR
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
		<?php endforeach; ?>
	</main>

	<footer>
		<table>
			<tr>
				<td></td>
			</tr>
		</table>
	</footer>
</body>

</html>