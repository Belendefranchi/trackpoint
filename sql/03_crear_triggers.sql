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
GO

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
GO

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
GO

CREATE TRIGGER trg_Update_mercaderias
ON configuracion_abm_mercaderias
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE configuracion_abm_mercaderias
	SET editado_en = GETDATE()
	FROM configuracion_abm_mercaderias m
	INNER JOIN inserted i ON m.mercaderia_id = i.mercaderia_id;
END;
GO

CREATE TRIGGER trg_Update_grupos
ON configuracion_abm_grupos
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE configuracion_abm_grupos
	SET editado_en = GETDATE()
	FROM configuracion_abm_grupos g
	INNER JOIN inserted i ON g.grupo_id = i.grupo_id;
END;
GO

CREATE TRIGGER trg_Update_subgrupos
ON configuracion_abm_subgrupos
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE configuracion_abm_subgrupos
	SET editado_en = GETDATE()
	FROM configuracion_abm_subgrupos g
	INNER JOIN inserted i ON g.subgrupo_id = i.subgrupo_id;
END;
GO

CREATE TRIGGER trg_Update_produccion_general
ON produccion_general
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;

    UPDATE produccion_general
    SET fecha_modificacion = GETDATE()
    FROM produccion_general p
    INNER JOIN inserted i ON p.codbar_id = i.codbar_id;
END;
GO

CREATE TRIGGER trg_Update_presupuestos_resumen
ON ventas_egresos_presupuestos_resumen
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE ventas_egresos_presupuestos_resumen
	SET editado_en = GETDATE(),
		fecha_modificacion = GETDATE()
	FROM ventas_egresos_presupuestos_resumen p
	INNER JOIN inserted i ON p.presupuesto_id = i.presupuesto_id;
END;
GO

CREATE TRIGGER trg_Update_presupuestos_detalle
ON ventas_egresos_presupuestos_detalle
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE ventas_egresos_presupuestos_detalle
	SET fecha_modificacion = GETDATE()
	FROM ventas_egresos_presupuestos_detalle p
	INNER JOIN inserted i ON p.presupuesto_id = i.presupuesto_id;
END;
GO

CREATE TRIGGER trg_Update_listaPrecios_resumen
ON ventas_egresos_listaPrecios_resumen
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE ventas_egresos_listaPrecios_resumen
	SET fecha_modificacion = GETDATE()
	FROM ventas_egresos_listaPrecios_resumen p
	INNER JOIN inserted i ON p.lista_id = i.lista_id;
END;
GO

CREATE TRIGGER trg_Update_listaPrecios_detalle
ON ventas_egresos_listaPrecios_detalle
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE ventas_egresos_listaPrecios_detalle
	SET fecha_modificacion = GETDATE()
	FROM ventas_egresos_listaPrecios_detalle p
	INNER JOIN inserted i ON p.lista_id = i.lista_id;
END;
GO