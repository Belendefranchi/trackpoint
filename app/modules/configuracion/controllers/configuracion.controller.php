<?php

function cargarVistaConfiguracion($rutaVistaRelativa = null, $variables = []) {
	extract($variables); // Hace disponibles $operadores, $perfiles, etc.

	// Si pasaron una vista interna, la prepara
	if ($rutaVistaRelativa) {
			$content = __DIR__ . '/../views/' . $rutaVistaRelativa;
	} else {
			$content = null;
	}

	require __DIR__ . '/../views/configuracion.view.php';
}

if (!defined('VISTA_INTERNA')) {
	cargarVistaConfiguracion();
}
