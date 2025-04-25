<?php
require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../config/helpers.php';

function loginUser($username, $password) {
    try {
        $conn = getConnection();

        $stmt = $conn->prepare("SELECT * FROM configuracion_abm_operadores WHERE username = :username");
        $stmt->bindParam(':username', $username);
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
        $_SESSION['username'] = $_POST['username'];

        // Manejo de errores
        registrarEvento("Error al autenticar al usuario: " . $e->getMessage(), "ERROR");
        return false;
    }
}


