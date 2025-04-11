<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
require_once 'app/auth/views/register.view.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $nombre   = trim($_POST['nombre']);

    if (empty($username) || empty($password) || empty($nombre)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Hashear la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn = getConnection();

        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            echo "El usuario ya existe.";
            exit;
        }

        // Insertar usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password, nombre) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPassword, $nombre]);

        header("Location: /login");
        exit;
    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
        exit;
    }
}
