ALTER TABLE [dbo].[ventas_egresos_presupuestos_detalle] DROP CONSTRAINT [PK__ventas_e__52020FDD9635C329] WITH ( ONLINE = OFF )
GO

ALTER TABLE [dbo].[ventas_egresos_presupuestos_resumen] DROP CONSTRAINT [PK__expedici__DAAAB25C6692B631] WITH ( ONLINE = OFF )
GO


IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[ventas_egresos_presupuestos_detalle]') AND type in (N'U'))
DROP TABLE [dbo].[ventas_egresos_presupuestos_detalle]
GO

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[ventas_egresos_presupuestos_resumen]') AND type in (N'U'))
DROP TABLE [dbo].[ventas_egresos_presupuestos_resumen]
GO