@echo off
REM Batch script to update HTML files with multi-language support
REM This script uses PowerShell to perform the updates

echo Updating HTML files with multi-language support...

powershell -Command "& {
    $files = Get-ChildItem -Path '.' -Filter '*.html' | Where-Object { $_.Name -ne 'documentation.html' -and $_.Name -ne 'Requirements.html' -and $_.Name -ne 'Table-of-Contents.html' }
    
    foreach ($file in $files) {
        Write-Host 'Processing:' $file.Name
        
        $content = Get-Content $file.FullName -Raw -Encoding UTF8
        
        # Skip if already updated
        if ($content -match 'js/i18n.js') {
            Write-Host 'Skipping' $file.Name '- already updated'
            continue
        }
        
        # Update HTML lang attribute
        $content = $content -replace '<html[^>]*lang=""""[^>]*xml:lang=""""[^>]*>', '<html xmlns=""http://www.w3.org/1999/xhtml"" lang=""en"" xml:lang=""en"">'
        
        # Add data-i18n to copyright
        $content = $content -replace '<p>Copyright \(c\) 2004-2024 The Cacti Group</p>', '<p data-i18n=""copyright"">Copyright (c) 2004-2024 The Cacti Group</p>'
        
        # Add scripts before closing body tag
        $scriptContent = @'

<!-- Multi-language Support Scripts -->
<script type=""text/javascript"" src=""js/i18n.js""></script>
<script type=""text/javascript"" src=""js/common.js""></script>
<script type=""text/javascript"">
// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, initializing language system...');
    // Initialize language system (this will load saved language and apply translations)
    initializeLanguage();
    console.log('Page initialization complete');
});

// Global function for language change (called by selector onchange)
function changeLanguage() {
    const selector = document.getElementById('languageSelector');
    if (selector) {
        const selectedLang = selector.value;
        console.log('Language changed to:', selectedLang);
        setLanguage(selectedLang);
    }
}
</script>
</body>
'@
        
        $content = $content -replace '</body>', $scriptContent
        
        # Write back to file
        Set-Content -Path $file.FullName -Value $content -Encoding UTF8
        
        Write-Host 'Updated:' $file.Name
    }
    
    Write-Host 'Update complete!'
}"

echo.
echo Update complete! 
echo.
echo Next steps:
echo 1. Review the updated files
echo 2. Add specific translations for each page as needed  
echo 3. Test the language switching functionality
echo.
pause
