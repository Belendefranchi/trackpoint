<?php

/* session_start();

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
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  if (empty($email) && empty($password)) {
    $message = "Por favor ingrese el usuario y la contraseña";
  } elseif (empty($email)) {
    $message = "Por favor ingrese el usuario";
  } elseif (empty($password)) {
    $message = "Por favor ingrese la contraseña";
  } elseif ($email && $password) {
    $user = loginUser($email, $password);
    // Autenticación exitosa
    $_SESSION['user'] = [
        'id' => $user['id'],
        'email' => $user['email'],
        'nombre' => $user['nombre'] ?? ''
    ];
    echo "user: " . $_SESSION['user']['email'];
    echo "pass: " . $_SESSION['user']['password'];
    /* header('Location: /'); */
    /* exit; */
  } else {
      // Error de autenticación
      $message = "Email o contraseña incorrectos.";
  }
} 

/* require_once __DIR__ . '/../views/login.view.php'; */

