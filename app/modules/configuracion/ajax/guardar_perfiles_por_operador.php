<?php
// guardar_perfiles_por_operador.php

require_once __DIR__ . '/../models/abm.perfilesPorOperador.model.php';

// Asegurar que venga por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Obtener datos enviados
$idOperador = isset($_POST['id_operador']) ? (int)$_POST['id_operador'] : null;
$perfiles = isset($_POST['perfiles']) ? $_POST['perfiles'] : [];

// Validar datos
if (!$idOperador || !is_array($perfiles)) {
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

// Procesar el guardado en la base de datos
try {
    // Función modelo que deberías tener en abm.perfilesPorOperador.model.php
    guardarPerfilesPorOperador($idOperador, $perfiles);

    echo json_encode(['success' => true, 'message' => 'Perfiles asignados correctamente']);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error al guardar perfiles: ' . $e->getMessage()]);
}
exit;
