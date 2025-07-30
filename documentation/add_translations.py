#!/usr/bin/env python3
"""
Script to add comprehensive translation support to all HTML documentation files
This script will add data-i18n attributes to common elements and create page-specific translations
"""

import os
import re
import glob
from pathlib import Path

# Common translation mappings for HTML elements
COMMON_TRANSLATIONS = {
    # Headers and titles
    r'<h1[^>]*>([^<]+)</h1>': r'<h1 data-i18n="page_title">\1</h1>',
    r'<h2[^>]*>Requirements</h2>': r'<h2 data-i18n="requirements">Requirements</h2>',
    r'<h2[^>]*>Installation</h2>': r'<h2 data-i18n="installation">Installation</h2>',
    r'<h2[^>]*>Configuration</h2>': r'<h2 data-i18n="configuration">Configuration</h2>',
    r'<h2[^>]*>Overview</h2>': r'<h2 data-i18n="overview">Overview</h2>',
    r'<h2[^>]*>Settings</h2>': r'<h2 data-i18n="settings">Settings</h2>',
    r'<h2[^>]*>Templates</h2>': r'<h2 data-i18n="templates">Templates</h2>',
    r'<h2[^>]*>Devices</h2>': r'<h2 data-i18n="devices">Devices</h2>',
    r'<h2[^>]*>Graphs</h2>': r'<h2 data-i18n="graphs">Graphs</h2>',
    r'<h2[^>]*>Data Sources</h2>': r'<h2 data-i18n="data_sources">Data Sources</h2>',
    
    # Navigation links
    r'<a href="[^"]*">Requirements</a>': r'<a href="Requirements.html" data-i18n="requirements">Requirements</a>',
    r'<a href="[^"]*">Installation</a>': r'<a href="#" data-i18n="installation">Installation</a>',
    r'<a href="[^"]*">Configuration</a>': r'<a href="#" data-i18n="configuration">Configuration</a>',
    r'<a href="[^"]*">Overview</a>': r'<a href="#" data-i18n="overview">Overview</a>',
    r'<a href="[^"]*">Settings</a>': r'<a href="#" data-i18n="settings">Settings</a>',
    
    # Common phrases
    r'>Table of Contents<': r' data-i18n="table_of_contents">Table of Contents<',
    r'>Known Issues<': r' data-i18n="known_issues">Known Issues<',
    r'>Video Tutorials<': r' data-i18n="video_tutorials">Video Tutorials<',
    r'>Contributing<': r' data-i18n="contributing">Contributing<',
    r'>Development Standards<': r' data-i18n="development_standards">Development Standards<',
}

# Page-specific translations based on filename
PAGE_SPECIFIC_TRANSLATIONS = {
    'Requirements.html': {
        'page_title': 'Requirements',
        'system_requirements': 'System Requirements',
        'software_requirements': 'Software Requirements',
        'hardware_requirements': 'Hardware Requirements',
        'database_requirements': 'Database Requirements',
        'web_server_requirements': 'Web Server Requirements'
    },
    'Installing-Under-Windows.html': {
        'page_title': 'Installing Under Windows',
        'windows_installation': 'Windows Installation',
        'prerequisites': 'Prerequisites',
        'installation_steps': 'Installation Steps',
        'post_installation': 'Post Installation'
    },
    'Installing-Under-Ubuntu-Debian.html': {
        'page_title': 'Installing Under Ubuntu/Debian',
        'ubuntu_installation': 'Ubuntu/Debian Installation',
        'package_installation': 'Package Installation',
        'manual_installation': 'Manual Installation'
    },
    'Devices.html': {
        'page_title': 'Devices',
        'device_management': 'Device Management',
        'adding_devices': 'Adding Devices',
        'device_templates': 'Device Templates',
        'device_monitoring': 'Device Monitoring'
    },
    'Graphs.html': {
        'page_title': 'Graphs',
        'graph_management': 'Graph Management',
        'creating_graphs': 'Creating Graphs',
        'graph_templates': 'Graph Templates',
        'graph_viewing': 'Graph Viewing'
    },
    'Data-Sources.html': {
        'page_title': 'Data Sources',
        'data_source_management': 'Data Source Management',
        'creating_data_sources': 'Creating Data Sources',
        'data_source_templates': 'Data Source Templates'
    },
    'Settings.html': {
        'page_title': 'Settings',
        'general_settings': 'General Settings',
        'system_settings': 'System Settings',
        'performance_settings': 'Performance Settings'
    }
}

def add_translations_to_file(file_path):
    """Add translation attributes to a single HTML file"""
    
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Skip if already has extensive translation support
        if content.count('data-i18n') > 10:
            print(f"Skipping {file_path} - already has extensive translations")
            return
        
        original_content = content
        
        # Apply common translations
        for pattern, replacement in COMMON_TRANSLATIONS.items():
            content = re.sub(pattern, replacement, content, flags=re.IGNORECASE)
        
        # Add page-specific translations
        filename = os.path.basename(file_path)
        if filename in PAGE_SPECIFIC_TRANSLATIONS:
            page_translations = PAGE_SPECIFIC_TRANSLATIONS[filename]
            
            # Add page-specific translation script
            script_content = f'''
<!-- Page-specific translations -->
<script type="text/javascript">
const pageTranslations = {{
    'en': {page_translations},
    'zh-cn': {{
        // Add Chinese translations here
    }},
    'zh-tw': {{
        // Add Traditional Chinese translations here
    }}
}};

// Merge page translations with global translations
Object.keys(pageTranslations).forEach(lang => {{
    if (!translations[lang]) translations[lang] = {{}};
    Object.assign(translations[lang], pageTranslations[lang]);
}});
</script>'''
            
            # Insert before the existing scripts
            if 'js/i18n.js' in content:
                content = content.replace(
                    '<script type="text/javascript" src="js/i18n.js"></script>',
                    script_content + '\n<script type="text/javascript" src="js/i18n.js"></script>'
                )
        
        # Add common elements that might be missed
        content = re.sub(
            r'<p>Copyright \(c\) 2004-2024 The Cacti Group</p>',
            '<p data-i18n="copyright">Copyright (c) 2004-2024 The Cacti Group</p>',
            content
        )
        
        # Only write if content changed
        if content != original_content:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Updated {file_path}")
        else:
            print(f"No changes needed for {file_path}")
            
    except Exception as e:
        print(f"Error processing {file_path}: {e}")

def create_comprehensive_translations():
    """Create comprehensive translation files for all common terms"""
    
    # Extended translations for common documentation terms
    extended_translations = {
        'en': {
            # Page titles
            'requirements_page': 'Cacti - Requirements',
            'installation_page': 'Cacti - Installation',
            'configuration_page': 'Cacti - Configuration',
            'devices_page': 'Cacti - Devices',
            'graphs_page': 'Cacti - Graphs',
            'templates_page': 'Cacti - Templates',
            'settings_page': 'Cacti - Settings',
            
            # Common sections
            'introduction': 'Introduction',
            'getting_started': 'Getting Started',
            'prerequisites': 'Prerequisites',
            'installation_steps': 'Installation Steps',
            'configuration_steps': 'Configuration Steps',
            'troubleshooting': 'Troubleshooting',
            'examples': 'Examples',
            'notes': 'Notes',
            'warnings': 'Warnings',
            'tips': 'Tips',
            
            # Common actions
            'add': 'Add',
            'edit': 'Edit',
            'delete': 'Delete',
            'save': 'Save',
            'cancel': 'Cancel',
            'create': 'Create',
            'update': 'Update',
            'configure': 'Configure',
            'install': 'Install',
            'upgrade': 'Upgrade',
            
            # Common terms
            'name': 'Name',
            'description': 'Description',
            'type': 'Type',
            'status': 'Status',
            'enabled': 'Enabled',
            'disabled': 'Disabled',
            'active': 'Active',
            'inactive': 'Inactive',
            'default': 'Default',
            'custom': 'Custom',
            'automatic': 'Automatic',
            'manual': 'Manual'
        },
        'zh-cn': {
            # Page titles
            'requirements_page': 'Cacti - 系统要求',
            'installation_page': 'Cacti - 安装',
            'configuration_page': 'Cacti - 配置',
            'devices_page': 'Cacti - 设备',
            'graphs_page': 'Cacti - 图形',
            'templates_page': 'Cacti - 模板',
            'settings_page': 'Cacti - 设置',
            
            # Common sections
            'introduction': '介绍',
            'getting_started': '入门指南',
            'prerequisites': '先决条件',
            'installation_steps': '安装步骤',
            'configuration_steps': '配置步骤',
            'troubleshooting': '故障排除',
            'examples': '示例',
            'notes': '注意事项',
            'warnings': '警告',
            'tips': '提示',
            
            # Common actions
            'add': '添加',
            'edit': '编辑',
            'delete': '删除',
            'save': '保存',
            'cancel': '取消',
            'create': '创建',
            'update': '更新',
            'configure': '配置',
            'install': '安装',
            'upgrade': '升级',
            
            # Common terms
            'name': '名称',
            'description': '描述',
            'type': '类型',
            'status': '状态',
            'enabled': '启用',
            'disabled': '禁用',
            'active': '活动',
            'inactive': '非活动',
            'default': '默认',
            'custom': '自定义',
            'automatic': '自动',
            'manual': '手动'
        },
        'zh-tw': {
            # Page titles
            'requirements_page': 'Cacti - 系統要求',
            'installation_page': 'Cacti - 安裝',
            'configuration_page': 'Cacti - 配置',
            'devices_page': 'Cacti - 裝置',
            'graphs_page': 'Cacti - 圖形',
            'templates_page': 'Cacti - 範本',
            'settings_page': 'Cacti - 設定',
            
            # Common sections
            'introduction': '介紹',
            'getting_started': '入門指南',
            'prerequisites': '先決條件',
            'installation_steps': '安裝步驟',
            'configuration_steps': '配置步驟',
            'troubleshooting': '故障排除',
            'examples': '範例',
            'notes': '注意事項',
            'warnings': '警告',
            'tips': '提示',
            
            # Common actions
            'add': '新增',
            'edit': '編輯',
            'delete': '刪除',
            'save': '儲存',
            'cancel': '取消',
            'create': '建立',
            'update': '更新',
            'configure': '配置',
            'install': '安裝',
            'upgrade': '升級',
            
            # Common terms
            'name': '名稱',
            'description': '描述',
            'type': '類型',
            'status': '狀態',
            'enabled': '啟用',
            'disabled': '停用',
            'active': '活動',
            'inactive': '非活動',
            'default': '預設',
            'custom': '自訂',
            'automatic': '自動',
            'manual': '手動'
        }
    }
    
    # Append to existing i18n.js file
    i18n_file = Path(__file__).parent / 'js' / 'i18n.js'
    
    try:
        with open(i18n_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Add extended translations before the closing braces
        for lang in ['en', 'zh-cn', 'zh-tw']:
            lang_section = f"    '{lang}': {{"
            if lang_section in content:
                # Find the end of this language section
                start_pos = content.find(lang_section)
                brace_count = 0
                pos = start_pos + len(lang_section)
                
                while pos < len(content):
                    if content[pos] == '{':
                        brace_count += 1
                    elif content[pos] == '}':
                        if brace_count == 0:
                            # Found the closing brace for this language
                            # Insert new translations before it
                            new_translations = ',\n        '.join([
                                f"'{key}': '{value}'" 
                                for key, value in extended_translations[lang].items()
                            ])
                            content = (content[:pos] + 
                                     ',\n        ' + new_translations + 
                                     '\n    ' + content[pos:])
                            break
                        else:
                            brace_count -= 1
                    pos += 1
        
        with open(i18n_file, 'w', encoding='utf-8') as f:
            f.write(content)
        
        print("Extended translations added to i18n.js")
        
    except Exception as e:
        print(f"Error updating i18n.js: {e}")

def main():
    """Main function to process all HTML files"""
    
    # Get the directory where this script is located
    script_dir = Path(__file__).parent
    
    # Create comprehensive translations first
    create_comprehensive_translations()
    
    # Find all HTML files in the documentation directory
    html_files = glob.glob(str(script_dir / "*.html"))
    
    # Exclude files that are already fully updated
    exclude_files = ['documentation.html', 'test-multilingual.html', 'debug-multilingual.html']
    html_files = [f for f in html_files if not any(ex in f for ex in exclude_files)]
    
    print(f"Found {len(html_files)} HTML files to process")
    
    for html_file in html_files:
        add_translations_to_file(html_file)
    
    print("Translation addition complete!")
    print("\nNext steps:")
    print("1. Review the updated files")
    print("2. Test the language switching functionality")
    print("3. Add more specific translations as needed")

if __name__ == "__main__":
    main()
