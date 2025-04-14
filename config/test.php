<?php
require_once 'db.php';

$conn = getConnection();
echo "✅ Conexión exitosa a la base de datos.";

$hash = password_hash('123', PASSWORD_DEFAULT);
echo $hash;
