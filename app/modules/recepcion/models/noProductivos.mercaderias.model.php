<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

function agregarMercaderia($datos) {

	$fechaActual = date('Y-m-d H:i:s');
	
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

function obtenerResumenRecepcion($recepcion_id) {
	try {
		$conn = getConnection();
		$sql = "SELECT * FROM recepcion_noProductivos_mercaderias_resumen WHERE recepcion_id = :recepcion_id";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':recepcion_id', $recepcion_id);
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
		$sql = "SELECT * FROM recepcion_noProductivos_mercaderias_detalle WHERE recepcion_id = :recepcion_id";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':recepcion_id', $recepcion_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("Recepción Mercaderías Model: Error al buscar detalle, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}
}

function obtenerRecepcionAbierta($operador_id) {
	$conn = getConnection();
	$sql = "SELECT recepcion_id FROM recepcion_noProductivos_mercaderias_resumen WHERE operador_id = :operador_id AND estado = 'pendiente'";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(':operador_id', $operador_id);
	$stmt->execute();
	return $stmt->fetchColumn(); // Devuelve directamente el recepcion_id o false si no hay
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
			return ['success' => false, 'message' => 'No hay mercaderías pendientes para guardar.'];
		}

		$sqlInsert = "INSERT INTO produccion_general (
												fecha_faena,
												fecha_produccion,
												fecha_recepcion,
												fecha_remito,
												fecha_sistema,
												creado_por_id,
												creado_por_username,
												proceso_id,
												mercaderia_id,
												proveedor_id,
												pallet_id,
												pedido_id,
												unidades,
												cantidad,
												peso_neto,
												peso_bruto,
												tara_pri,
												tara_sec,
												codbar_e,
												codbar_s,
												estado,
												impreso
											)
											VALUES (
												:fecha_faena,
												:fecha_produccion,
												:fecha_recepcion,
												:fecha_remito,
												:fecha_sistema,
												:creado_por_id,
												:creado_por_username,
												:mercaderia_id,
												:proveedor_id,
												:pallet_id,
												:pedido_id,
												:unidades,
												:cantidad,
												:peso_neto,
												:peso_bruto,
												:tara_pri,
												:tara_sec,
												:codbar_e,
												:codbar_s,
												:estado,
												:impreso
											)";

    $stmtInsert = $conn->prepare($sqlInsert);

		foreach ($mercaderias as $mercaderia) {
			$stmtInsert->execute([
				':fecha_faena' => $fechaActual,
				':fecha_produccion' => $fechaActual,
				':fecha_recepcion' => $mercaderia['fecha_recepcion'],
				':fecha_remito' => $mercaderia['fecha_remito'],
				':fecha_sistema' => $fechaActual,
				':creado_por_id' => $creado_por_id,
				':creado_por_username' => $creado_por_username,
				':mercaderia_id' => $mercaderia['mercaderia_id'],
				':proveedor_id' => $mercaderia['proveedor_id'],
				':pallet_id' => 0, // Asignar valor por defecto
				':pedido_id' => 0, // Asignar valor por defecto
				':unidades' => $mercaderia['unidades'],
				':cantidad' => 0, // Asignar valor por defecto
				':peso_neto' => $mercaderia['peso_neto'],
				':peso_bruto' => $mercaderia['peso_neto'] + $mercaderia['tara'], // Calcular peso bruto
				':tara_pri' => $mercaderia['tara'],
				':tara_sec' => $mercaderia['tara'],
				':codbar_e' => null, // Asignar valor por defecto
				':codbar_s' => 'codbar', // Asignar valor por defecto
				':estado' => 'disponible', // Estado inicial
				':impreso' => 1 // Por defecto
			]);
		}

		if ($stmtInsert->execute()) {
			registrarEvento("Recepción Mercaderías Model: mercadería guardada correctamente.", "INFO");
		}

		$sqlCerrarResumen = "UPDATE recepcion_noProductivos_mercaderias_resumen SET estado = 'cerrada', fecha_modificacion = :fecha WHERE recepcion_id = :recepcion_id";
		$stmtCerrarResumen = $conn->prepare($sqlCerrarResumen);
		$stmtCerrarResumen->execute([
				':fecha' => $fechaActual,
				':recepcion_id' => $recepcion_id
		]);

		$sqlCerrarDetalle = "UPDATE recepcion_noProductivos_mercaderias_detalle SET estado = 'cerrado', fecha_modificacion = :fecha WHERE recepcion_id = :recepcion_id";
		$stmtCerrarDetalle = $conn->prepare($sqlCerrarDetalle);
		$stmtCerrarDetalle->execute([
				':fecha' => $fechaActual,
				':recepcion_id' => $recepcion_id
		]);

		return ['success' => true, 'message' => 'Recepción guardada correctamente en producción_general.'];

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Recepción Mercaderías Model: Error al guardar la mercadería, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => 'Error al guardar la recepción.'];
	}
}

