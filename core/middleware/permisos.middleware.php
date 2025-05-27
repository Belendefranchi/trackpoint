<?php
require_once __DIR__ . '/../../core/config/db.php';

/* Devuelve la ruta lógica del controlador actual,
 * por ejemplo: "configuracion/operadores" */

function obtenerRutaActual() {
	$ruta = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$basePath = '/trackpoint/public';

	if (str_starts_with($ruta, $basePath)) {
			$ruta = substr($ruta, strlen($basePath));
	}

	return $ruta ?: '/';
}

/* Middleware que verifica si el operador actual tiene permiso
 * para acceder a la pantalla actual (ruta).
 * Si no tiene permiso, redirige al error 403. */

function verificarPermiso() {
	$ruta = obtenerRutaActual();
	$operadorId = $_SESSION['operador_id'] ?? null;

	if ($operadorId === "1") {
		// Si el operador es el administrador, no se verifica permiso
		return;
	}

	$conn = getConnection();
	$stmt = $conn->prepare("SELECT TOP 1 1
		FROM configuracion_abm_perfilesPorOperador po
		INNER JOIN configuracion_abm_permisosPorPerfil pp ON pp.perfil_id = po.perfil_id
		INNER JOIN configuracion_abm_permisos p ON p.permiso_id = pp.permiso_id
		WHERE po.operador_id = ? AND p.pantalla = ?");

	$stmt->execute([$operadorId, $ruta]);
	$result = $stmt->fetchColumn();

	if (!$result) {
		header('Location: /trackpoint/public/forbidden');
		exit;
	}
}