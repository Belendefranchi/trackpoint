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
		registrarEvento("Permisos Model: Error al obtener los permisos, " . $e->getMessage(), "ERROR");
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
		registrarEvento("Permisos Model: Error al verificar si el permiso existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearPermiso($nombre, $descripcion, $pantalla) {
	session_start();
	$creado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_permisos (nombre, descripcion, pantalla, creado_por) VALUES (:nombre, :descripcion, :pantalla, :creado_por)");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':pantalla', $pantalla);
		$stmt->bindParam(':creado_por', $creado_por);
		$result = $stmt->execute();
		if ($result) {
			registrarEvento("Permisos Model: permiso creado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Permisos Model: Error al crear el permiso, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarPermiso($permiso_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_permisos WHERE id = :permiso_id");
		$stmt->bindParam(':permiso_id', $permiso_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Permisos Model: Error al eliminar el permiso, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarPermiso($permiso_id, $nombre, $descripcion, $pantalla) {
	session_start();
	$editado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_permisos SET nombre = :nombre, descripcion = :descripcion, pantalla = :pantalla, editado_por = :editado_por WHERE permiso_id = :permiso_id");
		$stmt->bindParam(':permiso_id', $permiso_id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':pantalla', $pantalla);
		$stmt->bindParam(':editado_por', $editado_por);
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Permisos Model: permiso editado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Permisos Model: Error al actualizar el permiso, " . $e->getMessage(), "ERROR");
		return false;
	}
}
