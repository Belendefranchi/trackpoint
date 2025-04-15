<?php
require_once __DIR__ . '/../../../config/db.php';

function loginUser($email, $password) {
    try {
        $conn = getConnection();
        if (!$conn) {
            return false;
        }

        $stmt = $conn->prepare("
            SELECT id, email, username, password, rol 
            FROM users 
            WHERE email = :email
        ");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos si existe el usuario y si la contraseña es correcta
        if ($user && password_verify($password, $user['password'])) {
            // No devolvemos la contraseña
            unset($user['password']);
            return $user;
        }else{
            return false;
        }

    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error al autenticar al usuario: " . $e->getMessage(), 3, __DIR__ . '/../../../logs/error.log');
        return false;
    }
}


