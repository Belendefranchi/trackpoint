<?php
require_once __DIR__ . '/../../../../config/db.php';

function obtenerOperadores() {
    $conn = getConnection();
    $stmt = $conn->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function crearOperador($nombre_completo, $email, $rol) {
    $conn = getConnection();

    $stmt = $conn->prepare("INSERT INTO users (nombre_completo, email, username, password, rol) VALUES (:nombre_completo, :email, :username, :password, :rol)");
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':rol', $rol);

    $result = $stmt->execute();
}

function eliminarOperador($id) {
    $conn = getConnection();
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function editarOperador($id, $nombre_completo, $email, $rol) {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE users SET nombre_completo = :nombre_completo, email = :email, rol = :rol WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':rol', $rol);
    $stmt->execute();
}