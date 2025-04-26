<?php

function registrarEvento($mensaje, $tipo = 'INFO') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $fechaHora = date('Y-m-d H:i:s');
    $fechaArchivo = date('Y-m-d'); // formato YYYY-MM-DD

    // Usuario actual si está logueado
    $usuario = isset($_SESSION['username']) ? $_SESSION['username'] : 'Invitado';

    // Formato del mensaje
    $linea = "[$fechaHora] | $tipo | $usuario | $mensaje\n";

    // Carpeta de logs
    $carpetaLogs = __DIR__ . '/../logs';

    // Crear carpeta si no existe
    if (!file_exists($carpetaLogs)) {
        mkdir($carpetaLogs, 0777, true);
    }

    // Nombre del archivo según tipo y fecha
    if (in_array($tipo, ['ERROR', 'CRITICAL'])) {
        $rutaLog = "$carpetaLogs/error_$fechaArchivo.log";
    } else {
        $rutaLog = "$carpetaLogs/eventos_$fechaArchivo.log";
    }

    // Escribir en el archivo correspondiente
    error_log($linea, 3, $rutaLog);
}


/* ################################### EJEMPLOS DE USO ################################# */

/* registrarEvento("Usuario registrado correctamente", "INFO"); */
/* registrarEvento("Autenticación incorrecta", "INFO"); */
/* registrarEvento("Error al autenticar al usuario: " . $e->getMessage(), "ERROR"); */
/* registrarEvento("Error al acceder a la base de datos: " . $e->getMessage(), "CRITICAL"); */


