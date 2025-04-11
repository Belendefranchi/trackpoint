<?php
function getConnection() {
  $serverName = "localhost"; // o IP/instancia SQL
  $connectionOptions = [
    "Database" => "nombre_de_tu_base",
    "Uid" => "usuario",
    "PWD" => "contraseña"
  ];
  return sqlsrv_connect($serverName, $connectionOptions);
}


/* <?php
// config/db.php

$host = 'localhost';
$dbname = 'trackpoint';
$user = 'sa';
$pass = 'Acofar*664';

try {
    $conn = new PDO("sqlsrv:Server=$host;Database=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
} */