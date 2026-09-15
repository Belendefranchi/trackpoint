<?php

require_once __DIR__ . '/../../vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class PdfGenerator
{
    public static function render(string $html, string $filename = 'documento.pdf')
    {
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream($filename, [
            'Attachment' => false
        ]);
    }
}