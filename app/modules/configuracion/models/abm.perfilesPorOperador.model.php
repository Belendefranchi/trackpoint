<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';

function obtenerPerfilesPorOperador($operadorId) {
	try {
		$conn = getConnection();

		$stmt = $conn->prepare("SELECT perfil_id FROM configuracion_abm_perfilesPorOperador WHERE operador_id = :operador_id");
		$stmt->bindParam(':operador_id', $operadorId, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);

		return $result;
	} catch (PDOException $e) {
		registrarEvento("Error al obtener perfiles por operador: " . $e->getMessage(), "ERROR");
		return [];
	}
}

function guardarPerfilesPorOperador($operadorId, $perfiles) {
	try {
		$conn = getConnection();
    // Primero, eliminamos las asignaciones anteriores de ese operador
    $stmt = $conn->prepare("DELETE FROM configuracion_abm_perfilesPorOperador WHERE operador_id = :operadorId");
    $stmt->bindParam(':operadorId', $operadorId, PDO::PARAM_INT);
    $stmt->execute();

    // Luego insertamos los nuevos perfiles
    $stmt = $conn->prepare("INSERT INTO configuracion_abm_perfilesPorOperador (operador_id, perfil_id) VALUES (:operadorId, :perfilId)");

    foreach ($perfiles as $perfilId) {
			$stmt->bindParam(':operadorId', $operadorId, PDO::PARAM_INT);
			$stmt->bindParam(':perfilId', $perfilId, PDO::PARAM_INT);
			$stmt->execute();
    }
    return true;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Perfiles por Operador Model: Error al obtener los datos, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function asignarPerfilAOperador($operador_id, $perfil_id) {
	try {
		$conn = getConnection();

			// Verificar si ya existe la relación
			$sql = "SELECT COUNT(*) FROM configuracion_abm_perfilesPorOperador WHERE operador_id = ? AND perfil_id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$operador_id, $perfil_id]);
			$existe = $stmt->fetchColumn();
			if ($existe == 0) {
				$sql = "INSERT INTO configuracion_abm_perfilesPorOperador (operador_id, perfil_id) VALUES (?, ?)";
				$stmt = $conn->prepare($sql);
				registrarEvento("Perfiles por Operador Model: Perfil insertado", "INFO");
				return $stmt->execute([$operador_id, $perfil_id]); // Devuelve true o false
			} else {
				registrarEvento("Perfiles por Operador Model: Perfil ya existe", "INFO");
				return true; // Ya existe, no es un error
			}

	} catch (PDOException $e) {
			registrarEvento("Error SQL al asignar perfil: " . $e->getMessage(), "ERROR");
			return false;
	}
}


function desasignarPerfilAOperador($operador_id, $perfil_id) {
    $conn = getConnection();
    $sql = "DELETE FROM configuracion_abm_perfilesPorOperador WHERE operador_id = ? AND perfil_id = ?";
    $stmt = $conn->prepare($sql);
		registrarEvento("Perfiles por Operador Model: Perfil desasignado", "INFO");
    return $stmt->execute([$operador_id, $perfil_id]);
}
