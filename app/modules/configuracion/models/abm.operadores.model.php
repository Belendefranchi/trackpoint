<?php
require_once __DIR__ . '/../../../../config/db.php';

function obtenerOperadores() {
    $conn = getConnection();
    $stmt = $conn->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function crearOperador($nombre, $email, $rol) {
    $conn = getConnection();

    $stmt = $conn->prepare("INSERT INTO users (nombre_completo, email, username, password, rol) VALUES (:nombre_completo, :email, :username, :password, :rol)");
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':rol', $rol);

    $result = $stmt->execute();
}
