<?php
require_once '../models/register.model.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre_completo'] ?? '';
  $email = $_POST['email'] ?? '';
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  $rol = $_POST['rol'] ?? '';

  if ($nombre && $username && $password && $rol) {
    $existe = userExists($username);
    if ($existe) {
      $error = "El usuario ya existe.";
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      crearUsuario($nombre, $email, $username, $hash, $rol);
      $success = "Usuario registrado correctamente.";
    }
  } else {
    $error = "Todos los campos son obligatorios.";
  }
}
