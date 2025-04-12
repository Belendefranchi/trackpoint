<?php
function getConnection() {

  $host = 'localhost';
  $dbname = 'trackpoint';
  $user = 'sa';
  $pass = 'Acofar*664';

  try {
      $conn = new PDO("sqlsrv:Server=$host;Database=$dbname", $user, $pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      die("Error de conexión: " . $e->getMessage());
  }

}
?>