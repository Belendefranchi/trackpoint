<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerEstados() {
  try {
    $conn = getConnection();
    $stmt = $conn->query("SELECT * FROM sistema_estados_tiposHabilitados");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    registrarEvento("Error al obtener tipos de estado: " . $e->getMessage(), "ERROR");
    return [];
  }
}

function habilitarEstado($estado) {
  try {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE sistema_estados_tiposHabilitados SET habilitado = 1 WHERE estado = :estado");
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

    if ($stmt->execute()) {
      registrarEvento("Tipo de estado habilitado: $estado", "INFO");
      return true;
    }

    return false;
  } catch (PDOException $e) {
    registrarEvento("Error al habilitar tipo de estado: " . $e->getMessage(), "ERROR");
    return false;
  }
}

function deshabilitarEstado($estado) {
  try {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE sistema_estados_tiposHabilitados SET habilitado = 0 WHERE estado = :estado");
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

    if ($stmt->execute()) {
      registrarEvento("Tipo de estado deshabilitado: $estado", "INFO");
      return true;
    }

    return false;
  } catch (PDOException $e) {
    registrarEvento("Error al deshabilitar tipo de estado: " . $e->getMessage(), "ERROR");
    return false;
  }
}
