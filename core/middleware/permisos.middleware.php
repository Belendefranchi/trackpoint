<?php
require_once 'core/database.php';

/**
 * Middleware que verifica si el operador actual tiene permiso
 * para acceder a la pantalla actual (ruta).
 * Si no tiene permiso, redirige al error 403.
 */
function middlewarePermisos() {
    $ruta = obtenerRutaActual();
    $operadorId = $_SESSION['operador']['id'] ?? null;

    if (!$operadorId || !$ruta) {
        header('Location: /error403.php');
        exit;
    }

    $db = conectarDB();

    $sql = "
        SELECT 1
        FROM operador_perfil op
        INNER JOIN perfil_permiso pp ON pp.perfil_id = op.perfil_id
        INNER JOIN permisos p ON p.id = pp.permiso_id
        WHERE op.operador_id = ? AND p.ruta = ?
        LIMIT 1
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute([$operadorId, $ruta]);

    if (!$stmt->fetchColumn()) {
        header('Location: /error403.php');
        exit;
    }
}

/**
 * Devuelve la ruta lógica del controlador actual, por ejemplo: "configuracion/operadores"
 */
function obtenerRutaActual() {
    $script = $_SERVER['SCRIPT_NAME'];
    $partes = explode('/modules/', $script);

    if (count($partes) === 2) {
        $ruta = $partes[1];
        $ruta = str_replace('controllers/', '', $ruta);
        $ruta = str_replace('.controller.php', '', $ruta);
        return $ruta;
    }

    return null;
}
