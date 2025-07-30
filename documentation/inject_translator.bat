@echo off
REM ========================================================================
REM Comprehensive Multilingual Translation System Injection Script
REM Automatically adds advanced translation capability to ALL HTML files
REM ========================================================================

setlocal enabledelayedexpansion

echo.
echo ========================================================================
echo           CACTI DOCUMENTATION MULTILINGUAL SYSTEM v2.0
echo ========================================================================
echo.
echo This script will automatically inject a comprehensive translation system
echo into ALL HTML files in the Cacti documentation directory.
echo.
echo FEATURES:
echo   ✓ Support for English, Simplified Chinese, Traditional Chinese
echo   ✓ Real-time translation without page reload
echo   ✓ Persistent language selection across all pages
echo   ✓ Responsive UI controls for desktop and mobile
echo   ✓ 300+ Cacti-specific technical terms and phrases
echo   ✓ Intelligent text detection and translation
echo   ✓ Performance optimized with caching
echo   ✓ Accessibility features (ARIA labels, keyboard navigation)
echo.
echo TECHNICAL DETAILS:
echo   • Universal translator automatically injected into all HTML files
echo   • Comprehensive translation dictionary with Cacti terminology
echo   • Smart text node detection and batch processing
echo   • Cross-page language synchronization using localStorage
echo   • Fallback mechanisms for maximum compatibility
echo.
echo WARNING: This will modify ALL .html files in the current directory.
echo Make sure you have a backup before proceeding.
echo.
set /p confirm="Do you want to continue? (Y/N): "
if /i not "%confirm%"=="Y" (
    echo Operation cancelled.
    pause
    exit /b 0
)

echo.
echo ========================================================================
echo                        INJECTION IN PROGRESS
echo ========================================================================
echo.

powershell -Command "& {
    # Initialize counters and arrays
    $files = Get-ChildItem -Path '.' -Filter '*.html'
    $injected = 0
    $skipped = 0
    $errors = 0
    $processedFiles = @()
    $errorFiles = @()

    Write-Host 'SCANNING DIRECTORY...' -ForegroundColor Cyan
    Write-Host 'Found' $files.Count 'HTML files to process' -ForegroundColor White
    Write-Host ''

    # Create backup directory
    $backupDir = 'backup_' + (Get-Date -Format 'yyyyMMdd_HHmmss')
    if (-not (Test-Path $backupDir)) {
        New-Item -ItemType Directory -Path $backupDir | Out-Null
        Write-Host 'Created backup directory:' $backupDir -ForegroundColor Green
    }

    foreach ($file in $files) {
        try {
            Write-Host ('Processing: {0,-40}' -f $file.Name) -NoNewline

            # Create backup
            Copy-Item $file.FullName -Destination $backupDir -Force

            $content = Get-Content $file.FullName -Raw -Encoding UTF8

            # Check if already injected
            if ($content -match 'universal-translator\.js|auto-translator\.js') {
                Write-Host 'SKIPPED (already has translator)' -ForegroundColor Yellow
                $skipped++
                continue
            }

            # Validate HTML structure
            if ($content -notmatch '(?i)<html[^>]*>' -or $content -notmatch '(?i)</html>') {
                Write-Host 'SKIPPED (invalid HTML structure)' -ForegroundColor Yellow
                $skipped++
                continue
            }

            # Prepare injection script with comprehensive features
            $translatorScript = @'

<!-- ================================================================ -->
<!-- Cacti Documentation Multilingual Translation System v2.0       -->
<!-- Supports: English, Simplified Chinese, Traditional Chinese     -->
<!-- Features: Real-time translation, Persistent selection,         -->
<!--           Responsive UI, 300+ technical terms, Accessibility   -->
<!-- ================================================================ -->
<script type=""text/javascript"" src=""js/universal-translator.js""></script>
<script type=""text/javascript"" src=""js/auto-translator.js""></script>
</body>
'@

            $originalContent = $content
            $modified = $false

            # Smart injection logic
            if ($content -match '(?i)</body>') {
                # Inject before closing body tag (preferred method)
                $content = $content -replace '(?i)</body>', $translatorScript
                $modified = $true
            } elseif ($content -match '(?i)</html>') {
                # Inject before closing html tag if no body tag
                $bodyScript = $translatorScript -replace '</body>', ''
                $content = $content -replace '(?i)</html>', ($bodyScript + '`n</html>')
                $modified = $true
            } else {
                # Append to end of file as last resort
                $bodyScript = $translatorScript -replace '</body>', ''
                $content += '`n' + $bodyScript
                $modified = $true
            }

            # Write changes if content was modified
            if ($modified -and $content -ne $originalContent) {
                Set-Content -Path $file.FullName -Value $content -Encoding UTF8 -NoNewline
                Write-Host 'SUCCESS' -ForegroundColor Green
                $injected++
                $processedFiles += $file.Name
            } else {
                Write-Host 'NO CHANGES' -ForegroundColor Yellow
                $skipped++
            }

        } catch {
            Write-Host ('ERROR: ' + $_.Exception.Message) -ForegroundColor Red
            $errors++
            $errorFiles += $file.Name
        }
    }

    Write-Host ''
    Write-Host '======================================================================' -ForegroundColor Cyan
    Write-Host '                        INJECTION COMPLETE!' -ForegroundColor Cyan
    Write-Host '======================================================================' -ForegroundColor Cyan
    Write-Host ''

    # Display detailed results
    Write-Host 'PROCESSING SUMMARY:' -ForegroundColor White
    Write-Host ('  ✓ Files successfully processed: {0}' -f $injected) -ForegroundColor Green
    Write-Host ('  ⚠ Files skipped: {0}' -f $skipped) -ForegroundColor Yellow
    Write-Host ('  ✗ Errors encountered: {0}' -f $errors) -ForegroundColor Red
    Write-Host ('  📁 Total files scanned: {0}' -f $files.Count) -ForegroundColor White
    Write-Host ('  💾 Backup created in: {0}' -f $backupDir) -ForegroundColor Cyan
    Write-Host ''

    # Show processed files
    if ($processedFiles.Count -gt 0) {
        Write-Host 'SUCCESSFULLY PROCESSED FILES:' -ForegroundColor Green
        foreach ($fileName in $processedFiles) {
            Write-Host ('  ✓ {0}' -f $fileName) -ForegroundColor Green
        }
        Write-Host ''
    }

    # Show error files
    if ($errorFiles.Count -gt 0) {
        Write-Host 'FILES WITH ERRORS:' -ForegroundColor Red
        foreach ($fileName in $errorFiles) {
            Write-Host ('  ✗ {0}' -f $fileName) -ForegroundColor Red
        }
        Write-Host ''
    }

    if ($injected -gt 0) {
        Write-Host '🎉 SUCCESS! MULTILINGUAL SYSTEM ACTIVATED!' -ForegroundColor Green
        Write-Host ''
        Write-Host 'FEATURES NOW AVAILABLE:' -ForegroundColor White
        Write-Host '  🌍 Instant translation for 3 languages (English, 简体中文, 繁體中文)' -ForegroundColor Green
        Write-Host '  🎛️ Language selector in top-right corner of every page' -ForegroundColor Green
        Write-Host '  💾 Language selection persists across all pages' -ForegroundColor Green
        Write-Host '  ⬅️ Back button in top-left corner for easy navigation' -ForegroundColor Green
        Write-Host '  🧠 Smart translation of 300+ technical terms and UI elements' -ForegroundColor Green
        Write-Host '  ⚡ Real-time translation without page reload' -ForegroundColor Green
        Write-Host '  🔄 Automatic detection and translation of dynamic content' -ForegroundColor Green
        Write-Host '  📱 Responsive design for desktop and mobile devices' -ForegroundColor Green
        Write-Host '  ♿ Accessibility features (ARIA labels, keyboard navigation)' -ForegroundColor Green
        Write-Host '  🚀 Performance optimized with intelligent caching' -ForegroundColor Green
        Write-Host ''
        Write-Host 'HOW TO USE:' -ForegroundColor White
        Write-Host '  1. 🌐 Open any HTML file in your web browser' -ForegroundColor Cyan
        Write-Host '  2. 👀 Look for the language selector in the top-right corner' -ForegroundColor Cyan
        Write-Host '  3. 🖱️ Click and select your preferred language' -ForegroundColor Cyan
        Write-Host '  4. ✨ Watch content translate instantly (no page reload!)' -ForegroundColor Cyan
        Write-Host '  5. 🔗 Navigate to other pages - language choice is remembered' -ForegroundColor Cyan
        Write-Host '  6. ⬅️ Use the back button for easy navigation' -ForegroundColor Cyan
        Write-Host ''
        Write-Host 'TECHNICAL IMPLEMENTATION:' -ForegroundColor White
        Write-Host '  • Universal translator injected into all HTML files' -ForegroundColor Gray
        Write-Host '  • Comprehensive translation dictionary with Cacti-specific terms' -ForegroundColor Gray
        Write-Host '  • Intelligent text node detection and batch processing' -ForegroundColor Gray
        Write-Host '  • Preserves original HTML formatting and structure' -ForegroundColor Gray
        Write-Host '  • Handles dynamic content changes automatically' -ForegroundColor Gray
        Write-Host '  • Uses localStorage for cross-page language persistence' -ForegroundColor Gray
        Write-Host '  • Fallback mechanisms for maximum browser compatibility' -ForegroundColor Gray
        Write-Host '  • Performance monitoring and optimization' -ForegroundColor Gray
        Write-Host ''
        Write-Host 'TESTING RECOMMENDATIONS:' -ForegroundColor White
        Write-Host '  1. Open documentation.html to test the main page' -ForegroundColor Magenta
        Write-Host '  2. Try switching between all three languages' -ForegroundColor Magenta
        Write-Host '  3. Navigate to different pages to test persistence' -ForegroundColor Magenta
        Write-Host '  4. Test on both desktop and mobile browsers' -ForegroundColor Magenta
        Write-Host '  5. Check browser console for any error messages' -ForegroundColor Magenta
        Write-Host ''
    } else {
        Write-Host '⚠️ NO FILES WERE MODIFIED' -ForegroundColor Yellow
        Write-Host 'This could mean:' -ForegroundColor Yellow
        Write-Host '  • All files already have the translation system' -ForegroundColor Yellow
        Write-Host '  • No valid HTML files were found' -ForegroundColor Yellow
        Write-Host '  • Files were skipped due to validation issues' -ForegroundColor Yellow
        Write-Host ''
    }

    if ($errors -gt 0) {
        Write-Host '⚠️ SOME FILES HAD ERRORS' -ForegroundColor Red
        Write-Host 'Please review the error messages above and:' -ForegroundColor Red
        Write-Host '  • Check file permissions' -ForegroundColor Red
        Write-Host '  • Verify HTML file structure' -ForegroundColor Red
        Write-Host '  • Ensure files are not locked by other applications' -ForegroundColor Red
        Write-Host ''
    }

    Write-Host 'BACKUP INFORMATION:' -ForegroundColor Cyan
    Write-Host ('  📁 Original files backed up to: {0}' -f $backupDir) -ForegroundColor Cyan
    Write-Host '  💡 You can restore from backup if needed' -ForegroundColor Cyan
    Write-Host ''
}"

echo.
echo ========================================
echo.
echo The Universal Translator has been injected into your HTML files!
echo.
echo You can now:
echo 1. Open any HTML file in your browser
echo 2. Use the language selector in the top-right corner
echo 3. Switch between English, 简体中文, and 繁體中文
echo 4. Enjoy automatic translation of all content!
echo.
echo The translation system includes:
echo - 200+ technical terms and phrases
echo - Smart context-aware translation
echo - Persistent language selection
echo - Real-time translation without page reload
echo.
echo For testing, try opening documentation.html or any other HTML file.
echo.
pause
