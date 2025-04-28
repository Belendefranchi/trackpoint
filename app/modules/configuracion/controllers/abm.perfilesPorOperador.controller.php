<?php
define('VISTA_INTERNA', true);
require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.operadores.model.php';
require_once __DIR__ . '/../models/abm.perfiles.model.php';
require_once __DIR__ . '/../../../../config/helpers.php';

// Lógica de actualizar, eliminar y crear operadores
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}

// Obtener datos para pasar a la vista
$operadores = obtenerOperadores();
$perfiles = obtenerPerfiles();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'operadores' => $operadores,
	'perfiles' => $perfiles
];

if (isset($_SESSION['message'])) {
  $datosVista['message'] = $_SESSION['message'];
	unset($_SESSION['message']);
}

cargarVistaConfiguracion('abm.perfilesPorOperador.view.php', $datosVista);


