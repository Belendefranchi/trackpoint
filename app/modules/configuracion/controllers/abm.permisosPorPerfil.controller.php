<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['perfil_seleccionado']);
}

require_once __DIR__ . '/configuracion.controller.php';
require_once __DIR__ . '/../models/abm.perfiles.model.php';
require_once __DIR__ . '/../models/abm.permisos.model.php';
require_once __DIR__ . '/../models/abm.permisosPorPerfil.model.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

// Obtener operadores y perfiles
$perfiles = obtenerPerfiles();
$permisos = obtenerPermisos();

$perfilSeleccionado = $_SESSION['perfil_seleccionado'] ?? null;
$permisosAsignados = [];

// Si hay operador seleccionado en sesión, obtener sus perfiles
if ($perfilSeleccionado) {
  $perfil_id = $perfilSeleccionado['perfil_id'];

  $permisosAsignados = obtenerPermisosPorPerfil($perfil_id) ?: [];

  // Marcar los permisos asignados
  foreach ($permisos as &$permiso) {
    $permiso['asignado'] = in_array($permiso['permiso_id'], $permisosAsignados);
  }
}

// Si se envía el formulario por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // ####### SELECCIONAR PERFIL #######
  if (isset($_GET['seleccionar'])) {

    $perfil_id = $_POST['perfil_id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    if (empty($perfil_id)) {
      echo json_encode(['success' => false, 'message' => 'Error: No se recibió el ID del operador']);
      exit;
    } else {
      // Guardar el operador en sesión
      $_SESSION['perfil_seleccionado'] = [
        'perfil_id' => $perfil_id,
        'nombre' => $nombre,
        'descripcion' => $descripcion
      ];
    }
  }
	
  // ####### ASIGNAR PERFILES #######
  if (isset($_GET['asignar'])) {

		header('Content-Type: application/json');
		
		$perfil_id = $_POST['perfil_id'] ?? null;
    $permiso_id = $_POST['permiso_id'] ?? null;
    $asignar = $_POST['asignar'] ?? null;

    if (!isset($perfil_id, $permiso_id, $asignar) || $perfil_id === '' || $permiso_id === '' || $asignar === '') {
			registrarEvento("Permisos por Perfil Controller: Faltan datos obligatorios", "ERROR");
      echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
      exit;
    }

    if ($asignar == 1) {
        $result = asignarPermisoAPerfil($perfil_id, $permiso_id);
        if ($result) {
					registrarEvento("Permisos por Perfil Controller: Permiso asignado", "INFO");
          echo json_encode(['success' => true, 'message' => 'Permiso asignado']);
					exit;
        } else {
					registrarEvento("Permisos por Perfil Controller: Error al asignar perfil", "ERROR");
          echo json_encode(['success' => false, 'message' => 'Error al asignar perfil']);
					exit;
        }
    } else {
        $result = desasignarPermisoAPerfil($perfil_id, $permiso_id);
        if ($result) {
					registrarEvento("Permisos por Perfil Controller: Permiso desasignado", "INFO");
          echo json_encode(['success' => true, 'message' => 'Permiso desasignado']);
					exit;
        } else {
					registrarEvento("Permisos por Perfil Controller: Error al desasignar permiso", "ERROR");
          echo json_encode(['success' => false, 'message' => 'Error al desasignar permiso']);
					exit;
        }
    }

    exit;

	}

}

// Datos para la vista
$datosVista = [
  'perfiles' => $perfiles,
  'permisos' => $permisos,
  'permisosAsignados' => $permisosAsignados
];

cargarVistaConfiguracion('abm.permisosPorPerfil.view.php', $datosVista);
