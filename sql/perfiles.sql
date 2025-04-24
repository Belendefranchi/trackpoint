-- Crear la tabla de perfiles
CREATE TABLE perfiles (
	id INT PRIMARY KEY IDENTITY(1,1),
	nombre VARCHAR(50) NOT NULL UNIQUE,
	descripcion VARCHAR(255),
	creado_en DATETIME DEFAULT GETDATE()
);

-- Insertar un perfil de ejemplo
INSERT INTO perfiles (nombre, descripcion)
VALUES (
  'Administrador',
  'Perfil con acceso completo al sistema'
);