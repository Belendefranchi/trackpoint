<?php
require_once 'app/auth/views/register.view.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_completo = ($_POST['nombre_completo']);
    $email = ($_POST['email']);
    $username = ($_POST['username']);
    $password = $_POST['password'];
    $rol = ($_POST['rol']);

    try {
        $conn = getConnection();

        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            echo "El usuario ya existe.";
            exit;
        }

        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, email, username, password, rol) VALUES (:nombre_completo, :email, :username, :password, :rol)");
        $stmt->bindParam(':nombre_completo', $nombre_completo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();


        header("Location: /login");
        exit;
    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
        exit;
    }
}
