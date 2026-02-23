@echo off
CHCP 65001 >NUL
SETLOCAL ENABLEDELAYEDEXPANSION

:: ==== Configuración de conexión ====
SET SERVER=localhost
SET DATABASE=trackpoint
SET USER=sa
SET PASSWORD=Acofar*664

:: ==== Nombre del log con fecha/hora ====
SET LOGFILE=inicializacion_%DATE:~6,4%%DATE:~3,2%%DATE:~0,2%_%TIME:~0,2%%TIME:~3,2%%TIME:~6,2%.log
SET LOGFILE=%LOGFILE: =0%

:: ==== Inicio ====
ECHO =============================================== > %LOGFILE%
ECHO INICIO DEL SCRIPT - %DATE% %TIME% >> %LOGFILE%
ECHO =============================================== >> %LOGFILE%
ECHO ===============================================
ECHO INICIO DEL SCRIPT - %DATE% %TIME%
ECHO ===============================================

:: ==== Crear o recrear base ====
ECHO Reiniciando base de datos '%DATABASE%'...
ECHO Reiniciando base de datos '%DATABASE%'... >> %LOGFILE%
sqlcmd -S %SERVER% -U %USER% -P %PASSWORD% -f 65001 -Q "IF DB_ID(N'%DATABASE%') IS NOT NULL BEGIN PRINT 'Base existente. Eliminando...'; ALTER DATABASE [%DATABASE%] SET SINGLE_USER WITH ROLLBACK IMMEDIATE; DROP DATABASE [%DATABASE%]; END PRINT 'Creando nueva base de datos...'; CREATE DATABASE [%DATABASE%];" > temp_output.log 2>&1
TYPE temp_output.log
TYPE temp_output.log >> %LOGFILE%
IF ERRORLEVEL 1 GOTO error

:: ==== Info ====
ECHO ===============================================
ECHO INICIANDO CONFIGURACIÓN DE BASE DE DATOS
ECHO Servidor: %SERVER% ^| Base de datos: %DATABASE%
ECHO ===============================================
ECHO =============================================== >> %LOGFILE%
ECHO INICIANDO CONFIGURACIÓN DE BASE DE DATOS >> %LOGFILE%
ECHO Servidor: %SERVER% ^| Base de datos: %DATABASE% >> %LOGFILE%
ECHO =============================================== >> %LOGFILE%

:: ==== Paso 1: Crear tablas ====
ECHO [1/3] Creando tablas...
ECHO [1/3] Creando tablas... >> %LOGFILE%
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 01_crear_tablas.sql > temp_output.log 2>&1
TYPE temp_output.log
TYPE temp_output.log >> %LOGFILE%
IF ERRORLEVEL 1 GOTO error

:: ==== Paso 2: Insertar datos iniciales ====
ECHO [2/3] Insertando datos seed...
ECHO [2/3] Insertando datos seed... >> %LOGFILE%
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 02_insertar_seed_data.sql > temp_output.log 2>&1
TYPE temp_output.log
TYPE temp_output.log >> %LOGFILE%
IF ERRORLEVEL 1 GOTO error

:: ==== Paso 3: Crear triggers ====
ECHO [3/3] Creando triggers...
ECHO [3/3] Creando triggers... >> %LOGFILE%
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 03_crear_triggers.sql > temp_output.log 2>&1
TYPE temp_output.log
TYPE temp_output.log >> %LOGFILE%
IF ERRORLEVEL 1 GOTO error

:: ==== Éxito ====
ECHO ===============================================
ECHO FINALIZADO CON ÉXITO - %DATE% %TIME%
ECHO ===============================================
ECHO =============================================== >> %LOGFILE%
ECHO FINALIZADO CON ÉXITO - %DATE% %TIME% >> %LOGFILE%
ECHO =============================================== >> %LOGFILE%
ECHO ✅ Inicialización completada. Ver log: %LOGFILE%

GOTO end

:error
ECHO ❌ ERROR en la ejecución. Ver log: %LOGFILE%
ECHO =============================================== >> %LOGFILE%
ECHO ❌ ERROR DETECTADO - %DATE% %TIME% >> %LOGFILE%
ECHO =============================================== >> %LOGFILE%

:end
DEL temp_output.log >NUL 2>&1
ENDLOCAL
PAUSE
