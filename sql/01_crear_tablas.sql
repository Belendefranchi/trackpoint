-- 1. Dropear tablas si existen
IF OBJECT_ID('configuracion_abm_perfilesPorOperador', 'U') IS NOT NULL DROP TABLE configuracion_abm_perfilesPorOperador;
IF OBJECT_ID('configuracion_abm_permisosPorPerfil', 'U') IS NOT NULL DROP TABLE configuracion_abm_permisosPorPerfil;
IF OBJECT_ID('configuracion_abm_operadores', 'U') IS NOT NULL DROP TABLE configuracion_abm_operadores;
IF OBJECT_ID('configuracion_abm_perfiles', 'U') IS NOT NULL DROP TABLE configuracion_abm_perfiles;
IF OBJECT_ID('configuracion_abm_permisos', 'U') IS NOT NULL DROP TABLE configuracion_abm_permisos;

/* ------------------------------------ TABLAS CONFIGURACIÓN ------------------------------------ */
/* ############################################################################################## */

-- 2. Crear tabla configuracion_abm_operadores
CREATE TABLE configuracion_abm_operadores (
	operador_id INT PRIMARY KEY IDENTITY(1,1),
	username VARCHAR(20) NOT NULL,
	password VARCHAR(100) NOT NULL,
	nombre_completo VARCHAR(50),
	email VARCHAR(100) NOT NULL UNIQUE,
	rol VARCHAR(20),
	creado_en DATETIME DEFAULT GETDATE(),
	creado_por VARCHAR(20) NULL,
	editado_en DATETIME NULL,
	editado_por VARCHAR(20) NULL,
	activo BIT DEFAULT 1
);

-- 3. Crear tabla configuracion_abm_perfiles
CREATE TABLE configuracion_abm_perfiles (
	perfil_id INT PRIMARY KEY IDENTITY(1,1),
	nombre VARCHAR(50) NOT NULL UNIQUE,
	descripcion VARCHAR(100) NOT NULL,
	creado_en DATETIME DEFAULT GETDATE(),
	creado_por VARCHAR(20) NULL,
	editado_en DATETIME NULL,
	editado_por VARCHAR(20) NULL,
	activo BIT DEFAULT 1
);

-- 4. Crear tabla configuracion_abm_perfilesPorOperador
CREATE TABLE configuracion_abm_perfilesPorOperador (
	operador_id INT,
	perfil_id INT,
	PRIMARY KEY (operador_id, perfil_id),
	FOREIGN KEY (operador_id) REFERENCES configuracion_abm_operadores(operador_id) ON DELETE CASCADE,
	FOREIGN KEY (perfil_id) REFERENCES configuracion_abm_perfiles(perfil_id) ON DELETE CASCADE
);

-- 5. Crear tabla configuracion_abm_permisos
CREATE TABLE configuracion_abm_permisos (
	permiso_id INT PRIMARY KEY IDENTITY(1,1),
	nombre VARCHAR(50) NOT NULL UNIQUE,
	descripcion VARCHAR(100) NOT NULL, 
	pantalla VARCHAR(100) NOT NULL,
	creado_en DATETIME DEFAULT GETDATE(),
	creado_por VARCHAR(20) NULL,
	editado_en DATETIME NULL,
	editado_por VARCHAR(20) NULL
);

-- 6. Crear tabla configuracion_abm_permisosPorPerfil
CREATE TABLE configuracion_abm_permisosPorPerfil (
	perfil_id INT,
	permiso_id INT,
	PRIMARY KEY (perfil_id, permiso_id),
	FOREIGN KEY (perfil_id) REFERENCES configuracion_abm_perfiles(perfil_id) ON DELETE CASCADE,
	FOREIGN KEY (permiso_id) REFERENCES configuracion_abm_permisos(permiso_id) ON DELETE CASCADE
);

/* -------------------------------------- TABLAS PRODUCCIÓN -------------------------------------- */
/* ############################################################################################### */


CREATE TABLE produccion_general (
    codbar_id INT IDENTITY(1,1) PRIMARY KEY,

    -- Trazabilidad
    fecha_faena DATE NOT NULL,
    fecha_produccion DATE NOT NULL,

    -- Datos del sistema
    fecha_sistema DATETIME2(0) NOT NULL DEFAULT SYSUTCDATETIME(),
    fecha_modificacion DATETIME2(0) NULL,

    -- Referencias de usuario (ID + nombre al momento)
    creado_por_id INT NOT NULL,
    creado_por_username VARCHAR(100) NOT NULL,
    editado_por_id INT NULL,
    editado_por_username VARCHAR(100) NULL,

    -- Referencias a proceso y producto
    proceso_id INT NOT NULL,
    mercaderia_id INT NOT NULL,
    usuario_faena VARCHAR(100) NOT NULL,
    turno VARCHAR(10) CHECK (turno IN ('mañana', 'tarde', 'noche')) NULL,

    -- Asociación futura
    pallet_id INT NULL,
    pedido_id INT NULL,

    -- Datos físicos
    unidades INT NOT NULL,
    cantidad INT NOT NULL,
    peso_neto DECIMAL(10,2) NULL,
    peso_bruto DECIMAL(10,2) NULL,
    tara_pri DECIMAL(10,2) NULL,
    tara_sec DECIMAL(10,2) NULL,

    -- Codificación y trazabilidad por escaneo
    codbar_e VARCHAR(100) NULL,
    codbar_s VARCHAR(100) NULL,

    -- Estado de la etiqueta
    estado VARCHAR(20) NOT NULL DEFAULT 'disponible' CHECK (estado IN (
        'disponible', 'eliminado', 'palletizado', 'en_pedido', 'en_carga',
        'en_proceso', 'despachado', 'remitido', 'baja_por_inventario'
    )),
    impreso INT NOT NULL DEFAULT 1,

    -- Claves foráneas
    CONSTRAINT FK_produccion_creado_por FOREIGN KEY (creado_por_id) REFERENCES configuracion_abm_operadores(operador_id),
    CONSTRAINT FK_produccion_editado_por FOREIGN KEY (editado_por_id) REFERENCES configuracion_abm_operadores(operador_id),
    CONSTRAINT FK_produccion_proceso FOREIGN KEY (proceso_id) REFERENCES produccion_abm_procesos(proceso_id),
    CONSTRAINT FK_produccion_producto FOREIGN KEY (mercaderia_id) REFERENCES produccion_abm_mercaderias(mercaderia_id),
    CONSTRAINT FK_produccion_pallet FOREIGN KEY (pallet_id) REFERENCES produccion_pallets(pallet_id),
    CONSTRAINT FK_produccion_pedido FOREIGN KEY (pedido_id) REFERENCES expedicion_pedidos(pedido_id)
);
GO

-- Índices por fechas
CREATE INDEX idx_produccion_fecha_produccion ON produccion_general(fecha_produccion) WITH (ONLINE = ON);
CREATE INDEX idx_produccion_fecha_faena ON produccion_general(fecha_faena) WITH (ONLINE = ON);
CREATE INDEX idx_produccion_fecha_sistema ON produccion_general(fecha_sistema) WITH (ONLINE = ON);

-- Índices por estado
CREATE INDEX idx_produccion_estado ON produccion_general(estado) WITH (ONLINE = ON);

-- Índices por códigos de barras (ajustar a UNIQUE si aplica)
CREATE INDEX idx_produccion_codbar_e ON produccion_general(codbar_e) WITH (ONLINE = ON);
CREATE INDEX idx_produccion_codbar_s ON produccion_general(codbar_s) WITH (ONLINE = ON);

-- Índices por relaciones a otras entidades
CREATE INDEX idx_produccion_pallet ON produccion_general(pallet_id) WITH (ONLINE = ON);
CREATE INDEX idx_produccion_pedido ON produccion_general(pedido_id) WITH (ONLINE = ON);
CREATE INDEX idx_produccion_mercaderia_id ON produccion_general(mercaderia_id) WITH (ONLINE = ON);
CREATE INDEX idx_produccion_proceso_id ON produccion_general(proceso_id) WITH (ONLINE = ON);




