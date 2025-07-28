<?php

function registrarEvento($mensaje, $tipo = 'INFO') {
	$tipo = strtoupper($tipo);

	// Obtener tipos habilitados desde la base
	try {
		require_once __DIR__ . '/../config/db.php';
		$conn = getConnection();

		$stmt = $conn->prepare("SELECT 1 FROM sistema_logs_tiposHabilitados WHERE tipo = ? AND habilitado = 1");
		$stmt->execute([$tipo]);
		if ($stmt->rowCount() === 0) {
				return; // Tipo no habilitado
		}
	} catch (Exception $e) {
		// Si hay error al acceder a la base, registrar como CRITICAL para no perder errores importantes
		error_log("[FALLO] No se pudo acceder a configuración de logs: " . $e->getMessage() . "\n", 3, __DIR__ . '/../logs/error_' . date('Y-m-d') . '.log');
		return;
	}

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	$fechaHora = date('Y-m-d H:i:s');
	$fechaArchivo = date('Y-m-d');

	$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : 'Invitado';
	$linea = "[$fechaHora] | $tipo | $usuario | $mensaje\n";

	$carpetaLogs = __DIR__ . '/../logs';
	if (!file_exists($carpetaLogs)) {
			mkdir($carpetaLogs, 0777, true);
	}

	$rutaLog = in_array($tipo, ['ERROR', 'CRITICAL']) ?
			"$carpetaLogs/error_$fechaArchivo.log" :
			"$carpetaLogs/eventos_$fechaArchivo.log";

	error_log($linea, 3, $rutaLog);
}



/* ################################### EJEMPLOS DE USO ################################# */

/* registrarEvento("Usuario registrado correctamente", "INFO"); */
/* registrarEvento("Autenticación incorrecta", "INFO"); */
/* registrarEvento("Error al autenticar al usuario: " . $e->getMessage(), "ERROR"); */
/* registrarEvento("Error al acceder a la base de datos: " . $e->getMessage(), "CRITICAL"); */


