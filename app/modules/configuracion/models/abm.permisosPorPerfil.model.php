<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/helpers.php';

function obtenerPermisosPorPerfil($perfil_id) {
	try {
		$conn = getConnection();

		$stmt = $conn->prepare("SELECT permiso_id FROM configuracion_abm_PermisosPorPerfil WHERE perfil_id = :perfil_id");
		$stmt->bindParam(':perfil_id', $perfil_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);

		return $result;
	} catch (PDOException $e) {
		registrarEvento("Error al obtener permisos por perfil: " . $e->getMessage(), "ERROR");
		return [];
	}
}

function asignarPermisoAPerfil($perfil_id, $permiso_id) {
	try {
		$conn = getConnection();

			// Verificar si ya existe la relación
			$sql = "SELECT COUNT(*) FROM configuracion_abm_PermisosPorPerfil WHERE perfil_id = ? AND permiso_id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$perfil_id, $permiso_id]);
			$existe = $stmt->fetchColumn();
			if ($existe == 0) {
				$sql = "INSERT INTO configuracion_abm_PermisosPorPerfil (perfil_id, permiso_id) VALUES (?, ?)";
				$stmt = $conn->prepare($sql);
				registrarEvento("Permisos por perfil Model: Permiso insertado", "INFO");
				return $stmt->execute([$perfil_id, $permiso_id]); // Devuelve true o false
			} else {
				registrarEvento("Permisos por perfil Model: Permiso ya existe", "INFO");
				return true; // Ya existe, no es un error
			}

	} catch (PDOException $e) {
			registrarEvento("Error SQL al asignar perfil: " . $e->getMessage(), "ERROR");
			return false;
	}
}


function desasignarPermisoAPerfil($perfil_id, $permiso_id) {
    $conn = getConnection();
    $sql = "DELETE FROM configuracion_abm_permisosPorPerfil WHERE perfil_id = ? AND permiso_id = ?";
    $stmt = $conn->prepare($sql);
		registrarEvento("Permisos por perfil Model: Permiso desasignado", "INFO");
    return $stmt->execute([$perfil_id, $permiso_id]);
}
