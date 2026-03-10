<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerListaId(){
	try {
		$conn = getConnection();
		$sql = "SELECT lista_id FROM ventas_egresos_listaPrecios_resumen LIMIT 1 ORDER BY fecha DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchColumn();
	} catch (PDOException $e) {
		registrarEvento("ListaPrecios Model: Error al obtener ID de lista, " . $e->getMessage(), "ERROR");
		return null;
	}
}

function obtenerUltimaListaId()
{
	try {
		$conn = getConnection();
		$sql = "SELECT MAX(lista_id) AS ultimo_id FROM ventas_egresos_listaPrecios_resumen";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchColumn();
	} catch (PDOException $e) {
		registrarEvento("ListaPrecios Model: Error al obtener último ID de lista, " . $e->getMessage(), "ERROR");
		return null;
	}
}

function obtenerResumenLista(){
	try {
		$conn = getConnection();
		$sql = "SELECT 
							r.lista_id,
							r.proveedor,
							r.moneda,
							r.fecha_lista,
							r.fecha_sistema,
							r.fecha_modificacion,
							r.estado
						FROM ventas_egresos_listaPrecios_resumen r
						LEFT JOIN ventas_egresos_listaPrecios_detalle d
							ON r.lista_id = d.lista_id
						GROUP BY
							r.lista_id,
							r.proveedor,
							r.moneda,
							r.fecha_lista,
							r.fecha_sistema,
							r.fecha_modificacion,
							r.estado
						";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("ListaPrecios Model: Error al buscar resumen, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}

}

function obtenerResumenListaPorId($lista_id){
	try {
		$conn = getConnection();
		$sql = "SELECT 
							r.lista_id,
							r.fecha,
							r.proveedor,
							r.moneda,
							r.fecha_sistema,
							r.fecha_modificacion,
							r.estado,
						FROM ventas_egresos_listaPrecios_resumen r
						LEFT JOIN ventas_egresos_listaPrecios_detalle d
							ON r.lista_id = d.lista_id
						WHERE r.lista_id = :lista_id
						GROUP BY
							r.lista_id,
							r.fecha,
							r.proveedor,
							r.moneda,
							r.fecha_sistema,
							r.fecha_modificacion,
							r.estado
						";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':lista_id', $lista_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("ListaPrecios Model: Error al buscar resumen, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}

}

function obtenerDetalleLista($lista_id){
	try {
		$conn = getConnection();
		$sql = "SELECT 
								item_id,
								lista_id,
								codigo_mercaderia,
								descripcion_mercaderia,
								codigo_externo,
								cantidad,
								precio_compra,
								precio_venta,
								iva_tasa,
								descuento_porcentaje,
								(cantidad * precio_venta) AS subtotal
						FROM ventas_egresos_listaPrecios_detalle
						WHERE lista_id = :lista_id
							--AND estado = 'pendiente'
						";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':lista_id', $lista_id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("ListaPrecios Model: Error al buscar detalle, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}
}

function crearListaPrecios($datos){

	$creado_por = $_SESSION['username'];

	try {
		$conn = getConnection();
		$sql = "INSERT INTO ventas_egresos_listaPrecios_resumen (
							fecha_lista,
							proveedor,
							moneda,
							operador_id,
							creado_por,
							estado
						)
						VALUES (
							:fecha_lista,
							:proveedor,
							:moneda,
							:operador_id,
							:creado_por,
							:estado)";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':fecha_lista', $datos['fecha_lista']);
		$stmt->bindParam(':proveedor', $datos['proveedor']);
		$stmt->bindParam(':moneda', $datos['moneda']);
		$stmt->bindParam(':operador_id', $datos['operador_id']);
		$stmt->bindParam(':creado_por', $creado_por);
		$stmt->bindValue(':estado', 'pendiente');

		$result = $stmt->execute();

		if ($result) {
			registrarEvento("ListaPrecios Model: lista creada correctamente.", "INFO");
			$lista_id = $conn->lastInsertId();
			return ['success' => true, 'lista_id' => $lista_id];
		} else {
			return ['success' => false, 'message' => 'Error al crear la lista.'];
		}

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("ListaPrecios Model: Error al crear la lista, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarListaPrecios($datos){

	$editado_por = $_SESSION['username'];

	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE ventas_egresos_listaPrecios_resumen
														SET
															fecha_lista = :fecha_lista,
															proveedor = :proveedor,
															moneda = :moneda,
															editado_por = :editado_por
														WHERE
															lista_id = :lista_id");

		$stmt->bindParam(':lista_id', $datos['lista_id']);
		$stmt->bindParam(':fecha_lista', $datos['fecha_lista']);
		$stmt->bindParam(':proveedor', $datos['proveedor']);
		$stmt->bindParam(':moneda', $datos['moneda']);
		$stmt->bindParam(':editado_por', $editado_por);

		$result = $stmt->execute();

		if ($result) {
			registrarEvento("ListaPrecios Model: lista editada correctamente.", "INFO");
		}
		return ['success' => true, 'message' => 'Lista editada correctamente.'];

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("ListaPrecios Model: Error al editar la lista, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function eliminarListaPrecios($lista_id){

	$creado_por_id = $_SESSION['operador_id'];
	$creado_por_username = $_SESSION['username'];

	try {
		$conn = getConnection();

		$stmt = $conn->prepare("SELECT COUNT(*) FROM ventas_egresos_listaPrecios_resumen 
                            WHERE lista_id = :lista_id");
		$stmt->bindValue(':lista_id', $lista_id);
		$stmt->execute();

		$cantidad = $stmt->fetchColumn();

		if ($cantidad == 0) {
			return ['success' => false, 'message' => 'No hay lista pendiente para cancelar'];
		}

		// Actualizar el estado en la tabla de detalle
		$stmt = $conn->prepare("UPDATE ventas_egresos_listaPrecios_detalle
                            SET estado = 'cancelado'
                            WHERE lista_id = :lista_id AND estado = 'pendiente'");
		$stmt->bindValue(':lista_id', $lista_id);
		$stmt->execute();

		// Actualizar el estado en la tabla de resumen
		$stmtResumen = $conn->prepare("UPDATE ventas_egresos_listaPrecios_resumen
                                  SET estado = 'cancelado'
                                  WHERE lista_id = :lista_id");
		$stmtResumen->bindValue(':lista_id', $lista_id);
		$stmtResumen->execute();

		registrarEvento("Presupuestos Model: Presupuesto cancelado correctamente => $lista_id", "INFO");
		return ['success' => true, 'message' => 'Presupuesto cancelado correctamente.'];

	} catch (PDOException $e) {
		registrarEvento("Presupuestos Model: Error al cancelar el presupuesto => " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => 'Error al cancelar el presupuesto.'];
	}
}

function agregarMercaderia($datos){
	try {
		$conn = getConnection();

		$sql = "INSERT INTO ventas_egresos_listaPrecios_detalle (
										lista_id,
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
										:lista_id,
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
		$stmt->bindValue(':lista_id', $datos['lista_id']);
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
		$stmt = $conn->prepare("UPDATE ventas_egresos_listaPrecios_detalle
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
		$stmt = $conn->prepare("DELETE FROM ventas_egresos_listaPrecios_detalle WHERE item_id = :item_id");
		$stmt->bindParam(':item_id', $item_id);
		return $stmt->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Presupuestos Model: Error al eliminar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}