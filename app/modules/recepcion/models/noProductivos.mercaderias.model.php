<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function agregarMercaderia($datos) {

	$fechaActual = date('Y-m-d H:i:s');
	$datos['fecha_remito'] = trim($datos['fecha_remito']) === '' ? null : $datos['fecha_remito'];
	
	try {
		$conn = getConnection();
		// 1. Buscar si ya existe una recepción abierta
		$sql = "SELECT recepcion_id FROM recepcion_noProductivos_mercaderias_resumen WHERE operador_id = :operador_id AND estado = 'pendiente'";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':operador_id', $datos['operador_id']);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if($result){
			$recepcion_id = $result['recepcion_id'];
			registrarEvento("Recepción Mercaderías Model: mercadería pendiente en recepción.", "INFO");
		}else {
			// 2. Crear nueva recepción
			$sqlResumen = "INSERT INTO recepcion_noProductivos_mercaderias_resumen (fecha_recepcion, fecha_sistema, operador_id, estado) VALUES (:fecha_recepcion, :fecha_sistema, :operador_id, :estado)";

			$stmtResumen = $conn->prepare($sqlResumen);
			$stmtResumen->bindValue(':fecha_recepcion', $datos['fecha_recepcion']);
			$stmtResumen->bindValue(':fecha_sistema', $fechaActual);
			$stmtResumen->bindValue(':operador_id', $datos['operador_id']);
			$stmtResumen->bindValue(':estado', 'pendiente');
			$stmtResumen->execute();
			
			// 3. Obtener el ID generado
			$recepcion_id = $conn->lastInsertId();
			registrarEvento("Recepción Mercaderías Model: nueva recepción creada.", "INFO");
		}

		// 4. Insertar en detalle
		$sqlDetalle = "INSERT INTO recepcion_noProductivos_mercaderias_detalle (
										recepcion_id,
										proveedor_id,
										fecha_recepcion,
										nro_remito,
										fecha_remito,
										mercaderia_id,
										unidades,
										peso_neto,
										fecha_sistema,
										fecha_modificacion,
										operador_id
									)
                  VALUES (
										:recepcion_id,
										:proveedor_id,
										:fecha_recepcion,
										:nro_remito,
										:fecha_remito,
										:mercaderia_id,
										:unidades,
										:peso_neto,
										:fecha_sistema,
										:fecha_modificacion,
										:operador_id
									)";

		$stmtDetalle = $conn->prepare($sqlDetalle);
		$stmtDetalle->bindValue(':recepcion_id', $recepcion_id);
		$stmtDetalle->bindValue(':proveedor_id', $datos['proveedor_id']);
		$stmtDetalle->bindValue(':fecha_recepcion', $datos['fecha_recepcion']);
		$stmtDetalle->bindValue(':nro_remito', $datos['nro_remito']);
		$stmtDetalle->bindValue(':fecha_remito', $datos['fecha_remito']);
		$stmtDetalle->bindValue(':mercaderia_id', $datos['mercaderia_id']);
		$stmtDetalle->bindValue(':unidades', $datos['unidades']);
		$stmtDetalle->bindValue(':peso_neto', $datos['peso_neto']);
		$stmtDetalle->bindValue(':fecha_sistema', $fechaActual);
		$stmtDetalle->bindValue(':fecha_modificacion', $fechaActual);
		$stmtDetalle->bindValue(':operador_id', $datos['operador_id']);
		
		$result = $stmtDetalle->execute();

		if ($result) {
			registrarEvento("Recepción Mercaderías Model: mercadería agregada correctamente.", "INFO");
			return ['success' => true, 'recepcion_id' => $recepcion_id];
		} else {
			return ['success' => false, 'message' => 'Error al insertar en detalle'];
		}

	} catch (PDOException $e) {
		registrarEvento("Recepción Mercaderías Model: Error al buscar pendientes, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}
}

function obtenerResumenRecepcion($operador_id) {
	try {
		$conn = getConnection();
		$sql = "SELECT 
								r.recepcion_id,
								r.fecha_recepcion,
								r.operador_id,
								r.estado,
								ISNULL(SUM(d.unidades), 0) AS total_unidades,
								ISNULL(SUM(d.peso_neto), 0) AS total_peso_neto
						FROM recepcion_noProductivos_mercaderias_resumen r
						LEFT JOIN recepcion_noProductivos_mercaderias_detalle d 
								ON r.recepcion_id = d.recepcion_id
						WHERE r.operador_id = :operador_id 
							AND r.estado = 'pendiente'
						GROUP BY 
								r.recepcion_id, 
								r.fecha_recepcion,
								r.operador_id, 
								r.estado
						";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':operador_id', $operador_id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("Recepción Mercaderías Model: Error al buscar resumen, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}

}

function obtenerDetalleRecepcion($recepcion_id) {
	try{
		$conn = getConnection();
		$sql = "SELECT 
								d.item_id,
								d.recepcion_id,
								d.proveedor_id,
								d.fecha_recepcion,
								d.nro_remito,
								d.fecha_remito,
								m.codigo AS codigo_mercaderia,
								m.descripcion AS descripcion_mercaderia,
								d.unidades,
								d.peso_neto,
								d.estado
						FROM recepcion_noProductivos_mercaderias_detalle d
						JOIN produccion_abm_mercaderias m 
							ON d.mercaderia_id = m.mercaderia_id
						WHERE d.recepcion_id = :recepcion_id
							AND d.estado = 'pendiente'
						";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':recepcion_id', $recepcion_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("Recepción Mercaderías Model: Error al buscar detalle, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}
}

function editarMercaderiaRecepcion($datos) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE recepcion_noProductivos_mercaderias_detalle
														SET
															proveedor_id = :proveedor_id,
															nro_remito = :nro_remito,
															fecha_remito = :fecha_remito,
															unidades = :unidades,
															peso_neto = :peso_neto
														WHERE
															item_id = :item_id");

		$stmt->bindParam(':item_id', $datos['item_id']);		
		$stmt->bindParam(':proveedor_id', $datos['proveedor_id']);
		$stmt->bindParam(':nro_remito', $datos['nro_remito']);
		$stmt->bindParam(':fecha_remito', $datos['fecha_remito']);
		$stmt->bindValue(':unidades', (float) $datos['unidades'], PDO::PARAM_STR);
		$stmt->bindValue(':peso_neto',(float) $datos['peso_neto'], PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Recepción Mercaderías Model: mercadería editada correctamente.", "INFO");
		}
		return $result;
		} catch (PDOException $e) {
			// Manejo de errores
			registrarEvento("Recepción Mercaderías Model: Error al editar la mercadería, " . $e->getMessage(), "ERROR");
			return false;
		}
}

function eliminarMercaderiaRecepcion($item_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM recepcion_noProductivos_mercaderias_detalle WHERE item_id = :item_id");
		$stmt->bindParam(':item_id', $item_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Recepción Mercaderías Model: Error al eliminar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function guardarRecepcion($recepcion_id) {

	$fechaActual = date('Y-m-d H:i:s');
	$creado_por_id = $_SESSION['operador_id'];
	$creado_por_username = $_SESSION['username'];

	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT * FROM recepcion_noProductivos_mercaderias_detalle WHERE recepcion_id = :recepcion_id AND estado = 'pendiente' AND operador_id = :operador_id");
		$stmt->bindParam(':recepcion_id', $recepcion_id);
		$stmt->bindParam(':operador_id', $creado_por_id);
		$stmt->execute();

		$mercaderias = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (!$mercaderias) {
			return ['success' => false, 'message' => 'No hay mercaderías pendientes para guardar'];
		}

		$sqlInsert = "INSERT INTO produccion_general (
												codbar_s,
												codbar_e,
												estado,
												fecha_faena,
												fecha_produccion,
												fecha_recepcion,
												fecha_remito,
												fecha_sistema,
												creado_por_id,
												creado_por_username,
												recepcion_id,
												proveedor_id,
												proceso_id,
												mercaderia_id,
												pallet_id,
												pedido_id,
												unidades,
												cantidad,
												peso_neto,
												peso_bruto,
												tara_pri,
												tara_sec,
												impreso
											)
											VALUES (
												:codbar_s,
												:codbar_e,
												:estado,
												:fecha_faena,
												:fecha_produccion,
												:fecha_recepcion,
												:fecha_remito,
												:fecha_sistema,
												:creado_por_id,
												:creado_por_username,
												:recepcion_id,
												:proveedor_id,
												:proceso_id,
												:mercaderia_id,
												:pallet_id,
												:pedido_id,
												:unidades,
												:cantidad,
												:peso_neto,
												:peso_bruto,
												:tara_pri,
												:tara_sec,
												:impreso
											)";

		$stmtInsert = $conn->prepare($sqlInsert);

		foreach ($mercaderias as $mercaderia) {
			$stmtInsert->execute([
				':codbar_s' => 'codbar',
				':codbar_e' => 0,
				':estado' => 'disponible',
				':fecha_faena' => $fechaActual,
				':fecha_produccion' => $fechaActual,
				':fecha_recepcion' => $mercaderia['fecha_recepcion'],
				':fecha_remito' => $mercaderia['fecha_remito'],
				':fecha_sistema' => $fechaActual,
				':creado_por_id' => $creado_por_id,
				':creado_por_username' => $creado_por_username,
				':recepcion_id' => $recepcion_id,
				':proveedor_id' => $mercaderia['proveedor_id'],
				':proceso_id' => null,
				':mercaderia_id' => $mercaderia['mercaderia_id'],
				':pallet_id' => null,
				':pedido_id' => null,
				':unidades' => $mercaderia['unidades'],
				':cantidad' => 0,
				':peso_neto' => $mercaderia['peso_neto'],
				':peso_bruto' => $mercaderia['peso_neto'] + ($mercaderia['tara'] ?? 0),
				':tara_pri' => $mercaderia['tara'] ?? 0,
				':tara_sec' => $mercaderia['tara'] ?? 0,
				':impreso' => 1
			]);
		}

		registrarEvento("Recepción Mercaderías Model: recepción guardada correctamente.", "INFO");

		$sqlCerrarResumen = "UPDATE recepcion_noProductivos_mercaderias_resumen SET estado = 'cerrada', fecha_modificacion = :fecha WHERE recepcion_id = :recepcion_id";
		$stmtCerrarResumen = $conn->prepare($sqlCerrarResumen);
		$stmtCerrarResumen->execute([
				':fecha' => $fechaActual,
				':recepcion_id' => $recepcion_id
		]);

		$sqlCerrarDetalle = "UPDATE recepcion_noProductivos_mercaderias_detalle SET estado = 'cerrada', fecha_modificacion = :fecha WHERE recepcion_id = :recepcion_id";
		$stmtCerrarDetalle = $conn->prepare($sqlCerrarDetalle);
		$stmtCerrarDetalle->execute([
				':fecha' => $fechaActual,
				':recepcion_id' => $recepcion_id
		]);

    registrarEvento("Recepción Mercaderías Model: recepción guardada correctamente => $recepcion_id", "INFO");
		return ['success' => true, 'message' => 'Recepción guardada correctamente en producción_general.'];

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Recepción Mercaderías Model: Error al guardar la recepción, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => 'Error al guardar la recepción.'];
	}
}

function cancelarRecepcion($recepcion_id) {

  $fechaActual = date('Y-m-d H:i:s');
  $creado_por_id = $_SESSION['operador_id'];
  $creado_por_username = $_SESSION['username'];

  try {
    $conn = getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM recepcion_noProductivos_mercaderias_resumen 
                            WHERE recepcion_id = :recepcion_id 
                              AND estado = 'pendiente' 
                              AND operador_id = :operador_id");
    $stmt->bindValue(':recepcion_id', $recepcion_id);
    $stmt->bindValue(':operador_id', $creado_por_id);
    $stmt->execute();

    $cantidad = $stmt->fetchColumn();

    if ($cantidad == 0) {
      return ['success' => false, 'message' => 'No hay recepción pendiente para cancelar'];
    }

    // Actualizar el estado en la tabla de detalle
    $stmt = $conn->prepare("UPDATE recepcion_noProductivos_mercaderias_detalle 
                            SET estado = 'cancelada', fecha_modificacion = :fecha 
                            WHERE recepcion_id = :recepcion_id AND estado = 'pendiente'");
    $stmt->bindValue(':fecha', $fechaActual);
    $stmt->bindValue(':recepcion_id', $recepcion_id);
    $stmt->execute();

    // Actualizar el estado en la tabla de resumen
    $stmtResumen = $conn->prepare("UPDATE recepcion_noProductivos_mercaderias_resumen 
                                  SET estado = 'cancelada', fecha_modificacion = :fecha 
                                  WHERE recepcion_id = :recepcion_id");
    $stmtResumen->bindValue(':fecha', $fechaActual);
    $stmtResumen->bindValue(':recepcion_id', $recepcion_id);
    $stmtResumen->execute();

    registrarEvento("Recepción Mercaderías Model: recepción cancelada correctamente => $recepcion_id", "INFO");
    return ['success' => true, 'message' => 'Recepción cancelada correctamente.'];

  } catch (PDOException $e) {
    registrarEvento("Recepción Mercaderías Model: Error al cancelar la recepción => " . $e->getMessage(), "ERROR");
    return ['success' => false, 'message' => 'Error al cancelar la recepción.'];
  }
}


