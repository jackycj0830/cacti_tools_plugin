@echo off
cd /d "%~dp0"

echo [1/2] Checking environment...

:: Try to find PHP in the known relative path (L:\php\php.exe relative to L:\Coding\Block_IP)
set "PHP_BIN=..\..\php\php.exe"

:: If not found there, try system PATH
if not exist "%PHP_BIN%" (
    where php >nul 2>nul
    if %ERRORLEVEL% EQU 0 (
        set "PHP_BIN=php"
    ) else (
        echo [ERROR] PHP not found! 
        echo Please ensure php.exe is in "%~dp0..\..\php\" or added to your system PATH.
        pause
        exit /b 1
    )
)

echo [OK] Using PHP: %PHP_BIN%

echo [2/2] Starting server at http://localhost:8080 ...
echo Press Ctrl+C to stop.
echo.

"%PHP_BIN%" -S localhost:8080 -t web

pause
