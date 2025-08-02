@echo off
echo 🚀 Creating basic PHP files from HTML files...
echo.

REM List of important HTML files to convert
set files=Settings-Paths.html Settings-Device-Defaults.html Settings-Poller.html Settings-Data.html Settings-Visual.html Settings-Performance.html Settings-Spikes.html Settings-Mail-Reporting-DNS.html Settings-Auth-Local.html Settings-Auth-LDAP.html Settings-Auth-Basic.html Settings-Domains.html User-Management.html User-Group-Management.html User-Domains.html System-Utilities.html Data-Debug.html External-Links.html Reports-Admin.html Reports-User.html Reports-Items.html Reports-Preview.html Reports-Events.html Reports-Other-Options.html Cacti-Log.html Command-Line-Scripts.html PHP-Script-Server.html Boost.html Frequently-Asked-Questions.html Variables.html RRDtool-Specific-Features.html RRDproxy.html Spikekill.html Debugging.html Version-Specific-Release-Notes.html

for %%f in (%files%) do (
    set "htmlfile=%%f"
    set "phpfile=%%~nf.php"
    
    if exist "!htmlfile!" (
        if not exist "!phpfile!" (
            echo Creating !phpfile! from !htmlfile!...
            call :create_php_file "!htmlfile!" "!phpfile!"
        ) else (
            echo ⚠️  !phpfile! already exists, skipping...
        )
    ) else (
        echo ❌ !htmlfile! not found, skipping...
    )
)

echo.
echo ✅ Basic PHP file creation completed!
pause
goto :eof

:create_php_file
set "html_file=%~1"
set "php_file=%~2"
set "title=%~n2"
set "title=%title:-= %"

(
echo ^<?php
echo /**
echo  * Cacti Documentation - %title%
echo  * 
echo  * This page provides comprehensive information about %title% in Cacti
echo  * with multilingual support.
echo  * 
echo  * @package Cacti Documentation
echo  * @version 2.0.0
echo  */
echo.
echo // Include language management system
echo require_once 'includes/language.php';
echo require_once 'includes/page_template.php';
echo.
echo // Generate page header
echo generatePageHeader^('page_title_%title: =_%', '%title: =_%', true^);
echo ?^>
echo.
echo ^<h1 id="%title: =-%-page"^>^<?php _e^('%title: =_%_title'^); ?^>^</h1^>
echo.
echo ^<p^>^<?php _e^('%title: =_%_intro'^); ?^>^</p^>
echo.
echo ^<p^>This page is under construction. Please refer to the original HTML documentation for complete information.^</p^>
echo.
echo ^<hr /^>
echo.
echo ^<p^>Copyright ^(c^) 2004-2024 The Cacti Group^</p^>
echo.
echo ^<?php
echo // Generate page footer
echo generatePageFooter^(^);
echo ?^>
) > "%php_file%"

goto :eof
