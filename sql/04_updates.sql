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
END


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
END
