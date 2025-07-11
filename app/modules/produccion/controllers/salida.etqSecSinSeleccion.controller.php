<?php
define('VISTA_INTERNA', true);

// Iniciar sesión siempre al comienzo
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	unset($_SESSION['proceso_seleccionado']);
	unset($_SESSION['mercaderia_seleccionada']);
}

require_once __DIR__ . '/produccion.controller.php';
require_once __DIR__ . '/../models/abm.procesos.model.php';
require_once __DIR__ . '/../models/abm.mercaderias.model.php';
require_once __DIR__ . '/../models/salida.etqSecSinSeleccion.model.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

// Obtener procesos y mercaderías
$procesos = obtenerProcesos();
$mercaderias = obtenerMercaderias();

$procesoSeleccionado = $_SESSION['proceso_seleccionado'] ?? null;
$mercaderiaSeleccionada = $_SESSION['mercaderia_seleccionada'] ?? null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


	// ####### SELECCIONAR PROCESO #######
	if (isset($_GET['seleccionarProceso'])) {

		$proceso_id = $_POST['proceso_id'] ?? null;
		$codigo = $_POST['codigo-proceso'] ?? '';
		$descripcion = $_POST['descripcion-proceso'] ?? '';

		if (empty($proceso_id)) {
      echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID del proceso']);
      exit;
    } else {
      // Guardar el proceso en sesión
      $_SESSION['proceso_seleccionado'] = [
        'proceso_id' => $proceso_id,
        'codigo' => $codigo,
        'descripcion' => $descripcion
      ];
    }
  }

	// ####### SELECCIONAR MERCADERÍA #######
	if (isset($_GET['seleccionarMercaderia'])) {
		
		$mercaderia_id = $_POST['mercaderia_id'] ?? null;
		$codigo = $_POST['codigo-mercaderia'] ?? '';
		$descripcion = $_POST['descripcion-mercaderia'] ?? '';
		
		if (empty($mercaderia_id)) {
			echo json_encode(['success' => false, 'message' => 'Error: No se recibio el ID de la mercaderia']);
			exit;
		} else {
			// Guardar la mercadería en sesión
			$_SESSION['mercaderia_seleccionada'] = [
				'mercaderia_id' => $mercaderia_id,
				'codigo' => $codigo,
				'descripcion' => $descripcion
			];
		}
	}

		// ####### CREAR #######
		if (isset($_GET['crear'])) {
		
			header('Content-Type: application/json');

		}

	}

// Obtener datos para pasar a la vista
$datosVista = [
	'procesos' => $procesos,
	'mercaderias' => $mercaderias,
/* 	'proceso_seleccionado' => $procesoSeleccionado,
	'mercaderia_seleccionada' => $mercaderiaSeleccionada */
];

// Llamar a la función común que carga todo en el layout
cargarVistaProduccion('salida.etqSecSinSeleccion.view.php', $datosVista);