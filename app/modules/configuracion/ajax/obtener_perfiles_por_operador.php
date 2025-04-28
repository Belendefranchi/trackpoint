<?php

require_once __DIR__ . '/../models/abm.perfilesPorOperador.model.php';

// Verificamos que se haya enviado el ID del operador
if (isset($_GET['id'])) {
	$idOperador = (int) $_GET['id']; // Aseguramos que sea un número entero

	// Llamamos a la función del modelo que devuelve los perfiles asignados
	$perfilesAsignados = obtenerPerfilesPorOperador($idOperador);

	// Devolvemos la lista de perfiles asignados en formato JSON
	echo json_encode($perfilesAsignados);
} else {
	// Si no se recibió el ID, devolvemos un error
	echo json_encode(['error' => 'ID de operador no proporcionado']);
}

exit;

