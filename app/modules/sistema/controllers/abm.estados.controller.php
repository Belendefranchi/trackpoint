<?php
define('VISTA_INTERNA', true);

session_start();

require_once __DIR__ . '/../../module.controller.php';
require_once __DIR__ . '/../models/abm.estados.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Content-Type: application/json');

  $estado = $_POST['estado'] ?? '';

  if (isset($_GET['habilitar'])) {
    if (habilitarEstado($estado)) {
      registrarEvento("Configuración actualizada (habilitado '$estado')", "INFO");
      echo json_encode(['success' => true]);
    } else {
      registrarEvento("Fallo al habilitar tipo de estado: $estado", "ERROR");
      echo json_encode(['success' => false, 'message' => 'No se pudo habilitar el estado.']);
    }
    exit;
  }

  if (isset($_GET['deshabilitar'])) {
    if (deshabilitarEstado($estado)) {
      registrarEvento("Configuración actualizada (deshabilitado '$estado')", "INFO");
      echo json_encode(['success' => true]);
    } else {
      registrarEvento("Fallo al deshabilitar tipo de estado: $estado", "ERROR");
      echo json_encode(['success' => false, 'message' => 'No se pudo deshabilitar el estado.']);
    }
    exit;
  }
}

$estados = obtenerEstados();

$datosVista = [
  'estados' => $estados
];

cargarVista('/sistema/views/abm.estados.view.php', $datosVista);
