/* ############################################################################################## */
/* --------------------------------------- AGREGAR COLUMNAS ------------------------------------- */
/* ############################################################################################## */

IF EXISTS (
    SELECT 1
    FROM sys.columns
    WHERE object_id = OBJECT_ID('dbo.expedicion_egresos_presupuestos_detalle')
    AND name = 'precio_costo'
)
BEGIN
    EXEC sp_rename 
    'dbo.expedicion_egresos_presupuestos_detalle.precio_costo',
    'precio_compra',
    'COLUMN';
END;
GO


IF EXISTS (
    SELECT 1
    FROM sys.columns
    WHERE object_id = OBJECT_ID('dbo.recepcion_noProductivos_mercaderias_detalle')
    AND name = 'precio_costo'
)
BEGIN
    EXEC sp_rename 
    'dbo.recepcion_noProductivos_mercaderias_detalle.precio_costo',
    'precio_compra',
    'COLUMN';
END;
GO


/* ############################################################################################## */
/* --------------------------------------- RENOMBRAR TABLAS ------------------------------------- */
/* ############################################################################################## */

IF EXISTS (
    SELECT 1 FROM sys.tables 
    WHERE name = 'expedicion_egresos_presupuestos_resumen'
)
AND NOT EXISTS (
    SELECT 1 FROM sys.tables 
    WHERE name = 'ventas_egresos_presupuestos_resumen'
)
BEGIN
    EXEC sp_rename 
        'dbo.expedicion_egresos_presupuestos_resumen', 
        'ventas_egresos_presupuestos_resumen';
END;
GO

IF EXISTS (
    SELECT 1 FROM sys.tables 
    WHERE name = 'expedicion_egresos_presupuestos_detalle'
)
AND NOT EXISTS (
    SELECT 1 FROM sys.tables 
    WHERE name = 'ventas_egresos_presupuestos_detalle'
)
BEGIN
    EXEC sp_rename 
        'dbo.expedicion_egresos_presupuestos_detalle', 
        'ventas_egresos_presupuestos_detalle';
END;
GO

/* =========================================
   Trigger UPDATE resumen
   ========================================= */

CREATE OR ALTER TRIGGER trg_Update_presupuestos_resumen
ON ventas_egresos_presupuestos_resumen
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;

    UPDATE p
    SET 
        editado_en = GETDATE(),
        fecha_modificacion = GETDATE()
    FROM ventas_egresos_presupuestos_resumen p
    INNER JOIN inserted i 
        ON p.presupuesto_id = i.presupuesto_id;
END;
GO


/* =========================================
   Trigger UPDATE detalle
   ========================================= */

CREATE OR ALTER TRIGGER trg_Update_presupuestos_detalle
ON ventas_egresos_presupuestos_detalle
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;

    UPDATE p
    SET 
        fecha_modificacion = GETDATE()
    FROM ventas_egresos_presupuestos_detalle p
    INNER JOIN inserted i 
        ON p.presupuesto_id = i.presupuesto_id;
END;
GO
