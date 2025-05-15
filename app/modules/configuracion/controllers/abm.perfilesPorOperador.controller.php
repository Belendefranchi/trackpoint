<?php
define('VISTA_INTERNA', true);
require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.operadores.model.php';
require_once __DIR__ . '/../models/abm.perfiles.model.php';
require_once __DIR__ . '/../models/abm.perfilesPorOperador.model.php';
require_once __DIR__ . '/../../../../config/helpers.php';

// Obtener datos para pasar a la vista
$operadores = obtenerOperadores();
$perfiles = obtenerPerfiles();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### SELECCIONAR OPERADOR #######
	if (isset($_GET['seleccionar'])) {

		$operador_id = $_POST['operador_id'];

    if ($operador_id) {
			session_start();
			// Guardar operador en sesión para mantenerlo después del redirect
			$_SESSION['operador_id_seleccionado'] = $operador_id;

			// Redirigir para evitar reenvíos del formulario
			header('Location: /trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador');
			exit;
    } else {
        
    }

	}
}

$operadorSeleccionado = null;

if (isset($_SESSION['operador_id_seleccionado'])) {
    $operador_id = $_SESSION['operador_id_seleccionado'];

    foreach ($operadores as $op) {
        if ($op['operador_id'] == $operador_id) {
            $operadorSeleccionado = $op;
            break;
        }
    }
}

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'operadores' => $operadores,
	'perfiles' => $perfiles,
	'operadorSeleccionado' => $operadorSeleccionado
];

cargarVistaConfiguracion('abm.perfilesPorOperador.view.php', $datosVista);


