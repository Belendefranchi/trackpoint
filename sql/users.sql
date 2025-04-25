-- Crear la tabla de usuarios
CREATE TABLE configuracion_abm_operadores (
    id INT PRIMARY KEY IDENTITY(1,1),
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100),
    email VARCHAR(100),
    rol VARCHAR(50),
    creado_en DATETIME DEFAULT GETDATE(),
    activo BIT DEFAULT 1
);

-- Insertar un usuario de ejemplo
INSERT INTO users (username, password, nombre_completo, email, rol)
VALUES (
  'admin',
  '$2y$10$67nqUpzKDPYQLJKqx8j8v.xdnv4i1YZDUsW3F6MAaJ0Fr0mt0SDEW',
  'Administrador',
  'admin@empresa.com',
  'admin'
);
