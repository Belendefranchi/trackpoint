@echo off
CHCP 65001 >NUL
SETLOCAL ENABLEDELAYEDEXPANSION

:: ==== Configuración de conexión ====
SET SERVER=localhost
SET DATABASE=trackpoint
SET USER=sa
SET PASSWORD=Acofar*664

:: ==== Nombre del log con fecha/hora ====
SET LOGFILE=actualizacion_%DATE:~6,4%%DATE:~3,2%%DATE:~0,2%_%TIME:~0,2%%TIME:~3,2%%TIME:~6,2%.log
SET LOGFILE=%LOGFILE: =0%

:: ==== Inicio ====
ECHO =============================================== > %LOGFILE%
ECHO INICIO DEL SCRIPT - %DATE% %TIME% >> %LOGFILE%
ECHO =============================================== >> %LOGFILE%
ECHO ===============================================
ECHO INICIO DEL SCRIPT - %DATE% %TIME%
ECHO ===============================================


:: ==== Info ====
ECHO ===============================================
ECHO INICIANDO ACTUALIZACIÓN DE BASE DE DATOS
ECHO Servidor: %SERVER% ^| Base de datos: %DATABASE%
ECHO ===============================================

ECHO =============================================== >> %LOGFILE%
ECHO INICIANDO ACTUALIZACIÓN DE BASE DE DATOS >> %LOGFILE%
ECHO Servidor: %SERVER% ^| Base de datos: %DATABASE% >> %LOGFILE%
ECHO =============================================== >> %LOGFILE%

:: ==== Paso 1: actualizar tablas ====

ECHO Actualizando tablas '%DATABASE%'...
ECHO Actualizando tablas '%DATABASE%'... >> %LOGFILE%
sqlcmd -S %SERVER% -d %DATABASE% -U %USER% -P %PASSWORD% -f 65001 -i 04_updates.sql > temp_output.log 2>&1
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
ECHO ✅ Actualización completada. Ver log: %LOGFILE%

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
