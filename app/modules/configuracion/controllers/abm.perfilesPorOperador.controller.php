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

$operadorSeleccionado = $_SESSION['operador_seleccionado'] ?? null;
$perfilesAsignados = [];

if ($operadorSeleccionado) {
  $operador_id = $operadorSeleccionado['operador_id'];

	$perfilesAsignados = obtenerPerfilesPorOperador($operador_id) ?: [];

  foreach ($perfiles as $perfil) {
    $perfil['asignado'] = in_array($perfil['perfil_id'], $perfilesAsignados);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// ####### SELECCIONAR OPERADOR #######
	if (isset($_GET['seleccionar'])) {

		$operador_id = $_POST['operador_id'] ?? null;
		$username = $_POST['username'] ?? '';
		$nombre_completo = $_POST['nombre_completo'] ?? '';
		$email = $_POST['email'] ?? '';
		$rol = $_POST['rol'] ?? '';

		if (empty($operador_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: Faltan datos del operador seleccionado']);
			exit;
		}

    if ($operador_id) {
			// Guardar operador en sesión para mantenerlo después del redirect
			$_SESSION['operador_seleccionado'] = [
        'operador_id' => $operador_id,
        'username' => $username,
        'nombre_completo' => $nombre_completo,
        'email' => $email,
        'rol' => $rol
			];

			$perfilesAsignados = obtenerPerfilesPorOperador($operador_id);

			// Validar que sea array, si no lo es forzar a array vacío
			if (!is_array($perfilesAsignados)) {
				$perfilesAsignados = [];
			}

			// Marcar cuáles están asignados
			foreach ($perfiles as &$perfil) {
				$perfil['asignado'] = in_array($perfil['perfil_id'], $perfilesAsignados);
			}

			// Redirigir para evitar reenvíos del formulario
/* 			header('Location: /trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador');
			exit; */
		}
	}


		// ####### OBTENER PERFILES POR OPERADOR #######
		if (isset($_GET['perfilesAsignados'])) {

			header('Content-Type: application/json');

			$operador_id = $_POST['operador_id'] ?? null;
	
			if ($operador_id) {
				$perfiles = obtenerPerfilesPorOperador($operador_id) ?: [];
				echo json_encode(['success' => true, 'perfiles' => $perfiles]);
			} else {
				echo json_encode(['success' => false, 'message' => 'ID de operador no recibido']);
			}
			exit; // Salir para evitar que siga cargando la vista
	}
}



// Llamar a la función común que carga todo en el layout
$datosVista = [
  'operadores' => $operadores,
	'perfiles' => $perfiles,
	'perfilesAsignados' => $perfilesAsignados
];

cargarVistaConfiguracion('abm.perfilesPorOperador.view.php', $datosVista);


