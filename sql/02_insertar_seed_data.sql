INSERT INTO sistema_logs_tiposHabilitados (tipo, habilitado) VALUES
('INFO', 1),
('ERROR', 1),
('CRITICAL', 1),
('DEBUG', 0),
('WARNING', 1);


INSERT INTO sistema_estados_tiposHabilitados (estado, descripcion, habilitado) VALUES
('D', 'disponible', 1),
('P', 'palletizado', 1),
('S', 'eliminado', 1),
('E', 'despachado', 1),
('B', 'baja', 1),
('C', 'cancelado', 1);


-- Insertar operador admin
INSERT INTO configuracion_abm_operadores
	( username, password, nombre_completo, email, rol, creado_en, creado_por, editado_en, editado_por, activo )
VALUES
	( 'admin', '$2y$10$SiJZDUAZqYz1qktsokIQcux.ptIzOVyhN.TC4KYb040aE2UiOHeK2', 'Administrador', 'soporte@puntoconectado.com.ar', 'admin', GETDATE(), 'admin', NULL, NULL, 1 ),
	( 'juan', '$2y$10$SiJZDUAZqYz1qktsokIQcux.ptIzOVyhN.TC4KYb040aE2UiOHeK2', 'Juan', 'juan@puntoconectado.com.ar', 'admin', GETDATE(), 'admin', NULL, NULL, 1 ),
	( 'belen', '$2y$10$SiJZDUAZqYz1qktsokIQcux.ptIzOVyhN.TC4KYb040aE2UiOHeK2', 'Belen', 'belen@puntoconectado.com.ar', 'admin', GETDATE(), 'admin', NULL, NULL, 1 );


-- Insertar perfil "Permisos"
INSERT INTO configuracion_abm_perfiles
	( nombre, descripcion, creado_en, creado_por, editado_en, editado_por, activo )
VALUES
	( 'Permisos', 'Perfil con acceso a pantalla Permisos', GETDATE(), 'admin', NULL, NULL, 1 ), /* 1 */
	( 'Configuración', 'Perfil con acceso al menú de Configuración', GETDATE(), 'admin', NULL, NULL, 1 ), /* 2 */
	( 'Producción', 'Perfil con acceso al menú de Producción', GETDATE(), 'admin', NULL, NULL, 1 ); /* 3 */

-- Asignar perfil "Permisos" al operador admin
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

-- Insertar permiso "Permisos"
INSERT INTO configuracion_abm_permisos
	( nombre, descripcion, pantalla, creado_en, creado_por, editado_en, editado_por )
VALUES
	( 'Configuración', 'Permiso para acceder al menú Configuración', '/configuracion', GETDATE(), 'admin', NULL, NULL ), /* 1 */
	( 'Permisos', 'Permiso para acceder a la pantalla de Permisos', '/configuracion/ABMs/permisos', GETDATE(), 'admin', NULL, NULL ), /* 2 */
	( 'Operadores', 'Permiso para acceder a la pantalla de Operadores', '/configuracion/ABMs/operadores', GETDATE(), 'admin', NULL, NULL ), /* 3 */
	( 'Perfiles', 'Permiso para acceder a la pantalla de Perfiles', '/configuracion/ABMs/perfiles', GETDATE(), 'admin', NULL, NULL ), /* 4 */
	( 'Perfiles por Operador', 'Permiso para acceder a la pantalla de Perfiles por Operador', '/configuracion/ABMs/perfilesPorOperador', GETDATE(), 'admin', NULL, NULL ), /* 5 */
	( 'Permisos por Perfil', 'Permiso para acceder a la pantalla de Permisos por Perfil', '/configuracion/ABMs/permisosPorPerfil', GETDATE(), 'admin', NULL, NULL ), /* 6 */

	( 'Producción', 'Permiso para acceder al menú Producción', '/produccion', GETDATE(), 'admin', NULL, NULL ), /* 7 */
 	( 'Mercaderías', 'Permiso para acceder al menú Mercaderías', '/produccion/ABMs/mercaderias', GETDATE(), 'admin', NULL, NULL ), /* 8 */
	( 'Procesos', 'Permiso para acceder al menú Procesos', '/produccion/ABMs/procesos', GETDATE(), 'admin', NULL, NULL ), /* 9 */
	( 'Etiquetas Secundarias Sin Seleccion de Stock', 'Permiso para acceder a la pantalla de Etiquetas Secundarias Sin Seleccion de Stock', '/produccion/salida/etqSecSinSeleccion', GETDATE(), 'admin', NULL, NULL ), /* 10 */
	
	( 'Recepción', 'Permiso para acceder al menú Recepción', '/recepcion', GETDATE(), 'admin', NULL, NULL ), /* 11 */
	( 'Mercaderías no Productivas', 'Permiso para acceder a la pantalla de Mercaderías no Productivas', '/recepcion/noProductivos/mercaderias', GETDATE(), 'admin', NULL, NULL ) /* 12 */


	;

-- Asignar permiso "Permisos" al perfil "Permisos"
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


-- Insertar mercaderías de ejemplo
INSERT INTO produccion_abm_mercaderias (
	codigo,
	descripcion,
	unidad_medida,
	grupo,
	subgrupo,
	envase_pri,
	envase_sec,
	marca,
	cantidad_propuesta,
	peso_propuesto,
	peso_min,
	peso_max,
	etiqueta_sec,
	codigo_externo,
	creado_en,
	creado_por,
	editado_en,
	editado_por,
	activo
	)
VALUES
	( 'M001', 'Descripción de la mercadería 1', 'Unidad de medida', 'Grupo', 'Subgrupo', 'Envase', NULL, 'Marca', 10, 100, 1.00, 2.00, 'Etiqueta', NULL, GETDATE(), 'admin', NULL, NULL, 1 ),
	( 'M002', 'Descripción de la mercadería 2', 'Unidad de medida', 'Grupo', 'Subgrupo', 'Envase', NULL, 'Marca', 20, 200, 2.00, 3.00, 'Etiqueta', NULL, GETDATE(), 'admin', NULL, NULL, 1 ),
	( 'M003', 'Descripción de la mercadería 3', 'Unidad de medida', 'Grupo', 'Subgrupo', 'Envase', NULL, 'Marca', 30, 300, 3.00, 4.00, 'Etiqueta', NULL, GETDATE(), 'admin', NULL, NULL, 1 );


-- Insertar procesos de ejemplo
INSERT INTO produccion_abm_procesos (
	codigo,
	descripcion,
	creado_en,
	creado_por,
	editado_en,
	editado_por,
	activo
	)
VALUES 
	( 'P001', 'Descripción del proceso 1', GETDATE(), 'admin', NULL, NULL, 1 )