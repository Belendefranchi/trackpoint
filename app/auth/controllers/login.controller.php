<?php
session_start();
if (isset($_SESSION['id'])) {
  header('Location: /trackpoint/public/home');
  exit();
}
require_once __DIR__ . '/../models/login.model.php';
require_once __DIR__ . '/../../../config/helpers.php';


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
      $_SESSION['id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['rol'] = $user['rol'];
      $_SESSION['nombre_completo'] = $user['nombre_completo'];
      
      registrarEvento("Autenticación correcta", "INFO");

      header("Location: /trackpoint/public/home");
      exit();
    } else {
      $_SESSION['username'] = $_POST['username'];

      // Error de autenticación
      $message = "username o contraseña incorrectos.";
      registrarEvento("Autenticación incorrecta", "INFO");
    }
  }
}

