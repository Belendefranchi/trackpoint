-- 1. Insertar operador admin
INSERT INTO configuracion_abm_operadores
	( username, password, nombre_completo, email, rol, creado_en, creado_por, editado_en, editado_por, activo )
VALUES
	( 'admin', '$2y$10$SiJZDUAZqYz1qktsokIQcux.ptIzOVyhN.TC4KYb040aE2UiOHeK2', 'Administrador', 'soporte@puntoconectado.com.ar', 'admin', GETDATE(), 'admin', NULL, NULL, 1 ),
	( 'juan', '$2y$10$SiJZDUAZqYz1qktsokIQcux.ptIzOVyhN.TC4KYb040aE2UiOHeK2', 'Juan', 'juan@puntoconectado.com.ar', 'admin', GETDATE(), 'admin', NULL, NULL, 1 ),
	( 'belen', '$2y$10$SiJZDUAZqYz1qktsokIQcux.ptIzOVyhN.TC4KYb040aE2UiOHeK2', 'Belen', 'belen@puntoconectado.com.ar', 'admin', GETDATE(), 'admin', NULL, NULL, 1 );


-- 2. Insertar perfil "Permisos"
INSERT INTO configuracion_abm_perfiles
	( nombre, descripcion, creado_en, creado_por, editado_en, editado_por, activo )
VALUES
	( 'Permisos', 'Perfil con acceso a pantalla Permisos', GETDATE(), 'admin', NULL, NULL, 1 ), /* 1 */
	( 'Configuración', 'Perfil con acceso al menú de Configuración', GETDATE(), 'admin', NULL, NULL, 1 ), /* 2 */
	( 'Producción', 'Perfil con acceso al menú de Producción', GETDATE(), 'admin', NULL, NULL, 1 ); /* 3 */

-- 3. Asignar perfil "Permisos" al operador admin
-- Asumiendo que el operador_id del admin es 1 y el perfil_id del perfil "Permisos" es 1
INSERT INTO configuracion_abm_perfilesPorOperador
	( operador_id, perfil_id )
VALUES
	( 1, 1 ),
	( 2, 2 ),
	( 2, 3 ),
	( 3, 2 ),
	( 3, 3 )
	;

-- 4. Insertar permiso "Permisos"
INSERT INTO configuracion_abm_permisos
	( nombre, descripcion, pantalla, creado_en, creado_por, editado_en, editado_por )
VALUES
	( 'Configuración', 'Permiso para acceder al menú Configuración', '/configuracion', GETDATE(), 'admin', NULL, NULL ),
	( 'Permisos', 'Permiso para acceder a la pantalla de Permisos', '/configuracion/ABMs/permisos', GETDATE(), 'admin', NULL, NULL ),
	( 'Operadores', 'Permiso para acceder a la pantalla de Operadores', '/configuracion/ABMs/operadores', GETDATE(), 'admin', NULL, NULL ),
	( 'Perfiles', 'Permiso para acceder a la pantalla de Perfiles', '/configuracion/ABMs/perfiles', GETDATE(), 'admin', NULL, NULL ),
	( 'Perfiles por Operador', 'Permiso para acceder a la pantalla de Perfiles por Operador', '/configuracion/ABMs/perfilesPorOperador', GETDATE(), 'admin', NULL, NULL ),
	( 'Permisos por Perfil', 'Permiso para acceder a la pantalla de Permisos por Perfil', '/configuracion/ABMs/permisosPorPerfil', GETDATE(), 'admin', NULL, NULL ),
	( 'Producción', 'Permiso para acceder al menú Producción', '/produccion', GETDATE(), 'admin', NULL, NULL )
	;

-- 5. Asignar permiso "Permisos" al perfil "Permisos"
-- Asumiendo que el perfil_id del perfil "Permisos" es 1 y el permiso_id del permiso "Permisos" es 1
INSERT INTO configuracion_abm_permisosPorPerfil
	( perfil_id, permiso_id )
VALUES
	( 1, 1 ),
	( 1, 2 ),
	( 2, 1 ),
	( 2, 3 ),
	( 2, 4 ),
	( 2, 5 ),
	( 2, 6 ),
	( 3, 7 )
	;
