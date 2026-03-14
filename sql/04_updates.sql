/* ############################################################################################## */
/* -------------------------------------- RENOMBRAR COLUMNAS ------------------------------------ */
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
/* --------------------------------------- AGREGAR COLUMNAS ------------------------------------- */
/* ############################################################################################## */

IF COL_LENGTH('ventas_egresos_presupuestos_resumen', 'lista_nombre') IS NULL
BEGIN
    ALTER TABLE ventas_egresos_presupuestos_resumen
        ADD lista_nombre VARCHAR(100) NULL;

END


/* ############################################################################################## */
/* --------------------------------------- RENOMBRAR TABLAS ------------------------------------- */
/* ############################################################################################## */

IF EXISTS (
    SELECT 1
FROM sys.tables
WHERE name = 'expedicion_egresos_presupuestos_resumen'
)
BEGIN
	EXEC sp_rename 
        'dbo.expedicion_egresos_presupuestos_resumen', 
        'ventas_egresos_presupuestos_resumen';
END;
GO

IF EXISTS (
    SELECT 1
FROM sys.tables
WHERE name = 'expedicion_egresos_presupuestos_detalle'
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



/* ############################################################################################## */
/* ---------------------------------------- AGREGAR TABLAS -------------------------------------- */
/* ############################################################################################## */


IF NOT EXISTS (
    SELECT 1
FROM sys.tables
WHERE name = 'ventas_egresos_listaPrecios_resumen'
)
BEGIN
	CREATE TABLE ventas_egresos_listaPrecios_resumen
	(
		lista_id INT PRIMARY KEY IDENTITY(1,1),
		tipo VARCHAR(50) NOT NULL,
		nombre VARCHAR(100) NOT NULL,
		proveedor VARCHAR(100) NOT NULL,
		moneda VARCHAR(100) NULL,
		fecha_lista DATE NOT NULL,
		fecha_sistema DATETIME DEFAULT GETDATE(),
		fecha_modificacion DATETIME NULL,
		operador_id INT NOT NULL,
		activo BIT DEFAULT 1,
		estado VARCHAR(20) NOT NULL DEFAULT 'pendiente',
	);
END;
GO


IF NOT EXISTS (
    SELECT 1
FROM sys.tables
WHERE name = 'ventas_egresos_listaPrecios_detalle'
)
BEGIN
	CREATE TABLE ventas_egresos_listaPrecios_detalle
	(
		item_id INT PRIMARY KEY IDENTITY(1,1),
		lista_id INT NOT NULL,
		mercaderia_id INT NOT NULL,
		precio_compra DECIMAL(10,2) NULL,
		precio_venta DECIMAL(10,2) NULL,
		iva_tasa DECIMAL(5,2) NULL,
		descuento_porcentaje DECIMAL(5,2) NULL,

		-- Datos de auditoría
		fecha_sistema DATETIME DEFAULT GETDATE(),
		fecha_modificacion DATETIME NULL,
		activo BIT DEFAULT 0,

		-- Claves foráneas
		FOREIGN KEY (lista_id) REFERENCES ventas_egresos_listaPrecios_resumen(lista_id),
		FOREIGN KEY (mercaderia_id) REFERENCES configuracion_abm_mercaderias(mercaderia_id)
	);
END;
GO


/* IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[ventas_egresos_listaPrecios_detalle]') AND type in (N'U'))
DROP TABLE [dbo].[ventas_egresos_listaPrecios_detalle]
GO */
