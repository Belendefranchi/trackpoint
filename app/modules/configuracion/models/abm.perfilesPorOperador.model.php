<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';


/* function obtenerPerfilesPorOperador($operadorId) {
	try {
		$conn = getConnection();

    $stmt = $conn->prepare("SELECT perfil_id FROM configuracion_abm_perfilesPorOperador WHERE operador_id = :operador_id");
    $stmt->bindParam(':operadorId', $operador_id, PDO::PARAM_INT);
    $stmt->execute();
		// fetchAll con PDO::FETCH_COLUMN para traer solo los ids en un array simple
		$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

		// Retornar array vacío si no hay resultados
		return $result ?: [];
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles por Operador Model: Error al obtener los datos, " . $e->getMessage(), "ERROR");
		return false;
	}
} */


function obtenerPerfilesPorOperador($operadorId) {
	try {
		$conn = getConnection();

		/* var_dump($operadorId); */ // TEMPORAL: Asegurate de que llega el valor correcto

		$stmt = $conn->prepare("SELECT perfil_id FROM configuracion_abm_perfilesPorOperador WHERE operador_id = :operador_id");
		$stmt->bindParam(':operador_id', $operadorId, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
		/* var_dump($result); */ // TEMPORAL: Ver qué devuelve

		return $result;
	} catch (PDOException $e) {
		registrarEvento("Error al obtener perfiles por operador: " . $e->getMessage(), "ERROR");
		return [];
	}
}


function guardarPerfilesPorOperador($operadorId, $perfiles) {
	try {
		$conn = getConnection();
    // Primero, eliminamos las asignaciones anteriores de ese operador
    $stmt = $conn->prepare("DELETE FROM configuracion_abm_perfilesPorOperador WHERE operador_id = :operadorId");
    $stmt->bindParam(':operadorId', $operadorId, PDO::PARAM_INT);
    $stmt->execute();

    // Luego insertamos los nuevos perfiles
    $stmt = $conn->prepare("INSERT INTO configuracion_abm_perfilesPorOperador (operador_id, perfil_id) VALUES (:operadorId, :perfilId)");

    foreach ($perfiles as $perfilId) {
			$stmt->bindParam(':operadorId', $operadorId, PDO::PARAM_INT);
			$stmt->bindParam(':perfilId', $perfilId, PDO::PARAM_INT);
			$stmt->execute();
    }
    return true;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles por Operador Model: Error al obtener los datos, " . $e->getMessage(), "ERROR");
		return false;
	}
}