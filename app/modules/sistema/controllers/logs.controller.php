<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

require_once __DIR__ . '/sistema.controller.php';
require_once __DIR__ . '/../models/logs.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
		if (isset($_GET['habilitar'])) {
		
		header('Content-Type: application/json');
		
		$tipo = $_POST['tipo'];

		try {
			
			habilitarTipo($tipo);

			registrarEvento("Configuración de logs actualizada", "INFO");
			echo json_encode(['success' => true]);
			exit;
		} catch (Exception $e) {
			registrarEvento("Error al actualizar configuración de logs: " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, "error" => $e->getMessage()]);
			exit;
		}
	}

	if (isset($_GET['deshabilitar'])) {
		
		header('Content-Type: application/json');
		
		$tipo = $_POST['tipo'];

		try {

			deshabilitarTipo($tipo);

			registrarEvento("Configuración de logs actualizada", "INFO");
			echo json_encode(['success' => true]);
			exit;
		} catch (Exception $e) {
			registrarEvento("Error al actualizar configuración de logs: " . $e->getMessage(), "ERROR");
			echo json_encode(['success' => false, "error" => $e->getMessage()]);
			exit;
		}
	}

}


// Obtener datos para pasar a la vista
$tipos = obtenerTipos();

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'tipos' => $tipos
];

cargarVistaSistema('logs.view.php', $datosVista);
