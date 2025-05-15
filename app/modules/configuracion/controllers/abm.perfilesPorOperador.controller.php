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

// Si seleccionaron un operador
$operadorId = isset($_GET['operador_id']) ? (int)$_GET['operador_id'] : null;
$perfilesAsignados = $operadorId ? obtenerPerfilesPorOperador($operadorId) : [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $operadorId = $_POST['operador_id'];

  // Consultar perfiles asignados a ese operador
  $perfiles = obtenerPerfilesPorOperador($operadorId);
	

	// Guardar los perfiles seleccionados
	guardarPerfilesPorOperador($operadorIdPost, $perfilesSeleccionados);

	// Redirigir para evitar reenviar formulario al refrescar
	header("Location: ?operador_id=$operadorIdPost");
	exit;
}


// Llamar a la función común que carga todo en el layout
$datosVista = [
  'operadores' => $operadores,
	'perfiles' => $perfiles
];

cargarVistaConfiguracion('abm.perfilesPorOperador.view.php', $datosVista);


