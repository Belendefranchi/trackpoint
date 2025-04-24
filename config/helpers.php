<?php

function registrarEvento($mensaje, $tipo = 'INFO') {
 $fechaHora = date('Y-m-d H:i:s');

 // Usuario actual si está logueado
 $usuario = isset($_SESSION['username']) ? $_SESSION['username'] : 'Invitado';

 // Formato del mensaje
 $linea = "[$fechaHora] | $tipo | $usuario | $mensaje\n"/*  . str_repeat('-', 60) . "\n" */;

 // Ruta del archivo de log según el tipo
 if (in_array($tipo, ['ERROR', 'CRITICAL'])) {
     $rutaLog = __DIR__ . '/../logs/error.log';
 } else {
     $rutaLog = __DIR__ . '/../logs/eventos.log';
 }

 // Escribir en el archivo
 error_log($linea, 3, $rutaLog);
}

