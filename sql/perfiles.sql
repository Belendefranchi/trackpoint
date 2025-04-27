-- Crear la tabla de perfiles
CREATE TABLE configuracion_abm_perfiles (
	id INT PRIMARY KEY IDENTITY(1,1),
	nombre VARCHAR(20) NOT NULL UNIQUE,
	descripcion VARCHAR(50) NOT NULL,
	creado_en DATETIME DEFAULT GETDATE(),
  actualizado_en DATETIME NULL,
  activo BIT DEFAULT 1 -- 1 = activo, 0 = inactivo
);

-- Crear la tabla pivote, relación muchos a muchos: operadores ↔ perfiles
CREATE TABLE configuracion_abm_operadores_perfiles (
  operador_id INT,
  perfil_id INT,
  PRIMARY KEY (operador_id, perfil_id),
  FOREIGN KEY (operador_id) REFERENCES configuracion_abm_operadores(id) ON DELETE CASCADE,
  FOREIGN KEY (perfil_id) REFERENCES configuracion_abm_perfiles(id) ON DELETE CASCADE
);


-- Trigger que modificar el campo actualizado_en de forma autromática al actualizar un registro
CREATE TRIGGER trg_Update_perfiles
ON configuracion_abm_perfiles
AFTER UPDATE
AS
BEGIN
  SET NOCOUNT ON;

  UPDATE configuracion_abm_perfiles
  SET actualizado_en = GETDATE()
  FROM configuracion_abm_perfiles p
  INNER JOIN inserted i ON p.id = i.id;
END;

