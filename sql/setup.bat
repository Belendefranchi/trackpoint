@echo off
CHCP 65001 >NUL

SETLOCAL ENABLEDELAYEDEXPANSION

:: Configuración de conexión
SET SERVER=localhost
SET DATABASE=trackpoint
SET USER=sa
SET PASSWORD=Acofar*664
SET LOGFILE=inicializacion_%DATE:~6,4%%DATE:~3,2%%DATE:~0,2%_%TIME:~0,2%%TIME:~3,2%%TIME:~6,2%.log

:: Eliminar espacios de la hora (por si TIME devuelve ' 9:xx')
SET LOGFILE=%LOGFILE: =0%

ECHO ================================================ >> %LOGFILE%
ECHO INICIO DEL SCRIPT - %DATE% %TIME% >> %LOGFILE%
ECHO ================================================ >> %LOGFILE%

:: ==== Verificar y recrear base ====
ECHO Reiniciando base de datos '%DATABASE%'...
sqlcmd -S %SERVER% -U %USER% -P %PASSWORD% -f 65001 -Q "IF DB_ID(N'%DATABASE%') IS NOT NULL BEGIN PRINT 'Base existente. Eliminando...'; ALTER DATABASE [%DATABASE%] SET SINGLE_USER WITH ROLLBACK IMMEDIATE; DROP DATABASE [%DATABASE%]; END PRINT 'Creando nueva base de datos...'; CREATE DATABASE [%DATABASE%];" >> %LOGFILE% 2>&1
IF ERRORLEVEL 1 GOTO error

ECHO ================================================
ECHO INICIANDO CONFIGURACION DE BASE DE DATOS
ECHO ================================================
ECHO Servidor: %SERVER% ^| Base de datos: %DATABASE%
ECHO ================================================


REM ==== Paso 1: Crear tablas ====
ECHO [1/3] Creando tablas...
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 01_crear_tablas.sql >> %LOGFILE% 2>&1
IF ERRORLEVEL 1 GOTO error

REM ==== Paso 2: Insertar datos iniciales ====
ECHO [2/3] Insertando datos seed...
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 02_insertar_seed_data.sql >> %LOGFILE% 2>&1
IF ERRORLEVEL 1 GOTO error

REM ==== Paso 3: Crear triggers ====
ECHO [3/3] Creando triggers...
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 03_crear_triggers.sql >> %LOGFILE% 2>&1
IF ERRORLEVEL 1 GOTO error

ECHO ================================================ >> %LOGFILE%
ECHO FINALIZADO CON ÉXITO - %DATE% %TIME% >> %LOGFILE%
ECHO ================================================ >> %LOGFILE%

ECHO ✅ Inicialización completada. Ver registro: %LOGFILE%
GOTO end

:error
ECHO ❌ Error en la ejecución. Ver detalles en el log: %LOGFILE%
ECHO ================================================ >> %LOGFILE%
ECHO ❌ ERROR DETECTADO - %DATE% %TIME% >> %LOGFILE%
ECHO ================================================ >> %LOGFILE%

:end
ENDLOCAL
PAUSE
