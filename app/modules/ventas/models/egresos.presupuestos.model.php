<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerPresupuestoId($operador_id){
	try {
		$conn = getConnection();
		$sql = "SELECT presupuesto_id FROM ventas_egresos_presupuestos_resumen WHERE estado = 'pendiente' AND operador_id = :operador_id LIMIT 1";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':operador_id', $operador_id);
		$stmt->execute();
		return $stmt->fetchColumn();
	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al obtener ID de recepción, " . $e->getMessage(), "ERROR");
		return null;
	}
}

function obtenerUltimoPresupuestoId()
{
	try {
		$conn = getConnection();
		$sql = "SELECT MAX(presupuesto_id) AS ultimo_id FROM ventas_egresos_presupuestos_resumen";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchColumn();
	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al obtener último ID de presupuesto, " . $e->getMessage(), "ERROR");
		return null;
	}
}

function obtenerResumenPresupuesto($operador_id){
	try {
		$conn = getConnection();
		$sql = "SELECT 
							r.presupuesto_id,
							r.empresa_nombre,
							r.sucursal_nombre,
							r.rubro_nombre,
							r.fecha_presupuesto,
							r.fecha_vencimiento,
							r.cliente_nombre,
							r.cliente_direccion,
							r.cliente_contacto,
							r.estado,
							r.lista_id,
							l.nombre AS lista_nombre,
							SUM(d.cantidad) AS cantidad,
							SUM(d.cantidad * d.precio_venta) AS total
						FROM ventas_egresos_presupuestos_resumen r
						LEFT JOIN ventas_egresos_listaPrecios_resumen l
							ON r.lista_id = l.lista_id
						LEFT JOIN ventas_egresos_presupuestos_detalle d
							ON r.presupuesto_id = d.presupuesto_id
						WHERE r.operador_id = :operador_id
							AND r.estado = 'pendiente'
						GROUP BY
							r.presupuesto_id,
							r.empresa_nombre,
							r.sucursal_nombre,
							r.rubro_nombre,
							r.fecha_presupuesto,
							r.fecha_vencimiento,
							r.cliente_nombre,
							r.cliente_direccion,
							r.cliente_contacto,
							r.estado,
							r.lista_id,
							l.nombre
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

function obtenerResumenPresupuestoPorId($presupuesto_id){
	try {
		$conn = getConnection();
		$sql = "SELECT 
							r.presupuesto_id,
							r.empresa_nombre,
							r.sucursal_nombre,
							r.rubro_nombre,
							r.fecha_presupuesto,
							r.fecha_vencimiento,
							r.cliente_nombre,
							r.cliente_direccion,
							r.cliente_contacto,
							r.estado,
							r.lista_id,
							l.nombre AS lista_nombre,
							SUM(d.cantidad) AS cantidad,
							SUM(d.cantidad * d.precio_venta) AS total
						FROM ventas_egresos_presupuestos_resumen r
						LEFT JOIN ventas_egresos_listaPrecios_resumen l
							ON r.lista_id = l.lista_id
						LEFT JOIN ventas_egresos_presupuestos_detalle d
							ON r.presupuesto_id = d.presupuesto_id
						WHERE r.presupuesto_id = :presupuesto_id
						GROUP BY
							r.presupuesto_id,
							r.empresa_nombre,
							r.sucursal_nombre,
							r.rubro_nombre,
							r.fecha_presupuesto,
							r.fecha_vencimiento,
							r.cliente_nombre,
							r.cliente_direccion,
							r.cliente_contacto,
							r.estado,
							r.lista_id,
							l.nombre
						";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':presupuesto_id', $presupuesto_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al buscar resumen, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}

}

function obtenerDetallePresupuestoPorId($presupuesto_id){
	try {
		$conn = getConnection();
		$sql = "SELECT 
								item_id,
								presupuesto_id,
								codigo_mercaderia,
								descripcion_mercaderia,
								codigo_externo,
								cantidad,
								precio_compra,
								precio_venta,
								iva_tasa,
								descuento_porcentaje,
								(cantidad * precio_venta) AS subtotal
						FROM ventas_egresos_presupuestos_detalle
						WHERE presupuesto_id = :presupuesto_id
							--AND estado = 'pendiente'
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

function crearPresupuesto($datos){

	$creado_por = $_SESSION['username'];

	try {
		$conn = getConnection();
		$sql = "INSERT INTO ventas_egresos_presupuestos_resumen (
							empresa_nombre,
							sucursal_nombre,
							rubro_nombre,
							fecha_presupuesto,
							fecha_vencimiento,
							cliente_nombre,
							cliente_direccion,
							cliente_contacto,
							operador_id,
							creado_por,
							lista_id,
							estado
						)
						VALUES (
							:empresa_nombre,
							:sucursal_nombre,
							:rubro_nombre,
							:fecha_presupuesto,
							:fecha_vencimiento,
							:cliente_nombre,
							:cliente_direccion,
							:cliente_contacto,
							:operador_id,
							:creado_por,
							:lista_id,
							:estado)";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':empresa_nombre', $datos['empresa_nombre']);
		$stmt->bindParam(':sucursal_nombre', $datos['sucursal_nombre']);
		$stmt->bindParam(':rubro_nombre', $datos['rubro_nombre']);
		$stmt->bindParam(':fecha_presupuesto', $datos['fecha_presupuesto']);
		$stmt->bindParam(':fecha_vencimiento', $datos['fecha_vencimiento']);
		$stmt->bindParam(':cliente_nombre', $datos['cliente_nombre']);
		$stmt->bindParam(':cliente_direccion', $datos['cliente_direccion']);
		$stmt->bindParam(':cliente_contacto', $datos['cliente_contacto']);
		$stmt->bindParam(':operador_id', $datos['operador_id']);
		$stmt->bindParam(':lista_id', $datos['lista_id']);
		$stmt->bindParam(':creado_por', $creado_por);
		$stmt->bindValue(':estado', 'pendiente');

		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Presupuestos Model: presupuesto creado correctamente.", "INFO");
			$presupuesto_id = $conn->lastInsertId();
			return ['success' => true, 'presupuesto_id' => $presupuesto_id];
		} else {
			return ['success' => false, 'message' => 'Error al crear el presupuesto.'];
		}

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Presupuestos Model: Error al crear el presupuesto, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarPresupuesto($datos){

	$editado_por = $_SESSION['username'];

	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE ventas_egresos_presupuestos_resumen
														SET
															empresa_nombre = :empresa_nombre,
															sucursal_nombre = :sucursal_nombre,
															rubro_nombre = :rubro_nombre,
															fecha_presupuesto = :fecha_presupuesto,
															fecha_vencimiento = :fecha_vencimiento,
															cliente_nombre = :cliente_nombre,
															cliente_direccion = :cliente_direccion,
															cliente_contacto = :cliente_contacto,
															lista_id = :lista_id,
															editado_por = :editado_por
														WHERE
															presupuesto_id = :presupuesto_id");

		$stmt->bindParam(':presupuesto_id', $datos['presupuesto_id']);
		$stmt->bindParam(':empresa_nombre', $datos['empresa_nombre']);
		$stmt->bindParam(':sucursal_nombre', $datos['sucursal_nombre']);
		$stmt->bindParam(':rubro_nombre', $datos['rubro_nombre']);
		$stmt->bindParam(':fecha_presupuesto', $datos['fecha_presupuesto']);
		$stmt->bindParam(':fecha_vencimiento', $datos['fecha_vencimiento']);
		$stmt->bindParam(':cliente_nombre', $datos['cliente_nombre']);
		$stmt->bindParam(':cliente_direccion', $datos['cliente_direccion']);
		$stmt->bindParam(':cliente_contacto', $datos['cliente_contacto']);
		$stmt->bindParam(':lista_id', $datos['lista_id']);
		$stmt->bindParam(':editado_por', $editado_por);

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

function eliminarPresupuesto($presupuesto_id){

	$fechaActual = date('Y-m-d H:i:s');
	$creado_por_id = $_SESSION['operador_id'];
	$creado_por_username = $_SESSION['username'];

	try {
		$conn = getConnection();

		$stmt = $conn->prepare("SELECT COUNT(*) FROM ventas_egresos_presupuestos_resumen 
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
		$stmt = $conn->prepare("UPDATE ventas_egresos_presupuestos_detalle
                            SET estado = 'cancelado'
                            WHERE presupuesto_id = :presupuesto_id AND estado = 'pendiente'");
		$stmt->bindValue(':presupuesto_id', $presupuesto_id);
		$stmt->execute();

		// Actualizar el estado en la tabla de resumen
		$stmtResumen = $conn->prepare("UPDATE ventas_egresos_presupuestos_resumen
                                  SET estado = 'cancelado'
                                  WHERE presupuesto_id = :presupuesto_id");
		$stmtResumen->bindValue(':presupuesto_id', $presupuesto_id);
		$stmtResumen->execute();

		registrarEvento("Presupuestos Model: Presupuesto cancelado correctamente => $presupuesto_id", "INFO");
		return ['success' => true, 'message' => 'Presupuesto cancelado correctamente.'];

	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al cancelar el presupuesto => " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => 'Error al cancelar el presupuesto.'];
	}
}

function generarPresupuesto($presupuesto_id){
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("
				SELECT TOP 1 1 
				FROM ventas_egresos_presupuestos_detalle 
				WHERE presupuesto_id = :presupuesto_id
			");
		$stmt->execute([':presupuesto_id' => $presupuesto_id]);

		if (!$stmt->fetch()) {
			return [
				'success' => false,
				'message' => 'El presupuesto no tiene mercaderías asignadas'
			];
		} else {
			registrarEvento("Presupuestos Model: Mercaderías encontradas para el presupuesto.", "INFO");

			$sqlCerrarResumen = "UPDATE ventas_egresos_presupuestos_resumen SET estado = 'cerrado' WHERE presupuesto_id = :presupuesto_id";
			$stmtCerrarResumen = $conn->prepare($sqlCerrarResumen);
			$stmtCerrarResumen->execute([
				':presupuesto_id' => $presupuesto_id
			]);

			$sqlCerrarDetalle = "UPDATE ventas_egresos_presupuestos_detalle SET estado = 'cerrado' WHERE presupuesto_id = :presupuesto_id";
			$stmtCerrarDetalle = $conn->prepare($sqlCerrarDetalle);
			$stmtCerrarDetalle->execute([
				':presupuesto_id' => $presupuesto_id
			]);

			registrarEvento("Presupuestos Model: Presupuesto creado correctamente => " . $presupuesto_id, "INFO");

			return [
				'success' => true,
				'message' => 'Presupuesto creado correctamente.',
				'presupuesto_id' => $presupuesto_id
			];

		}

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Presupuestos Model: Error al guardar el presupuesto, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => 'Error al guardar el presupuesto.'];
	}
}

function agregarMercaderia($datos){
	try {
		$conn = getConnection();

		$sql = "INSERT INTO ventas_egresos_presupuestos_detalle (
										presupuesto_id,
										mercaderia_id,
										codigo_mercaderia,
										descripcion_mercaderia,
										cantidad,
										/* codigo_externo, */
										precio_compra,
										precio_venta,
										/* iva_tasa, */
										/* descuento_porcentaje, */
										operador_id,
										estado
									)
                  VALUES (
										:presupuesto_id,
										:mercaderia_id,
										:codigo_mercaderia,
										:descripcion_mercaderia,
										:cantidad,
										/* :codigo_externo, */
										:precio_compra,
										:precio_venta,
										/* :iva_tasa, */
										/* :descuento_porcentaje, */
										:operador_id,
										:estado
									)";

		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':presupuesto_id', $datos['presupuesto_id']);
		$stmt->bindValue(':mercaderia_id', $datos['mercaderia_id']);
		$stmt->bindValue(':codigo_mercaderia', $datos['codigo_mercaderia']);
		$stmt->bindValue(':descripcion_mercaderia', $datos['descripcion_mercaderia']);
		$stmt->bindValue(':cantidad', $datos['cantidad']);
		/* $stmt->bindValue(':codigo_externo', $datos['codigo_externo']); */
		$stmt->bindValue(':precio_compra', $datos['precio_compra_mercaderia']);
		$stmt->bindValue(':precio_venta', $datos['precio_venta_mercaderia']);
		/* $stmt->bindValue(':iva_tasa', $datos['iva_tasa']); */
		/* $stmt->bindValue(':descuento_porcentaje', $datos['descuento_porcentaje']); */
		$stmt->bindValue(':operador_id', $datos['operador_id']);
		$stmt->bindValue(':estado', 'pendiente');

		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Presupuestos Model: mercadería agregada correctamente.", "INFO");
			return ['success' => true];
		} else {
			return ['success' => false, 'message' => 'Error al insertar en detalle'];
		}

	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al buscar pendientes, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}
}

function editarMercaderiaPresupuesto($datos){
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE ventas_egresos_presupuestos_detalle
														SET
															codigo_mercaderia = :codigo_mercaderia,
															descripcion_mercaderia = :descripcion_mercaderia,
															cantidad = :cantidad,
															precio_compra = :precio_compra,
															precio_venta = :precio_venta
															/* iva_tasa = :iva_tasa,
															descuento_porcentaje = :descuento_porcentaje, */
														WHERE
															item_id = :item_id");

		$stmt->bindParam(':item_id', $datos['item_id']);
		$stmt->bindParam(':codigo_mercaderia', $datos['codigo_mercaderia']);
		$stmt->bindParam(':descripcion_mercaderia', $datos['descripcion_mercaderia']);
		$stmt->bindParam(':cantidad', $datos['cantidad']);
		$stmt->bindParam(':precio_compra', $datos['precio_compra_mercaderia']);
		$stmt->bindParam(':precio_venta', $datos['precio_venta_mercaderia']);
		/* $stmt->bindParam(':iva_tasa', $datos['iva_tasa']);
			$stmt->bindParam(':descuento_porcentaje', $datos['descuento_porcentaje']); */
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

function eliminarMercaderiaPresupuesto($item_id){
	try {
		$conn = getConnection();
		$stmt = $conn->prepare("DELETE FROM ventas_egresos_presupuestos_detalle WHERE item_id = :item_id");
		$stmt->bindParam(':item_id', $item_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Presupuestos Model: Error al eliminar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}