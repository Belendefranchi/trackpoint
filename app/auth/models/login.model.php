<?php
require_once __DIR__ . '/../../../config/db.php';

function check_credentials($email, $password) {
    $conn = getConnection();
    if (!$conn) return false;

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}
