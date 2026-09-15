<?php
use Dompdf\Dompdf;
use Dompdf\Options;

function generarAlcance()
{
    require_once __DIR__ . '/../../../../vendor/dompdf/autoload.inc.php';

    $css = file_get_contents(__DIR__ . '/../../../../public/assets/css/alcance.style.css');

    $logoPath = realpath(
        __DIR__ . '/../../../../public/assets/images/logo_fondo_blanco_100x109.png'
    );
    $firmaPath = realpath(
        __DIR__ . '/../../../../public/assets/images/firma.png'
    );

    $logoBase64 = '';
    if ($logoPath && file_exists($logoPath)) {
        $logoBase64 = 'data:' . mime_content_type($logoPath) . ';base64,' .
            base64_encode(file_get_contents($logoPath));
    }

    $firmaBase64 = '';
    if ($firmaPath && file_exists($firmaPath)) {
        $firmaBase64 = 'data:' . mime_content_type($firmaPath) . ';base64,' .
            base64_encode(file_get_contents($firmaPath));
    }

    // Capturar solamente la plantilla: no enviar HTML a la respuesta HTTP.
    ob_start();
    try {
        require __DIR__ . '/../views/egresos.presupuestos.plantilla.alcance.view.php';
        $contenido = ob_get_contents();
    } finally {
        ob_end_clean();
    }

    $html = '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <style>' . $css . '</style>
        </head>
        <body>' . $contenido . '</body>
        </html>';

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', false);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Descargar el resultado del POST sin depender de otra petición del visor.
    // stream() establece Content-Type, Content-Length y Content-Disposition.
    $dompdf->stream(
        'Alcance_' . ($_POST['presupuesto_id'] ?? '') . '.pdf',
        ['Attachment' => true]
    );
    exit;
}
