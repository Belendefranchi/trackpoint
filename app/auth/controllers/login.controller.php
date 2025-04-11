<?php
require_once __DIR__ . '/../models/login.model.php';
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $user = check_credentials($email, $password);

  if ($user) {
      // Autenticación exitosa
      $_SESSION['user'] = [
          'id' => $user['id'],
          'email' => $user['email'],
          'nombre' => $user['nombre'] ?? ''
      ];
      header('Location: /');
      exit;
  } else {
      // Error de autenticación
      $error = "Email o contraseña incorrectos.";
  }
} 
var_dump($error);
require_once __DIR__ . '/../views/login.view.php';

