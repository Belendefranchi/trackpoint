-- Crear la tabla permisos
CREATE TABLE configuracion_abm_permisos (
	id INT PRIMARY KEY IDENTITY(1,1),
	nombre VARCHAR(20) NOT NULL UNIQUE,
	descripcion VARCHAR(50) NOT NULL,
	pantalla VARCHAR(20) NOT NULL,
	creado_en DATETIME DEFAULT GETDATE(),
	actualizado_en DATETIME NULL
);

-- Crear la tabla pivote, relación muchos a muchos: perfiles ↔ permisos
CREATE TABLE configuracion_abm_perfiles_permisos (
	perfil_id INT,
	permiso_id INT,
	PRIMARY KEY (perfil_id, permiso_id),
	FOREIGN KEY (perfil_id) REFERENCES configuracion_abm_perfiles(id) ON DELETE CASCADE,
	FOREIGN KEY (permiso_id) REFERENCES configuracion_abm_permisos(id) ON DELETE CASCADE
);


-- Trigger que modificar el campo actualizado_en de forma autromática al actualizar un registro
CREATE TRIGGER trg_Update_permisos
ON configuracion_abm_permisos
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;

	UPDATE configuracion_abm_permisos
	SET actualizado_en = GETDATE()
	FROM configuracion_abm_permisos per
	INNER JOIN inserted i ON per.id = i.id;
END;



