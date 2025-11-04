<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function agregarMercaderia($datos) {

	$fechaActual = date('Y-m-d H:i:s');
	$datos['fecha_presupuesto'] = trim($datos['fecha_presupuesto']) === '' ? null : $datos['fecha_presupuesto'];
	
	try {
		$conn = getConnection();
		// 1. Buscar si ya existe un presupuesto abierto
		$sql = "SELECT presupuesto_id FROM expedicion_egresos_presupuestos_resumen WHERE operador_id = :operador_id AND estado = 'pendiente'";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':operador_id', $datos['operador_id']);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if($result){
			$presupuesto_id = $result['presupuesto_id'];
			registrarEvento("Presupuestos Model: mercadería pendiente en presupuesto.", "INFO");
		}else {
			// 2. Crear nuevo presupuesto
			$sqlResumen = "INSERT INTO expedicion_egresos_presupuestos_resumen (
											empresa_id,
											sucursal_id,
											rubro_id,
											fecha_presupuesto,
											fecha_vencimiento,
											cliente_id,
											direccion_cliente,
											contacto_nombre,
											operador_id,
											estado
										)
										VALUES (
											:empresa_id,
											:sucursal_id,
											:rubro_id,
											:fecha_presupuesto,
											:fecha_vencimiento,
											:cliente_id,
											:direccion_cliente,
											:contacto_nombre,
											:operador_id,
											:estado)";

			$stmtResumen = $conn->prepare($sqlResumen);
			$stmtResumen->bindValue(':empresa_id', $datos['empresa_id']);
			$stmtResumen->bindValue(':sucursal_id', $datos['sucursal_id']);
			$stmtResumen->bindValue(':rubro_id', $datos['rubro_id']);
			$stmtResumen->bindValue(':fecha_presupuesto', $datos['fecha_presupuesto']);
			$stmtResumen->bindValue(':fecha_vencimiento', $datos['fecha_vencimiento']);
			$stmtResumen->bindValue(':cliente_id', $datos['cliente_id']);
			$stmtResumen->bindValue(':direccion_cliente', $datos['direccion_cliente']);
			$stmtResumen->bindValue(':contacto_nombre', $datos['contacto_nombre']);
			$stmtResumen->bindValue(':operador_id', $datos['operador_id']);
			$stmtResumen->bindValue(':estado', 'pendiente');
			$stmtResumen->execute();
			
			// 3. Obtener el ID generado
			$presupuesto_id = $conn->lastInsertId();
			registrarEvento("Presupuestos Model: nuevo presupuesto creado.", "INFO");
		}

		// 4. Insertar en detalle
		$sqlDetalle = "INSERT INTO expedicion_egresos_presupuestos_detalle (
										presupuesto_id,
										mercaderia_id,
										cantidad,
										/* codigo_externo, */
										precio_venta,
										/* iva_tasa, */
										/* descuento_porcentaje, */
										fecha_modificacion,
										operador_id,
										estado
									)
                  VALUES (
										:presupuesto_id,
										:mercaderia_id,
										:cantidad,
										/* :codigo_externo, */
										:precio_venta,
										/* :iva_tasa, */
										/* :descuento_porcentaje, */
										:fecha_modificacion,
										:operador_id,
										:estado
									)";

		$stmtDetalle = $conn->prepare($sqlDetalle);
		$stmtDetalle->bindValue(':presupuesto_id', $presupuesto_id);
		$stmtDetalle->bindValue(':mercaderia_id', $datos['mercaderia_id']);
		$stmtDetalle->bindValue(':cantidad', $datos['cantidad']);
		/* $stmtDetalle->bindValue(':codigo_externo', $datos['codigo_externo']); */
		$stmtDetalle->bindValue(':precio_venta', $datos['precio_venta']);
		/* $stmtDetalle->bindValue(':iva_tasa', $datos['iva_tasa']); */
		/* $stmtDetalle->bindValue(':descuento_porcentaje', $datos['descuento_porcentaje']); */
		$stmtDetalle->bindValue(':fecha_modificacion', $fechaActual);
		$stmtDetalle->bindValue(':operador_id', $datos['operador_id']);
		$stmtDetalle->bindValue(':estado', 'pendiente');

		$result = $stmtDetalle->execute();

		if ($result) {
			registrarEvento("Presupuestos Model: mercadería agregada correctamente.", "INFO");
			return ['success' => true, 'presupuesto_id' => $presupuesto_id];
		} else {
			return ['success' => false, 'message' => 'Error al insertar en detalle'];
		}

	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al buscar pendientes, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}
}

function obtenerPresupuestoId($operador_id) {
	try {
		$conn = getConnection();
		$sql = "SELECT presupuesto_id FROM expedicion_egresos_presupuestos_resumen WHERE estado = 'pendiente' AND operador_id = :operador_id LIMIT 1";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':operador_id', $operador_id);
		$stmt->execute();
		return $stmt->fetchColumn();
	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al obtener ID de recepción, " . $e->getMessage(), "ERROR");
		return null;
	}
}

function obtenerResumenPresupuesto($operador_id) {
	try {
		$conn = getConnection();
		$sql = "SELECT 
							r.presupuesto_id,
							r.empresa_id,
							r.sucursal_id,
							r.rubro_id,
							r.fecha_presupuesto,
							r.fecha_vencimiento,
							r.cliente_id,
							r.direccion_cliente,
							r.contacto_nombre,
							r.estado,
							SUM(d.cantidad) AS cantidad,
							SUM(d.cantidad * d.precio_venta) AS total
						FROM expedicion_egresos_presupuestos_resumen r
						LEFT JOIN expedicion_egresos_presupuestos_detalle d
							ON r.presupuesto_id = d.presupuesto_id
						WHERE r.operador_id = :operador_id
							AND r.estado = 'pendiente'
						GROUP BY
							r.presupuesto_id,
							r.empresa_id,
							r.sucursal_id,
							r.rubro_id,
							r.fecha_presupuesto,
							r.fecha_vencimiento,
							r.cliente_id, r.direccion_cliente,
							r.contacto_nombre,
							r.estado
						";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':operador_id', $operador_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al buscar resumen, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}

}

function obtenerDetallePresupuesto($presupuesto_id) {
	try{
		$conn = getConnection();
		$sql = "SELECT 
								d.item_id,
								d.presupuesto_id,
								d.mercaderia_id,
								m.codigo AS codigo_mercaderia,
								m.descripcion AS descripcion_mercaderia,
								d.codigo_externo,
								d.cantidad,
								d.precio_costo,
								d.precio_venta,
								d.iva_tasa,
								d.descuento_porcentaje,
								(d.cantidad * d.precio_venta) AS subtotal
						FROM expedicion_egresos_presupuestos_detalle d
						LEFT JOIN configuracion_abm_mercaderias m
								ON d.mercaderia_id = m.mercaderia_id
						WHERE d.presupuesto_id = :presupuesto_id
							AND d.estado = 'pendiente'
						";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':presupuesto_id', $presupuesto_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al buscar detalle, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}
}

function editarPresupuesto($datos) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE expedicion_egresos_presupuestos_resumen
														SET
															empresa_id = :empresa_id,
															sucursal_id = :sucursal_id,
															rubro_id = :rubro_id,
															fecha_presupuesto = :fecha_presupuesto,
															fecha_vencimiento = :fecha_vencimiento,
															cliente_id = :cliente_id,
															direccion_cliente = :direccion_cliente,
															contacto_nombre = :contacto_nombre,
															fecha_modificacion = :fecha_modificacion
														WHERE
															presupuesto_id = :presupuesto_id");

		$stmt->bindParam(':presupuesto_id', $datos['presupuesto_id']);
		$stmt->bindParam(':empresa_id', $datos['empresa_id']);
		$stmt->bindParam(':sucursal_id', $datos['sucursal_id']);
		$stmt->bindParam(':rubro_id', $datos['rubro_id']);
		$stmt->bindParam(':fecha_presupuesto', $datos['fecha_presupuesto']);
		$stmt->bindParam(':fecha_vencimiento', $datos['fecha_vencimiento']);
		$stmt->bindParam(':cliente_id', $datos['cliente_id']);
		$stmt->bindParam(':direccion_cliente', $datos['direccion_cliente']);
		$stmt->bindParam(':contacto_nombre', $datos['contacto_nombre']);
		$stmt->bindParam(':fecha_modificacion', $fechaActual);
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Presupuestos Model: presupuesto editado correctamente.", "INFO");
		}
		return ['success' => true, 'message' => 'Presupuesto editado correctamente.'];

		} catch (PDOException $e) {
			// Manejo de errores
			registrarEvento("Presupuestos Model: Error al editar el presupuesto, " . $e->getMessage(), "ERROR");
			return false;
		}
}

function editarMercaderiaPresupuesto($datos) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE expedicion_egresos_presupuestos_detalle
														SET
															cantidad = :cantidad,
															precio_costo = :precio_costo,
															precio_venta = :precio_venta,
															iva_tasa = :iva_tasa,
															descuento_porcentaje = :descuento_porcentaje,
															fecha_modificacion = :fecha_modificacion
														WHERE
															item_id = :item_id");

		$stmt->bindParam(':item_id', $datos['item_id']);
		$stmt->bindParam(':cantidad', $datos['cantidad']);
		$stmt->bindParam(':precio_costo', $datos['precio_costo']);
		$stmt->bindParam(':precio_venta', $datos['precio_venta']);
		$stmt->bindParam(':iva_tasa', $datos['iva_tasa']);
		$stmt->bindParam(':descuento_porcentaje', $datos['descuento_porcentaje']);
		$stmt->bindParam(':fecha_modificacion', $fechaActual);
		$stmt->execute();
		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Presupuestos Model: mercadería editada correctamente.", "INFO");
		}
		return ['success' => true, 'message' => 'Mercadería editada correctamente.'];

		} catch (PDOException $e) {
			// Manejo de errores
			registrarEvento("Presupuestos Model: Error al editar la mercadería, " . $e->getMessage(), "ERROR");
			return false;
		}
}

function eliminarMercaderiaPresupuesto($item_id) {
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM expedicion_egresos_presupuestos_detalle WHERE item_id = :item_id");
		$stmt->bindParam(':item_id', $item_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Presupuestos Model: Error al eliminar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function generarPresupuesto($presupuesto_id) {

	$fechaActual = date('Y-m-d H:i:s');
	$creado_por_id = $_SESSION['operador_id'];
	$creado_por_username = $_SESSION['username'];

	try {
		$conn = getConnection();
		$stmt = $conn->prepare("SELECT * FROM expedicion_egresos_presupuestos_detalle WHERE presupuesto_id = :presupuesto_id AND estado = 'pendiente' AND operador_id = :operador_id");
		$stmt->bindParam(':presupuesto_id', $presupuesto_id);
		$stmt->bindParam(':operador_id', $creado_por_id);
		$stmt->execute();

		$mercaderias = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (!$mercaderias) {
			return ['success' => false, 'message' => 'No hay mercaderías pendientes para guardar'];
		}
		
		/* Aca no se deben guardar los registros en ninguna otra tabla, sino que se debe generar el pdf */

		/* $sqlInsert = "INSERT INTO produccion_general (
												codbar_s,
												codbar_e,
												estado,
												fecha_faena,
												fecha_produccion,
												fecha_presupuesto,
												fecha_remito,
												fecha_sistema,
												creado_por_id,
												creado_por_username,
												presupuesto_id,
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
												:fecha_presupuesto,
												:fecha_remito,
												:fecha_sistema,
												:creado_por_id,
												:creado_por_username,
												:presupuesto_id,
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
				':fecha_presupuesto' => $mercaderia['fecha_presupuesto'],
				':fecha_remito' => $mercaderia['fecha_remito'],
				':fecha_sistema' => $fechaActual,
				':creado_por_id' => $creado_por_id,
				':creado_por_username' => $creado_por_username,
				':presupuesto_id' => $presupuesto_id,
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
		} */

		registrarEvento("Presupuestos Model: presupuesto creado correctamente.", "INFO");

		$sqlCerrarResumen = "UPDATE expedicion_egresos_presupuestos_resumen SET estado = 'cerrado', fecha_modificacion = :fecha_presupuesto WHERE presupuesto_id = :presupuesto_id";
		$stmtCerrarResumen = $conn->prepare($sqlCerrarResumen);
		$stmtCerrarResumen->execute([
				':fecha_presupuesto' => $fechaActual,
				':presupuesto_id' => $presupuesto_id
		]);

		$sqlCerrarDetalle = "UPDATE expedicion_egresos_presupuestos_detalle SET estado = 'cerrado', fecha_modificacion = :fecha_presupuesto WHERE presupuesto_id = :presupuesto_id";
		$stmtCerrarDetalle = $conn->prepare($sqlCerrarDetalle);
		$stmtCerrarDetalle->execute([
				':fecha_presupuesto' => $fechaActual,
				':presupuesto_id' => $presupuesto_id
		]);

    registrarEvento("Presupuestos Model: Presupuesto creado correctamente => $presupuesto_id", "INFO");
		return ['success' => true, 'message' => 'Presupuesto creado correctamente en producción_general.'];

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Presupuestos Model: Error al guardar el presupuesto, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => 'Error al guardar el presupuesto.'];
	}
}

function eliminarPresupuesto($presupuesto_id) {

  $fechaActual = date('Y-m-d H:i:s');
  $creado_por_id = $_SESSION['operador_id'];
  $creado_por_username = $_SESSION['username'];

  try {
    $conn = getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM expedicion_egresos_presupuestos_resumen 
                            WHERE presupuesto_id = :presupuesto_id 
                              AND estado = 'pendiente' 
                              AND operador_id = :operador_id");
    $stmt->bindValue(':presupuesto_id', $presupuesto_id);
    $stmt->bindValue(':operador_id', $creado_por_id);
    $stmt->execute();

    $cantidad = $stmt->fetchColumn();

    if ($cantidad == 0) {
      return ['success' => false, 'message' => 'No hay presupuesto pendiente para cancelar'];
    }

    // Actualizar el estado en la tabla de detalle
    $stmt = $conn->prepare("UPDATE expedicion_egresos_presupuestos_detalle
                            SET estado = 'cancelado', fecha_modificacion = :fecha_modificacion
                            WHERE presupuesto_id = :presupuesto_id AND estado = 'pendiente'");
    $stmt->bindValue(':fecha_modificacion', $fechaActual);
    $stmt->bindValue(':presupuesto_id', $presupuesto_id);
    $stmt->execute();

    // Actualizar el estado en la tabla de resumen
    $stmtResumen = $conn->prepare("UPDATE expedicion_egresos_presupuestos_resumen
                                  SET estado = 'cancelado', fecha_modificacion = :fecha_modificacion
                                  WHERE presupuesto_id = :presupuesto_id");
    $stmtResumen->bindValue(':fecha_modificacion', $fechaActual);
    $stmtResumen->bindValue(':presupuesto_id', $presupuesto_id);
    $stmtResumen->execute();

    registrarEvento("Presupuestos Model: Presupuesto cancelado correctamente => $presupuesto_id", "INFO");
    return ['success' => true, 'message' => 'Presupuesto cancelado correctamente.'];

  } catch (PDOException $e) {
    registrarEvento("Presupuestos Model: Error al cancelar el presupuesto => " . $e->getMessage(), "ERROR");
    return ['success' => false, 'message' => 'Error al cancelar el presupuesto.'];
  }
}


