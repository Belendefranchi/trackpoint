<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerSubgrupos() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM configuracion_abm_subgrupos");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Subgrupos Model: Error al obtener los subgrupos, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function subgrupoExists($codigo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT codigo FROM configuracion_abm_subgrupos WHERE codigo = :codigo");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->execute();
		$subgrupo = $stmt->fetch(PDO::FETCH_ASSOC);
		return $subgrupo ?: false;
	} catch (PDOException $e) {
		registrarEvento("Subgrupos Model: Error al verificar si el subgrupo existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearSubgrupo($codigo, $descripcion) {
	session_start();
	$creado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_subgrupos (codigo, descripcion, grupo_id, creado_por) VALUES (:codigo, :descripcion, :grupo_id, :creado_por)");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':grupo_id', $grupo_id);
		$stmt->bindParam(':creado_por', $creado_por);
		$result = $stmt->execute();
		if ($result) {
			registrarEvento("Subgrupos Model: subgrupo creado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Subgrupos Model: Error al crear el subgrupo, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarSubgrupo($subgrupo_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_subgrupos WHERE subgrupo_id = :subgrupo_id");
		$stmt->bindParam(':subgrupo_id', $subgrupo_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Subgrupos Model: Error al eliminar el subgrupo, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarSubgrupo($subgrupo_id, $codigo, $descripcion, $grupo_id, $activo) {
	session_start();
	$editado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_subgrupos SET codigo = :codigo, descripcion = :descripcion, grupo_id = :grupo_id, editado_por = :editado_por, activo = :activo WHERE subgrupo_id = :subgrupo_id");
		$stmt->bindParam(':subgrupo_id', $subgrupo_id);
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':grupo_id', $grupo_id);
		$stmt->bindParam(':editado_por', $editado_por);
		$stmt->bindParam(':activo', $activo);
		$stmt->execute();
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Subgrupos Model: operador editado correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Subgrupos Model: Error al editar el operador, " . $e->getMessage(), "ERROR");
		return false;
	}
}