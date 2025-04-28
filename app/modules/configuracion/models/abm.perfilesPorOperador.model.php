<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';


function obtenerPerfilesPorOperador($operadorId) {
	try {
		$conn = getConnection();
		/* SELECT p.id, p.nombre FROM configuracion_abm_perfiles p JOIN configuracion_abm_perfilesPorOperador op ON p.id = op.perfil_id WHERE op.operador_id = :operadorId */
    $stmt = $conn->prepare("SELECT perfil_id FROM perfiles_por_operador WHERE operador_id = :operador_id");
    $stmt->bindParam(':operadorId', $operadorId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles por Operador Model: Error al obtener los datos, " . $e->getMessage(), "ERROR");
		return false;
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
