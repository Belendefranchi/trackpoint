<?php
require_once __DIR__ . '/../../../config/db.php';

function loginUser($email, $password) {
    try {
        $conn = getConnection();
        if (!$conn) return false;

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
/*         while ($row = $result->fetchArray()) {
            $db_email = $row["email"];
            $db_password_hash = $row["password"];
            $db_rol = $row["rol"];
            if ($email == $db_email && $password == password_verify($password, $db_password_hash)) {
                $_SESSION["email"] = $db_email;
                $_SESSION["rol"] = $db_rol;
            }
            return $db_rol; 
        } */
        $dbUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dbUser && password_verify($password, $dbUuser['password'])) {
            return $dbUser;
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
