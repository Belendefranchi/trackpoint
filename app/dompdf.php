<?php

require_once __DIR__ . '/../vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$dompdf->loadHtml('Hola mundo');

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream(
    'prueba.pdf',
    ['Attachment' => false]
);