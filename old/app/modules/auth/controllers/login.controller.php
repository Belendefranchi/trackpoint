<?php
require_once '../models/login.model.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  $user = getUserByUsername($username);

  if ($user && password_verify($password, $user['password'])) {
    // Autenticación correcta
    $_SESSION['user'] = [
      'id' => $user['id'],
      'username' => $user['username'],
      'rol' => $user['rol'],
      'nombre_completo' => $user['nombre_completo']
    ];
    require_once "../app/templates/welcome.php"; // Redirigir al panel principal
    exit;
  } else {
    $error = "Usuario o contraseña incorrectos.";
  }
}
