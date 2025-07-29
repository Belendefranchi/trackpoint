<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerTipos() {
	try {
    $conn = getConnection();
    $stmt = $conn->query("SELECT * FROM sistema_logs_tiposHabilitados");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
			registrarEvento("Error al obtener tipos de log: " . $e->getMessage(), "ERROR");
			return [];
	}
}

function habilitarTipo($tipo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE sistema_logs_tiposHabilitados SET habilitado = 1 WHERE tipo = :tipo");
		$stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
		registrarEvento("Tipo de log habilitado: " . $tipo, "INFO");
		return $stmt->execute();
	} catch (PDOException $e) {
		registrarEvento("Error al habilitar tipo de log: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function deshabilitarTipo($tipo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE sistema_logs_tiposHabilitados SET habilitado = 0 WHERE tipo = :tipo");
		$stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
		registrarEvento("Tipo de log deshabilitado: " . $tipo, "INFO");
		return $stmt->execute();
	} catch (PDOException $e) {
		registrarEvento("Error al deshabilitar tipo de log: " . $e->getMessage(), "ERROR");
		return false;
	}
}