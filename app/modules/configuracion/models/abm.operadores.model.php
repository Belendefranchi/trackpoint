<?php
require_once __DIR__ . '/../../../../config/db.php';

function obtenerOperadores() {
    try {
        $conn = getConnection();
        $stmt = $conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error al obtener los usuarios: " . $e->getMessage(), 3, __DIR__ . '/../../../../logs/error.log');
        return false;
    }
}

function userExists($email) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: false;
    } catch (PDOException $e) {
        error_log("Error al verificar si el usuario existe: " . $e->getMessage(), 3, __DIR__ . '/../../../../logs/error.log');
        return false;
    }
}

function crearOperador($username, $hashedPassword, $nombre_completo, $email, $rol) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO users (nombre_completo, email, username, password, rol) VALUES (:nombre_completo, :email, :username, :password, :rol)");
        $stmt->bindParam(':nombre_completo', $nombre_completo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':rol', $rol);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error al crear el usuario: " . $e->getMessage(), 3, __DIR__ . '/../../../../logs/error.log');
        return false;
    }
}

function eliminarOperador($id) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error al eliminar el usuario: " . $e->getMessage(), 3, __DIR__ . '/../../../../logs/error.log');
        return false;
    }
}

function editarOperador($id, $nombre_completo, $email, $rol) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE users SET nombre_completo = :nombre_completo, email = :email, rol = :rol WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre_completo', $nombre_completo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
        return $stmt->execute();
    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error al actualizar el usuario: " . $e->getMessage(), 3, __DIR__ . '/../../../../logs/error.log');
        return false;
    }
}

function restablecerPassword($id, $newHashedPassword) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':password', $newHashedPassword);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error al restablecer la contraseña: " . $e->getMessage(), 3, __DIR__ . '/../../../../logs/error.log');
        return false;
    }
}