-- Crear la tabla de operadores
CREATE TABLE configuracion_abm_operadores (
	id INT PRIMARY KEY IDENTITY(1,1),
	username VARCHAR(10) NOT NULL UNIQUE,
	password VARCHAR(20) NOT NULL,
	nombre_completo VARCHAR(50),
	email VARCHAR(100) NOT NULL UNIQUE,
	rol VARCHAR(10),
	creado_en DATETIME DEFAULT GETDATE(),
	actualizado_en DATETIME NULL,
	activo BIT DEFAULT 1
);
	

-- Trigger que modificar el campo actualizado_en de forma autromática al actualizar un registro
CREATE TRIGGER trg_Update_operadores
ON configuracion_abm_operadores
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE configuracion_abm_operadores
	SET actualizado_en = GETDATE()
	FROM configuracion_abm_operadores o
	INNER JOIN inserted i ON o.id = i.id;
END;

