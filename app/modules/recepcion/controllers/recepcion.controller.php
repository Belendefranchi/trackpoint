<?php

function cargarVistaRecepcion($rutaVistaRelativa = null, $variables = []) {
	extract($variables); // Hace disponibles $operadores, $perfiles, $message, etc.

	// Si pasaron una vista interna, la prepara
	if ($rutaVistaRelativa) {
			$content = __DIR__ . '/../views/' . $rutaVistaRelativa;
	} else {
			$content = null;
	}

	require __DIR__ . '/../views/recepcion.view.php';
}

if (!defined('VISTA_INTERNA')) {
	cargarVistaRecepcion();
}