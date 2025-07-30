@echo off
REM Manual translation script for key documentation pages
REM This script adds translation attributes to the most important pages

echo Adding translations to key documentation pages...

powershell -Command "& {
    # Define key pages to translate
    $keyPages = @(
        'Requirements.html',
        'General-Installing-Instructions.html',
        'Installing-Under-Windows.html',
        'Installing-Under-Ubuntu-Debian.html',
        'Devices.html',
        'Graphs.html',
        'Data-Sources.html',
        'Templates.html',
        'Settings.html',
        'Navigating-The-User-Interface.html',
        'Graph-Overview.html',
        'How-to-Graph-Your-Network.html'
    )
    
    foreach ($page in $keyPages) {
        if (Test-Path $page) {
            Write-Host 'Processing:' $page
            
            $content = Get-Content $page -Raw -Encoding UTF8
            
            # Skip if already has many translations
            if (($content -split 'data-i18n').Length -gt 10) {
                Write-Host 'Skipping' $page '- already has translations'
                continue
            }
            
            # Add common translation attributes
            $content = $content -replace '<h1([^>]*)>([^<]+)</h1>', '<h1$1 data-i18n=""page_title"">$2</h1>'
            $content = $content -replace '<h2([^>]*)>Requirements</h2>', '<h2$1 data-i18n=""requirements"">Requirements</h2>'
            $content = $content -replace '<h2([^>]*)>Installation</h2>', '<h2$1 data-i18n=""installation"">Installation</h2>'
            $content = $content -replace '<h2([^>]*)>Configuration</h2>', '<h2$1 data-i18n=""configuration"">Configuration</h2>'
            $content = $content -replace '<h2([^>]*)>Overview</h2>', '<h2$1 data-i18n=""overview"">Overview</h2>'
            $content = $content -replace '<h2([^>]*)>Settings</h2>', '<h2$1 data-i18n=""settings"">Settings</h2>'
            $content = $content -replace '<h2([^>]*)>Templates</h2>', '<h2$1 data-i18n=""templates"">Templates</h2>'
            $content = $content -replace '<h2([^>]*)>Devices</h2>', '<h2$1 data-i18n=""devices"">Devices</h2>'
            $content = $content -replace '<h2([^>]*)>Graphs</h2>', '<h2$1 data-i18n=""graphs"">Graphs</h2>'
            $content = $content -replace '<h2([^>]*)>Data Sources</h2>', '<h2$1 data-i18n=""data_sources"">Data Sources</h2>'
            
            # Add navigation translations
            $content = $content -replace '>Table of Contents<', ' data-i18n=""table_of_contents"">Table of Contents<'
            $content = $content -replace '>Introduction<', ' data-i18n=""introduction"">Introduction<'
            $content = $content -replace '>Getting Started<', ' data-i18n=""getting_started"">Getting Started<'
            $content = $content -replace '>Prerequisites<', ' data-i18n=""prerequisites"">Prerequisites<'
            $content = $content -replace '>Installation Steps<', ' data-i18n=""installation_steps"">Installation Steps<'
            $content = $content -replace '>Configuration Steps<', ' data-i18n=""configuration_steps"">Configuration Steps<'
            $content = $content -replace '>Troubleshooting<', ' data-i18n=""troubleshooting"">Troubleshooting<'
            $content = $content -replace '>Examples<', ' data-i18n=""examples"">Examples<'
            $content = $content -replace '>Notes<', ' data-i18n=""notes"">Notes<'
            
            # Add common action translations
            $content = $content -replace '>Add<', ' data-i18n=""add"">Add<'
            $content = $content -replace '>Edit<', ' data-i18n=""edit"">Edit<'
            $content = $content -replace '>Delete<', ' data-i18n=""delete"">Delete<'
            $content = $content -replace '>Save<', ' data-i18n=""save"">Save<'
            $content = $content -replace '>Cancel<', ' data-i18n=""cancel"">Cancel<'
            $content = $content -replace '>Create<', ' data-i18n=""create"">Create<'
            $content = $content -replace '>Update<', ' data-i18n=""update"">Update<'
            
            # Add page-specific translations based on filename
            switch ($page) {
                'Requirements.html' {
                    $content = $content -replace '>System Requirements<', ' data-i18n=""system_requirements"">System Requirements<'
                    $content = $content -replace '>Software Requirements<', ' data-i18n=""software_requirements"">Software Requirements<'
                    $content = $content -replace '>Hardware Requirements<', ' data-i18n=""hardware_requirements"">Hardware Requirements<'
                    $content = $content -replace '>Database Requirements<', ' data-i18n=""database_requirements"">Database Requirements<'
                }
                'Devices.html' {
                    $content = $content -replace '>Device Management<', ' data-i18n=""device_management"">Device Management<'
                    $content = $content -replace '>Adding Devices<', ' data-i18n=""adding_devices"">Adding Devices<'
                    $content = $content -replace '>Device Templates<', ' data-i18n=""device_templates"">Device Templates<'
                    $content = $content -replace '>Device Monitoring<', ' data-i18n=""device_monitoring"">Device Monitoring<'
                }
                'Graphs.html' {
                    $content = $content -replace '>Graph Management<', ' data-i18n=""graph_management"">Graph Management<'
                    $content = $content -replace '>Creating Graphs<', ' data-i18n=""creating_graphs"">Creating Graphs<'
                    $content = $content -replace '>Graph Templates<', ' data-i18n=""graph_templates"">Graph Templates<'
                    $content = $content -replace '>Graph Viewing<', ' data-i18n=""graph_viewing"">Graph Viewing<'
                }
                'Settings.html' {
                    $content = $content -replace '>General Settings<', ' data-i18n=""general_settings"">General Settings<'
                    $content = $content -replace '>System Settings<', ' data-i18n=""system_settings"">System Settings<'
                    $content = $content -replace '>Performance Settings<', ' data-i18n=""performance_settings"">Performance Settings<'
                }
            }
            
            # Ensure copyright is translated
            $content = $content -replace '<p>Copyright \(c\) 2004-2024 The Cacti Group</p>', '<p data-i18n=""copyright"">Copyright (c) 2004-2024 The Cacti Group</p>'
            
            # Write back to file
            Set-Content -Path $page -Value $content -Encoding UTF8
            
            Write-Host 'Updated:' $page
        } else {
            Write-Host 'File not found:' $page
        }
    }
    
    Write-Host 'Key page translation complete!'
}"

echo.
echo Key page translation complete!
echo.
echo The following pages have been updated with translation attributes:
echo - Requirements.html
echo - General-Installing-Instructions.html  
echo - Installing-Under-Windows.html
echo - Installing-Under-Ubuntu-Debian.html
echo - Devices.html
echo - Graphs.html
echo - Data-Sources.html
echo - Templates.html
echo - Settings.html
echo - Navigating-The-User-Interface.html
echo - Graph-Overview.html
echo - How-to-Graph-Your-Network.html
echo.
echo Next steps:
echo 1. Test the language switching on these key pages
echo 2. Add more specific translations to js/i18n.js as needed
echo 3. Run the full update script for remaining pages
echo.
pause
