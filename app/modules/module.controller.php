<?php

function cargarVista($rutaVistaRelativa = null, $variables = []) {
	extract($variables); // Hace disponibles $operadores, $perfiles, $message, etc.

	// Si pasaron una vista interna, la prepara
	if ($rutaVistaRelativa) {
			$content = __DIR__ . $rutaVistaRelativa;
	} else {
			$content = null;
	}

	require __DIR__ . '/module.view.php';
}

if (!defined('VISTA_INTERNA')) {
	cargarVista();
}