-- Crear la tabla de perfiles
CREATE TABLE configuracion_abm_perfiles (
	id INT PRIMARY KEY IDENTITY(1,1),
	nombre VARCHAR(50) NOT NULL UNIQUE,
	descripcion VARCHAR(255),
	creado_en DATETIME DEFAULT GETDATE(),
  activo BIT DEFAULT 1 -- 1 = activo, 0 = inactivo
);

-- Crear la tabla pivote, relación muchos a muchos: operadores ↔ perfiles
CREATE TABLE configuracion_abm_perfiles_operador_perfil (
    operador_id INT,
    perfil_id INT,
    PRIMARY KEY (operador_id, perfil_id),
    FOREIGN KEY (operador_id) REFERENCES operadores(id) ON DELETE CASCADE,
    FOREIGN KEY (perfil_id) REFERENCES perfiles(id) ON DELETE CASCADE
);

-- Insertar un perfil de ejemplo
INSERT INTO configuracion_abm_perfiles (nombre, descripcion)
VALUES (
  'Administrador',
  'Perfil con acceso completo al sistema',
	1
);