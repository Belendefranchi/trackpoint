<?php
function getConnection() {
  $serverName = 'localhost';
  $database = 'trackpoint';
  $username = 'sa';
  $password = 'Acofar*664';

  $connections = [
    "sqlsrv:Server=$serverName;Database=$database",       // Named Pipes / por instancia
    "sqlsrv:Server=$serverName,1433;Database=$database",  // TCP/IP con puerto explícito
  ];

  foreach ($connections as $dsn) {
    try {
      $conn = new PDO($dsn, $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      // Guardamos error para mostrarlo si falla todo
      registrarEvento("Error al acceder a la base de datos: " . $e->getMessage(), "CRITICAL");
      $lastError = $e->getMessage();
    }
  }

  // Si ninguna conexión funcionó, mostramos error
  die("Error de conexión: $lastError");
}
