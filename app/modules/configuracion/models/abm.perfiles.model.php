<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerPerfiles() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_perfiles WHERE nombre <> 'Permisos'");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al obtener los perfiles, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function obtenerPerfilesActivos() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_perfiles WHERE activo = 1 AND nombre <> 'Permisos'");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al obtener los perfiles activos, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function perfilExists($nombre) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT nombre, perfil_id FROM configuracion_abm_perfiles WHERE nombre = :nombre");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->execute();
		$perfil = $stmt->fetch(PDO::FETCH_ASSOC);
		return $perfil ?: false;
	} catch (PDOException $e) {
		registrarEvento("Perfiles Model: Error al verificar si el perfil existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearPerfil($nombre, $descripcion) {
	session_start();
	$creado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_perfiles (nombre, descripcion, creado_por) VALUES (:nombre, :descripcion, :creado_por)");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':creado_por', $creado_por);
		$result = $stmt->execute();
		if ($result) {
			registrarEvento("Perfiles Model: perfil creado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al crear el perfil, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarPerfil($perfil_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_perfiles WHERE perfil_id = :perfil_id");
		$stmt->bindParam(':perfil_id', $perfil_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al eliminar el perfil, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarPerfil($perfil_id, $nombre, $descripcion, $activo) {
	session_start();
	$editado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_perfiles SET nombre = :nombre, descripcion = :descripcion, editado_por = :editado_por, activo = :activo WHERE perfil_id = :perfil_id");
		$stmt->bindParam(':perfil_id', $perfil_id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':editado_por', $editado_por);
		$stmt->bindParam(':activo', $activo);
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Perfiles Model: perfil editado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al editar el perfil, " . $e->getMessage(), "ERROR");
		return false;
	}
}