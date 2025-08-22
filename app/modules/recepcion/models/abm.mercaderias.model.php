<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerMercaderias() {
	try {
		$conn = getConnection();
		/* $stmt = $conn->query("SELECT * FROM configuracion_abm_mercaderias"); */
		$stmt = $conn->query("SELECT
														m.mercaderia_id,
														m.codigo,
														m.descripcion,
														m.unidad_medida,
														g.codigo AS grupo_codigo,
														s.codigo AS subgrupo_codigo,
														m.envase_pri,
														/* m.envase_sec, */
														m.marca,
														m.cantidad_propuesta,
														m.peso_propuesto,
														m.peso_min,
														m.peso_max,
														m.etiqueta_sec,
														m.activo
													FROM configuracion_abm_mercaderias m
													JOIN configuracion_abm_subgrupos s
														ON m.subgrupo_id = s.subgrupo_id
													JOIN configuracion_abm_grupos g
														ON m.grupo_id = g.grupo_id");
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
		$stmt = $conn->prepare("SELECT * FROM configuracion_abm_mercaderias WHERE mercaderia_id = :mercaderia_id");
		$stmt->bindParam(':mercaderia_id', $mercaderia_id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al obtener la mercadería por ID, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function obtenerMercaderiaPorCodigo($codigo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT mercaderia_id, codigo, descripcion, cantidad_propuesta, peso_propuesto FROM configuracion_abm_mercaderias WHERE codigo = :codigo");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al obtener la mercadería por código, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function mercaderiaExists($codigo) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT mercaderia_id, codigo FROM configuracion_abm_mercaderias WHERE codigo = :codigo");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result ?: false;
	} catch (PDOException $e) {
		registrarEvento("Mercaderías Model: Error al verificar si la mercadería existe, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function crearMercaderia($codigo, $descripcion, $unidad_medida, $grupo, $subgrupo, $envase_pri, $envase_sec, $marca, $cantidad_propuesta, $peso_propuesto, $peso_min, $peso_max, $etiqueta_sec) {
	session_start();
	$creado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("INSERT INTO configuracion_abm_mercaderias (codigo, descripcion, unidad_medida, grupo, subgrupo, envase_pri, envase_sec, marca, cantidad_propuesta, peso_propuesto, peso_min, peso_max, creado_por, etiqueta_sec) VALUES (:codigo, :descripcion, :unidad_medida, :grupo, :subgrupo, :envase_pri, :envase_sec, :marca, :cantidad_propuesta, :peso_propuesto, :peso_min, :peso_max, :creado_por, :etiqueta_sec)");
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':unidad_medida', $unidad_medida);
		$stmt->bindParam(':grupo', $grupo);
		$stmt->bindParam(':subgrupo', $subgrupo);
		$stmt->bindParam(':envase_pri', $envase_pri);
		$stmt->bindParam(':envase_sec', $envase_sec);
		$stmt->bindParam(':marca', $marca);
		$stmt->bindParam(':cantidad_propuesta', $cantidad_propuesta);
		$stmt->bindParam(':peso_propuesto', $peso_propuesto);
		$stmt->bindParam(':peso_min', $peso_min);
		$stmt->bindParam(':peso_max', $peso_max);
		$stmt->bindParam(':etiqueta_sec', $etiqueta_sec);
		$stmt->bindParam(':creado_por', $creado_por);
		$result = $stmt->execute();
		if ($result) {
			registrarEvento("Mercaderías Model: mercadería creada correctamente.", "INFO");
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
		$stmt = $conn->prepare("DELETE FROM configuracion_abm_mercaderias WHERE mercaderia_id = :mercaderia_id");
		$stmt->bindParam(':mercaderia_id', $mercaderia_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al eliminar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarMercaderia($mercaderia_id, $codigo, $descripcion, $unidad_medida, $grupo, $subgrupo, $envase_pri, $envase_sec, $marca, $cantidad_propuesta, $peso_propuesto, $peso_min, $peso_max, $etiqueta_sec, $activo) {
	session_start();
	$editado_por = $_SESSION['username'];
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE configuracion_abm_mercaderias SET codigo = :codigo, descripcion = :descripcion, unidad_medida = :unidad_medida, grupo = :grupo, subgrupo = :subgrupo, envase_pri = :envase_pri, envase_sec = :envase_sec, marca = :marca, cantidad_propuesta = :cantidad_propuesta, peso_propuesto = :peso_propuesto, peso_min = :peso_min, peso_max = :peso_max, editado_por = :editado_por, activo = :activo, etiqueta_sec = :etiqueta_sec WHERE mercaderia_id = :mercaderia_id");
		$stmt->bindParam(':mercaderia_id', $mercaderia_id);
		$stmt->bindParam(':codigo', $codigo);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':unidad_medida', $unidad_medida);
		$stmt->bindParam(':grupo', $grupo);
		$stmt->bindParam(':subgrupo', $subgrupo);
		$stmt->bindParam(':envase_pri', $envase_pri);
		$stmt->bindParam(':envase_sec', $envase_sec);
		$stmt->bindParam(':marca', $marca);
		$stmt->bindParam(':cantidad_propuesta', $cantidad_propuesta);
		$stmt->bindParam(':peso_propuesto', $peso_propuesto);
		$stmt->bindParam(':peso_min', $peso_min);
		$stmt->bindParam(':peso_max', $peso_max);
		$stmt->bindParam(':etiqueta_sec', $etiqueta_sec);
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