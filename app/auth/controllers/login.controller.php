<?php
session_start();
/*
if (isset($_SESSION['role'])) {
  if ($role == "admin"){
    header("Location: /");
  }else{
    header("Location: /");
  }
  exit();
} */

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
      $_SESSION['user'] = [
        'id' => $user['id'],
        'email' => $user['email'],
        'nombre' => $user['nombre'] ?? ''
      ];
      /* header('Location: /');*/
      exit(); 
    }
    
    $message = "Autenticación exitosa. Redirigiendo...". $user;
  } else {
      // Error de autenticación
      $message = "Email o contraseña incorrectos.";
  }
} 

/* require_once __DIR__ . '/../views/login.view.php'; */

