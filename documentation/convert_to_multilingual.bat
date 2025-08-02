@echo off
REM ========================================================================
REM Cacti Documentation Multilingual Conversion Script
REM Converts HTML files to PHP with multilingual support
REM ========================================================================

setlocal enabledelayedexpansion

echo.
echo ========================================================================
echo           CACTI DOCUMENTATION MULTILINGUAL CONVERSION v2.0
echo ========================================================================
echo.
echo This script will convert your HTML documentation files to PHP files
echo with comprehensive multilingual support.
echo.
echo FEATURES:
echo   ✓ PHP-based language management system
echo   ✓ Support for English, Simplified Chinese, Traditional Chinese
echo   ✓ Language selection with persistent storage
echo   ✓ Responsive UI controls for desktop and mobile
echo   ✓ Easy content management through PHP language files
echo   ✓ Automatic backup of original HTML files
echo   ✓ Professional navigation controls
echo.
echo WHAT THIS SCRIPT DOES:
echo   • Creates PHP language files for all three languages
echo   • Converts HTML files to PHP with language support
echo   • Adds language selector and back button to all pages
echo   • Creates backup of original HTML files
echo   • Sets up complete multilingual infrastructure
echo.
echo REQUIREMENTS:
echo   • PHP 5.4 or higher installed on your system
echo   • Web server with PHP support (Apache, Nginx, IIS)
echo   • Write permissions in the documentation directory
echo.
echo WARNING: This will modify your documentation files.
echo Make sure you have a backup before proceeding.
echo.
set /p confirm="Do you want to continue with the conversion? (Y/N): "
if /i not "%confirm%"=="Y" (
    echo Conversion cancelled.
    pause
    exit /b 0
)

echo.
echo ========================================================================
echo                        CONVERSION IN PROGRESS
echo ========================================================================
echo.

REM Check if PHP is available
php --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: PHP is not installed or not in PATH.
    echo Please install PHP and make sure it's accessible from command line.
    echo.
    echo You can download PHP from: https://www.php.net/downloads
    echo.
    pause
    exit /b 1
)

echo ✓ PHP is available
echo.

REM Create directories if they don't exist
if not exist "includes" (
    mkdir includes
    echo ✓ Created includes directory
)

if not exist "languages" (
    mkdir languages
    echo ✓ Created languages directory
)

echo.
echo Running PHP conversion script...
echo.

REM Run the PHP conversion script
php convert_to_php.php

if errorlevel 1 (
    echo.
    echo ❌ Conversion failed. Please check the error messages above.
    echo.
    pause
    exit /b 1
)

echo.
echo ========================================================================
echo                        CONVERSION COMPLETE!
echo ========================================================================
echo.

echo 🎉 SUCCESS! Your documentation has been converted to multilingual PHP!
echo.
echo WHAT WAS CREATED:
echo   📁 languages/           - Language files directory
echo   📄 languages/en.php     - English language file
echo   📄 languages/zh-cn.php  - Simplified Chinese language file
echo   📄 languages/zh-tw.php  - Traditional Chinese language file
echo   📁 includes/            - PHP includes directory
echo   📄 includes/language.php - Language management system
echo   📄 includes/page_template.php - Page template system
echo   📄 documentation.php    - Main documentation page (PHP version)
echo   📄 Requirements.php     - Requirements page (PHP version)
echo   📄 Navigating-The-User-Interface.php - UI navigation guide (PHP version)
echo   📄 Principles-of-Operation.php - Operation principles guide (PHP version)
echo   📄 Graph-Overview.php   - Graph overview guide (PHP version)
echo   📄 How-to-Graph-Your-Network.php - Network graphing tutorial (PHP version)
echo   📄 Viewing-Graphs.php   - Graph viewing guide (PHP version)
echo   📄 Devices.php         - Device management guide (PHP version)
echo   📄 Sites.php           - Site management guide (PHP version)
echo   📄 Trees.php           - Tree management guide (PHP version)
echo   📄 Graphs.php          - Graph management guide (PHP version)
echo   📄 Data-Sources.php    - Data source management guide (PHP version)
echo   📄 Aggregates.php     - Aggregate graphs guide (PHP version)
echo   📄 Data-Collectors.php - Data collectors guide (PHP version)
echo   📄 Spine-Data-Collection.php - Spine data collection guide (PHP version)
echo   📄 Data-Input-Methods.php - Data input methods guide (PHP version)
echo   📄 Data-Queries.php   - Data queries guide (PHP version)
echo   📄 Device-Templates.php - Device templates guide (PHP version)
echo   📄 Graph-Templates.php - Graph templates guide (PHP version)
echo   📄 Data-Source-Templates.php - Data source templates guide (PHP version)
echo   📄 Aggregate-Templates.php - Aggregate templates guide (PHP version)
echo   📄 Color-Templates.php - Color templates guide (PHP version)
echo   📄 test-multilingual-system.php - System testing page
echo   📄 *.php               - Converted PHP documentation files
echo   📁 backup_html_*       - Backup of original HTML files
echo.
echo FEATURES NOW AVAILABLE:
echo   🌍 Three-language support (English, 简体中文, 繁體中文)
echo   🎛️ Language selector in top-right corner of every page
echo   ⬅️ Back button in top-left corner for easy navigation
echo   💾 Language selection persists across all pages
echo   📱 Responsive design for desktop and mobile devices
echo   🔧 Easy content management through PHP language files
echo   🚀 Professional multilingual documentation system
echo.
echo HOW TO USE:
echo   1. 🌐 Set up a web server with PHP support
echo   2. 📂 Place the documentation files in your web directory
echo   3. 🔗 Access documentation.php in your web browser
echo   4. 🎯 Use the language selector to switch languages
echo   5. ✏️ Edit language files to customize translations
echo.
echo TESTING INSTRUCTIONS:
echo   1. Start your web server (Apache, Nginx, IIS, or PHP built-in server)
echo   2. Navigate to documentation.php in your browser
echo   3. Test the system using test-multilingual-system.php
echo   4. Test language switching using the dropdown in top-right corner
echo   5. Navigate between pages to verify language persistence
echo   6. Test specific pages like Requirements.php, Navigating-The-User-Interface.php, Principles-of-Operation.php, Graph-Overview.php, How-to-Graph-Your-Network.php, Viewing-Graphs.php, Devices.php, Sites.php, Trees.php, Graphs.php, Data-Sources.php, Aggregates.php, Data-Collectors.php, Spine-Data-Collection.php, Data-Input-Methods.php, Data-Queries.php, Device-Templates.php, Graph-Templates.php, Data-Source-Templates.php, Aggregate-Templates.php, and Color-Templates.php
echo   7. Test on mobile devices for responsive design
echo   8. Verify all links point to .php files (not .html)
echo.
echo CUSTOMIZATION:
echo   • Edit languages/en.php for English content
echo   • Edit languages/zh-cn.php for Simplified Chinese content
echo   • Edit languages/zh-tw.php for Traditional Chinese content
echo   • Add new translation keys as needed
echo   • Modify includes/language.php for advanced features
echo.
echo QUICK START WITH PHP BUILT-IN SERVER:
echo   1. Open command prompt in documentation directory
echo   2. Run: php -S localhost:8000
echo   3. Open browser to: http://localhost:8000/documentation.php
echo   4. Test the multilingual features!
echo.
echo TROUBLESHOOTING:
echo   • Ensure PHP is properly installed and configured
echo   • Check file permissions for web server access
echo   • Verify all PHP files are in the correct directories
echo   • Check browser console for any JavaScript errors
echo   • Review PHP error logs if pages don't load
echo.
echo SUPPORT:
echo   • Check the generated PHP files for proper structure
echo   • Review language files for translation accuracy
echo   • Test all navigation and language switching features
echo   • Verify responsive design on different devices
echo.

echo Press any key to exit...
pause >nul
