<?php
require_once __DIR__ . '/../models/login.model.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email) && empty($password)) {
    $message = "Por favor ingrese el usuario y la contraseña";
  } elseif (empty($email)) {
    $message = "Por favor ingrese el usuario";
  } elseif (empty($password)) {
    $message = "Por favor ingrese la contraseña";
  } elseif ($email && $password) {

    $user = loginUser($email, $password);
    if ($user) {
      $_SESSION['id'] = $user['id'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['rol'] = $user['rol'];
      
      $message = "Autenticación exitosa. Redirigiendo...";

      header("Location: /trackpoint/public/home");
      exit();
    } else {
        // Error de autenticación
        $message = "Email o contraseña incorrectos.";
    }
  }
}

