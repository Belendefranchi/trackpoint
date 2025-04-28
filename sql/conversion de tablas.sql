-- Opcional: crear backups por si algo falla
SELECT * INTO backup_operadores FROM configuracion_abm_operadores;
SELECT * INTO backup_perfiles FROM configuracion_abm_perfiles;
SELECT * INTO backup_permisos FROM configuracion_abm_permisos;


-- 1. Eliminar tablas principales
DROP TABLE configuracion_abm_permisos;
DROP TABLE configuracion_abm_perfiles;
DROP TABLE configuracion_abm_operadores;

-- 2. Crear tablas corregidas
CREATE TABLE configuracion_abm_operadores (
	id INT PRIMARY KEY IDENTITY(1,1),
	username VARCHAR(10) NOT NULL UNIQUE,
	password VARCHAR(100) NOT NULL,
	nombre_completo VARCHAR(20),
	email VARCHAR(100) NOT NULL UNIQUE,
	rol VARCHAR(20),
	creado_en DATETIME DEFAULT GETDATE(),
	actualizado_en DATETIME NULL,
	activo BIT DEFAULT 1
);

CREATE TABLE configuracion_abm_perfiles (
	id INT PRIMARY KEY IDENTITY(1,1),
	nombre VARCHAR(20) NOT NULL UNIQUE,
	descripcion VARCHAR(50) NOT NULL,
	creado_en DATETIME DEFAULT GETDATE(),
	actualizado_en DATETIME NULL,
	activo BIT DEFAULT 1
);

CREATE TABLE configuracion_abm_perfilesPorOperador (
	operador_id INT,
	perfil_id INT,
	PRIMARY KEY (operador_id, perfil_id),
	FOREIGN KEY (operador_id) REFERENCES configuracion_abm_operadores(id) ON DELETE CASCADE,
	FOREIGN KEY (perfil_id) REFERENCES configuracion_abm_perfiles(id) ON DELETE CASCADE
);

CREATE TABLE configuracion_abm_permisos (
	id INT PRIMARY KEY IDENTITY(1,1),
	nombre VARCHAR(20) NOT NULL UNIQUE,
	descripcion VARCHAR(50) NOT NULL, 
	pantalla VARCHAR(20) NOT NULL,
	creado_en DATETIME DEFAULT GETDATE(),
	actualizado_en DATETIME NULL
);

CREATE TABLE configuracion_abm_permisosPorPerfil (
	perfil_id INT,
	permiso_id INT,
	PRIMARY KEY (perfil_id, permiso_id),
	FOREIGN KEY (perfil_id) REFERENCES configuracion_abm_perfiles(id) ON DELETE CASCADE,
	FOREIGN KEY (permiso_id) REFERENCES configuracion_abm_permisos(id) ON DELETE CASCADE
);


-- 3. Insertar datos de los backups a las nuevas tablas
INSERT INTO configuracion_abm_operadores (username, password, nombre_completo, email, rol, creado_en, actualizado_en, activo)
SELECT
    username,
    password,
    nombre_completo,
    email,
    rol,
    creado_en,
    NULL AS actualizado_en, -- Porque no existe en el backup
    activo
FROM backup_operadores;


INSERT INTO configuracion_abm_perfiles (nombre, descripcion, creado_en, actualizado_en, activo)
SELECT
    nombre,
    descripcion,
    creado_en,
    NULL AS actualizado_en,
    activo
FROM backup_perfiles;


INSERT INTO configuracion_abm_permisos (nombre, descripcion, pantalla, creado_en, actualizado_en)
SELECT
    nombre,
    descripcion,
    pantalla,
    creado_en,
    NULL AS actualizado_en
FROM backup_permisos;

