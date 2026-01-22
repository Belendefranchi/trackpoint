<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 30px; color: #333; }
    .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
    .logo { width: 150px; }
    .company-info { text-align: right; font-size: 11px; line-height: 1.4; }
    h1 { text-align: center; font-size: 18px; margin: 0 0 10px; text-transform: uppercase; }
    .info-table, .details-table, .totals { width: 100%; border-collapse: collapse; font-size: 12px; }
    .info-table td { padding: 4px; vertical-align: top; }
    .details-table th, .details-table td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    .details-table th { background-color: #f0f0f0; text-transform: uppercase; font-size: 11px; }
    .totals td { padding: 6px; }
    .totals td.label { text-align: right; font-weight: bold; }
    .conditions { font-size: 11px; margin-top: 30px; line-height: 1.5; }
    .footer { border-top: 1px solid #000; margin-top: 30px; padding-top: 10px; text-align: center; font-size: 10px; color: #777; }
  </style>
</head>
<body>

  <div class="header">
    <div><img src="public/img/logo.png" class="logo"></div>
    <div class="company-info">
      <strong>PUNTO CONECTADO</strong><br>
      LOS POLVORINES & AZUL<br>
      info@puntoconectado.com.ar<br>
      11 6527 2617 | 2281 51 0754<br>
      www.puntoconectado.com.ar
    </div>
  </div>

  <h1>PRESUPUESTO Nº <?php echo $presupuesto['presupuesto_id'] ?></h1>

  <table class="info-table" style="margin-bottom:20px;">
    <tr>
      <td><strong>Cliente:</strong> <?= $presupuesto['cliente'] ?? 'Cliente no informado' ?></td>
      <td><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($presupuesto['fecha_creacion'] ?? date('Y-m-d'))) ?></td>
    </tr>
    <tr>
      <td><strong>Vencimiento:</strong> <?= date('d/m/Y', strtotime($presupuesto['vencimiento'] ?? date('Y-m-d'))) ?></td>
      <td><strong>Condición de pago:</strong> <?= $presupuesto['condicion_pago'] ?? 'Contado' ?></td>
    </tr>
    <tr>
      <td><strong>Vendedor:</strong> <?= $presupuesto['vendedor'] ?? 'Sin asignar' ?></td>
      <td><strong>Teléfono:</strong> <?= $presupuesto['telefono'] ?? '' ?></td>
    </tr>
  </table>

  <table class="details-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Descripción</th>
        <th>Cant.</th>
        <th>Precio Unit.</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($items)): ?>
        <?php foreach ($items as $i => $item): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($item['descripcion']) ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td>$ <?= number_format($item['precio_unitario'], 2, ',', '.') ?></td>
            <td>$ <?= number_format($item['total'], 2, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="5" align="center">Sin ítems</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <table class="totals" style="margin-top:10px;">
    <tr><td class="label">Subtotal:</td><td>$ <?= number_format($presupuesto['subtotal'], 2, ',', '.') ?></td></tr>
    <tr><td class="label">Total:</td><td><strong>$ <?= number_format($presupuesto['total'], 2, ',', '.') ?></strong></td></tr>
  </table>

  <div class="conditions">
    <p><strong>Condiciones:</strong></p>
    <p>Pago contra entrega. Este presupuesto se acompaña de una hoja con las aclaraciones sobre su alcance.
       Cualquier solicitud adicional no incluida será presupuestada aparte. Se otorga una garantía de 30 días
       sobre los trabajos realizados.</p>
  </div>

  <div class="footer">
    BANCO GALICIA · PUNTOSEGURO.AR<br>
    Este documento no tiene validez fiscal
  </div>

</body>
</html>
