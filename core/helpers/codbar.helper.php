<?php
require_once __DIR__ . '/../../../../core/config/db.php';

function generarCodbar($conn, $equipo_id, $cliente_id, $fecha_produccion) {
  try {
    $conn->beginTransaction();

    $clave = $cliente_id . '_' . $equipo_id . '_' . $fecha_produccion;

    $stmt = $conn->prepare("SELECT ultimo_valor FROM codbar_contadores WHERE clave = :clave FOR UPDATE");
    $stmt->execute([':clave' => $clave]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      $nuevoValor = $row['ultimo_valor'] + 1;
      $stmtUpdate = $conn->prepare("UPDATE codbar_contadores SET ultimo_valor = :valor WHERE clave = :clave");
      $stmtUpdate->execute([':valor' => $nuevoValor, ':clave' => $clave]);
    } else {
      $nuevoValor = 1;
      $stmtInsert = $conn->prepare("INSERT INTO codbar_contadores (clave, ultimo_valor) VALUES (:clave, :valor)");
      $stmtInsert->execute([':clave' => $clave, ':valor' => $nuevoValor]);
    }

    $conn->commit();

    $codigo = str_pad($cliente_id, 2, '0', STR_PAD_LEFT)
            . str_pad($equipo_id, 2, '0', STR_PAD_LEFT)
            . date('Ymd', strtotime($fecha_produccion))
            . str_pad($nuevoValor, 6, '0', STR_PAD_LEFT);

    // Logging detallado
    $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'desconocido';
    $logMensaje = "Código generado: $codigo | Cliente: $cliente_id | Equipo: $equipo_id | Fecha prod.: $fecha_produccion | Correlativo: $nuevoValor | Usuario: $usuario | Fecha/Hora: " . date('Y-m-d H:i:s');
    registrarEvento($logMensaje, "INFO");

    return $codigo;

  } catch (Exception $e) {
    $conn->rollBack();
    registrarEvento("Error al generar código de barras: " . $e->getMessage(), "ERROR");
    return false;
  }
}
