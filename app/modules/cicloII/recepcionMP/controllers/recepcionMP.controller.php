<?php
/* require_once '../models/recepcionMP.model.php'; */
function formAction() {
    include '../app/modules/cicloII/recepcionMP/views/form.view.php';
}

function listadoAction() {
    $registros = obtenerRegistros();
    include __DIR__ . '../app/modules/cicloII/recepcionMP/views/listado.view.php';
}

function guardarAction() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = [
            'tropa' => $_POST['tropa'],
            'origen' => $_POST['origen'],
            'peso' => $_POST['peso'],
        ];

        if (validarDatos($data)) {
            guardarRecepcion($data);
            header("Location: index.php?module=cicloII/recepcionMP&action=listado");
            exit;
        } else {
            echo "Datos inválidos.";
        }
    }
}
