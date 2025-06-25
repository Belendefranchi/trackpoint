<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

function obtenerMercaderias() {
	try {
		$conn = getConnection();
		$stmt = $conn->query("SELECT * FROM produccion_abm_mercaderias ORDER BY mercaderia_id DESC");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al obtener las mercaderías, " . $e->getMessage(), "ERROR");
		return false;
	}
}
function obtenerMercaderiaPorId($mercaderia_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT * FROM produccion_abm_mercaderias WHERE mercaderia_id = :mercaderia_id");
		$stmt->bindParam(':mercaderia_id', $mercaderia_id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al obtener la mercadería por ID, " . $e->getMessage(), "ERROR");
		return false;
	}
}
function mercaderiaExists($codigo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT codigo FROM produccion_abm_mercaderias WHERE codigo = :codigo");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result ?: false;
	} catch (PDOException $e) {
		registrarEvento("Mercaderías Model: Error al verificar si la mercadería existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearMercaderia($codigo, $descripcion, $familia, $grupo, $subgrupo) {
	session_start();
	$creado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO produccion_abm_mercaderias (codigo, descripcion, familia, grupo, subgrupo, creado_por) VALUES (:codigo, :descripcion, :familia, :grupo, :subgrupo, :creado_por)");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':familia', $familia);
		$stmt->bindParam(':grupo', $grupo);
		$stmt->bindParam(':subgrupo', $subgrupo);
		$stmt->bindParam(':creado_por', $creado_por);
		$result = $stmt->execute();
		if ($result) {
			registrarEvento("Mercaderías Model: mercaderia creada correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al crear la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarMercaderia($mercaderia_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM produccion_abm_mercaderias WHERE mercaderia_id = :mercaderia_id");
		$stmt->bindParam(':mercaderia_id', $mercaderia_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al eliminar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarMercaderia($mercaderia_id, $codigo, $descripcion, $familia, $grupo, $subgrupo, $activo) {
	session_start();
	$editado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE produccion_abm_mercaderias SET codigo = :codigo, descripcion = :descripcion, familia = :familia, grupo = :grupo, subgrupo = :subgrupo, editado_por = :editado_por, activo = :activo WHERE mercaderia_id = :mercaderia_id");
		$stmt->bindParam(':mercaderia_id', $mercaderia_id);
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':familia', $familia);
		$stmt->bindParam(':grupo', $grupo);
		$stmt->bindParam(':subgrupo', $subgrupo);
		$stmt->bindParam(':editado_por', $editado_por);
		$stmt->bindParam(':activo', $activo);
		$stmt->execute();
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Mercaderías Model: mercadería editada correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al editar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}