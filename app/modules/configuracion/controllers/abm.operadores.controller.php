<?php
require_once __DIR__ . '/../models/abm.operadores.model.php';
require_once __DIR__ . '/configuracion.controller.php';

// Lógica de crear, eliminar, actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        crearOperador($_POST['nombre_completo'], $_POST['email'], $_POST['rol']);
    }

    if (isset($_POST['eliminar'])) {
        eliminarOperador($_POST['id']);
    }

    if (isset($_POST['actualizar'])) {
        actualizarOperador($_POST['id'], $_POST['nombre_completo'], $_POST['email'], $_POST['rol']);
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener datos para pasar a la vista
$operadores = obtenerOperadores();

// Llamar a la función común que carga todo en el layout
cargarVistaConfiguracion('abm.operadores.view.php', [
    'operadores' => $operadores
]);
