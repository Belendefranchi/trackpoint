<?php
require_once __DIR__ . '/../../../../core/config/db.php';
require_once __DIR__ . '/../../../../core/config/helpers.php';

function emitirCodbar($codigo, $descripcion, $familia, $grupo, $subgrupo, $unidad_medida) {
	session_start();
  $creado_por_id = $_SESSION['operador_id'] ?? null;
  $creado_por_username = $_SESSION['username'] ?? 'desconocido';
	try {
		$conn = getConnection();
		$sql = "INSERT INTO produccion_general (
												fecha_faena,
												fecha_produccion,
												creado_por_id,
												creado_por_username,
												proceso_id,
												mercaderia_id,
												usuario_faena,
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
												:creado_por_id,
												:creado_por_username,
												:proceso_id,
												:mercaderia_id,
												:usuario_faena,
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

    $stmt = $conn->prepare($sql);

		// Bind de parámetros
		$stmt->bindValue(':fecha_faena', $datos['fecha_faena']);
		$stmt->bindValue(':fecha_produccion', $datos['fecha_produccion']);
		$stmt->bindValue(':creado_por_id', $creado_por_id);
		$stmt->bindValue(':creado_por_username', $creado_por_username);
		$stmt->bindValue(':proceso_id', $datos['proceso_id']);
		$stmt->bindValue(':mercaderia_id', $datos['mercaderia_id']);
		$stmt->bindValue(':usuario_faena', $datos['usuario_faena']);
		$stmt->bindValue(':turno', $datos['turno']);
		$stmt->bindValue(':unidades', $datos['unidades']);
		$stmt->bindValue(':cantidad', $datos['cantidad']);
		$stmt->bindValue(':peso_neto', $datos['peso_neto']);
		$stmt->bindValue(':peso_bruto', $datos['peso_bruto']);
		$stmt->bindValue(':tara_pri', $datos['tara_pri']);
		$stmt->bindValue(':tara_sec', $datos['tara_sec']);
		$stmt->bindValue(':codbar_e', $datos['codbar_e']);
		$stmt->bindValue(':codbar_s', $datos['codbar_s']);
		$stmt->bindValue(':estado', 'disponible'); // Estado inicial
		$stmt->bindValue(':impreso', 1); // Por defecto

		$result = $stmt->execute();

		if ($result) {
			registrarEvento("Mercaderías Model: mercadería creada correctamente.", "INFO");
		}
		return $result;
	} catch (PDOException $e) {
		// Manejo de errores
		registrarEvento("Mercaderías Model: Error al crear la mercadería, " . $e->getMessage(), "ERROR");
		return false;
	}
}