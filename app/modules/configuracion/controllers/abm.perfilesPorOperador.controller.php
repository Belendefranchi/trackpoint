<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['operador_seleccionado']);
}

require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.operadores.model.php';
require_once __DIR__ . '/../models/abm.perfiles.model.php';
require_once __DIR__ . '/../models/abm.perfilesPorOperador.model.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

// Obtener operadores y perfiles
$operadores = obtenerOperadoresActivos();
$perfiles = obtenerPerfilesActivos();

$operadorSeleccionado = $_SESSION['operador_seleccionado'] ?? null;
$perfilesAsignados = [];

// Si hay operador seleccionado en sesión, obtener sus perfiles
if ($operadorSeleccionado) {
  $operador_id = $operadorSeleccionado['operador_id'];

  $perfilesAsignados = obtenerPerfilesPorOperador($operador_id) ?: [];

  // Marcar los perfiles asignados
  foreach ($perfiles as &$perfil) {
    $perfil['asignado'] = in_array($perfil['perfil_id'], $perfilesAsignados);
  }
}

// Si se envía el formulario por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // ####### SELECCIONAR OPERADOR #######
  if (isset($_GET['seleccionar'])) {

    $operador_id = $_POST['operador_id'] ?? null;
    $username = $_POST['username'] ?? '';
    $nombre_completo = $_POST['nombre_completo'] ?? '';
    $email = $_POST['email'] ?? '';
    $rol = $_POST['rol'] ?? '';

    if (empty($operador_id)) {
      echo json_encode(['success' => false, 'message' => 'Error: No se recibió el ID del operador']);
      exit;
    } else {
      // Guardar el operador en sesión
      $_SESSION['operador_seleccionado'] = [
        'operador_id' => $operador_id,
        'username' => $username,
        'nombre_completo' => $nombre_completo,
        'email' => $email,
        'rol' => $rol
      ];
    }
  }
	
  // ####### ASIGNAR PERFILES #######
  if (isset($_GET['asignar'])) {

		header('Content-Type: application/json');
		
		$operador_id = $_POST['operador_id'] ?? null;
    $perfil_id = $_POST['perfil_id'] ?? null;
    $asignar = $_POST['asignar'] ?? null;

    if (!isset($operador_id, $perfil_id, $asignar) || $operador_id === '' || $perfil_id === '' || $asignar === '') {
			registrarEvento("Perfiles por Operador Controller: Faltan datos obligatorios", "ERROR");
      echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
      exit;
    }

    if ($asignar == 1) {
        $result = asignarPerfilAOperador($operador_id, $perfil_id);
        if ($result) {
					registrarEvento("Perfiles por Operador Controller: Perfil asignado", "INFO");
          echo json_encode(['success' => true, 'message' => 'Perfil asignado']);
					exit;
        } else {
					registrarEvento("Perfiles por Operador Controller: Error al asignar perfil", "ERROR");
          echo json_encode(['success' => false, 'message' => 'Error al asignar perfil']);
					exit;
        }
    } else {
        $result = desasignarPerfilAOperador($operador_id, $perfil_id);
        if ($result) {
					registrarEvento("Perfiles por Operador Controller: Perfil desasignado", "INFO");
          echo json_encode(['success' => true, 'message' => 'Perfil desasignado']);
					exit;
        } else {
					registrarEvento("Perfiles por Operador Controller: Error al desasignar perfil", "ERROR");
          echo json_encode(['success' => false, 'message' => 'Error al desasignar perfil']);
					exit;
        }
    }

    exit;

	}

}

// Datos para la vista
$datosVista = [
  'operadores' => $operadores,
  'perfiles' => $perfiles,
  'perfilesAsignados' => $perfilesAsignados
];

cargarVistaConfiguracion('abm.perfilesPorOperador.view.php', $datosVista);
