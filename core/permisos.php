<?php
require_once __DIR__ . '/../core/config/db.php';

function obtenerPermisosDelOperador($conn, $operador_id) {
	$sql = "SELECT p.nombre 
					FROM operador_perfil op
					JOIN perfil_permiso pp ON op.perfil_id = pp.perfil_id
					JOIN permisos p ON pp.permiso_id = p.id
					WHERE op.operador_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$operador_id]);
	$permisos = $stmt->fetchAll(PDO::FETCH_COLUMN); // array con claves de permisos
	return $permisos;
}

function tienePermiso($conn, $operador_id, $clave_permiso) {
	$permisos = obtenerPermisosDelOperador($conn, $operador_id);
	return in_array($clave_permiso, $permisos);
}
