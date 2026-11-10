@echo off
setlocal

REM --------------------------------------------------------------
REM QR Attendance System - Offline Local Launcher
REM --------------------------------------------------------------
REM This file starts the Laravel app locally on the machine.
REM It can be copied to other PCs and run from the project folder.

set "APP_ROOT=%~dp0"
cd /d "%APP_ROOT%"

where php >nul 2>nul
if errorlevel 1 (
    echo.
    echo PHP was not found in PATH.
    echo Please install PHP or XAMPP and make sure 'php' is on PATH.
    echo.
    pause
    exit /b 1
)

if not exist "vendor\autoload.php" (
    echo.
    echo Composer dependencies are missing.
    echo Please run: composer install
    echo.
    pause
    exit /b 1
)

if not exist ".env" if exist ".env.example" (
    copy ".env.example" ".env" >nul
)

where findstr >nul 2>nul
if not errorlevel 1 (
    findstr /R "^APP_KEY=" ".env" >nul 2>nul
    if errorlevel 1 (
        echo.
        echo Generating Laravel application key...
        php artisan key:generate --force
    )
)

echo.
echo Starting QR Attendance System...
echo URL: http://127.0.0.1:8000
echo.
start "QR Attendance System" http://127.0.0.1:8000
php artisan serve --host 127.0.0.1 --port 8000

if errorlevel 1 (
    echo.
    echo The app did not start successfully.
    echo Check if port 8000 is already in use or if PHP/Composer is not configured correctly.
    echo.
    pause
)

endlocal
