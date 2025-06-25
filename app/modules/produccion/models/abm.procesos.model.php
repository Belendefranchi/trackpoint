<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

function obtenerProcesos() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM produccion_abm_procesos ORDER BY proceso_id DESC");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Procesos Model: Error al obtener los procesos, " . $e->getMessage(), "ERROR");
		return false;
	}
}
function obtenerProcesoPorId($proceso_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT * FROM produccion_abm_procesos WHERE proceso_id = :proceso_id");
		$stmt->bindParam(':proceso_id', $proceso_id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Procesos Model: Error al obtener el proceso por ID, " . $e->getMessage(), "ERROR");
		return false;
	}
}
function procesoExists($codigo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT codigo FROM produccion_abm_procesos WHERE codigo = :codigo");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result ?: false;
	} catch (PDOException $e) {
		registrarEvento("Procesos Model: Error al verificar si el proceso existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearProceso($codigo, $descripcion) {
	session_start();
	$creado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO produccion_abm_procesos (codigo, descripcion, creado_por) VALUES (:codigo, :descripcion, :creado_por)");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':creado_por', $creado_por);
		$result = $stmt->execute();
		if ($result) {
			registrarEvento("Procesos Model: proceso creada correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Procesos Model: Error al crear el proceso, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarProceso($proceso_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM produccion_abm_procesos WHERE proceso_id = :proceso_id");
		$stmt->bindParam(':proceso_id', $proceso_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Procesos Model: Error al eliminar el proceso, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarProceso($proceso_id, $codigo, $descripcion, $activo) {
	session_start();
	$editado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE produccion_abm_procesos SET codigo = :codigo, descripcion = :descripcion, editado_por = :editado_por, activo = :activo WHERE proceso_id = :proceso_id");
		$stmt->bindParam(':proceso_id', $proceso_id);
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':editado_por', $editado_por);
		$stmt->bindParam(':activo', $activo);
		$stmt->execute();
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Procesos Model: proceso editado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Procesos Model: Error al editar el proceso, " . $e->getMessage(), "ERROR");
		return false;
	}
}