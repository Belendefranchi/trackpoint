-- 1. Dropear tablas si existen
IF OBJECT_ID('configuracion_abm_perfilesPorOperador', 'U') IS NOT NULL DROP TABLE configuracion_abm_perfilesPorOperador;
IF OBJECT_ID('configuracion_abm_permisosPorPerfil', 'U') IS NOT NULL DROP TABLE configuracion_abm_permisosPorPerfil;
IF OBJECT_ID('configuracion_abm_operadores', 'U') IS NOT NULL DROP TABLE configuracion_abm_operadores;
IF OBJECT_ID('configuracion_abm_perfiles', 'U') IS NOT NULL DROP TABLE configuracion_abm_perfiles;
IF OBJECT_ID('configuracion_abm_permisos', 'U') IS NOT NULL DROP TABLE configuracion_abm_permisos;

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
