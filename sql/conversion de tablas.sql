-- Opcional: crear backups por si algo falla
DROP TABLE backup_operadores 
DROP TABLE backup_perfiles
DROP TABLE backup_permisos

SELECT * INTO backup_operadores FROM configuracion_abm_operadores;
SELECT * INTO backup_perfiles FROM configuracion_abm_perfiles;
SELECT * INTO backup_permisos FROM configuracion_abm_permisos;


-- 1. Eliminar tablas principales
DROP TABLE configuracion_abm_perfilesPorOperador;
DROP TABLE configuracion_abm_permisosPorPerfil;
DROP TABLE configuracion_abm_operadores;
DROP TABLE configuracion_abm_perfiles;
DROP TABLE configuracion_abm_permisos;

-- 2. Crear tablas corregidas
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
	pantalla VARCHAR(50) NOT NULL,
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


-- 3. Insertar datos de los backups a las nuevas tablas
INSERT INTO configuracion_abm_operadores (username, password, nombre_completo, email, rol, creado_en, creado_por, editado_en, editado_por, activo)
SELECT
    username,
    password,
    nombre_completo,
    email,
    rol,
    creado_en,
		NULL AS creado_por,
    NULL AS editado_en, -- Porque no existeN en el backup
		NULL AS editado_por,
    activo
FROM backup_operadores;


INSERT INTO configuracion_abm_perfiles (nombre, descripcion, creado_en, creado_por, editado_en, editado_por, activo)
SELECT
    nombre,
    descripcion,
    creado_en,
		NULL AS creado_por,
    NULL AS editado_en, -- Porque no existeN en el backup
		NULL AS editado_por,
    activo
FROM backup_perfiles;


INSERT INTO configuracion_abm_permisos (nombre, descripcion, pantalla, creado_en)
SELECT
    nombre,
    descripcion,
    pantalla,
    creado_en
FROM backup_permisos;


