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
if (isset($_SESSION['operador_id'])) {
  header('Location: /trackpoint/public/home');
  exit();
}

require_once __DIR__ . '/../models/login.model.php';
require_once __DIR__ . '/../../../core/helpers/logs.helper.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username) && empty($password)) {
    $message = "Por favor ingrese el usuario y la contraseña";
  } elseif (empty($username)) {
    $message = "Por favor ingrese el usuario";
  } elseif (empty($password)) {
    $message = "Por favor ingrese la contraseña";
  } elseif ($username && $password) {

    $user = loginUser($username, $password);
    if ($user) {
      $_SESSION['operador_id'] = $user['operador_id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['rol'] = $user['rol'];
      $_SESSION['nombre_completo'] = $user['nombre_completo'];
      session_write_close();
      
      registrarEvento("Login Controller: Autenticación correcta", "INFO");

      header("Location: /trackpoint/public/home");
      exit();
    } else {
      $_SESSION['username'] = $_POST['username'];

      // Error de autenticación
      $message = "Usuario o contraseña incorrectos";
      registrarEvento("Login Controller: Autenticación incorrecta", "INFO");
    }
  }
}

require_once __DIR__ . '/../views/login.view.php';
?>

