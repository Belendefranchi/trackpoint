<?php
require_once '../../config/db.php';

function userExists($email) {
  $conn = getConnection();
  $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->execute([$email]);
  return $stmt->fetch() !== false;
}

function crearUsuario($nombre, $email, $username, $hash, $rol) {
  $conn = getConnection();
  $stmt = $conn->prepare("INSERT INTO auth.users (email, nombre_completo, username, password, rol) VALUES (?, ?, ?, ?, ?)");
  return $stmt->execute([$email, $nombre, $username, $hash, $rol]);
}
