<?php
require_once __DIR__ . '/../core/config/db.php';

/*
 * Carga los permisos del operador logueado y los guarda en $_SESSION.
 * El array queda estructurado así:
 * $_SESSION['permisos'] = [
 *     '/configuracion/ABMs/operadores' => ['ver', 'crear', 'editar'],
 *     '/expedición/despachos' => ['ver']
 * ];
 */
function cargarPermisos($operadorId) {
	$conn = getConnection();

	$stmt = $conn->prepare("
		SELECT p.pantalla, p.accion
		FROM configuracion_abm_perfilesPorOperador po
		INNER JOIN configuracion_abm_permisosPorPerfil pp ON pp.perfil_id = po.perfil_id
		INNER JOIN configuracion_abm_permisos p ON p.permiso_id = pp.permiso_id
		WHERE po.operador_id = ?
	");
	$stmt->execute([$operadorId]);

	$permisos = [];
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$pantalla = $row['pantalla'];
		$accion = $row['accion'];
		$permisos[$pantalla][] = $accion;
	}

	$_SESSION['permisos'] = $permisos;
}

/*
 * Verifica si el operador tiene permiso para una acción específica en una pantalla.
 */
function tienePermiso($pantalla, $accion) {
  return in_array($accion, $_SESSION['permisos'][$pantalla] ?? []);
}



// COMO USARLO

/* 
 * Al iniciar sesión:
 * require_once __DIR__ . '/../helpers/permisos.helper.php';
 * cargarPermisos($operadorId);
 * 
 * En una vista o controlador:
 * if (tienePermiso('/configuracion/ABMs/operadores', 'editar')) {
 *   echo '<button>Editar</button>';
 * }
 * 
 */
