<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';

function obtenerPerfiles() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_perfiles");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al obtener los perfiles, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function perfilExists($nombre) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT nombre FROM configuracion_abm_perfiles WHERE nombre = :nombre");
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
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_perfiles (nombre, descripcion, creado_por) VALUES (:nombre, :descripcion, :creado_por)");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindValue(':creado_por', $_SESSION['username']);
		return $stmt->execute();
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
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_perfiles SET nombre = :nombre, descripcion = :descripcion, editado_por = :editado_por, activo = :activo WHERE perfil_id = :perfil_id");
		$stmt->bindParam(':perfil_id', $perfil_id);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindValue(':editado_por', $_SESSION['username']);
		$stmt->bindParam(':activo', $activo);
		$result = $stmt->execute(); // Ejecutar solo una vez

		if ($result) {
			registrarEvento("Perfiles Model: perfil editado correctamente, " . htmlspecialchars($_SESSION['nombre_completo']), "INFO");
		}
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles Model: Error al editar el perfil, " . $e->getMessage(), "ERROR");
		return false;
	}
}