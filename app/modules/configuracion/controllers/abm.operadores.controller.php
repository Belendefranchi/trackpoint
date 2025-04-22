<?php
require_once __DIR__ . '/../models/abm.operadores.model.php';
require_once __DIR__ . '/configuracion.controller.php';

// Lógica de crear, eliminar, actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $nombre_completo = $_POST['nombre_completo'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];
        $fecha = $_POST['creado_en'];

        // Llamar a la función que actualiza los datos
        editarOperador($id, $nombre_completo, $email, $rol);

        // Redirigimos para evitar reenvío del formulario
        header('Location: index.php?route=/configuracion/ABMs/operadores');
        exit;
    } elseif (isset($_POST['eliminar'])) {
        $id = $_POST['id'];

        // Llamar a la función que elimina el operador
        eliminarOperador($id);

        // Redirigimos para evitar reenvío del formulario
        header('Location: index.php?route=/configuracion/ABMs/operadores');
        exit;
    }
}


// Obtener datos para pasar a la vista
$operadores = obtenerOperadores();

// Llamar a la función común que carga todo en el layout
cargarVistaConfiguracion('abm.operadores.view.php', [
    'operadores' => $operadores
]);
