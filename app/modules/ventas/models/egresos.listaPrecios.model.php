<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/helpers/logs.helper.php';

function obtenerListaId()
{
	try {
		$conn = getConnection();
		$sql = "SELECT lista_id FROM ventas_egresos_listaPrecios_resumen WHERE activo = 1 ORDER BY fecha DESC LIMIT 1";
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
		$sql = "SELECT MAX(lista_id) AS ultimo_id FROM ventas_egresos_listaPrecios_resumen WHERE activo = 1";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchColumn();
	} catch (PDOException $e) {
		registrarEvento("ListaPrecios Model: Error al obtener último ID de lista, " . $e->getMessage(), "ERROR");
		return null;
	}
}

function obtenerResumenLista()
{
	try {
		$conn = getConnection();
		$sql = "SELECT 
							lista_id,
							tipo,
							nombre,
							proveedor,
							moneda,
							fecha_lista,
							fecha_sistema,
							fecha_modificacion
						FROM ventas_egresos_listaPrecios_resumen
						WHERE activo = 1
							AND estado = 'pendiente'
						";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		registrarEvento("ListaPrecios Model: Error al buscar resumen, " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => $e->getMessage()];
	}

}

function obtenerResumenListaPorId($lista_id)
{
	try {
		$conn = getConnection();
		$sql = "SELECT 
							r.lista_id,
							r.tipo,
							r.fecha_lista,
							r.proveedor,
							r.moneda,
							r.fecha_sistema,
							r.fecha_modificacion,
							r.estado,
						FROM ventas_egresos_listaPrecios_resumen r
						LEFT JOIN ventas_egresos_listaPrecios_detalle d
							ON r.lista_id = d.lista_id
						WHERE r.lista_id = :lista_id
							AND r.activo = 1
						GROUP BY
							r.lista_id,
							r.tipo,
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

function obtenerDetalleLista($lista_id)
{
	try {
		$conn = getConnection();
		$sql = "SELECT 
								d.item_id,
								d.lista_id,
								d.mercaderia_id,
								m.codigo,
								m.descripcion,
								d.precio_compra,
								d.precio_venta,
								d.iva_tasa
						FROM ventas_egresos_listaPrecios_detalle d
						INNER JOIN configuracion_abm_mercaderias m
							ON d.mercaderia_id = m.mercaderia_id
						WHERE d.lista_id = :lista_id
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

function crearListaPrecios($datos)
{

	$nombre = $datos['fecha_lista'] . ' - ' . $datos['proveedor'];

	try {
		$conn = getConnection();
		$sqlResumen = "INSERT INTO ventas_egresos_listaPrecios_resumen (
							fecha_lista,
							tipo,
							nombre,
							proveedor,
							moneda,
							operador_id,
							estado
						)
						VALUES (
							:fecha_lista,
							:tipo,
							:nombre,
							:proveedor,
							:moneda,
							:operador_id,
							:estado)";

		$stmtResumen = $conn->prepare($sqlResumen);
		$stmtResumen->bindParam(':fecha_lista', $datos['fecha_lista']);
		$stmtResumen->bindParam(':tipo', $datos['tipo']);
		$stmtResumen->bindParam(':nombre', $nombre);
		$stmtResumen->bindParam(':proveedor', $datos['proveedor']);
		$stmtResumen->bindParam(':moneda', $datos['moneda']);
		$stmtResumen->bindParam(':operador_id', $datos['operador_id']);
		$stmtResumen->bindValue(':estado', 'pendiente');

		$resultResumen = $stmtResumen->execute();
		$lista_id = $conn->lastInsertId();

		if ($resultResumen) {
			registrarEvento("ListaPrecios Model: lista creada correctamente.", "INFO");
			return ['success' => true, 'lista_id' => $lista_id];
		} else {
			registrarEvento("ListaPrecios Model: Error al crear la lista, lista_id: " . $lista_id, "ERROR");
			return ['success' => false, 'message' => 'Error al crear la lista.'];
		}

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("ListaPrecios Model: Error al crear la lista, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function agregarMercaderiasListaPrecios($lista_id, $mercaderia_id)
{
	try {
		$conn = getConnection();
		$sqlDetalle = "INSERT INTO ventas_egresos_listaPrecios_detalle (
							lista_id,
							mercaderia_id,
							precio_compra,
							precio_venta,
							iva_tasa,
							descuento_porcentaje
						)
						VALUES (
							:lista_id,
							:mercaderia_id,
							0.00,
							0.00,
							0.00,
							0.00
						)";

		$stmtDetalle = $conn->prepare($sqlDetalle);
		$stmtDetalle->bindValue(':lista_id', $lista_id);
		$stmtDetalle->bindValue(':mercaderia_id', $mercaderia_id);
		$stmtDetalle->execute();
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("ListaPrecios Model: Error al agregar productos a la lista, " . $e->getMessage(), "ERROR");
		return false;
	}
}

function editarListaPrecios($datos)
{

	try {
		$conn = getConnection();
		$stmt = $conn->prepare("UPDATE ventas_egresos_listaPrecios_resumen
														SET
															tipo = :tipo,
															fecha_lista = :fecha_lista,
															proveedor = :proveedor,
															moneda = :moneda
														WHERE
															lista_id = :lista_id");

		$stmt->bindParam(':lista_id', $datos['lista_id']);
		$stmt->bindParam(':tipo', $datos['tipo']);
		$stmt->bindParam(':fecha_lista', $datos['fecha_lista']);
		$stmt->bindParam(':proveedor', $datos['proveedor']);
		$stmt->bindParam(':moneda', $datos['moneda']);

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

function eliminarListaPrecios($lista_id)
{

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
/* 		$stmtDetalle = $conn->prepare("UPDATE ventas_egresos_listaPrecios_detalle
                            SET estado = 'cancelado'
                            WHERE lista_id = :lista_id");
		$stmtDetalle->bindValue(':lista_id', $lista_id);
		$stmtDetalle->execute(); */

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

function guardarCambiosListaPrecios($lista_id, $items)
{
	echo "Guardando cambios para lista_id: $lista_id con datos: " . print_r($items, true);
	try {
		$conn = getConnection();
		foreach ($items as $item_id => $item) {

			$sql = "UPDATE ventas_egresos_listaPrecios_detalle
                    SET 
                        precio_compra = :precio_compra,
                        precio_venta  = :precio_venta,
                        iva_tasa      = :iva_tasa
                    WHERE item_id = :item_id
                      AND lista_id = :lista_id";

			$stmt = $conn->prepare($sql);

			$stmt->bindValue(':precio_compra', $item['precio_compra']);
			$stmt->bindValue(':precio_venta', $item['precio_venta']);
			$stmt->bindValue(':iva_tasa', $item['iva_tasa']);
			$stmt->bindValue(':item_id', $item_id);
			$stmt->bindValue(':lista_id', $lista_id);

			$result = $stmt->execute();
		}

		if ($result) {
			registrarEvento("ListaPrecios Model: lista guardada correctamente.", "INFO");
			return ['success' => true, 'lista_id' => $lista_id];
		} else {
			registrarEvento("ListaPrecios Model: Error al guardar la lista, lista_id: " . $lista_id, "ERROR");
			return ['success' => false, 'message' => 'Error al guardar la lista.'];
		}

	} catch (PDOException $e) {
		registrarEvento("ListaPrecios Model: Error al guardar cambios para lista_id => " . $e->getMessage(), "ERROR");
		return ['success' => false, 'message' => 'Error al guardar los cambios.'];
	}
}