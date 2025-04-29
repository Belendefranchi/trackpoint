-- 4. Crear triggers para las tablas nuevas
-- 1. Ejecutar trigger operadores
CREATE TRIGGER trg_Update_operadores
ON configuracion_abm_operadores
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE configuracion_abm_operadores
	SET editado_en = GETDATE()
	FROM configuracion_abm_operadores o
	INNER JOIN inserted i ON o.operador_id = i.operador_id;
END;


-- 2. Ejecutar trigger perfiles
CREATE TRIGGER trg_Update_perfiles
ON configuracion_abm_perfiles
AFTER UPDATE
AS
BEGIN
  SET NOCOUNT ON;

  UPDATE configuracion_abm_perfiles
  SET editado_en = GETDATE()
  FROM configuracion_abm_perfiles p
  INNER JOIN inserted i ON p.perfil_id = i.perfil_id;
END;


-- 3. Ejecutar trigger permisos
CREATE TRIGGER trg_Update_permisos
ON configuracion_abm_permisos
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE configuracion_abm_permisos
	SET editado_en = GETDATE()
	FROM configuracion_abm_permisos per
	INNER JOIN inserted i ON per.permiso_id = i.permiso_id;
END;