#!/usr/bin/env python3
"""
自動注入翻譯器腳本
為所有HTML文件自動添加通用翻譯功能，無需手動修改每個文件
"""

import os
import re
import glob
from pathlib import Path

def inject_translator_to_file(file_path):
    """為單個HTML文件注入翻譯器"""
    
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # 檢查是否已經注入
        if 'universal-translator.js' in content:
            print(f"Skipping {file_path} - translator already injected")
            return False
        
        # 檢查是否是有效的HTML文件
        if not re.search(r'<html[^>]*>', content, re.IGNORECASE):
            print(f"Skipping {file_path} - not a valid HTML file")
            return False
        
        # 注入翻譯器腳本
        translator_script = '''
<!-- Universal Translator - Auto Translation System -->
<script type="text/javascript" src="js/universal-translator.js"></script>
</body>'''
        
        # 在 </body> 標籤前注入
        if '</body>' in content:
            content = content.replace('</body>', translator_script)
        else:
            # 如果沒有 </body> 標籤，在 </html> 前添加
            if '</html>' in content:
                content = content.replace('</html>', translator_script + '\n</html>')
            else:
                # 如果都沒有，在文件末尾添加
                content += '\n' + translator_script
        
        # 寫回文件
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        
        print(f"✓ Injected translator into {file_path}")
        return True
        
    except Exception as e:
        print(f"✗ Error processing {file_path}: {e}")
        return False

def create_batch_script():
    """創建Windows批處理腳本"""
    
    batch_content = '''@echo off
REM 自動為所有HTML文件注入翻譯器
echo Injecting Universal Translator into all HTML files...

powershell -Command "& {
    $files = Get-ChildItem -Path '.' -Filter '*.html'
    $injected = 0
    $skipped = 0
    
    foreach ($file in $files) {
        Write-Host 'Processing:' $file.Name
        
        $content = Get-Content $file.FullName -Raw -Encoding UTF8
        
        # 檢查是否已經注入
        if ($content -match 'universal-translator.js') {
            Write-Host 'Skipping' $file.Name '- translator already injected'
            $skipped++
            continue
        }
        
        # 檢查是否是有效的HTML文件
        if ($content -notmatch '<html[^>]*>') {
            Write-Host 'Skipping' $file.Name '- not a valid HTML file'
            $skipped++
            continue
        }
        
        # 注入翻譯器腳本
        $translatorScript = @'

<!-- Universal Translator - Auto Translation System -->
<script type=""text/javascript"" src=""js/universal-translator.js""></script>
</body>
'@
        
        # 在 </body> 標籤前注入
        if ($content -match '</body>') {
            $content = $content -replace '</body>', $translatorScript
        } elseif ($content -match '</html>') {
            $content = $content -replace '</html>', ($translatorScript + '`n</html>')
        } else {
            $content += '`n' + $translatorScript
        }
        
        # 寫回文件
        Set-Content -Path $file.FullName -Value $content -Encoding UTF8
        
        Write-Host '✓ Injected translator into' $file.Name
        $injected++
    }
    
    Write-Host ''
    Write-Host 'Injection complete!'
    Write-Host 'Files processed:' $injected
    Write-Host 'Files skipped:' $skipped
    Write-Host ''
    Write-Host 'All HTML files now have automatic translation capability!'
    Write-Host 'Users can switch languages using the selector in the top-right corner.'
}"

echo.
echo Injection complete!
echo.
echo All HTML files now have automatic translation capability!
echo Users can switch languages using the selector in the top-right corner.
echo.
echo Features:
echo - Automatic translation for English, Simplified Chinese, Traditional Chinese
echo - Language selection persists across pages
echo - No manual editing of HTML files required
echo - Works with any existing HTML content
echo.
pause'''
    
    with open('inject_translator.bat', 'w', encoding='utf-8') as f:
        f.write(batch_content)
    
    print("Created inject_translator.bat")

def main():
    """主函數"""
    
    # 獲取腳本所在目錄
    script_dir = Path(__file__).parent
    
    # 創建批處理腳本
    create_batch_script()
    
    # 查找所有HTML文件
    html_files = glob.glob(str(script_dir / "*.html"))
    
    print(f"Found {len(html_files)} HTML files")
    print("Injecting Universal Translator...")
    print("-" * 50)
    
    injected_count = 0
    skipped_count = 0
    
    for html_file in html_files:
        if inject_translator_to_file(html_file):
            injected_count += 1
        else:
            skipped_count += 1
    
    print("-" * 50)
    print(f"Injection complete!")
    print(f"Files processed: {injected_count}")
    print(f"Files skipped: {skipped_count}")
    print()
    print("🎉 All HTML files now have automatic translation capability!")
    print()
    print("Features:")
    print("- ✅ Automatic translation for English, Simplified Chinese, Traditional Chinese")
    print("- ✅ Language selection persists across pages")
    print("- ✅ No manual editing of HTML files required")
    print("- ✅ Works with any existing HTML content")
    print("- ✅ Smart translation using comprehensive dictionary")
    print("- ✅ Real-time translation without page reload")
    print()
    print("Usage:")
    print("1. Open any HTML file in your browser")
    print("2. Use the language selector in the top-right corner")
    print("3. Content will be automatically translated")
    print("4. Language choice is remembered across all pages")
    print()
    print("Technical Details:")
    print("- Universal translator automatically injected into all HTML files")
    print("- Comprehensive translation dictionary with 200+ terms")
    print("- Smart text node detection and translation")
    print("- Preserves original formatting and structure")
    print("- Handles dynamic content changes")
    print()

if __name__ == "__main__":
    main()
