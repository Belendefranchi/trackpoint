<?php
require_once '../config/db.php';

function userExists($username) {
  $conn = getConnection();
  $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
  $stmt->execute([$username]);
  return $stmt->fetch() !== false;
}

function crearUsuario($nombre, $username, $hash, $rol) {
  $conn = getConnection();
  $stmt = $conn->prepare("INSERT INTO users (nombre_completo, username, password, rol) VALUES (?, ?, ?, ?)");
  return $stmt->execute([$nombre, $username, $hash, $rol]);
}
