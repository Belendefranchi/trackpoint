<?php

require_once __DIR__ . '/../models/abm.perfilesPorOperador.model.php';

// Verificamos que se hayan recibido los datos correctos
if (isset($_POST['operadorId']) && isset($_POST['perfiles'])) {
    $operadorId = (int) $_POST['operadorId'];  // ID del operador
    $perfiles = $_POST['perfiles'];  // Array con los IDs de los perfiles seleccionados

    // Llamamos a la función que guarda los perfiles asignados
    $resultado = guardarPerfilesPorOperador($operadorId, $perfiles);

    // Si el resultado es verdadero, se guardaron los datos
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Perfiles asignados correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hubo un error al guardar los perfiles']);
    }
} else {
    // Si no se recibieron los datos correctos
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

exit;
