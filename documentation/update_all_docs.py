#!/usr/bin/env python3
"""
Script to automatically add multi-language support to all HTML documentation files
"""

import os
import re
import glob
from pathlib import Path

def update_html_file(file_path):
    """Update a single HTML file to add multi-language support"""
    
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Skip if already updated (check for i18n.js)
        if 'js/i18n.js' in content:
            print(f"Skipping {file_path} - already updated")
            return
        
        # Update HTML lang attribute
        content = re.sub(
            r'<html[^>]*lang=""[^>]*xml:lang=""[^>]*>',
            '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">',
            content
        )
        
        # Add data-i18n to copyright
        content = re.sub(
            r'<p>Copyright \(c\) 2004-2024 The Cacti Group</p>',
            '<p data-i18n="copyright">Copyright (c) 2004-2024 The Cacti Group</p>',
            content
        )
        
        # Find the closing </body> tag and add scripts before it
        script_content = '''
<!-- Multi-language Support Scripts -->
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Update page title based on language if needed
    const lang = getCurrentLanguage();
    // Add page-specific translations here if needed
});
</script>
</body>'''
        
        content = re.sub(r'</body>', script_content, content)
        
        # Write the updated content back
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        
        print(f"Updated {file_path}")
        
    except Exception as e:
        print(f"Error updating {file_path}: {e}")

def main():
    """Main function to update all HTML files"""
    
    # Get the directory where this script is located
    script_dir = Path(__file__).parent
    
    # Find all HTML files in the documentation directory
    html_files = glob.glob(str(script_dir / "*.html"))
    
    # Exclude the main documentation.html as it's already updated
    html_files = [f for f in html_files if not f.endswith('documentation.html')]
    
    print(f"Found {len(html_files)} HTML files to update")
    
    for html_file in html_files:
        update_html_file(html_file)
    
    print("Update complete!")
    print("\nNext steps:")
    print("1. Review the updated files")
    print("2. Add specific translations for each page as needed")
    print("3. Test the language switching functionality")

if __name__ == "__main__":
    main()
