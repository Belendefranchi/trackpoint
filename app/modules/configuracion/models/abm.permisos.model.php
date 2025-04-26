<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';

function obtenerPermisos() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_permisos");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al obtener los permisos: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function permisoExists($nombre) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT nombre FROM configuracion_abm_permisos WHERE nombre = :nombre");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->execute();
		$perfil = $stmt->fetch(PDO::FETCH_ASSOC);
		return $perfil ?: false;
	} catch (PDOException $e) {
		registrarEvento("Error al verificar si el permiso existe: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearPermiso($nombre, $descripcion, $pantalla) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_permisos (nombre, descripcion, pantalla) VALUES (:nombre, :descripcion, :pantalla)");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':pantalla', $pantalla);
		return $stmt->execute();
		registrarEvento("Permiso creado correctamente", "INFO");
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al crear el permiso: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarPermiso($id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_permisos WHERE id = :id");
		$stmt->bindParam(':id', $id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al eliminar el permiso: " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarPermiso($id, $nombre, $descripcion, $activo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_permisos SET nombre = :nombre, descripcion = :descripcion, activo = :activo WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':activo', $activo);
		$stmt->execute();
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Error al actualizar el permiso: " . $e->getMessage(), "ERROR");
		return false;
	}
}
