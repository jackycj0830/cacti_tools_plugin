// Multi-language support for Cacti Documentation
// Language translations object
const translations = {
    'en': {
        'back': '← Back',
        'main_title': 'Cacti (tm) Documentation',
        'copyright': 'Copyright (c) 2004-2024 The Cacti Group',
        'cacti_desc': 'Cacti is designed to be a complete graphing solution based on the RRDtool\'s framework. Its goal is to make a network administrator\'s job easier by taking care of all the necessary details necessary to create meaningful graphs.',
        'official_website': 'Please see the official Cacti website for information, support, and updates.',
        'core_developers': 'Core Developers - Both active and emeritus',
        'active_developers': 'Active Developers',
        'developers_working': 'Developers working on Cacti, its Architecture, Documentation and Future Releases.',
        'contributors_doc': 'Contributors to Documentation, QA, Packaging, the Forums and our YouTube page.',
        'original_members': 'Members of the original Cacti Group that have since moved on in their careers.',
        'wish_best': 'We continue to wish them the best.',
        'thanks': 'Thanks',
        'thanks_text': 'A very special thanks to Tobi Oetiker, the creator of RRDtool and the very popular MRTG. The users of Cacti - especially anyone who has taken the time to create a bug report, or otherwise help fix a Cacti related problem. Also to anyone who has contributed to supporting Cacti.',
        'license_text': 'Cacti is licensed under the GNU GPL:',
        'gpl_text1': 'This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.',
        'gpl_text2': 'This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.',
        'table_of_contents': 'Table of Contents',
        'cacti_installation': 'Cacti Installation',
        'installation_desc': 'This section contains information on how to install and/or upgrade the Cacti system. It covers requirements, different platforms and the steps needed to get your system working under normal circumstances.',
        'cacti_overview': 'Cacti Overview',
        'overview_desc': 'This section describes Cacti components and their purpose as well as providing examples including on how to create Templates in Cacti.',
        'advanced_operations': 'Advanced Operations',
        'advanced_desc': 'This section covers more advanced material such as using a advanced data collection and replacement variables that can be used within Templates, etc.',
        'plugin_development': 'Plugin Development',
        'plugin_desc': 'This section contains all Plugin development related information. Guidelines, hooks, references, etc. More information can be found on the Cacti Forums.',
        'how_tos': 'How To\'s',
        'howto_desc': 'This section contains how to\'s for several topics.',
        'contributing': 'Contributing',
        'contributing_desc': 'This section contains information on how to contribute to Cacti.',
        'development_standards': 'Development Standards',
        'standards_desc': 'This section contains the relevant information on how to ensure that any contribution is kept to the same standards that are applied for the Cacti Group. It should be noted that non-compliance does not mean automatically exclusion of proposed changes.',
        'known_issues': 'Known Issues',
        'video_tutorials': 'Video Tutorials',
        'video_desc': 'Watch Howto\'s and Tutorials on the Cacti Official YouTube page if you prefer. If you would have any ideas for videos or would like to contribute let us know !',
        'youtube_channel': 'Cacti Official Youtube Channel',
        'template_specific': 'Template Specific Documentation',
        'template_desc': 'This section will be for template specific configuration requirements',

        // Common navigation and UI elements
        'requirements': 'Requirements',
        'general_installing': 'General Installing Instructions',
        'installing_linux': 'Installing Cacti on Linux',
        'installing_centos_lamp': 'Installation Under CentOS 7 - LAMP Stack',
        'installing_centos_lemp': 'Installation Under CentOS 7 - LEMP Stack',
        'installing_ubuntu': 'Installation Under Ubuntu/Debian - LAMP Stack',
        'installing_windows': 'Installing Under Windows',
        'upgrading_linux': 'Upgrading Cacti Under Linux/UNIX',
        'upgrading_windows': 'Upgrading Cacti Under Windows',
        'upgrading_freebsd': 'Upgrading Cacti Under FreeBSD',

        // Overview section
        'overview': 'Overview',
        'navigating_ui': 'Navigating the User Interface',
        'principles_operation': 'Principles of Operation',
        'graph_overview': 'Graph Overview',
        'how_to_graph': 'How to Graph Your Network',
        'viewing_graphs': 'Viewing Graphs',

        // Management section
        'management': 'Management',
        'devices': 'Devices',
        'sites': 'Sites',
        'trees': 'Trees',
        'graphs': 'Graphs',
        'data_sources': 'Data Sources',
        'aggregates': 'Aggregates',

        // Data Collection
        'data_collection': 'Data Collection',
        'data_collectors': 'Data Collectors',
        'spine_collection': 'Spine Data Collection',
        'data_input_methods': 'Data Input Methods',
        'data_queries': 'Data Queries',

        // Templates
        'templates': 'Templates',
        'device_templates': 'Device Templates',
        'graph_templates': 'Graph Templates',
        'data_source_templates': 'Data Source Templates',
        'aggregate_templates': 'Aggregate Templates',
        'color_templates': 'Color Templates',

        // Automation
        'automation': 'Automation',
        'networks': 'Networks',
        'discovered_devices': 'Discovered Devices',
        'device_rules': 'Device Rules',
        'graph_rules': 'Graph Rules',
        'tree_rules': 'Tree Rules',
        'snmp_options': 'SNMP Options',

        // Presets
        'presets': 'Presets',
        'data_profiles': 'Data Profiles',
        'cdefs': 'CDEFs',
        'vdefs': 'VDEFs',
        'colors': 'Colors',
        'gprints': 'GPRINTs',

        // Import/Export
        'import_export': 'Import/Export',
        'import_templates': 'Import Templates',
        'export_templates': 'Export Templates',

        // Settings
        'settings': 'Settings',
        'settings_general': 'General',
        'settings_paths': 'Paths',
        'settings_device_defaults': 'Device Defaults',
        'settings_poller': 'Poller',
        'settings_data': 'Data',
        'settings_visual': 'Visual',
        'settings_performance': 'Performance',
        'settings_spikes': 'Spikes',
        'settings_mail': 'Mail/Reporting/DNS',

        // Authentication
        'auth_settings': 'Settings - Auth',
        'local_auth': 'Local Auth',
        'ldap_auth': 'LDAP Auth',
        'basic_auth': 'Basic Auth',
        'domains_auth': 'Domains Auth',

        // Users and Groups
        'users_groups': 'Configuration - Users, Groups and Domains',
        'users': 'Users',
        'user_groups': 'User Groups',
        'user_domains': 'User Domains',

        // Plugins
        'plugins': 'Configuration - Plugins',

        // Utilities
        'utilities': 'Utilities',
        'system_utilities': 'System Utilities',
        'data_debug': 'Data Debug',
        'external_links': 'External Links',

        // Reporting
        'reporting': 'Reporting',
        'reports_admin': 'Reports Administrative Interface',
        'reports_user': 'Reports User Interface',
        'reports_items': 'Report Items Page',
        'reports_preview': 'Report Preview Page',
        'reports_events': 'Report Events Page',
        'reports_other': 'Other Options for Adding Report Items',

        // Cacti Log
        'cacti_log': 'The Cacti Log',

        // Additional translations
        'list_known_issues': 'List of Known issues',

        // Requirements page
        'requirements_intro': 'Cacti requires that the following software is installed on your system.',
        'web_server_req': 'Web Server that supports PHP e.g. Apache, Nginx, or IIS',
        'build_env_req': 'Build environment when using spine (gcc, automake, autoconf, libtool, help2man)',
        'rrdtool_req': 'RRDtool 1.3 or greater, 1.5+ recommended',
        'php_req': 'PHP 5.4 or greater, 5.5+ recommended',
        'required_modules': 'Required modules:',
        'optional_modules': 'Optional modules:',
        'problematic_software': 'Problematic software and configuration',
        'mysql_req': 'MySQL 5.6 or MariaDB 5.5 or greater',
        'timezone_support': 'Timezone support must be enabled',
        'mycnf_recommendations': 'The following are my.cnf recommendations:',

        // Common UI elements
        'introduction': 'Introduction',
        'getting_started': 'Getting Started',
        'prerequisites': 'Prerequisites',
        'installation_steps': 'Installation Steps',
        'configuration_steps': 'Configuration Steps',
        'troubleshooting': 'Troubleshooting',
        'examples': 'Examples',
        'notes': 'Notes',
        'warnings': 'Warnings',
        'tips': 'Tips'
    },
    'zh-cn': {
        'back': '← 返回',
        'main_title': 'Cacti (tm) 文档',
        'copyright': '版权所有 (c) 2004-2024 Cacti 团队',
        'cacti_desc': 'Cacti 旨在成为基于 RRDtool 框架的完整图形解决方案。其目标是通过处理创建有意义图形所需的所有必要细节，使网络管理员的工作更加轻松。',
        'official_website': '请访问 Cacti 官方网站获取信息、支持和更新。',
        'core_developers': '核心开发者 - 活跃和荣誉成员',
        'active_developers': '活跃开发者',
        'developers_working': '致力于 Cacti 架构、文档和未来版本开发的开发者。',
        'contributors_doc': '文档、质量保证、打包、论坛和 YouTube 页面的贡献者。',
        'original_members': '原 Cacti 团队成员，现已在各自职业生涯中继续发展。',
        'wish_best': '我们继续祝愿他们一切顺利。',
        'thanks': '致谢',
        'thanks_text': '特别感谢 RRDtool 和广受欢迎的 MRTG 的创建者 Tobi Oetiker。感谢 Cacti 的用户 - 特别是那些花时间创建错误报告或以其他方式帮助解决 Cacti 相关问题的用户。同时感谢所有为支持 Cacti 做出贡献的人。',
        'license_text': 'Cacti 采用 GNU GPL 许可证：',
        'gpl_text1': '本程序是自由软件；您可以根据自由软件基金会发布的 GNU 通用公共许可证的条款重新分发和/或修改它；许可证的第 2 版，或（根据您的选择）任何更高版本。',
        'gpl_text2': '分发此程序是希望它有用，但不提供任何保证；甚至不提供适销性或特定用途适用性的暗示保证。有关更多详细信息，请参阅 GNU 通用公共许可证。',
        'table_of_contents': '目录',
        'cacti_installation': 'Cacti 安装',
        'installation_desc': '本节包含有关如何安装和/或升级 Cacti 系统的信息。它涵盖了要求、不同平台以及在正常情况下使系统正常工作所需的步骤。',
        'cacti_overview': 'Cacti 概述',
        'overview_desc': '本节描述 Cacti 组件及其用途，并提供示例，包括如何在 Cacti 中创建模板。',
        'advanced_operations': '高级操作',
        'advanced_desc': '本节涵盖更高级的内容，例如使用高级数据收集和可在模板中使用的替换变量等。',
        'plugin_development': '插件开发',
        'plugin_desc': '本节包含所有插件开发相关信息。指南、钩子、参考等。更多信息可以在 Cacti 论坛上找到。',
        'how_tos': '操作指南',
        'howto_desc': '本节包含多个主题的操作指南。',
        'contributing': '贡献',
        'contributing_desc': '本节包含有关如何为 Cacti 做出贡献的信息。',
        'development_standards': '开发标准',
        'standards_desc': '本节包含相关信息，说明如何确保任何贡献都保持与 Cacti 团队应用的相同标准。需要注意的是，不合规并不意味着自动排除建议的更改。',
        'known_issues': '已知问题',
        'video_tutorials': '视频教程',
        'video_desc': '如果您愿意，可以在 Cacti 官方 YouTube 页面上观看操作指南和教程。如果您有任何视频想法或想要贡献，请告诉我们！',
        'youtube_channel': 'Cacti 官方 YouTube 频道',
        'template_specific': '模板特定文档',
        'template_desc': '本节将用于模板特定配置要求',

        // Common navigation and UI elements
        'requirements': '系统要求',
        'general_installing': '通用安装说明',
        'installing_linux': '在 Linux 上安装 Cacti',
        'installing_centos_lamp': '在 CentOS 7 上安装 - LAMP 堆栈',
        'installing_centos_lemp': '在 CentOS 7 上安装 - LEMP 堆栈',
        'installing_ubuntu': '在 Ubuntu/Debian 上安装 - LAMP 堆栈',
        'installing_windows': '在 Windows 上安装',
        'upgrading_linux': '在 Linux/UNIX 上升级 Cacti',
        'upgrading_windows': '在 Windows 上升级 Cacti',
        'upgrading_freebsd': '在 FreeBSD 上升级 Cacti',

        // Overview section
        'overview': '概述',
        'navigating_ui': '导航用户界面',
        'principles_operation': '操作原理',
        'graph_overview': '图形概述',
        'how_to_graph': '如何绘制网络图形',
        'viewing_graphs': '查看图形',

        // Management section
        'management': '管理',
        'devices': '设备',
        'sites': '站点',
        'trees': '树形结构',
        'graphs': '图形',
        'data_sources': '数据源',
        'aggregates': '聚合',

        // Data Collection
        'data_collection': '数据收集',
        'data_collectors': '数据收集器',
        'spine_collection': 'Spine 数据收集',
        'data_input_methods': '数据输入方法',
        'data_queries': '数据查询',

        // Templates
        'templates': '模板',
        'device_templates': '设备模板',
        'graph_templates': '图形模板',
        'data_source_templates': '数据源模板',
        'aggregate_templates': '聚合模板',
        'color_templates': '颜色模板',

        // Automation
        'automation': '自动化',
        'networks': '网络',
        'discovered_devices': '发现的设备',
        'device_rules': '设备规则',
        'graph_rules': '图形规则',
        'tree_rules': '树形规则',
        'snmp_options': 'SNMP 选项',

        // Presets
        'presets': '预设',
        'data_profiles': '数据配置文件',
        'cdefs': 'CDEF',
        'vdefs': 'VDEF',
        'colors': '颜色',
        'gprints': 'GPRINT',

        // Import/Export
        'import_export': '导入/导出',
        'import_templates': '导入模板',
        'export_templates': '导出模板',

        // Settings
        'settings': '设置',
        'settings_general': '常规',
        'settings_paths': '路径',
        'settings_device_defaults': '设备默认值',
        'settings_poller': '轮询器',
        'settings_data': '数据',
        'settings_visual': '视觉',
        'settings_performance': '性能',
        'settings_spikes': '峰值',
        'settings_mail': '邮件/报告/DNS',

        // Authentication
        'auth_settings': '设置 - 认证',
        'local_auth': '本地认证',
        'ldap_auth': 'LDAP 认证',
        'basic_auth': '基本认证',
        'domains_auth': '域认证',

        // Users and Groups
        'users_groups': '配置 - 用户、组和域',
        'users': '用户',
        'user_groups': '用户组',
        'user_domains': '用户域',

        // Plugins
        'plugins': '配置 - 插件',

        // Utilities
        'utilities': '实用工具',
        'system_utilities': '系统实用工具',
        'data_debug': '数据调试',
        'external_links': '外部链接',

        // Reporting
        'reporting': '报告',
        'reports_admin': '报告管理界面',
        'reports_user': '报告用户界面',
        'reports_items': '报告项目页面',
        'reports_preview': '报告预览页面',
        'reports_events': '报告事件页面',
        'reports_other': '添加报告项目的其他选项',

        // Cacti Log
        'cacti_log': 'Cacti 日志',

        // Additional translations
        'list_known_issues': '已知问题列表',

        // Requirements page
        'requirements_intro': 'Cacti 需要在您的系统上安装以下软件。',
        'web_server_req': '支持 PHP 的 Web 服务器，如 Apache、Nginx 或 IIS',
        'build_env_req': '使用 spine 时的构建环境（gcc、automake、autoconf、libtool、help2man）',
        'rrdtool_req': 'RRDtool 1.3 或更高版本，推荐 1.5+',
        'php_req': 'PHP 5.4 或更高版本，推荐 5.5+',
        'required_modules': '必需模块：',
        'optional_modules': '可选模块：',
        'problematic_software': '有问题的软件和配置',
        'mysql_req': 'MySQL 5.6 或 MariaDB 5.5 或更高版本',
        'timezone_support': '必须启用时区支持',
        'mycnf_recommendations': '以下是 my.cnf 建议：',

        // Common UI elements
        'introduction': '介绍',
        'getting_started': '入门指南',
        'prerequisites': '先决条件',
        'installation_steps': '安装步骤',
        'configuration_steps': '配置步骤',
        'troubleshooting': '故障排除',
        'examples': '示例',
        'notes': '注意事项',
        'warnings': '警告',
        'tips': '提示'
    },
    'zh-tw': {
        'back': '← 返回',
        'main_title': 'Cacti (tm) 文件',
        'copyright': '版權所有 (c) 2004-2024 Cacti 團隊',
        'cacti_desc': 'Cacti 旨在成為基於 RRDtool 框架的完整圖形解決方案。其目標是透過處理創建有意義圖形所需的所有必要細節，使網路管理員的工作更加輕鬆。',
        'official_website': '請造訪 Cacti 官方網站獲取資訊、支援和更新。',
        'core_developers': '核心開發者 - 活躍和榮譽成員',
        'active_developers': '活躍開發者',
        'developers_working': '致力於 Cacti 架構、文件和未來版本開發的開發者。',
        'contributors_doc': '文件、品質保證、打包、論壇和 YouTube 頁面的貢獻者。',
        'original_members': '原 Cacti 團隊成員，現已在各自職業生涯中繼續發展。',
        'wish_best': '我們繼續祝願他們一切順利。',
        'thanks': '致謝',
        'thanks_text': '特別感謝 RRDtool 和廣受歡迎的 MRTG 的創建者 Tobi Oetiker。感謝 Cacti 的使用者 - 特別是那些花時間創建錯誤報告或以其他方式幫助解決 Cacti 相關問題的使用者。同時感謝所有為支援 Cacti 做出貢獻的人。',
        'license_text': 'Cacti 採用 GNU GPL 許可證：',
        'gpl_text1': '本程式是自由軟體；您可以根據自由軟體基金會發布的 GNU 通用公共許可證的條款重新分發和/或修改它；許可證的第 2 版，或（根據您的選擇）任何更高版本。',
        'gpl_text2': '分發此程式是希望它有用，但不提供任何保證；甚至不提供適銷性或特定用途適用性的暗示保證。有關更多詳細資訊，請參閱 GNU 通用公共許可證。',
        'table_of_contents': '目錄',
        'cacti_installation': 'Cacti 安裝',
        'installation_desc': '本節包含有關如何安裝和/或升級 Cacti 系統的資訊。它涵蓋了要求、不同平台以及在正常情況下使系統正常工作所需的步驟。',
        'cacti_overview': 'Cacti 概述',
        'overview_desc': '本節描述 Cacti 組件及其用途，並提供範例，包括如何在 Cacti 中創建範本。',
        'advanced_operations': '進階操作',
        'advanced_desc': '本節涵蓋更進階的內容，例如使用進階資料收集和可在範本中使用的替換變數等。',
        'plugin_development': '外掛開發',
        'plugin_desc': '本節包含所有外掛開發相關資訊。指南、鉤子、參考等。更多資訊可以在 Cacti 論壇上找到。',
        'how_tos': '操作指南',
        'howto_desc': '本節包含多個主題的操作指南。',
        'contributing': '貢獻',
        'contributing_desc': '本節包含有關如何為 Cacti 做出貢獻的資訊。',
        'development_standards': '開發標準',
        'standards_desc': '本節包含相關資訊，說明如何確保任何貢獻都保持與 Cacti 團隊應用的相同標準。需要注意的是，不合規並不意味著自動排除建議的更改。',
        'known_issues': '已知問題',
        'video_tutorials': '影片教學',
        'video_desc': '如果您願意，可以在 Cacti 官方 YouTube 頁面上觀看操作指南和教學。如果您有任何影片想法或想要貢獻，請告訴我們！',
        'youtube_channel': 'Cacti 官方 YouTube 頻道',
        'template_specific': '範本特定文件',
        'template_desc': '本節將用於範本特定配置要求',

        // Common navigation and UI elements
        'requirements': '系統要求',
        'general_installing': '通用安裝說明',
        'installing_linux': '在 Linux 上安裝 Cacti',
        'installing_centos_lamp': '在 CentOS 7 上安裝 - LAMP 堆疊',
        'installing_centos_lemp': '在 CentOS 7 上安裝 - LEMP 堆疊',
        'installing_ubuntu': '在 Ubuntu/Debian 上安裝 - LAMP 堆疊',
        'installing_windows': '在 Windows 上安裝',
        'upgrading_linux': '在 Linux/UNIX 上升級 Cacti',
        'upgrading_windows': '在 Windows 上升級 Cacti',
        'upgrading_freebsd': '在 FreeBSD 上升級 Cacti',

        // Overview section
        'overview': '概述',
        'navigating_ui': '導航使用者介面',
        'principles_operation': '操作原理',
        'graph_overview': '圖形概述',
        'how_to_graph': '如何繪製網路圖形',
        'viewing_graphs': '檢視圖形',

        // Management section
        'management': '管理',
        'devices': '裝置',
        'sites': '站點',
        'trees': '樹狀結構',
        'graphs': '圖形',
        'data_sources': '資料來源',
        'aggregates': '聚合',

        // Data Collection
        'data_collection': '資料收集',
        'data_collectors': '資料收集器',
        'spine_collection': 'Spine 資料收集',
        'data_input_methods': '資料輸入方法',
        'data_queries': '資料查詢',

        // Templates
        'templates': '範本',
        'device_templates': '裝置範本',
        'graph_templates': '圖形範本',
        'data_source_templates': '資料來源範本',
        'aggregate_templates': '聚合範本',
        'color_templates': '顏色範本',

        // Automation
        'automation': '自動化',
        'networks': '網路',
        'discovered_devices': '發現的裝置',
        'device_rules': '裝置規則',
        'graph_rules': '圖形規則',
        'tree_rules': '樹狀規則',
        'snmp_options': 'SNMP 選項',

        // Presets
        'presets': '預設',
        'data_profiles': '資料設定檔',
        'cdefs': 'CDEF',
        'vdefs': 'VDEF',
        'colors': '顏色',
        'gprints': 'GPRINT',

        // Import/Export
        'import_export': '匯入/匯出',
        'import_templates': '匯入範本',
        'export_templates': '匯出範本',

        // Settings
        'settings': '設定',
        'settings_general': '一般',
        'settings_paths': '路徑',
        'settings_device_defaults': '裝置預設值',
        'settings_poller': '輪詢器',
        'settings_data': '資料',
        'settings_visual': '視覺',
        'settings_performance': '效能',
        'settings_spikes': '峰值',
        'settings_mail': '郵件/報告/DNS',

        // Authentication
        'auth_settings': '設定 - 認證',
        'local_auth': '本機認證',
        'ldap_auth': 'LDAP 認證',
        'basic_auth': '基本認證',
        'domains_auth': '網域認證',

        // Users and Groups
        'users_groups': '配置 - 使用者、群組和網域',
        'users': '使用者',
        'user_groups': '使用者群組',
        'user_domains': '使用者網域',

        // Plugins
        'plugins': '配置 - 外掛',

        // Utilities
        'utilities': '實用工具',
        'system_utilities': '系統實用工具',
        'data_debug': '資料除錯',
        'external_links': '外部連結',

        // Reporting
        'reporting': '報告',
        'reports_admin': '報告管理介面',
        'reports_user': '報告使用者介面',
        'reports_items': '報告項目頁面',
        'reports_preview': '報告預覽頁面',
        'reports_events': '報告事件頁面',
        'reports_other': '新增報告項目的其他選項',

        // Cacti Log
        'cacti_log': 'Cacti 日誌',

        // Additional translations
        'list_known_issues': '已知問題清單',

        // Requirements page
        'requirements_intro': 'Cacti 需要在您的系統上安裝以下軟體。',
        'web_server_req': '支援 PHP 的 Web 伺服器，如 Apache、Nginx 或 IIS',
        'build_env_req': '使用 spine 時的建置環境（gcc、automake、autoconf、libtool、help2man）',
        'rrdtool_req': 'RRDtool 1.3 或更高版本，推薦 1.5+',
        'php_req': 'PHP 5.4 或更高版本，推薦 5.5+',
        'required_modules': '必需模組：',
        'optional_modules': '可選模組：',
        'problematic_software': '有問題的軟體和配置',
        'mysql_req': 'MySQL 5.6 或 MariaDB 5.5 或更高版本',
        'timezone_support': '必須啟用時區支援',
        'mycnf_recommendations': '以下是 my.cnf 建議：',

        // Common UI elements
        'introduction': '介紹',
        'getting_started': '入門指南',
        'prerequisites': '先決條件',
        'installation_steps': '安裝步驟',
        'configuration_steps': '配置步驟',
        'troubleshooting': '故障排除',
        'examples': '範例',
        'notes': '注意事項',
        'warnings': '警告',
        'tips': '提示'
    }
};

// Function to load language
function loadLanguage(lang) {
    console.log('Loading language:', lang); // Debug log

    const elements = document.querySelectorAll('[data-i18n]');
    elements.forEach(element => {
        const key = element.getAttribute('data-i18n');
        if (translations[lang] && translations[lang][key]) {
            element.textContent = translations[lang][key];
        }
    });

    // Update HTML lang attribute
    document.documentElement.lang = lang;
    document.documentElement.setAttribute('xml:lang', lang);

    // Update page title if there's a page-specific title translation
    updatePageTitle(lang);

    // Store the language selection
    localStorage.setItem('selectedLanguage', lang);

    console.log('Language loaded successfully:', lang); // Debug log
}

// Function to update page title
function updatePageTitle(lang) {
    // Try to find page-specific title translation
    const titleKeys = ['page_title', 'main_title', 'requirements_title', 'test_title'];

    for (let key of titleKeys) {
        if (translations[lang] && translations[lang][key]) {
            document.title = translations[lang][key];
            break;
        }
    }
}

// Function to get current language
function getCurrentLanguage() {
    return localStorage.getItem('selectedLanguage') || 'en';
}

// Function to set language
function setLanguage(lang) {
    console.log('Setting language to:', lang); // Debug log
    localStorage.setItem('selectedLanguage', lang);
    loadLanguage(lang);

    // Update selector if it exists
    const selector = document.getElementById('languageSelector');
    if (selector) {
        selector.value = lang;
    }

    // Trigger storage event for other tabs/frames (if any)
    window.dispatchEvent(new StorageEvent('storage', {
        key: 'selectedLanguage',
        newValue: lang,
        storageArea: localStorage
    }));
}
