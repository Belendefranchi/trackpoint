<?php
use Dompdf\Dompdf;
use Dompdf\Options;

/* function generarAlcance(){

	require_once __DIR__ . '/../../../../vendor/dompdf/autoload.inc.php';

	$css = file_get_contents(
		__DIR__ . '/../../../../public/assets/css/alcance.style.css'
	);

	$logo = realpath(
		__DIR__ . '/../../../../public/assets/images/logo_fondo_blanco.png'
	);

	ob_start();

	require __DIR__ . '/../views/egresos.presupuestos.plantilla.alcance.view.php';

	$html = ob_get_clean();

	$html = "
					<style>
					{$css}
					</style>
					{$html}
					";

	$dompdf = new Dompdf();

	$dompdf->loadHtml($html);

	$dompdf->setPaper('A4', 'portrait');

	$dompdf->render();

	$dompdf->stream(
		'Alcance_' . ($_POST['presupuesto_id'] ?? '') . '.pdf',
		['Attachment' => false]
	);

	exit;
} */



function generarAlcance()
{
    require_once __DIR__ . '/../../../../vendor/dompdf/autoload.inc.php';

    /*
     * ---------------------------------------------------------
     * CSS
     * ---------------------------------------------------------
     */

    $cssPath = __DIR__ . '/../../../../public/assets/css/alcance.style.css';

    $css = file_get_contents($cssPath);


    /*
     * ---------------------------------------------------------
     * Imágenes
     * ---------------------------------------------------------
     */

    $logoPath = realpath(
        __DIR__ . '/../../../../public/assets/images/logo_fondo_blanco_100x109.png'
    );

    $firmaPath = realpath(
        __DIR__ . '/../../../../public/assets/images/firma.png'
    );


    $logoBase64 = '';

    if ($logoPath && file_exists($logoPath)) {
        $logoMime = mime_content_type($logoPath);

        $logoBase64 = 'data:' . $logoMime . ';base64,' .
            base64_encode(file_get_contents($logoPath));
    }


    $firmaBase64 = '';

    if ($firmaPath && file_exists($firmaPath)) {
        $firmaMime = mime_content_type($firmaPath);

        $firmaBase64 = 'data:' . $firmaMime . ';base64,' .
            base64_encode(file_get_contents($firmaPath));
    }


    /*
     * ---------------------------------------------------------
     * Generar HTML de la vista
     * ---------------------------------------------------------
     */

    ob_start();

    require __DIR__ . '/../views/egresos.presupuestos.plantilla.alcance.view.php';

    $html = ob_get_clean();


    /*
     * ---------------------------------------------------------
     * HTML completo para Dompdf
     * ---------------------------------------------------------
     */

    /* $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">

            <style>

                @page {
                    size: A4 portrait;
                    margin: 25mm 20mm 25mm 20mm;
                }

                html,
                body {
                    margin: 0;
                    padding: 0;
                }

                ' . $css . '

            </style>
        </head>

        <body>

            ' . $html . '

        </body>
        </html>
    '; */

		$html = '
						<!DOCTYPE html>
						<html lang="es">
						<head>
								<meta charset="UTF-8">

								<style>

										@page {
												size: A4;
										}

										html,
										body {
												margin: 0 !important;
												padding: 0 !important;
										}

										' . $css . '

								</style>
						</head>

						<body>
								' . $html . '
						</body>
						</html>
						';


    /*
     * ---------------------------------------------------------
     * Dompdf
     * ---------------------------------------------------------
     */

    $options = new Options();

    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', false);

    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($html, 'UTF-8');

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream(
        'Alcance_' . ($_POST['presupuesto_id'] ?? '') . '.pdf',
        [
            'Attachment' => false
        ]
    );

    exit;
}