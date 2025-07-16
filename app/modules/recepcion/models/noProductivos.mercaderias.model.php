<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

function agregarMercaderia($datos) {
	
	$fechaActual = date('Y-m-d H:i:s');
	$operador_id = $_SESSION['operador_id'];

	try {
		$conn = getConnection();
		$sql = "INSERT INTO recepcion_noProductivos_mercaderias_resumen (
												fecha_recepcion,
												fecha_sistema,
												operador_id,
												estado
											)
											VALUES (
												:fecha_recepcion,
												:fecha_sistema,
												:operador_id,
												:estado
											)";

		$stmt = $conn->prepare($sql);

		// Bind de parámetros
		$stmt->bindValue(':fecha_recepcion', $datos['fecha_recepcion']);
		$stmt->bindValue(':fecha_sistema', $fechaActual);
		$stmt->bindValue(':operador_id', $operador_id);
		$stmt->bindValue(':estado', 'pendiente');

		$recepcion_id = $stmt->fetch(PDO::FETCH_ASSOC)['recepcion_id'];

		if ($recepcion_id) {
			registrarEvento("Recepción Mercaderías Model: mercadería agregada correctamente.", "INFO");
		}

		return $recepcion_id;

	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Recepción Mercaderías Model: Error al agregar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}


function guardarMercaderia($datos) {
	/* session_start(); */
	$fechaActual = date('Y-m-d H:i:s');
  $operador_id = $_SESSION['operador_id'];
  $creado_por_username = $_SESSION['username'];
	try {
		$conn = getConnection();
		$sql = "INSERT INTO produccion_general (
												fecha_faena,
												fecha_produccion,
												fecha_recepcion,
												fecha_remito,
												fecha_sistema,
												operador_id,
												creado_por_username,
												mercaderia_id,
												proveedor_id,
												unidades,
												cantidad,
												peso_neto,
												peso_bruto,
												tara_pri,
												tara_sec,
												codbar_e,
												estado,
												impreso
											)
											VALUES (
												:fecha_faena,
												:fecha_produccion,
												:fecha_recepcion,
												:fecha_remito,
												:fecha_sistema,
												:operador_id,,
												:creado_por_username,
												:mercaderia_id,
												:proveedor_id,
												:unidades,
												:cantidad,
												:peso_neto,
												:peso_bruto,
												:tara_pri,
												:tara_sec,
												:codbar_e,
												:estado,
												:impreso
											)";

    $stmt = $conn->prepare($sql);

		// Bind de parámetros
		$stmt->bindValue(':fecha_faena', $fechaActual);
		$stmt->bindValue(':fecha_produccion', $fechaActual);
		$stmt->bindValue(':fecha_recepcion', $datos['fecha_recepcion']);
		$stmt->bindValue(':fecha_remito', $datos['fecha_remito']);
		$stmt->bindValue(':fecha_sistema', $fechaActual);
		$stmt->bindValue(':operador_id,_id', $operador_id,_id);
		$stmt->bindValue(':creado_por_username', $creado_por_username);
		/* $stmt->bindValue(':proceso_id', "$datos['proceso_id']"); */
		$stmt->bindValue(':mercaderia_id', $datos['mercaderia_id']);
		$stmt->bindValue(':proveedor_id', $datos['proveedor_id']);
		/* $stmt->bindValue(':pallet_id', $datos['pallet_id']); */
		/* $stmt->bindValue(':pedido_id', $datos['pedido_id']); */
		$stmt->bindValue(':unidades', $datos['unidades']);
		$stmt->bindValue(':cantidad', 0);
		$stmt->bindValue(':peso_neto', $datos['peso_neto']);
		$stmt->bindValue(':peso_bruto', $datos['peso_neto'] + $datos['tara']);
		$stmt->bindValue(':tara_pri', $datos['tara']);
		$stmt->bindValue(':tara_sec', $datos['tara']);
		$stmt->bindValue(':codbar_e', null);
		$stmt->bindValue(':estado', 'disponible'); // Estado inicial
		$stmt->bindValue(':impreso', 1); // Por defecto

		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Recepción Mercaderías Model: mercadería agregada correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Recepción Mercaderías Model: Error al agregar la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}

