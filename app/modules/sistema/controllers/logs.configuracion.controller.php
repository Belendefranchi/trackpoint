<?php
require_once __DIR__ . '/../../../../core/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipos = $_POST['tipos'] ?? [];

    try {
        $conn = getConnection();
        $conn->beginTransaction();

        // Deshabilitar todos primero
        $conn->exec("UPDATE sistema_logs_tiposHabilitados SET habilitado = 0");

        // Habilitar solo los seleccionados
        $stmt = $conn->prepare("UPDATE sistema_logs_tiposHabilitados SET habilitado = 1 WHERE tipo = ?");
        foreach ($tipos as $tipo) {
            $stmt->execute([$tipo]);
        }

        $conn->commit();
        registrarEvento("Configuración de logs actualizada", "INFO");
        header('Location: logs.configuracion.view.php?ok=1');
        exit;
    } catch (Exception $e) {
        if ($conn->inTransaction()) $conn->rollBack();
        registrarEvento("Error al actualizar configuración de logs: " . $e->getMessage(), "ERROR");
        header('Location: logs.configuracion.view.php?error=1');
        exit;
    }
}
