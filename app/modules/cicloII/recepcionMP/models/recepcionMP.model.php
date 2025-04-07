<?php
function guardarRecepcion($data) {
    file_put_contents('registros.txt', json_encode($data) . PHP_EOL, FILE_APPEND);
}

function obtenerRegistros() {
    $lines = file('registros.txt', FILE_IGNORE_NEW_LINES);
    return array_map('json_decode', $lines);
}

function validarDatos($data) {
    return isset($data['tropa'], $data['origen'], $data['peso']) && is_numeric($data['peso']);
}
