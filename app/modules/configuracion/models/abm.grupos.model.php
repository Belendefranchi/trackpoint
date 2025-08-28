<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerGrupos() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_grupos");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Grupos Model: Error al obtener los grupos, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function obtenerGruposActivos() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT grupo_id, codigo, descripcion FROM configuracion_abm_grupos WHERE activo = 1");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Grupos Model: Error al obtener los grupos activos, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function grupoExists($codigo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT grupo_id, codigo FROM configuracion_abm_grupos WHERE codigo = :codigo");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->execute();
		$grupo = $stmt->fetch(PDO::FETCH_ASSOC);
		return $grupo ?: false;
	} catch (PDOException $e) {
		registrarEvento("Grupos Model: Error al verificar si el grupo existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearGrupo($codigo, $descripcion) {
	session_start();
	$creado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_grupos (codigo, descripcion, creado_por) VALUES (:codigo, :descripcion, :creado_por)");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':creado_por', $creado_por);
		$result = $stmt->execute();
		if ($result) {
			registrarEvento("Grupos Model: grupo creado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Grupos Model: Error al crear el grupo, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarGrupo($grupo_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_grupos WHERE grupo_id = :grupo_id");
		$stmt->bindParam(':grupo_id', $grupo_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Grupos Model: Error al eliminar el grupo, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarGrupo($grupo_id, $codigo, $descripcion, $activo) {
	session_start();
	$editado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_grupos SET codigo = :codigo, descripcion = :descripcion, editado_por = :editado_por, activo = :activo WHERE grupo_id = :grupo_id");
		$stmt->bindParam(':grupo_id', $grupo_id);
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':editado_por', $editado_por);
		$stmt->bindParam(':activo', $activo);
		$stmt->execute();
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Grupos Model: grupo editado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Grupos Model: Error al editar el grupo, " . $e->getMessage(), "ERROR");
		return false;
	}
}