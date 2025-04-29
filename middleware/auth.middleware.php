<?php
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/trackpoint/public', // SOLO para /trackpoint y sus subrutas
  'domain' => '',          // vacío en localhost
  'secure' => false,       // true si se usa HTTPS
  'httponly' => true,
  'samesite' => 'Lax'
]);
session_start();
if (!isset($_SESSION['operador_id'])) {
  header('Location: /trackpoint/public/login');
  exit();
}
?>

