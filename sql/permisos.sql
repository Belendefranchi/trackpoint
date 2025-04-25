-- Crear la tabla permisos
CREATE TABLE configuracion_abm_permisos (
    id INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
		pantalla VARCHAR(100) NOT NULL,
    creado_en DATETIME DEFAULT GETDATE(),
		actualizado_en DATETIME DEFAULT GETDATE()
);

-- Crear la tabla pivote, relación muchos a muchos: perfiles ↔ permisos
CREATE TABLE configuracion_abm_permisos_perfil_permiso (
    perfil_id INT,
    permiso_id INT,
    PRIMARY KEY (perfil_id, permiso_id),
    FOREIGN KEY (perfil_id) REFERENCES perfiles(id) ON DELETE CASCADE,
    FOREIGN KEY (permiso_id) REFERENCES permisos(id) ON DELETE CASCADE
);


