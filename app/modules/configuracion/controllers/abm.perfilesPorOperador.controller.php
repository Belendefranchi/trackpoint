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

		$operador_id = $_POST['operador_id'] ?? null;
		$username = $_POST['username'] ?? '';
		$nombre_completo = $_POST['nombre_completo'] ?? '';
		$email = $_POST['email'] ?? '';
		$rol = $_POST['rol'] ?? '';

		if (empty($operador_id) || empty($username) || empty($nombre_completo) || empty($email) || empty($rol)) {
			$_SESSION['error'] = 'Faltan datos del operador seleccionado.';
			header('Location: /trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador');
			exit;
		}

    if ($operador_id) {
			session_start();
			// Guardar operador en sesión para mantenerlo después del redirect
			$_SESSION['operador_seleccionado'] = [
        'operador_id' => $operador_id,
        'username' => $username,
        'nombre_completo' => $nombre_completo,
        'email' => $email,
        'rol' => $rol
    ];

			// Redirigir para evitar reenvíos del formulario
			header('Location: /trackpoint/public/index.php?route=/configuracion/ABMs/perfilesPorOperador');
			exit;
    }
	}
}

// Llamar a la función común que carga todo en el layout
$datosVista = [
  'operadores' => $operadores,
	'perfiles' => $perfiles
];

cargarVistaConfiguracion('abm.perfilesPorOperador.view.php', $datosVista);


