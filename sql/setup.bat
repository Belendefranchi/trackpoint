@echo off
CHCP 65001 >NUL

SETLOCAL ENABLEDELAYEDEXPANSION

:: Configuración de conexión
SET SERVER=localhost
SET DATABASE=trackpoint
SET USER=sa
SET PASSWORD=Acofar*664

ECHO ================================================
ECHO INICIANDO CONFIGURACION DE BASE DE DATOS
ECHO ================================================
ECHO Servidor: %SERVER% ^| Base de datos: %DATABASE%
ECHO ================================================

:: Verificar si la base de datos existe
sqlcmd -S %SERVER% -U %USER% -P %PASSWORD% -Q "IF DB_ID(N'%DATABASE%') IS NULL BEGIN PRINT 'Creando base de datos %DATABASE%...'; CREATE DATABASE [%DATABASE%]; END" -f 65001
IF ERRORLEVEL 1 GOTO error

:: Paso 1: Crear tablas
ECHO Creando tablas...
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 01_crear_tablas.sql
IF ERRORLEVEL 1 GOTO error

:: Paso 2: Insertar datos iniciales
ECHO Insertando datos iniciales...
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 02_insertar_seed_data.sql
IF ERRORLEVEL 1 GOTO error

:: Paso 3: Crear triggers
ECHO Creando triggers...
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 03_crear_triggers.sql
IF ERRORLEVEL 1 GOTO error

ECHO ================================================
ECHO CONFIGURACION COMPLETADA CON EXITO
ECHO ================================================
GOTO end

:error
ECHO ERROR: Falló la ejecución de uno de los scripts.
ECHO Verifica el archivo .sql correspondiente o la configuración de conexión.
GOTO end

:end
ENDLOCAL
PAUSE
