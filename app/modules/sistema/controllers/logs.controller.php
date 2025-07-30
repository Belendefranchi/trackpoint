<?php
define('VISTA_INTERNA', true);

session_start();

require_once __DIR__ . '/sistema.controller.php';
require_once __DIR__ . '/../models/logs.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Content-Type: application/json');

  $tipo = $_POST['tipo'] ?? '';

  if (isset($_GET['habilitar'])) {
    if (habilitarTipo($tipo)) {
      registrarEvento("Configuración de logs actualizada (habilitado '$tipo')", "INFO");
      echo json_encode(['success' => true]);
    } else {
      registrarEvento("Fallo al habilitar tipo de log: $tipo", "ERROR");
      echo json_encode(['success' => false, 'message' => 'No se pudo habilitar el log.']);
    }
    exit;
  }

  if (isset($_GET['deshabilitar'])) {
    if (deshabilitarTipo($tipo)) {
      registrarEvento("Configuración de logs actualizada (deshabilitado '$tipo')", "INFO");
      echo json_encode(['success' => true]);
    } else {
      registrarEvento("Fallo al deshabilitar tipo de log: $tipo", "ERROR");
      echo json_encode(['success' => false, 'message' => 'No se pudo deshabilitar el log.']);
    }
    exit;
  }
}

$tipos = obtenerTipos();

$datosVista = [
  'tipos' => $tipos
];

cargarVistaSistema('logs.view.php', $datosVista);
