/* ############################################################################################## */
/* ------------------------------------ TABLAS CONFIGURACIÓN ------------------------------------ */
/* ############################################################################################## */

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

CREATE TABLE configuracion_abm_perfilesPorOperador (
	operador_id INT,
	perfil_id INT,
	PRIMARY KEY (operador_id, perfil_id),
	FOREIGN KEY (operador_id) REFERENCES configuracion_abm_operadores(operador_id) ON DELETE CASCADE,
	FOREIGN KEY (perfil_id) REFERENCES configuracion_abm_perfiles(perfil_id) ON DELETE CASCADE
);

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

CREATE TABLE configuracion_abm_permisosPorPerfil (
	perfil_id INT,
	permiso_id INT,
	PRIMARY KEY (perfil_id, permiso_id),
	FOREIGN KEY (perfil_id) REFERENCES configuracion_abm_perfiles(perfil_id) ON DELETE CASCADE,
	FOREIGN KEY (permiso_id) REFERENCES configuracion_abm_permisos(permiso_id) ON DELETE CASCADE
);

/* ---------------------------------- ÍNDICES Y OPTIMIZACIONES ---------------------------------- */

CREATE INDEX idx_config_operadores_username ON configuracion_abm_operadores(username);



/* ############################################################################################## */
/* -------------------------------------- TABLAS RECEPCIÓN -------------------------------------- */
/* ############################################################################################## */

/* -------------------------------------------- ABMS -------------------------------------------- */



/* ---------------------------------- ÍNDICES Y OPTIMIZACIONES ---------------------------------- */




/* ############################################################################################## */
/* -------------------------------------- TABLAS PRODUCCIÓN ------------------------------------- */
/* ############################################################################################## */

/* -------------------------------------------- ABMS -------------------------------------------- */
CREATE TABLE produccion_abm_mercaderias (
    mercaderia_id INT PRIMARY KEY IDENTITY(1,1),
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NOT NULL,
    unidad_medida VARCHAR(20) NOT NULL,
    grupo VARCHAR(50) NULL,
    subgrupo VARCHAR(50) NULL,
    envase_pri VARCHAR(50) NULL,
    envase_sec VARCHAR(50) NULL,
    marca VARCHAR(50) NULL,
    cantidad_propuesta INT NULL,
    peso_propuesto DECIMAL(10,2) NULL,
    peso_min DECIMAL(10,2) NULL,
    peso_max DECIMAL(10,2) NULL,
    etiqueta_sec VARCHAR(100) NULL,
    codigo_externo VARCHAR(50) NULL,
    creado_en DATETIME DEFAULT GETDATE(),
    creado_por VARCHAR(20) NULL,
    editado_en DATETIME NULL,
    editado_por VARCHAR(20) NULL,
    activo BIT DEFAULT 1
);
GO

CREATE TABLE produccion_abm_familias (
    familia_id INT PRIMARY KEY IDENTITY(1,1),
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NOT NULL,
    creado_en DATETIME DEFAULT GETDATE(),
    creado_por VARCHAR(20) NULL,
    editado_en DATETIME NULL,
    editado_por VARCHAR(20) NULL,
    activo BIT DEFAULT 1
);
GO

CREATE TABLE produccion_abm_grupos (
    grupo_id INT PRIMARY KEY IDENTITY(1,1),
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NOT NULL,
    creado_en DATETIME DEFAULT GETDATE(),
    creado_por VARCHAR(20) NULL,
    editado_en DATETIME NULL,
    editado_por VARCHAR(20) NULL,
    activo BIT DEFAULT 1
);
GO

CREATE TABLE produccion_abm_subgrupos (
    subgrupo_id INT PRIMARY KEY IDENTITY(1,1),
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NOT NULL,
    creado_en DATETIME DEFAULT GETDATE(),
    creado_por VARCHAR(20) NULL,
    editado_en DATETIME NULL,
    editado_por VARCHAR(20) NULL,
    activo BIT DEFAULT 1
);

CREATE TABLE produccion_abm_procesos (
    proceso_id INT PRIMARY KEY IDENTITY(1,1),
    codigo VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NOT NULL,
    creado_en DATETIME DEFAULT GETDATE(),
    creado_por VARCHAR(20) NULL,
    editado_en DATETIME NULL,
    editado_por VARCHAR(20) NULL,
    activo BIT DEFAULT 1
);
GO

CREATE TABLE produccion_abm_traducciones (
    traduccion_id INT PRIMARY KEY IDENTITY(1,1),
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NOT NULL,
    creado_en DATETIME DEFAULT GETDATE(),
    creado_por VARCHAR(20) NULL,
    editado_en DATETIME NULL,
    editado_por VARCHAR(20) NULL,
    activo BIT DEFAULT 1
);
GO

/* ---------------------------------- SALIDAS DE PRODUCCION ------------------------------------- */

CREATE TABLE produccion_pallets (
    pallet_id INT PRIMARY KEY IDENTITY(1,1),
    estado VARCHAR(50) NOT NULL CHECK (estado IN ('disponible', 'en_proceso', 'completo', 'en_pedido', 'en_carga', 'despachado')),
    creado_en DATETIME DEFAULT GETDATE(),
    creado_por VARCHAR(20) NULL,
    editado_en DATETIME NULL,
    editado_por VARCHAR(20) NULL,
    activo BIT DEFAULT 1
);

CREATE TABLE produccion_general (
    codbar_id INT IDENTITY(1,1) PRIMARY KEY,

    -- Trazabilidad
    fecha_faena DATE NULL,
    fecha_produccion DATE NULL,
    fecha_recepcion DATE NULL,
    fecha_remito DATE NULL,

    -- Datos del sistema
    fecha_sistema DATETIME2(0) NOT NULL DEFAULT SYSUTCDATETIME(),
    fecha_modificacion DATETIME2(0) NULL,

    -- Referencias de usuario (ID + nombre al momento)
    creado_por_id INT NOT NULL,
    creado_por_username VARCHAR(100) NOT NULL,
    editado_por_id INT NULL,
    editado_por_username VARCHAR(100) NULL,

    -- Referencias a proceso y producto
    proceso_id INT NULL,
    mercaderia_id INT NOT NULL,
    proveedor_id INT NULL,

    -- Asociación futura
    pallet_id INT NULL,
    pedido_id INT NULL,

    -- Datos físicos
    unidades INT NULL,
    cantidad INT NULL,
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
    --CONSTRAINT FK_produccion_pallet FOREIGN KEY (pallet_id) REFERENCES produccion_pallets(pallet_id),
    --CONSTRAINT FK_produccion_pedido FOREIGN KEY (pedido_id) REFERENCES expedicion_pedidos(pedido_id)
);
GO


/* ---------------------------------- ÍNDICES Y OPTIMIZACIONES ---------------------------------- */

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