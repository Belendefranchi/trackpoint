<?php
require_once __DIR__ . '/../../../config/db.php';

function loginUser($email, $password) {
    try {
        $conn = getConnection();
        if (!$conn) {
            return false;
        }

        // Seleccionamos todos los campos que necesitamos
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


    } catch (Exception $e) {
        // En producción usarías un logger, por ahora podés guardar el error en un archivo:
        error_log("loginUser error: " . $e->getMessage(), 3, '/../../../logs/error.log');
        return false;
    }
}


/* function loginUserConPruebas($email, $password) {
    try {
        $conn = getConnection();
        var_dump($conn);
        if (!$conn) {
            echo "Sin conexión\n";
            return false;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Usuario no encontrado\n";
            return false;
        }

        echo "Password ingresado: $password\n";
        echo "Password en DB: " . $user['password'] . "\n";

        if (password_verify($password, $user['password'])) {
            echo "Verificación: OK\n";
            return $user;
        } else {
            echo "Verificación: FALLA\n";
        }

        return false;

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        return false;
    }

    echo "</pre>";
} */


