@echo off
REM ========================================================================
REM Quick Test Script for Cacti Multilingual PHP System
REM Tests the basic functionality of the multilingual documentation system
REM ========================================================================

echo.
echo ========================================================================
echo                    CACTI MULTILINGUAL SYSTEM QUICK TEST
echo ========================================================================
echo.

REM Check if PHP is available
php --version >nul 2>&1
if errorlevel 1 (
    echo ❌ ERROR: PHP is not installed or not in PATH.
    echo Please install PHP first.
    pause
    exit /b 1
)

echo ✅ PHP is available
echo.

REM Check if required files exist
echo Checking required files...

if exist "includes\language.php" (
    echo ✅ includes\language.php - Found
) else (
    echo ❌ includes\language.php - Missing
    set missing_files=1
)

if exist "includes\page_template.php" (
    echo ✅ includes\page_template.php - Found
) else (
    echo ❌ includes\page_template.php - Missing
    set missing_files=1
)

if exist "languages\en.php" (
    echo ✅ languages\en.php - Found
) else (
    echo ❌ languages\en.php - Missing
    set missing_files=1
)

if exist "languages\zh-cn.php" (
    echo ✅ languages\zh-cn.php - Found
) else (
    echo ❌ languages\zh-cn.php - Missing
    set missing_files=1
)

if exist "languages\zh-tw.php" (
    echo ✅ languages\zh-tw.php - Found
) else (
    echo ❌ languages\zh-tw.php - Missing
    set missing_files=1
)

if exist "documentation.php" (
    echo ✅ documentation.php - Found
) else (
    echo ❌ documentation.php - Missing
    set missing_files=1
)

if exist "Requirements.php" (
    echo ✅ Requirements.php - Found
) else (
    echo ❌ Requirements.php - Missing
    set missing_files=1
)

if exist "Navigating-The-User-Interface.php" (
    echo ✅ Navigating-The-User-Interface.php - Found
) else (
    echo ❌ Navigating-The-User-Interface.php - Missing
    set missing_files=1
)

if exist "Principles-of-Operation.php" (
    echo ✅ Principles-of-Operation.php - Found
) else (
    echo ❌ Principles-of-Operation.php - Missing
    set missing_files=1
)

if exist "Graph-Overview.php" (
    echo ✅ Graph-Overview.php - Found
) else (
    echo ❌ Graph-Overview.php - Missing
    set missing_files=1
)

if exist "How-to-Graph-Your-Network.php" (
    echo ✅ How-to-Graph-Your-Network.php - Found
) else (
    echo ❌ How-to-Graph-Your-Network.php - Missing
    set missing_files=1
)

if exist "Viewing-Graphs.php" (
    echo ✅ Viewing-Graphs.php - Found
) else (
    echo ❌ Viewing-Graphs.php - Missing
    set missing_files=1
)

if exist "Devices.php" (
    echo ✅ Devices.php - Found
) else (
    echo ❌ Devices.php - Missing
    set missing_files=1
)

if exist "Sites.php" (
    echo ✅ Sites.php - Found
) else (
    echo ❌ Sites.php - Missing
    set missing_files=1
)

if exist "Trees.php" (
    echo ✅ Trees.php - Found
) else (
    echo ❌ Trees.php - Missing
    set missing_files=1
)

if exist "Graphs.php" (
    echo ✅ Graphs.php - Found
) else (
    echo ❌ Graphs.php - Missing
    set missing_files=1
)

if exist "Data-Sources.php" (
    echo ✅ Data-Sources.php - Found
) else (
    echo ❌ Data-Sources.php - Missing
    set missing_files=1
)

if exist "Aggregates.php" (
    echo ✅ Aggregates.php - Found
) else (
    echo ❌ Aggregates.php - Missing
    set missing_files=1
)

if exist "test-multilingual-system.php" (
    echo ✅ test-multilingual-system.php - Found
) else (
    echo ❌ test-multilingual-system.php - Missing
    set missing_files=1
)

echo.

if defined missing_files (
    echo ❌ Some required files are missing!
    echo Please run convert_to_multilingual.bat first to set up the system.
    pause
    exit /b 1
)

echo ✅ All required files found!
echo.

REM Test PHP syntax
echo Testing PHP syntax...

php -l includes\language.php >nul 2>&1
if errorlevel 1 (
    echo ❌ includes\language.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ includes\language.php syntax OK
)

php -l includes\page_template.php >nul 2>&1
if errorlevel 1 (
    echo ❌ includes\page_template.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ includes\page_template.php syntax OK
)

php -l languages\en.php >nul 2>&1
if errorlevel 1 (
    echo ❌ languages\en.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ languages\en.php syntax OK
)

php -l languages\zh-cn.php >nul 2>&1
if errorlevel 1 (
    echo ❌ languages\zh-cn.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ languages\zh-cn.php syntax OK
)

php -l languages\zh-tw.php >nul 2>&1
if errorlevel 1 (
    echo ❌ languages\zh-tw.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ languages\zh-tw.php syntax OK
)

php -l documentation.php >nul 2>&1
if errorlevel 1 (
    echo ❌ documentation.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ documentation.php syntax OK
)

php -l test-multilingual-system.php >nul 2>&1
if errorlevel 1 (
    echo ❌ test-multilingual-system.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ test-multilingual-system.php syntax OK
)

php -l Principles-of-Operation.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Principles-of-Operation.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Principles-of-Operation.php syntax OK
)

php -l Graph-Overview.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Graph-Overview.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Graph-Overview.php syntax OK
)

php -l How-to-Graph-Your-Network.php >nul 2>&1
if errorlevel 1 (
    echo ❌ How-to-Graph-Your-Network.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ How-to-Graph-Your-Network.php syntax OK
)

php -l Viewing-Graphs.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Viewing-Graphs.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Viewing-Graphs.php syntax OK
)

php -l Devices.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Devices.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Devices.php syntax OK
)

php -l Sites.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Sites.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Sites.php syntax OK
)

php -l Trees.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Trees.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Trees.php syntax OK
)

php -l Graphs.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Graphs.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Graphs.php syntax OK
)

php -l Data-Sources.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Data-Sources.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Data-Sources.php syntax OK
)

php -l Aggregates.php >nul 2>&1
if errorlevel 1 (
    echo ❌ Aggregates.php has syntax errors
    set syntax_errors=1
) else (
    echo ✅ Aggregates.php syntax OK
)

echo.

if defined syntax_errors (
    echo ❌ Some files have PHP syntax errors!
    echo Please check the files and fix the errors.
    pause
    exit /b 1
)

echo ✅ All PHP files have valid syntax!
echo.

REM Start PHP built-in server for testing
echo ========================================================================
echo                           STARTING TEST SERVER
echo ========================================================================
echo.
echo Starting PHP built-in server on localhost:8000...
echo.
echo 🌐 You can now test the multilingual system:
echo.
echo   📄 Main Documentation: http://localhost:8000/documentation.php
echo   🧪 System Test Page:   http://localhost:8000/test-multilingual-system.php
echo   📋 Requirements Page:  http://localhost:8000/Requirements.php
echo   🎛️ UI Navigation:      http://localhost:8000/Navigating-The-User-Interface.php
echo   ⚙️ Operation Principles: http://localhost:8000/Principles-of-Operation.php
echo   📊 Graph Overview:     http://localhost:8000/Graph-Overview.php
echo   🌐 How to Graph Network: http://localhost:8000/How-to-Graph-Your-Network.php
echo   👁️ Viewing Graphs:      http://localhost:8000/Viewing-Graphs.php
echo   🖥️ Device Management:   http://localhost:8000/Devices.php
echo   🏢 Site Management:     http://localhost:8000/Sites.php
echo   🌳 Tree Management:     http://localhost:8000/Trees.php
echo   📈 Graph Management:    http://localhost:8000/Graphs.php
echo   📊 Data Source Management: http://localhost:8000/Data-Sources.php
echo   📈 Aggregate Graphs:    http://localhost:8000/Aggregates.php
echo.
echo 🔧 Test Instructions:
echo   1. Open the URLs above in your web browser
echo   2. Use the language selector (top-right) to switch languages
echo   3. Navigate between pages to test language persistence
echo   4. Check that all links point to .php files
echo   5. Test on different devices for responsive design
echo.
echo 🛑 Press Ctrl+C to stop the server when done testing
echo.

php -S localhost:8000

echo.
echo Server stopped.
pause
