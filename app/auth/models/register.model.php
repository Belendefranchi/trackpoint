<?php
require_once __DIR__ . '/../../../config/db.php';

function userExists($email) {
  try {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT id FROM configuracion_abm_operadores WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ? true : false;
  } catch (PDOException $e) {
    // Manejo de errores
		registrarEvento("Register Model: Error al verificar si el usuario existe: " . $e->getMessage(), "ERROR");
    return false;
  }
}

function crearUsuario($nombre_completo, $email, $username, $hashedPassword, $rol) {
  try {
    $conn = getConnection();    
    $stmt = $conn->prepare("INSERT INTO configuracion_abm_operadores (nombre_completo, email, username, password, rol) VALUES (:nombre_completo, :email, :username, :password, :rol)");
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':rol', $rol);
    $result = $stmt->execute();
    return $result;
  } catch (PDOException $e) {
    // Manejo de errores
		registrarEvento("Register Model: Error al crear usuario: " . $e->getMessage(), "ERROR");
    return false;
  }
}

