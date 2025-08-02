<?php
/**
 * Traditional Chinese Language File for Cacti Documentation
 * 
 * This file contains all Traditional Chinese text content for the documentation system.
 * Modify this file to update Traditional Chinese content.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 * @language 繁體中文 (Traditional Chinese)
 */

$lang = array(
    // Page titles
    'page_title_main' => 'Cacti (tm) 文件',
    'page_title_requirements' => 'Cacti - 系統要求',
    'page_title_installation' => 'Cacti - 安裝',
    'page_title_configuration' => 'Cacti - 配置',
    'page_title_toc' => 'Cacti - 目錄',
    
    // Navigation
    'language_selector_label' => '語言',
    'back_button' => '← 返回',
    'home' => '首頁',
    'documentation' => '文件',
    'table_of_contents' => '目錄',
    
    // Main page content
    'main_title' => 'Cacti (tm) 文件',
    'main_subtitle' => 'Cacti 網路監控完整指南',
    'welcome_message' => '歡迎使用 Cacti 文件。本文件將幫助您安裝、配置和使用 Cacti 來監控您的網路基礎設施。',
    
    // Documentation sections
    'section_installation' => 'Cacti 安裝',
    'section_installation_desc' => '本節包含有關如何安裝和/或升級 Cacti 系統的資訊。它涵蓋了要求、不同平台以及在正常情況下使系統正常工作所需的步驟。',
    
    'section_overview' => 'Cacti 概述',
    'section_overview_desc' => '本節描述 Cacti 元件及其用途，並提供範例，包括如何在 Cacti 中建立<strong>範本</strong>。',
    
    'section_advanced' => '進階操作',
    'section_advanced_desc' => '本節涵蓋更進階的內容，例如使用進階資料收集和可在<strong>範本</strong>中使用的替換變數等。',
    
    'section_plugin_dev' => '外掛開發',
    'section_plugin_dev_desc' => '本節包含所有外掛開發相關資訊。指南、鉤子、參考等。更多資訊可以在 <a href="https://forums.cacti.net/viewforum.php?f=6">Cacti 論壇</a>上找到。',
    
    'section_howtos' => '操作指南',
    'section_howtos_desc' => '本節包含多個主題的操作指南。',
    
    'section_contributing' => '貢獻',
    'section_contributing_desc' => '本節包含有關如何為 Cacti 做出貢獻的資訊。',
    
    'section_standards' => '開發標準',
    'section_standards_desc' => '本節包含相關資訊，說明如何確保任何貢獻都保持與 Cacti 團隊應用的相同標準。應該注意的是，不合規並不意味著自動排除建議的更改。',
    
    // Installation subsections
    'known_issues' => '已知問題',
    'known_issues_link' => '已知問題清單',
    'requirements' => '系統要求',
    'general_installing' => '通用安裝說明',
    'installing_linux' => '在 Linux 上安裝 Cacti',
    'installing_centos_lamp' => '在 CentOS 7 上安裝 - LAMP 堆疊',
    'installing_centos_lemp' => '在 CentOS 7 上安裝 - LEMP 堆疊',
    'installing_ubuntu' => '在 Ubuntu/Debian 上安裝 - LAMP 堆疊',
    'installing_windows' => '在 Windows 上安裝',
    'upgrading_linux' => '在 Linux/UNIX 上升級 Cacti',
    'upgrading_windows' => '在 Windows 上升級 Cacti',
    'upgrading_freebsd' => '在 FreeBSD 上升級 Cacti',
    
    // Overview subsections
    'overview' => '概述',
    'navigating_ui' => '導航使用者介面',
    'principles_operation' => '操作原理',
    'graph_overview' => '圖形概述',
    'how_to_graph' => '如何繪製網路圖形',
    'viewing_graphs' => '檢視圖形',
    
    // Management
    'management' => '管理',
    'devices' => '裝置',
    'sites' => '站點',
    'trees' => '樹狀結構',
    'graphs' => '圖形',
    'data_sources' => '資料來源',
    'aggregates' => '聚合',
    
    // Data Collection
    'data_collection' => '資料收集',
    'data_collectors' => '資料收集器',
    'spine_collection' => 'Spine 資料收集',
    'data_input_methods' => '資料輸入方法',
    'data_queries' => '資料查詢',
    
    // Templates
    'templates' => '範本',
    'device_templates' => '裝置範本',
    'graph_templates' => '圖形範本',
    'data_source_templates' => '資料來源範本',
    'aggregate_templates' => '聚合範本',
    'color_templates' => '顏色範本',
    
    // Automation
    'automation' => '自動化',
    'networks' => '網路',
    'discovered_devices' => '發現的裝置',
    'device_rules' => '裝置規則',
    'graph_rules' => '圖形規則',
    'tree_rules' => '樹狀規則',
    'snmp_options' => 'SNMP 選項',
    
    // Presets
    'presets' => '預設',
    'data_profiles' => '資料設定檔',
    'cdefs' => 'CDEF',
    'vdefs' => 'VDEF',
    'colors' => '顏色',
    'gprints' => 'GPRINT',
    
    // Import/Export
    'import_export' => '匯入/匯出',
    'import_templates' => '匯入範本',
    'export_templates' => '匯出範本',
    
    // Settings
    'settings' => '設定',
    'settings_general' => '一般',
    'settings_paths' => '路徑',
    'settings_device_defaults' => '裝置預設值',
    'settings_poller' => '輪詢器',
    'settings_data' => '資料',
    'settings_visual' => '視覺',
    'settings_performance' => '效能',
    'settings_spikes' => '峰值',
    'settings_mail' => '郵件/報告/DNS',
    
    // Authentication
    'auth_settings' => '設定 - 認證',
    'local_auth' => '本機認證',
    'ldap_auth' => 'LDAP 認證',
    'basic_auth' => '基本認證',
    'domains_auth' => '網域認證',
    
    // Users and Groups
    'users_groups' => '配置 - 使用者、群組和網域',
    'users' => '使用者',
    'user_groups' => '使用者群組',
    'user_domains' => '使用者網域',
    
    // Plugins
    'plugins' => '配置 - 外掛',
    
    // Utilities
    'utilities' => '實用工具',
    'system_utilities' => '系統實用工具',
    'data_debug' => '資料除錯',
    'external_links' => '外部連結',
    
    // Reporting
    'reporting' => '報告',
    'reports_admin' => '報告管理介面',
    'reports_user' => '報告使用者介面',
    'reports_items' => '報告項目頁面',
    'reports_preview' => '報告預覽頁面',
    'reports_events' => '報告事件頁面',
    'reports_other' => '新增報告項目的其他選項',
    
    // Cacti Log
    'cacti_log' => 'Cacti 日誌',
    
    // Footer
    'copyright' => '版權所有 (c) 2004-2024 Cacti 團隊',
    
    // Common terms
    'video_tutorials' => '影片教學',
    'template_specific' => '範本特定文件',
    'template_desc' => '本節將用於範本特定配置要求',

    // Requirements page specific
    'requirements_intro' => 'Cacti 需要在您的系統上安裝以下軟體。',
    'web_server_req' => '支援 PHP 的 Web 伺服器，如 Apache、Nginx 或 IIS',
    'build_env_req' => '使用 spine 時的建置環境（gcc、automake、autoconf、libtool、help2man）',
    'rrdtool_req' => 'RRDtool 1.3 或更高版本，推薦 1.5+',
    'php_req' => 'PHP 5.4 或更高版本，推薦 5.5+',
    'required_modules' => '必需模組：',
    'optional_modules' => '可選模組：',
    'mysql_req' => 'MySQL 5.6 或 MariaDB 5.5 或更高版本',
    'timezone_support' => '必須啟用時區支援',
    'mycnf_recommendations' => '以下是 my.cnf 建議：',
    'problematic_software' => '有問題的軟體和配置',
    'browser_requirements' => '瀏覽器要求',
    'browser_requirements_desc' => 'Cacti 已測試可在以下瀏覽器上執行：',
    'network_requirements' => '網路要求',
    'performance_considerations' => '效能考量',
    'performance_desc' => '以下因素影響 Cacti 效能：',
    'cpu_requirements' => 'CPU',
    'cpu_desc' => '大型安裝推薦多核心處理器',
    'memory_requirements' => '記憶體',
    'memory_desc' => '最低 1GB RAM，大型安裝推薦 4GB+',
    'storage_requirements' => '儲存',
    'storage_desc' => 'RRD 檔案推薦快速儲存（SSD）',
    'network_bandwidth' => '網路',
    'network_desc' => 'SNMP 輪詢需要足夠的頻寬',
    'security_considerations' => '安全考量',
    'security_ssl' => '使用 SSL/TLS 存取 Web 介面',
    'security_passwords' => '為所有帳戶使用強密碼',
    'security_updates' => '保持所有軟體元件更新',
    'security_firewall' => '配置防火牆限制存取',
    'security_snmp' => '盡可能使用 SNMPv3 進行裝置監控',

    // Navigating UI page specific
    'page_title_navigating_ui' => 'Cacti - 導航使用者介面',
    'navigating_ui_title' => '導航 Cacti 使用者介面',
    'ui_intro' => 'Cacti 使用者介面在視覺上分為多個面板。每個主要面板都設計用於容納內容。根據您使用的 Cacti 主題，某些面板可能在主題開發者的決定下不可見。常見的面板包括：',
    'top_tabs' => '頂部標籤',
    'top_tabs_desc' => '您在此執行主要導航分離內容',
    'navigation_area' => '導航區域',
    'navigation_area_desc' => '如果頂部標籤導航到的內容有選單，將在此處找到。',
    'breadcrumb_bar' => '麵包屑列',
    'breadcrumb_bar_desc' => '這是您可以看到目前在 Cacti 介面中所指向位置的地方',
    'content_area' => '內容區域',
    'content_area_desc' => '這是您展示表格、圖表、表單等的地方。這是您的主要內容所在的地方',
    'footer' => '頁尾',
    'footer_desc' => '此部分留給主題開發者插入屬於螢幕底部的內容。',
    'default_layout_desc' => '您可以在下面的圖像中看到預設的 Cacti 佈局及其各種面板。您會注意到，在這個現代主題中，主題作者決定省略頁尾。',
    'top_tabs_navigation' => '在 Cacti 中，當您點擊頂部標籤時，預設情況下您將進入 Cacti 的完全不同的部分。Cacti 的頂部標籤設計為模仿瀏覽器標籤，這有助於使用者定位到 Cacti 的各個部分。當您安裝了許多外掛時，如上面的範例所示，您可以清楚地看到這些導航輔助工具的好處。',
    'sub_panels_desc' => '在這些面板中的每一個內部，頁面可以分解為子面板。通常分解為子面板的兩個面板包括導航區域和內容區域。',
    'device_page_example' => '在下面的範例中，我們展示了 Cacti 中的裝置頁面，標出了各種子面板。',
    'content_control' => 'Cacti 的大多數頁面都是以這種方式佈局的。但是，進入 Cacti 內容區域的內容完全由外掛作者控制。',
    'theme_requirements' => '在主題開發者的決定下，所有頁面都應包括頂部標籤和麵包屑列。在麵包屑列或頂部標籤面板內，您應該始終在右側看到使用者設定檔和選單。',
    'understanding_sections' => '要正確使用 Cacti，您應該首先了解這些部分。我們將從描述 Cacti 控制台開始。',
    'core_panels_title' => 'Cacti 核心面板和子面板',
    'top_tabs_detail' => 'Cacti 頂部標籤為 Cacti 提供多個導航區域。預設情況下，Cacti 包括四個頂部標籤。它們是控制台、圖形、日誌和報告。',
    'breadcrumbs' => '麵包屑',
    'breadcrumbs_detail' => '麵包屑直接出現在頂部標籤下方。請注意，某些 Cacti 主題會停用麵包屑。如果需要，您可以點擊麵包屑區域導航到該區域。',
    'cacti_content_area' => 'Cacti 內容區域',
    'content_area_detail' => '這是主頁面內容將顯示的地方。它直接位於麵包屑或某些 Cacti 主題的頂部標籤下方。在外部連結的情況下，它們可以包括外掛作者或 Cacti 管理員所需的任何 HTML。',
    'navigation_menu' => '導航選單',
    'navigation_menu_detail' => '如果您點擊 Cacti 控制台，您將看到一個範例導航選單。除了 Cacti 控制台之外，這些選單可以出現在任何基於外掛的頂部標籤頁面上。',
    'cacti_tables' => 'Cacti 表格',
    'cacti_tables_detail' => '這些表格是在 Cacti 中呈現基於表格的資料的地方。Cacti 表格使用一個神秘但易於使用的 API 呈現。',
    'table_filters' => '表格篩選器',
    'table_filters_detail' => '任何 Cacti 表格都可以包括表格篩選器。這些篩選器可用於限制返回到 Cacti 表格的資料。',
    'actions_dropdown' => '操作下拉選單',
    'actions_dropdown_detail' => '包含 Cacti 表格的任何頁面通常都會包括操作下拉選單。這些操作下拉選單允許您對表格行或多行採取操作。',
    'user_profile_menu' => '使用者設定檔和選單',
    'user_profile_menu_detail' => '這是 Cacti 使用者可以編輯其設定檔、更改密碼、登出或查找其他 Cacti 資訊和支援連結的地方。',
    'non_admin_access' => '非管理使用者，如 Cacti 訪客帳戶，不應有權存取 Cacti 控制台。Cacti 訪客帳戶還不應有權存取其使用者設定檔，因為該帳戶與許多使用者共享。',

    // Graphs Top Tab section
    'graphs_top_tab_title' => 'Cacti 圖形頂部標籤',
    'graphs_top_tab_desc' => 'Cacti 圖形頂部標籤是檢視大多數 Cacti 圖形的地方。預設情況下，Cacti 圖形頂部標籤包括三個不同的檢視。它們包括：',
    'tree_view' => '樹狀檢視',
    'tree_view_desc' => '允許 Cacti 使用者以分層樹的形式檢視圖形。這些樹通常由 Cacti 管理員建構，並在使用者或使用者群組級別進行控制。',
    'preview_view' => '預覽檢視',
    'preview_view_desc' => '預覽檢視提供 Cacti 使用者有權存取的所有圖形的檢視。提供表格篩選器來約束返回到頁面的圖形清單。',
    'list_view' => '清單檢視',
    'list_view_desc' => '清單檢視允許 Cacti 使用者通過允許他們從各種頁面選擇圖形，然後最終從預覽檢視檢視這些頁面來建立自己的預覽頁面。',
    'tree_view_example' => '在下面的範例樹狀檢視頁面中，您可以看到左側的樹導航區域，在 Cacti 內容區域中，您可以看到圖形和用於約束返回的圖形清單的表格篩選器區域。您可以從樹導航區域上方的搜尋區域搜尋樹狀檢視。',

    // Console section
    'console_title' => 'Cacti 控制台',
    'console_intro' => '在下面的圖像中，您可以看到基本的 Cacti 控制台選單區域。它分為單獨的子選單。我們接下來將描述每個的目的。',
    'main_console' => '主控制台',
    'main_console_desc' => '這個子選單選擇相當溫和。它提供了一個開放區域。如果這是主控制台，這個螢幕感覺需要更多內容。幸運的是，外掛開發者已經解決了這個問題。例如，intropage 外掛可以滿足這種需求。',
    'create' => '建立',
    'create_desc' => '此子選單允許您建立裝置和圖形。它們本質上是其他子選單選擇的捷徑。',
    'management' => '管理',
    'management_desc' => '這是所有核心 Cacti 站點、圖形、裝置、樹、資料來源和聚合非範本化物件所在的地方。當您安裝 Cacti 外掛時，您會發現它們擴展了此子選單。',
    'data_collection' => '資料收集',
    'data_collection_desc' => '這是您定義資料收集規則的地方。範例包括：資料收集器、資料輸入方法和資料查詢',
    'templates' => '範本',
    'templates_desc' => '這是您在自動化之外找到 Cacti 各種範本的地方。預設情況下，您將找到圖形、資料來源、裝置、聚合和顏色的範本。',
    'automation' => '自動化',
    'automation_desc' => '此子選單是您找到自動化裝置發現規則以及建立裝置、圖形和樹的規則的地方。',
    'presets' => '預設',
    'presets_desc' => '此區域包含跨越範本邊界且本質上是全域的元物件。它們包括：資料來源設定檔、CDEF、VDEF、GPrint 預設和顏色',
    'import_export' => '匯入匯出',
    'import_export_desc' => '這是您可以匯入和匯出各種 Cacti 範本物件的方式。',
    'configuration' => '配置',
    'configuration_desc' => '這是您管理使用者、使用者群組、使用者網域、全域設定和外掛的地方。',
    'utilities' => '實用工具',
    'utilities_desc' => '這是 Cacti 包含可在 Web 入口網站中使用而無需轉到命令列的常用實用工具的地方。',
    'troubleshooting' => '故障排除',
    'troubleshooting_desc' => '這裡有一些方便的實用工具，可以幫助診斷 Cacti 的常見問題。',
    'objects_explanation' => '所有這些物件類型將在 Cacti 文件的後續部分中解釋。現在，重要的是要知道這些頁面存在。',

    // How to Graph Your Network page specific
    'page_title_how_to_graph' => 'Cacti - 如何繪製您的網路圖形',
    'how_to_graph_title' => '如何繪製您的網路圖形',
    'how_to_graph_intro' => '此時，您可能意識到圖形化是 Cacti 的最大優勢。Cacti 具有許多強大的功能，提供複雜的圖形化和資料採集，其中一些有輕微的學習曲線。但是不要讓這阻止您，因為繪製您的網路圖形非常簡單。',
    'basic_steps_intro' => '接下來的兩個部分將概述通常為大多數**裝置**或**裝置類型**建立**圖形**所需的兩個基本步驟。',
    'automation_note' => '**注意**：下面描述的過程是您建立和管理**裝置**和**圖形**的經典方式。但是，Cacti 現在允許您在控制台的**自動化**部分自動化許多這些任務。該主題在自動化章節中介紹。',

    // Creating a Device section
    'creating_device_title' => '建立裝置',
    'creating_device_intro' => '為您的網路建立**圖形**的第一步是為您想要建立**圖形**的每個網路裝置新增一個**裝置**。**裝置**包含重要的詳細資訊，如網路主機名稱、SNMP 參數和**裝置類型**（又名**裝置範本**）。',
    'device_management_intro' => '要在 Cacti 中管理**裝置**，請點擊裝置選單項目。點擊新增將彈出一個新的裝置表單。前兩個欄位，描述和主機名稱是除了預設值之外唯一需要您輸入的兩個欄位。如果您的主機類型在主機範本下拉選單中定義，請確保在此處選擇它。如果您只是繪製流量圖，您總是可以選擇"通用啟用 SNMP 的主機"，或者如果您不確定，可以選擇"無"。重要的是要記住，您選擇的主機範本不會將您鎖定到任何特定配置，它只會為該類型的主機提供更智慧的預設值。',

    // Device Field Definitions
    'device_field_definitions' => '裝置欄位定義',
    'description_field' => '描述',
    'description_field_desc' => '此描述將顯示在裝置清單的第一列中。您可以在圖形標題中引用它。',
    'hostname_field' => '主機名稱',
    'hostname_field_desc' => 'IP 位址或主機名稱。主機名稱將使用標準主機解析機制解析，例如動態名稱服務（DNS）',
    'host_template_field' => '主機範本',
    'host_template_field_desc' => '主機範本是與此主機相關的圖形範本清單的容器。',
    'notes_field' => '備註',
    'notes_field_desc' => '給定裝置的備註。',
    'disable_host_field' => '停用主機',
    'disable_host_field_desc' => '排除此主機被輪詢。如果裝置不再可用，但應保留作為參考，這特別有價值。',

    // Availability/Reachability Options
    'availability_reachability_options' => '可用性/可達性選項',
    'downed_device_detection' => '宕機裝置檢測',
    'detection_none' => '無',
    'detection_none_desc' => '停用宕機主機檢測',
    'detection_ping_snmp' => 'PING 和 SNMP 正常運行時間',
    'detection_ping_snmp_desc' => 'Ping 然後也檢查 SNMP 正常運行時間',
    'detection_ping_or_snmp' => 'PING 或 SNMP 正常運行時間',
    'detection_ping_or_snmp_desc' => 'Ping，如果成功則繼續，如果不成功則檢查 SNMP 正常運行時間',
    'detection_snmp_uptime' => 'SNMP 正常運行時間',
    'detection_snmp_uptime_desc' => '僅驗證 SNMP 正常運行時間',
    'detection_snmp_desc' => 'SNMP 描述',
    'detection_snmp_desc_desc' => '驗證 SNMP 系統描述',
    'detection_snmp_getnext' => 'SNMP GetNext',
    'detection_snmp_getnext_desc' => '驗證 .1.3 之後的下一個 SNMP OID',
    'detection_ping' => 'PING',
    'detection_ping_desc' => '執行 ping 測試，見下文',

    'ping_method' => 'Ping 方法',
    'ping_method_desc' => '僅適用於 **PING 和 SNMP** 或 **PING**',
    'ping_icmp' => 'ICMP',
    'ping_icmp_desc' => '執行 ICMP 測試。需要權限',
    'ping_udp' => 'UDP',
    'ping_udp_desc' => '執行 UDP 測試',
    'ping_tcp' => 'TCP',
    'ping_tcp_desc' => '執行 TCP 測試',

    'ping_port' => 'Ping 連接埠',
    'ping_port_desc' => '僅適用於 UDP/TCP PING 測試類型。請在此處定義要測試的連接埠。確保沒有防火牆攔截測試 ping。',
    'timeout_value' => '逾時值',
    'timeout_value_desc' => '在此時間後，測試失敗。以毫秒為單位測量。',
    'ping_retry_count' => 'Ping 重試次數',
    'ping_retry_count_desc' => 'Cacti 在失敗之前嘗試 ping 主機的次數。',

    // Viewing Graphs page specific
    'page_title_viewing_graphs' => 'Cacti - 檢視圖形',
    'viewing_graphs_title' => '檢視圖形',

    // Background section
    'background_title' => '背景',
    'background_intro' => 'Cacti 於 2001 年由 Ian Berry 首次發明時，他的願景是使其成為為網路、站點和資料中心營運空間的人員檢視和渲染網路監控**圖形**的最快和最簡單的方式。因此，從一開始它的重點就是渲染一件事，**圖形**。因此，Cacti 系統上的第二個**頂部標籤**是**圖形**標籤。',

    // The Graphs Top Tab section
    'graphs_top_tab_title' => '圖形頂部標籤',
    'graphs_top_tab_intro' => '**圖形****頂部標籤**有幾種個性。它們包括：',
    'tree_view_title' => '樹狀檢視',
    'tree_view_description' => '允許 Cacti 使用者以分層**樹**的形式檢視**圖形**。這些**樹**通常由 Cacti 管理員建構，並在**使用者**或**使用者群組**級別進行控制。',
    'preview_view_title' => '預覽檢視',
    'preview_view_description' => '**預覽檢視**提供 Cacti 使用者有權存取的所有**圖形**的檢視。提供**表格篩選器**來約束返回到頁面的**圖形**清單。',
    'list_view_title' => '清單檢視',
    'list_view_description' => '**清單檢視**允許 Cacti 使用者透過允許他們從各種頁面選擇圖形，然後最終從**預覽檢視**檢視這些頁面來建立自己的**預覽頁面**。',

    'graph_view_personalities' => '這些各種個性在 Cacti 中的顯示方式根據您的主題有所不同。檢視下面的兩個圖像，了解如何導航到各種**圖形檢視**模式。',
    'classic_theme_layout' => '在第一個圖像中，我們看到**圖形檢視**選項向最終使用者顯示的方式。這是經典、現代和深色主題的佈局。',
    'alternate_theme_layout' => '在第二個圖像中，您可以看到**圖形檢視**頁面對於 Paw、Paper-Plane 和 Sunrise 主題的使用者的顯示方式。',

    // Graph Manipulation and Options section
    'graph_manipulation_title' => '圖形操作和選項',
    'graph_manipulation_intro' => '一旦您可以檢視**圖形**，將有一個篩選器面板，為您提供多個選項來限制您對它們的檢視。下面，您可以看到該篩選器面板的圖像。',
    'filter_panel_options' => '從此子面板，您可以執行以下操作：',
    'search_regex' => '按正規表示式搜尋',
    'select_graph_templates' => '選擇一個到多個，或所有**圖形範本**來檢視',
    'graphs_per_page' => '指定每頁圖形數',
    'display_columns' => '指定要顯示的欄數',
    'view_thumbnails_or_full' => '檢視無圖例縮圖或帶圖例的完整圖形',
    'preset_timespans' => '設定各種預設時間跨度，或選擇時間範圍',
    'shift_time' => '按移位時間跨度向前或向後移動時間',

    'save_defaults' => '一旦您從欄、縮圖和每頁圖形設定中獲得您喜歡的篩選器，如果您有正確的權限，您可以按 `儲存` 按鈕，並為您的下次登入儲存這些預設值。',
    'action_icons_intro' => '再次取決於權限，在**圖形**的右側，您將找到許多操作圖示，允許您對**圖形**進行操作',
    'action_icons_example' => '如果您安裝了 **Thold** 和 **QuickTree** **外掛**，下面的圖像顯示了可能的樣子。',
    'action_icons_description' => '從上到下，圖形操作圖示執行以下操作。',

    // Graph Action Icons table
    'action_icon_name_column' => '名稱',
    'action_icon_description_column' => '描述',
    'graph_details_icon' => '圖形詳細資訊',
    'graph_details_desc' => '允許您執行精確縮放、檢視 RRDtool 除錯資訊並執行圖形資料的 CSV 匯出。',
    'csv_export_icon' => 'CSV 匯出',
    'csv_export_desc' => '允許您直接 CSV 匯出圖形資料',
    'realtime_view_icon' => '即時檢視',
    'realtime_view_desc' => '允許您以低至 1 秒粒度檢視圖形，可以就地檢視或在彈出視窗中檢視',
    'spike_kill_icon' => '峰值清除',
    'spike_kill_desc' => '允許您清除圖形中的峰值和間隙',
    'create_threshold_icon' => '建立閾值',
    'create_threshold_desc' => '為圖形建立閾值',
    'add_to_quicktree_icon' => '新增到快速樹',
    'add_to_quicktree_desc' => '允許您透過簡單地在圖形頁面周圍工具來選擇圖形新增到樹中。',

    // Graph Zooming section
    'graph_zooming_title' => '圖形縮放',
    'graph_zooming_intro' => 'Cacti 還內建了強大的圖形縮放介面。您可以透過簡單地在圖形區域右鍵點擊來發現它允許您做什麼。縮放時，您將縮放頁面上的所有**圖形**。它非常強大。',
    'zoom_options_note' => '縮放選單有許多選項。與其在這裡解釋它們，不如自己嘗試一下。',

    // Common graph viewing terms
    'graph_view_modes' => '圖形檢視模式',
    'filter_panel' => '篩選器面板',
    'action_icons' => '操作圖示',
    'zoom_interface' => '縮放介面',
    'context_menu' => '上下文選單',
    'time_range' => '時間範圍',
    'time_span' => '時間跨度',
    'thumbnails' => '縮圖',
    'legends' => '圖例',
    'precision_zooming' => '精確縮放',
    'rrdtool_debug' => 'RRDtool 除錯',
    'graph_data' => '圖形資料',
    'granularity' => '粒度',
    'popup_window' => '彈出視窗',
    'spikes_and_gaps' => '峰值和間隙',
    'threshold' => '閾值',
    'quicktree' => '快速樹',

    // Devices page specific
    'page_title_devices' => 'Cacti - 裝置管理',
    'devices_title' => '裝置管理',
    'devices_intro' => '本節將描述 Cacti 中的**裝置**管理。',
    'devices_adding_methods' => '向 Cacti 新增**裝置**可以透過幾種不同的方式完成，可以透過 Web GUI、Cacti 的自動化或命令列介面 (CLI)。',

    // Web GUI Option section
    'web_gui_option_title' => 'Web GUI 選項',
    'web_gui_intro' => '要透過 Web GUI 新增裝置，首先點擊 `控制台 > 管理 > 裝置`，您將看到下面的裝置控制台視窗，如果有的話，它將顯示現有裝置',
    'add_device_button_desc' => '您現在將選擇右上角的 +',
    'add_device_screen_desc' => '一旦您選擇了 +（也稱為新增裝置按鈕），您將看到下面的畫面，它將要求您提供裝置特定資訊',
    'device_important_info' => '此視窗中需要一些關於裝置的最重要資訊，包括',

    // Device fields
    'device_description_field' => '描述',
    'device_description_desc' => '預設情況下將出現在**圖形**上的名稱',
    'device_ip_hostname_field' => 'IP/主機名稱',
    'device_ip_hostname_desc' => '實際**裝置**的 DNS 或 IP 位址。IPv6 位址插入括號中（例如：[2001:abcd:1234::1]）',
    'device_poller_association_field' => '輪詢器關聯',
    'device_poller_association_desc' => '定義哪個**資料收集器**負責拉取關於**裝置**的資訊',
    'device_template_field' => '裝置範本',
    'device_template_desc' => 'Cisco、Net-SNMP、Linux 等 - 包含所有要繪製圖形的**圖形範本**和**資料查詢**的 Cacti 物件',
    'device_site_location_field' => '站點、位置',
    'device_site_location_desc' => '對於執行元查詢或在 Cacti **圖形樹**上進行站點級圖形組織非常重要',
    'device_availability_field' => '可用性/可達性',
    'device_availability_desc' => '描述**裝置**逾時和可用性方法的設定。',
    'device_snmp_info_field' => 'SNMP 資訊',
    'device_snmp_info_desc' => '連接到**裝置**的 SNMP 憑據',
    'device_notes_field' => '裝置備註',
    'device_notes_desc' => '關於**裝置**的任意非結構化資訊',

    'device_save_and_create_graphs' => 'Cacti 需要這些基本資訊才能監控裝置，輸入後，點擊右下角的儲存。建立裝置後，您需要透過點擊右上角的**為此裝置建立圖形**來為裝置新增圖形。',

    // Availability/Reachability Settings section
    'availability_reachability_settings_title' => '可用性/可達性設定',
    'availability_intro' => 'Cacti 更喜歡使用簡單網路管理協定 (SNMP) 與**裝置**通訊。因此，在建立**裝置**時，您需要提供 SNMP 憑據以獲取關於**裝置**的資訊，以便從中收集資料。在 Cacti 查詢**裝置**資料之前，它首先驗證**裝置**是否正常運行並回應。這樣做時，您有幾個選項。它們包括：',

    // Availability options
    'availability_none' => '無',
    'availability_none_desc' => '始終假設裝置正常運行。這通常保留給沒有狀態的**裝置**物件。',
    'availability_snmp_uptime' => 'SNMP 正常運行時間',
    'availability_snmp_uptime_desc' => '查詢 SNMP 正常運行時間實例 OID',
    'availability_ping_snmp' => 'Ping 和 SNMP 正常運行時間',
    'availability_ping_snmp_desc' => 'Ping 裝置但也檢查 SNMP 正常運行時間實例 OID',
    'availability_ping' => 'Ping',
    'availability_ping_desc' => 'ICMP、連接埠上的 TCP 或連接埠上的 UDP。較新版本有一個額外的方法 TCP Ping 關閉。即使 tcp ping 返回關閉，裝置也被認為是正常的',
    'availability_ping_or_snmp' => 'Ping 或 SNMP 正常運行時間',
    'availability_ping_or_snmp_desc' => '只需要一個工作即可讓 Cacti 收集資料',
    'availability_snmp_desc' => 'SNMP 描述',
    'availability_snmp_desc_desc' => '在 SNMP 正常運行時間 OID 不可用的情況下查詢 SNMP sysDescription',
    'availability_snmp_getnext' => 'SNMP GetNext',
    'availability_snmp_getnext_desc' => '查詢**裝置**的 OID 樹中第一個可用的 OID，用於具有有限 SNMP 支援的某些裝置。',

    // SNMP Credentials section
    'snmp_credentials_title' => 'SNMP 憑據',
    'snmp_credentials_intro' => '在提供 SNMP 憑據時，Cacti 目前支援以下版本：',
    'snmp_v1_title' => '版本 1',
    'snmp_v1_desc' => '很少再使用。保留給非常舊的硬體',
    'snmp_v2_title' => '版本 2',
    'snmp_v2_desc' => '仍然非常流行，支援 64 位元計數器，除了在 Windows 上',
    'snmp_v3_title' => '版本 3',
    'snmp_v3_desc' => '提供支援，但目前有限制。如果您使用 SNMPv3 的進階設定，如 SHA224+ 或 AES192+，您必須解除安裝 php-snmp 模組（如果在 php 中使用），並改用 Net-SNMP 二進位檔案。',
    'snmp_credentials_warning' => '在提供 SNMP 憑據時，如果您根據指定的 SNMP 版本和 SNMP 安全級別提供了不完整的資訊，Cacti 將警告您。',

    // Additional Important Options section
    'additional_important_options_title' => '其他重要選項',
    'additional_options_intro' => '在開始使用 Cacti 之前，您應該注意一些其他選項。它們包括以下內容：',
    'device_threads_option' => '裝置執行緒',
    'device_threads_desc' => '如果您的裝置很遠，並且可以容忍多個執行緒查詢資訊，您可以增加此數字以減少收集所有資訊所需的時間。',
    'max_oids_option' => '每個獲取請求的最大 OID 數',
    'max_oids_desc' => '也稱為 MaxOID，此 SNMP 選項將允許 SNMP 用戶端在每個獲取請求中收集更多指標。請記住，您使此數字越高，SNMP 回應可能需要的時間就越長。因此，隨著數字變大，您必須對 SNMP 逾時敏感。由於預設情況下 SNMP 通常透過 UDP 收集，您還將受到回應數量的限制，這取決於您到達裝置需要穿越多少路由器或 VPN。當穿越 VPN 連接時，許多 VPN 將 MTU 限制在大約 500 位元組，這將顯著限制最大 OID 的大小。在某些情況下，當您的裝置從延遲角度來看很遠，或者您必須穿越 VPN 進行通訊時，最好部署**遠端資料收集器**。',
    'external_id_option' => '外部 ID',
    'external_id_desc' => '此欄位通常用於**裝置**的資產追蹤資訊，但其使用完全取決於系統管理員。',

    // Plugin Behavior section
    'plugin_behavior_title' => '外掛行為',
    'plugin_behavior_intro' => '許多 Cacti 外掛可以並且確實向 Cacti 中的裝置表新增額外的欄。根據您安裝的外掛，您將找到可以提供的關於裝置的其他資訊，包括以下內容：',
    'notification_settings_option' => '通知設定',
    'notification_settings_desc' => '當**裝置**更改狀態時通知誰',
    'criticality_option' => '關鍵性',
    'criticality_desc' => '裝置有多重要',
    'failure_recovery_option' => '故障和恢復計數',
    'failure_recovery_desc' => '裝置被視為真正宕機需要多長時間。',
    'ping_thresholds_option' => 'Ping 閾值',
    'ping_thresholds_desc' => '到達裝置時什麼 RTL 被認為是壞的',

    // CLI section
    'cli_creation_title' => '透過 CLI 腳本建立裝置',
    'cli_creation_intro' => '您還可以使用位於 /cactidir/cli/ 的 CLI 腳本建立裝置',
    'cli_usage_example' => '使用最少資訊新增裝置看起來像這樣',
    'cli_success_message' => '新增測試 (192.168.1.15) 作為 "Cacti 統計" 使用 SNMP v3 與社群 "public"\n成功 - 新裝置 ID：(45)',

    // Common device management terms
    'device_console' => '裝置控制台',
    'add_device_button' => '新增裝置按鈕',
    'create_graphs_for_device' => '為此裝置建立圖形',
    'device_management' => '裝置管理',
    'data_collector' => '資料收集器',
    'remote_data_collector' => '遠端資料收集器',
    'asset_tracking' => '資產追蹤',
    'system_administrator' => '系統管理員',

    // Sites page specific
    'page_title_sites' => 'Cacti - 站點管理',
    'sites_title' => '站點管理',
    'sites_intro' => '本節將描述 Cacti 中的**站點**管理。',
    'sites_purpose' => 'Cacti 中的站點可用於將公司的不同部分與相應的位置裝置分開。例如，您可以有一個名為 **123 主街** 的站點，您可以將實體位置中的所有裝置關聯到 Cacti 站點。這也可以是客戶站點或資料中心位置',
    'sites_page_image_desc' => 'Cacti 站點頁面',
    'sites_attribute_data' => '以下是您可以為站點/位置輸入的一些屬性資料範例',
    'sites_create_instruction' => '為站點輸入適當的資訊，然後點擊右下方的建立',
    'sites_add_image_desc' => 'cacti 新增站點',
    'sites_device_association' => '建立站點後，在手動建立裝置時，您現在可以將裝置關聯到站點',
    'sites_device_site_image_desc' => 'cacti 新增裝置站點',
    'sites_automation_association' => '您還可以透過自動化將發現的裝置關聯到特定站點。',
    'sites_automation_image_desc' => 'cacti 站點自動化',

    // Common site management terms
    'site_management' => '站點管理',
    'physical_location' => '實體位置',
    'customer_site' => '客戶站點',
    'data_center_location' => '資料中心位置',
    'attribute_data' => '屬性資料',
    'device_association' => '裝置關聯',
    'discovered_devices' => '發現的裝置',
    'automation_association' => '自動化關聯',

    // Trees page specific
    'page_title_trees' => 'Cacti - Cacti 樹',
    'trees_title' => 'Cacti 樹',
    'trees_section_title' => '樹',
    'trees_intro' => '**樹**可以被認為是組織圖形的分層方式。每個**樹**由零個或多個分支組成，這些分支包含葉節點，如**圖形**、**裝置**和**站點**。這是組織**圖形**的一種非常強大的方式。',
    'trees_current_setup' => '下面我們可以看到我們在 Cacti 伺服器上設定的當前**樹**。要到達此畫面，請點擊 `控制台 > 管理 > 樹`。',
    'trees_add_remove' => '從此頁面您可以根據需要新增或刪除**樹**。',
    'tree_management_page_desc' => '樹管理頁面',
    'trees_graph_view' => '下面是**樹**在**圖形檢視**中的顯示方式。我們可以看到正在監控的**裝置** - 點擊此**裝置**將導致看到為**裝置**產生的所有**圖形**資料。',
    'tree_view_desc' => '樹檢視',

    // Creating a Tree section
    'creating_tree_title' => '建立樹',
    'creating_tree_intro' => '要建立新樹，只需點擊右上角的新增按鈕 (+) 並為您的**樹**輸入名稱。建立樹後，您將看到下面的頁面，您可以在其中向**樹**新增**裝置**。',
    'tree_options_desc' => '樹選項',
    'tree_device_adding' => '要向新樹新增裝置，只需將可用裝置拖到樹中，它將被新增到樹中。Cacti 目前支援四種 `排序類型`，可以繼承，或留給作者定義繼承和在什麼級別。請參見下面的圖像，了解如何完成樹排序的視覺化表示。',
    'tree_sorting_desc' => '樹排序',

    // Tree Sorting Type Definitions table
    'tree_sorting_table_title' => '表 8-1. 樹排序類型定義',
    'tree_field_column' => '欄位',
    'tree_value_column' => '值',
    'tree_description_column' => '描述',
    'tree_name_field' => '名稱',
    'tree_name_value' => '樹條目的名稱。',
    'tree_name_desc' => '所有樹本身的排序順序是',
    'tree_alphabetical_note' => '始終按字母順序',
    'tree_sorting_type_field' => '排序類型',
    'tree_manual_ordering' => '手動排序（無排序）',
    'tree_manual_ordering_value' => 'Y',
    'tree_manual_ordering_desc' => '您可以隨意更改序列',
    'tree_alphabetical_ordering' => '字母排序',
    'tree_alphabetical_value' => '1, Ab, ab',
    'tree_alphabetical_desc' => '所有子樹都按字母順序排序，',
    'tree_alphabetical_note_desc' => '除非另有說明（您可以在子樹標籤處更改排序選項）',
    'tree_natural_ordering' => '自然排序',
    'tree_natural_value' => 'ab1, ab2, ab7, ab10, ab20',
    'tree_natural_desc' => 'N/A',
    'tree_numeric_ordering' => '數字排序',
    'tree_numeric_value' => '01, 02, 4, 04',
    'tree_numeric_desc' => '數字排序時不考慮前導零',
    'tree_numeric_note' => '數字排序時',

    // Tree management and editing
    'tree_publishing' => '最終使用者將無法檢視**樹**或其圖形，直到您發布它。要編輯**樹**，您需要鎖定它供您使用。鎖定旨在防止多個使用者同時編輯**樹**。',
    'tree_drag_drop' => '當樹被鎖定時，您可以將**站點**、**裝置**和**圖形**拖放到樹選單上。要新增"根分支"，只需按下按鈕即可，一旦您有了根分支，您可以右鍵點擊它們在樹上建立子分支。',
    'tree_site_interaction' => '當您點擊**站點**時，與該**站點**關聯的**裝置**和**圖形**應該出現在它們各自的部分中。您還可以在各個部分上方的搜尋欄位中輸入以深入了解它們。您還可以在部分內的物件上進行 shift-click 和 control-click，以一次拖放多個物件。',
    'tree_unlock_reminder' => '在完成編輯會話之前，不要忘記解鎖您的**樹**。',

    // Common tree management terms
    'tree_management' => '樹管理',
    'hierarchical_organization' => '分層組織',
    'leaf_nodes' => '葉節點',
    'root_branch' => '根分支',
    'sub_branches' => '子分支',
    'sort_types' => '排序類型',
    'manual_ordering' => '手動排序',
    'alphabetical_ordering' => '字母排序',
    'natural_ordering' => '自然排序',
    'numeric_ordering' => '數字排序',
    'tree_locking' => '樹鎖定',
    'tree_publishing' => '樹發布',
    'drag_and_drop' => '拖放',

    // Graphs page specific
    'page_title_graphs' => 'Cacti - 圖形管理',
    'graphs_title' => '圖形管理',
    'graphs_intro' => '本節將描述 Cacti 中的**圖形**管理。',
    'graphs_console_view' => 'Cacti 具有透過控制台檢視每個裝置圖形的功能。這允許管理員檢視附加到特定裝置的圖形。您還可以按圖形類型搜尋。下面我們搜尋與本地 linux 伺服器關聯的圖形',
    'graph_management_image_desc' => '圖形管理',
    'graphs_menu_description' => '點擊清單中的一個圖形會顯示下面的選單。從此選單中，您可以在特定圖形上啟用除錯，還可以更改圖形範本等',
    'graph_management_click_desc' => '圖形管理點擊',

    // Modifying the graph template section
    'modifying_graph_template_title' => '修改圖形範本',
    'modifying_graph_template_desc' => 'Cacti 允許您更改圖形範本的許多方面。您可以更改參數，如圖形的標題以及圖形的大小。這些更改將推送到圖形範本，因此使用該範本的其他裝置也將被更新。',
    'graph_template_options_desc' => '圖形範本選項',

    // Common graph management terms
    'graph_management_console' => '圖形管理控制台',
    'graph_debugging' => '圖形除錯',
    'graph_template_modification' => '圖形範本修改',
    'graph_parameters' => '圖形參數',
    'graph_title' => '圖形標題',
    'graph_size' => '圖形大小',
    'template_updates' => '範本更新',

    // Data Sources page specific
    'page_title_data_sources' => 'Cacti - 資料來源管理',
    'data_sources_title' => '資料來源管理',
    'data_sources_intro' => 'Cacti 中的資料來源是 Cacti 將從裝置收集的資料點。以下是可用於圖形化的不同來源的範例，儘管這只是可實現內容的表面：',
    'data_source_ping_example' => '透過 ping 監控裝置通常算作 1 個資料來源。',
    'data_source_switch_example' => '一個 24 連接埠交換器，您透過 snmp 輪詢裝置並繪製所有連接埠的圖形，那麼將有 24 個資料來源',
    'data_source_note' => '**注意**：如果您新增更多基於原始**資料來源**的圖形，那不會算作另一個**資料來源**，因為它使用已經存在的來源。',
    'data_source_example_explanation' => '例如，如果您有一個 24 連接埠交換器，為每個介面建立一個**輸入/輸出位元**圖形，然後為每個介面新增**帶 95% 百分位的輸入/輸出位元**，您仍然只有 24 個資料來源。',
    'data_source_resource_importance' => '掌握您擁有的資料來源數量很重要，因為資料來源越多，您需要為伺服器分配的資源就越多。',
    'data_source_device_view' => '您可以透過轉到管理然後點擊裝置來檢視與單個裝置關聯的資料來源數量。',
    'device_datasources_image_desc' => '裝置資料來源',
    'data_source_total_view' => '您還可以透過檢查系統上的輪詢器統計資訊來檢視資料來源的總數。點擊日誌標籤並按統計資訊篩選，查找下面的訊息',
    'data_source_stats_example' => '2019/05/24 17:21:11 - 系統統計：時間:9.5913 方法:spine 程序:2 執行緒:2 主機:14 每程序主機:7 資料來源:162 已處理RRD:117',
    'data_source_stats_explanation' => '此輸出告訴我們系統上有 162 個資料來源。',

    // Storage considerations section
    'storage_considerations_title' => '儲存考慮和資料來源',
    'storage_considerations_intro' => '系統上的資料來源數量對您需要的儲存量有影響。您還需要考慮輪詢裝置的速率。例如 1 分鐘或 5 分鐘輪詢',
    'storage_per_datasource' => '以下是您可以期望每個資料來源消耗的大致儲存量',

    // Storage table headers
    'polling_time_column' => '輪詢時間',
    'retention_column' => '保留',
    'file_size_column' => '檔案大小',

    // Storage table data
    'thirty_second' => '30 秒',
    'one_minute' => '1 分鐘',
    'five_minute' => '5 分鐘',
    'daily' => '每日',
    'weekly' => '每週',
    'monthly' => '每月',
    'yearly' => '每年',

    // Common data source terms
    'data_source_management' => '資料來源管理',
    'data_collection_points' => '資料收集點',
    'polling_rate' => '輪詢速率',
    'storage_requirements' => '儲存要求',
    'poller_statistics' => '輪詢器統計',
    'system_resources' => '系統資源',

    // Aggregates page specific
    'page_title_aggregates' => 'Cacti - 聚合圖形',
    'aggregates_title' => '聚合圖形',
    'aggregates_intro' => '本節將描述 Cacti 中的**聚合圖形**。',

    // Common aggregate terms
    'aggregate_graphs' => '聚合圖形',
    'aggregation' => '聚合',
    'graph_aggregation' => '圖形聚合',

    // Data Collectors page specific
    'page_title_data_collectors' => 'Cacti - 資料收集器',
    'data_collectors_title' => '資料收集器',
    'data_collector_background_title' => '資料收集器背景',
    'data_collectors_intro' => 'Cacti 可以支援一個到多個**資料收集器**。有兩種類型的**資料收集器**：',
    'main_data_collector' => '**主資料收集器** - 這本質上是您的核心 Cacti 伺服器和資料庫。**主資料收集器**也被稱為**主伺服器**。',
    'remote_data_collector' => '**遠端資料收集器** - 這些資料收集器位於遠端位置，或者由於防火牆或安全策略而無法存取裝置的地方。**遠端資料收集器**也被稱為**遠端輪詢器**。',
    'remote_collector_design' => '由於 Cacti **遠端資料收集器**的設計，遠端站點的某人實際上可以登入到該**資料收集器**並與其互動，就像他們的**資料收集器**是**主資料收集器**一樣。此外，如果由於某種原因**主資料收集器**變得不可用（例如由於 WAN 中斷），它管理的**裝置**的資料將在本地快取，直到**主資料收集器**再次可達。',
    'collector_normalization' => '一旦**主資料收集器**變得可達，**遠端資料收集器**將把其快取刷新回**主資料收集器**，系統將恢復正常。因此，這通常被認為是更高可用性（HA）的設計。',
    'enterprise_architecture' => '一個好的 Cacti 企業架構將包括三個**主資料收集器**，其 cactid systemd 服務由 keepalived 管理，使用 GlusterFS 作為 Web 伺服器、日誌和 RRD 檔案的完全複製檔案系統，使用 MariaDB Galera 作為完全容錯的資料庫伺服器。',
    'load_balancing' => '然後，使用 keepalived 到負載平衡器，您可以在所有三個**主資料收集器**之間負載平衡連接，使用 MariaDB Galera 資料庫來維護登入會話資料。有許多關於設定和使用 MariaDB Galera 以及來自 Citrix 和其他公司的 HAProxy 或負載平衡器的好文章，以將讀寫流量定向到正確的 Galera 實例伺服器。底線是 Cacti 今天提供了擁有高可用性（HA）設定的機會。',
    'ha_setup_note' => '該 HA 設定不會在本章中涵蓋，但可能會在以後的日期包含。',
    'boost_module_requirement' => '當使用多個**資料收集器**時，Cacti 需要使用 `boost` 模組，該模組現在包含在主 Cacti 套件中。因此，如果您計劃部署多個**資料收集器**，您應該熟悉其使用以及為什麼它對 HA 設計至關重要。',
    'network_requirements' => '為了讓**遠端資料收集器**與**主資料收集器**一起工作，**遠端資料收集器**必須能夠透過 https 和 MySQL 協定以雙向方式與**主資料收集器**通訊。因此，只需要開啟兩個連接埠即可充分利用 Cacti 中的多個**資料收集器**架構。',

    // Data Collector User Interface section
    'data_collector_ui_title' => '資料收集器使用者介面',
    'data_collector_ui_description' => '下面的圖像顯示了當前線上收集器（又名輪詢器）。在此頁面上，我們可以看到當前、平均和最大資料收集時間，使用的**資料收集器**程序和執行緒，**裝置**的數量以及這些**裝置**正在輪詢什麼。操作下拉選單允許您啟用、停用和刪除**遠端資料收集器**。那裡還有一個 `完全同步` 選項。`完全同步` 選項將把關鍵的 Cacti 表複製到選定的**遠端資料收集器**，用於身份驗證、全域設定等。',
    'full_sync_usage' => '在當前的 Cacti 設計中，您不應該經常執行 `完全同步`。它主要用於在中斷後將使用者資料庫和全域設定推送到遠端，如果在該中斷期間有資料庫更改。',
    'data_collectors_image_desc' => '資料收集器',
    'main_collector_description' => '**主資料收集器**駐留在中央 Cacti 伺服器上。它還充當主**資料收集器**，為整個系統執行關鍵維護操作。',
    'main_collector_edit_description' => '在下面的編輯頁面中，您可以看到編輯**主資料收集器**時可用的選項。重要的是使用的主機名稱可以被**遠端資料收集器**解析。',
    'data_collectors_edit_main_desc' => '資料收集器編輯主',
    'remote_collector_edit_description' => '在下面的圖像中編輯**遠端資料收集器**時，您可以看到它與**主資料收集器**共享許多設定，另外還有 `時區` 設定和 MySQL/MariaDB 憑據以及 `測試連接` 按鈕。通常，這些設定僅在 Cacti 的初始設定期間使用，之後僅用於診斷。',
    'data_collectors_edit_remote_desc' => '資料收集器編輯遠端',
    'data_collectors_edit_remote_test_desc' => '資料收集器編輯遠端連接測試',

    // Setup section
    'setup_main_collector_title' => '設定主資料收集器以接受遠端連接',
    'mysql_config_changes' => '我們需要對 MySQL 設定進行一些設定更改，以允許**遠端資料收集器**與**主資料收集器**通訊。',
    'mysql_grant_commands' => 'mysql -u root mysql -e "GRANT ALL ON cacti.* TO cactidb@<遠端輪詢器主機的ip>  IDENTIFIED BY \'password\';"
mysql -u root mysql -e "GRANT SELECT ON mysql.time_zone_name TO cacti@<遠端輪詢器主機的ip> IDENTIFIED BY \'password\';"',
    'remote_config_setup' => '接下來設定位於 `<path_cacti>/include/config.php` 的**遠端資料收集器** config.php，包含遠端資料庫詳細資訊和憑據。通常，您不必作為**遠端資料收集器**直接維護的一部分來執行此操作，**遠端資料收集器**安裝程序將強制您採取這些步驟來完成安裝。但是，這裡提供它作為參考，以便您了解該程序。',
    'remote_config_example' => '#$rdatabase_type     = \'mysql\';
#$rdatabase_default  = \'cacti\';
#$rdatabase_hostname = \'localhost\'; <<< 主伺服器的IP/主機名稱
#$rdatabase_username = \'cactiuser\';
#$rdatabase_password = \'cactiuser\';
#$rdatabase_port     = \'3306\';
#$rdatabase_retries  = 5;
#$rdatabase_ssl      = false;
#$rdatabase_ssl_key  = \'\';
#$rdatabase_ssl_cert = \'\';
#$rdatabase_ssl_ca   = \'\';',
    'remote_install_instruction' => '您現在需要在遠端伺服器上安裝 Cacti，選擇如下所示的**新遠端輪詢器**安裝選項。',
    'remote_setup_image_desc' => '遠端資料收集器設定',

    // Common data collector terms
    'data_collector_management' => '資料收集器管理',
    'main_data_collector_term' => '主資料收集器',
    'remote_data_collector_term' => '遠端資料收集器',
    'primary_server' => '主伺服器',
    'remote_pollers' => '遠端輪詢器',
    'highly_available' => '高可用性',
    'full_sync' => '完全同步',
    'boost_module' => 'Boost 模組',
    'enterprise_architecture' => '企業架構',

    // Spine page specific
    'page_title_spine' => 'Cacti - Spine',
    'spine_title' => 'Spine',
    'spine_intro' => 'Spine 是 `cmd.php` 的快速替代品。它用 C 語言編寫，以確保裝置輪詢的最佳效能，並且是多執行緒的。預期輪詢時間會有數量級的減少。例如，在配備 4 GB RAM 和標準本地磁碟的雙 XEON 系統上，約 20,000 個資料來源的輪詢時間遠少於 60 秒是可以實現的。',
    'spine_warning' => '使用 Spine 時，不要更改 crontab 或 systemd 設定！始終使用 poller.php 與 crontab 或 cactid.php 與 systemd！',
    'spine_activation' => '要啟動 Spine 而不是 cmd.php，請造訪 `控制台 > 設定 > 設定 > 輪詢器` 並選擇 spine 並儲存為 `輪詢器類型`。如果它沒有顯示為可用的 `輪詢器類型`，這意味著它要麼沒有安裝，要麼它的路徑沒有在設定中的 `路徑` 標籤中定義。',
    'spine_testing' => '儲存後，poller.php 將在所有後續輪詢週期中使用 Spine。在進行此更改之前，請確保 Spine 使用以下測試從命令列正常執行：',
    'spine_test_command' => 'cd /usr/local/spine/bin
./spine -R -V 3 -S',
    'spine_output_note' => '您應該收到相當多的輸出，具體取決於系統的大小。要增加執行緒數和並行程序數，您必須在 `控制台 > 資料收集 > 資料收集器` 下編輯資料收集器時修改設定。',
    'spine_performance' => '雖然 Spine 真的很快，但選擇正確的設定將確保使用所有處理器資源。最大並行輪詢器程序的必需設定是可用於 Spine 的 CPU 核心數的 1-2 倍。',
    'spine_mysql_connections' => '使用 spine 時，您必須對 MySQL 或 MariaDB 可用的連接數敏感。在 `控制台 > 實用程式 > 系統實用程式 > 一般` 下，Cacti 將為 MySQL/MariaDB 提供推薦的 `max_connection`。',

    // Spine parameters tables
    'spine_system_params_title' => '表 15-1. 在系統級別維護的 Spine 參數',
    'spine_collector_params_title' => '表 15-2. 在資料收集器級別維護的 Spine 參數',
    'spine_device_params_title' => '表 15-3. 在裝置級別維護的 Spine 參數',
    'spine_param_name' => '名稱',
    'spine_param_description' => '描述',

    // System level parameters
    'spine_script_timeout_name' => '腳本和腳本伺服器逾時值',
    'spine_script_timeout_desc' => 'Spine 等待腳本完成的最長時間，以秒為單位。如果腳本伺服器腳本由於逾時條件而終止，則輸入到 RRD 檔案中的值將為 NaN',

    // Data collector level parameters
    'spine_max_threads_name' => '每個程序的最大執行緒數',
    'spine_max_threads_desc' => '每個程序允許的最大執行緒數。使用 Spine 時使用更高的數字將提高效能。必需設定為 10-15。超過 50 的值通常是不合理的，可能會降低效能而不是提高效能。',
    'spine_script_servers_name' => 'PHP 腳本伺服器數量',
    'spine_script_servers_desc' => '每個 Spine 程序執行的並行腳本伺服器程序數。接受 1 到 10 之間的設定。腳本伺服器將預載入 PHP 環境。然後，腳本伺服器腳本被包含到該環境中，以節省重新載入 PHP 和重新解釋每次呼叫的二進位檔案的開銷。',

    // Device level parameters
    'spine_snmp_oids_name' => '每個 SNMP Get 請求的最大 SNMP OID 數',
    'spine_snmp_oids_desc' => '每個 SNMP 請求發出的最大 SNMP get OID 數。增加此值可提高慢速連結上的輪詢器效能。最大值為 60 個 OID，但該值高度依賴於到遠端裝置的連結的 MTU。在某些情況下，使用**遠端資料收集器**對輪詢遠端**裝置**更有效。此外，某些**裝置類型**不處理大型 SNMP OID get 請求。最好進行實驗，直到找到正確的設定。',
    'spine_device_threads_name' => '裝置執行緒',
    'spine_device_threads_desc' => '用於從**裝置**收集資訊的最大 spine 執行緒數。在**裝置**級別使用此設定時，您必須確保為程序分配了足夠的執行緒，以免阻止從同一 spine 二進位檔案輪詢的其他**裝置**。',

    // Installing Spine section
    'installing_spine_title' => '安裝 Spine',
    'spine_compile_note' => '由於 Spine 是用 C 編寫的，必須在要安裝的本地系統上編譯，下面是在 centos 和 Ubuntu 上編譯的範例',
    'ubuntu_title' => 'Ubuntu',
    'ubuntu_packages' => '安裝所需的系統套件',
    'ubuntu_install_command' => 'apt-get install -y build-essential dos2unix dh-autoreconf libtool help2man libssl-dev libmysql++-dev librrds-perl libsnmp-dev',
    'spine_download_note' => '接下來，下載您要尋找的 spine 版本。通常這應該與您使用的 Cacti 版本匹配。在這種情況下，我們將下載 Spine 的 1.2.3 版本',
    'spine_download_commands' => 'wget <https://github.com/Cacti/spine/archive/release/1.2.3.zip>
unzip 1.2.3
cd spine-release-1.2.3',
    'spine_compile_note2' => '一旦您進入 spine 目錄，就是透過發出以下命令編譯輪詢器的時候了：',
    'spine_compile_commands' => './bootstrap
./configure
make
make install
chown root:root /usr/local/spine/bin/spine
chmod u+s /usr/local/spine/bin/spine',
    'spine_config_note' => '完成後，您需要設定 spine 的設定檔',
    'spine_config_command' => 'vi /usr/local/spine/etc/spine.conf',
    'spine_config_example_note' => '下面是一個設定範例，但您的設定應該與您的 cacti 資料庫使用者名稱和密碼匹配',
    'spine_config_example' => 'DB_Host       localhost
DB_Database   cacti
DB_User       spine
DB_Pass       spine
DB_Port       3306
#DB_UseSSL    0
#RDB_SSL_Key
#RDB_SSL_Cert
#RDB_SSL_CA',
    'centos_title' => 'CentOS',
    'centos_packages' => '安裝所需的系統套件',
    'centos_install_command' => 'yum install -y gcc mysql-devel net-snmp-devel autoconf automake libtool dos2unix help2man',
    'centos_compile_note' => '然後使用以下命令編譯',
    'centos_compile_commands' => './bootstrap
./configure
make
make install
chown root:root /usr/local/spine/bin/spine
chmod u+s /usr/local/spine/bin/spine',

    // Testing/Debugging section
    'testing_debugging_title' => '透過命令列測試/除錯 spine',
    'spine_testing_intro' => 'spine 在命令列提供了幾種不同的方式來測試其功能。以下是您可以透過執行 spine 執行的一些測試範例。',
    'test_without_db_title' => '測試 Spine 而不將結果寫入資料庫',
    'test_without_db_desc' => '此測試允許您執行 spine 並將結果顯示到控制台。透過指定 -R 選項，這不會將任何資料提交到資料庫。',
    'test_specific_host_title' => '為特定主機執行 spine',
    'test_specific_host_desc' => '如果您想為特定主機執行 spine，您可以使用以下命令執行此操作：',
    'spine_debug_gui_title' => '透過 GUI 除錯 Spine',
    'spine_debug_gui_desc' => '您還可以透過日誌檔案檢視 spine 除錯資訊，spine 還允許您提高它在日誌中提供的詳細級別，如果您想除錯特定裝置並檢視 spine 輸出，請點擊啟用裝置除錯。',
    'spine_debug_gui_example' => '下面是透過日誌檔案輸出的 Spine 除錯資訊範例',
    'spine_debug_image_desc' => 'spine',
    'spine_logging_settings' => '要啟用更詳細的 spine 日誌記錄，請轉到 `控制台 > 設定 > 設定 > 輪詢器`',
    'spine_logging_options' => '您可以選擇詳細、摘要或無效資料的無日誌記錄',
    'spine_logging_detailed' => '詳細日誌記錄將類似於 cmd.php，您將獲得每個有問題的資料來源的報告',
    'spine_logging_summary' => '摘要提供每個裝置有多少資料來源有問題的計數',
    'spine_parameters_image_desc' => 'spine',

    // Common errors section
    'spine_errors_title' => '常見的 Spine 相關錯誤',
    'spine_error_config_missing' => '2021/01/08 14:38:44 - SPINE: Poller[1] PID[14838] FATAL: Unable to read configuration file! (Spine init)',
    'spine_error_config_solution' => '確保您在 /usr/local/spine/etc 中有 spine.conf，在首次安裝時 `spine.conf` 可能是 `spine.conf.dist`。',
    'spine_error_setuid' => 'DEBUG Falling back to UDP Ping Due to SetUID Issues',
    'spine_error_setuid_desc' => '這是 spine 的權限問題，確保您已給 spine 適當的權限',
    'spine_error_setuid_solution' => 'chmod u+s /usr/local/spine/bin/spine',

    // Common spine terms
    'spine_data_collection' => 'Spine 資料收集',
    'multi_threaded' => '多執行緒',
    'poller_type' => '輪詢器類型',
    'script_server' => '腳本伺服器',
    'snmp_oids' => 'SNMP OID',
    'device_threads' => '裝置執行緒',
    'spine_collection' => 'Spine 資料收集',

    // Data Input Methods page specific
    'page_title_data_input_methods' => 'Cacti - 資料輸入方法',
    'data_input_methods_title' => '資料輸入方法',
    'data_input_methods_intro' => '資料輸入方法允許 Cacti 根據由**資料範本**及其相應的**資料來源**控制的映射檢索資料以插入到 RRD 檔案中。這些產生的**資料範本**和**資料來源**然後可以用於建立**圖形範本**和**圖形**。',
    'data_input_methods_builtin' => 'Cacti 包含許多內建的**資料輸入方法**，用於**SNMP**資料以及**腳本**、**腳本伺服器**和**SNMP 資料查詢**。',
    'data_input_methods_custom' => '除了內建的**資料輸入方法**之外，Cacti 管理員可以基於**腳本**或 PHP **腳本伺服器**腳本建立幾乎任何**資料輸入方法**。基於**腳本**的**資料輸入方法**允許 Cacti 從幾乎任何地方收集資料，儘管內建的**SNMP**和**腳本伺服器**方法在 Cacti 中提供最大的可擴展性。**資料查詢**和 PHP **腳本伺服器**主題將在文件的後續部分中介紹。',

    // Creating a Data Input Method section
    'creating_data_input_method_title' => '建立資料輸入方法',
    'creating_data_input_method_desc' => '要建立新的**資料輸入方法**，從 Cacti 控制台選擇**資料收集 > 資料輸入方法**。進入該畫面後，點擊右側的加號 (+) 符號，這將允許您新增新的**資料輸入方法**。您將在以下畫面上看到一些需要填入的欄位。',
    'data_input_methods_table_title' => '表 11-1. 欄位描述：資料輸入方法',
    'data_input_methods_name_field' => '名稱',
    'data_input_methods_description_field' => '描述',
    'data_input_methods_name_desc' => '為資料查詢提供一個您將用來識別它的名稱',
    'data_input_methods_input_type_field' => '輸入類型',
    'data_input_methods_input_type_desc' => '選擇您要建立的**資料輸入方法**的類型',
    'data_input_methods_input_string_field' => '輸入字串',
    'data_input_methods_input_string_desc' => '此欄位僅在輸入類型設定為**腳本/命令**時使用',

    'data_input_methods_name_consideration' => '指定的 `名稱` 將在整個 Cacti 中用於識別給予**資料輸入方法**的人類可讀名稱。應該仔細考慮以幫助唯一識別**資料來源**。擁有非常相似的名稱可能會在您的 Cacti 系統增長時使用它們時導致混亂。',
    'data_input_methods_input_types' => '`輸入類型` 的有效選項是**腳本/命令**和**腳本伺服器**。如前所述，Cacti 為 SNMP 資料收集以及基於 SNMP、**腳本**和**腳本伺服器**的**資料查詢**提供內建的**資料輸入方法**。雖然存在於 Cacti 資料庫中，但它們對使用者檢視是隱藏的。',
    'data_input_methods_script_command' => '當類型設定為 `腳本/命令` 時，`輸入字串` 指定腳本的完整路徑，包括任何每個**資料來源**的輸入變數。**資料來源**輸入變數必須用大於號和小於號字元括起來。例如，如果您要將 IP 位址傳遞給腳本，您的輸入字串可能看起來像：`/path/to/script.pl <ip>` 當使用者基於此**資料輸入方法**建立**資料來源**時，他們將被提示輸入 IP 位址以傳遞給腳本。',
    'data_input_methods_after_create' => '當您完成填寫所有必要欄位後，點擊建立按鈕繼續。儲存新的**資料輸入方法**後，您將看到兩個新的部分需要完成。這些部分將指示 Cacti 傳遞給腳本的內容，稱為 `輸入欄位`，也稱為 `輸入參數`，以及如何處理輸出資料，我們稱之為 `輸出欄位`。',
    'data_input_methods_input_fields_desc' => '`輸入欄位` 框用於定義需要使用者資訊或來自 Cacti 資料庫中各種資料（如主機名稱、IP 位址、主機 ID 等）的任何欄位。輸入字串中引用的任何輸入欄位都必須在此處定義。',
    'data_input_methods_output_fields_desc' => '`輸出欄位` 框用於定義您期望從腳本返回的每個欄位，最終將儲存在資料庫和 RRD 檔案中。',
    'data_input_methods_output_requirement' => '*所有**資料輸入方法**必須至少定義一個輸出欄位*，但根據類型可能有多個。',

    // Data Input Fields section
    'data_input_fields_title' => '資料輸入欄位',
    'data_input_fields_desc' => '要定義新欄位，請點擊輸入或輸出欄位框旁邊的加號 (+)。根據您是新增輸入欄位還是輸出欄位，您將看到以下部分或全部欄位。',
    'data_input_fields_table_title' => '表 11-2. 欄位描述：資料輸入欄位',
    'data_input_field_name' => '欄位/欄位名稱',
    'data_input_field_name_desc' => '您將看到來自命令的未使用的大括號輸入欄位的下拉清單',
    'data_input_friendly_name' => '友好名稱',
    'data_input_friendly_name_desc' => '為此欄位輸入更具描述性的名稱',
    'data_input_regex_match' => '正規表示式匹配（僅輸入）',
    'data_input_regex_match_desc' => '輸入有效的正規表示式以修改輸出',
    'data_input_allow_empty' => '允許空輸入（僅輸入）',
    'data_input_allow_empty_desc' => '此欄位的輸入值是否可以為空',
    'data_input_special_type' => '特殊類型代碼（僅輸入）',
    'data_input_special_type_desc' => '從 Cacti 資料庫中提取輸入資料，不提示使用者輸入此輸入值',
    'data_input_update_rrd' => '更新 RRD 檔案（僅輸出）',
    'data_input_update_rrd_desc' => '如果您打算將此輸出資料儲存在 RRD 檔案中，請選取',

    'data_input_field_name_rules' => '`欄位名稱` 不得包含空格或其他非字母數字字元（除了 \'-\' 或 \'_\'）。',
    'data_input_regex_rules' => '如果您想在使用者為此資料輸入欄位的 `正規表示式匹配（僅輸入）` 輸入值時強制執行某種正規表示式模式，它必須遵循 POSIX 語法，因為它將傳遞給 PHP 的 preg() 函數。',
    'data_input_special_type_usage' => '如果資料輸入欄位需要在內部引用另一個欄位，您可以將其輸入到 `特殊類型代碼` 中。例如，如果您的欄位需要使用者的 IP 位址，您可以在此處輸入 \'management_ip\'，Cacti 將使用所選主機的當前 IP 位址填入此欄位。',

    // Special Type Codes table
    'special_type_codes_table_title' => '表 11-3. 特殊類型代碼',
    'special_type_field_name' => '欄位名稱',
    'special_type_hostname' => 'hostname',
    'special_type_hostname_desc' => '主機名稱',
    'special_type_management_ip' => 'management_ip',
    'special_type_management_ip_desc' => 'IP 位址',
    'special_type_snmp_community' => 'snmp_community',
    'special_type_snmp_community_desc' => 'SNMP 團體',
    'special_type_snmp_username' => 'snmp_username',
    'special_type_snmp_username_desc' => 'SNMP 使用者名稱',
    'special_type_snmp_password' => 'snmp_password',
    'special_type_snmp_password_desc' => 'SNMP 版本',

    'data_input_update_rrd_note' => '如果您啟用 `更新 RRD 檔案`，Cacti 將把此欄位的返回值插入到 RRD 檔案中。每個資料輸入來源至少需要為一個輸出欄位選取此框，但可以留空以讓 Cacti 僅將值儲存在資料庫中。',
    'data_input_create_finish' => '當您完成填寫所有必要欄位後，點擊建立按鈕繼續。您將被重新導向回**資料輸入方法**編輯頁面。從這裡您可以繼續新增其他欄位，或在完成時點擊此畫面上的儲存。',

    // Making Your Scripts Work With Cacti section
    'scripts_work_with_cacti_title' => '使您的腳本與 Cacti 配合工作',
    'scripts_work_intro' => '擴展 Cacti 資料收集功能的最簡單方法是透過外部腳本。Cacti 開箱即用地提供了許多腳本，這些腳本位於 `scripts/` 目錄中。這些腳本由 Cacti 新安裝中存在的**資料輸入方法**使用。',
    'scripts_work_create_method' => '要讓 Cacti 呼叫外部腳本來收集資料，您必須建立新的**資料輸入方法**，確保為輸入類型欄位指定腳本/命令。有關如何建立**資料輸入方法**的更多資訊，請參見上一節"建立資料輸入方法"。要使用您的**資料輸入方法**收集資料，Cacti 只需執行輸入字串欄位中指定的 shell 命令。因此，您可以讓 Cacti 執行任何 shell 命令或呼叫幾乎可以用任何語言編寫的任何腳本。',
    'scripts_output_format' => 'Cacti 關心的是腳本的輸出。當您定義**資料輸入方法**時，您需要定義一個或多個輸出欄位。您在此處定義的輸出欄位數量對腳本的輸出很重要。對於只有一個輸出欄位的**資料輸入方法**，您的腳本應該以以下格式輸出其值：',
    'scripts_single_output_format' => '<數值>',
    'scripts_single_output_example' => '因此，如果我編寫了一個輸出正在執行的程序數的腳本，其輸出可能如下所示：',
    'scripts_single_output_value' => '67',
    'scripts_multiple_output_desc' => '具有多個輸出欄位的資料輸入方法在編寫腳本時處理方式略有不同。輸出多個值的腳本應格式化如下：',
    'scripts_multiple_output_format' => '<欄位名_1>:<值_1> <欄位名_2>:<值_2> ... <欄位名_n>:<值_n>',
    'scripts_multiple_output_example' => '如果您編寫了一個輸出 Unix 機器的 1、5 和 10 分鐘負載平均值的腳本，並在 Cacti 中將輸出欄位命名為 \'1min\'、\'5min\' 和 \'10min\'，腳本的輸出應如下所示：',
    'scripts_load_average_example' => '1min:0.40 5min:0.32 10min:0.01',
    'scripts_permissions_note' => '為 Cacti 編寫腳本時要記住的最後一件事是，它們將以資料收集器執行的使用者身份執行。有時腳本在以 root 身份執行時可能正常工作，但在以較低權限使用者身份執行時由於權限問題而失敗。',

    // Walkthrough section
    'walkthrough_title' => '演練',
    'walkthrough_desc' => '您可以在以下範例中找到如何從簡單命令輸出建立完整圖形的詳細範例：如何建立資料輸入方法。',

    // Common data input method terms
    'data_input_method' => '資料輸入方法',
    'input_fields' => '輸入欄位',
    'output_fields' => '輸出欄位',
    'input_parameters' => '輸入參數',
    'script_command' => '腳本/命令',
    'script_server' => '腳本伺服器',
    'special_type_codes' => '特殊類型代碼',
    'regular_expression_match' => '正規表示式匹配',
    'data_input_methods' => '資料輸入方法',

    // Data Queries page specific
    'page_title_data_queries' => 'Cacti - 資料查詢',
    'data_queries_title' => '資料查詢',
    'data_queries_overview_title' => '概述',
    'data_queries_overview_intro' => 'Cacti **資料查詢**不是 Cacti 中**資料輸入方法**的替代品。相反，它們提供了一種簡單的方法來擴展資料輸入方法，以解釋多維物件或基於索引列出資料，使資料更容易繪製圖形。在 Cacti 中**資料查詢**最常見的用途是透過 SNMP 檢索網路介面清單。',
    'data_queries_overview_process' => '如果您想繪製網路介面的流量圖，首先 Cacti 必須檢索主機上的介面清單。其次，Cacti 可以使用該資訊建立必要的**圖形**和**資料來源**。**資料查詢**只關心程序的第一步，即獲取網路介面清單，而不是為它們建立圖形/資料來源。雖然列出網路介面是**資料查詢**的常見用途，但它們也有其他用途，如列出分割區、處理器，甚至路由器中的卡。',
    'data_queries_unique_requirement' => 'Cacti 中任何**資料查詢**的一個要求是，它有一些唯一值來定義清單中的每一行。這個概念遵循 SQL 中"主鍵"的概念，並確保清單中的每一行都可以被唯一引用。這些索引值的範例是 SNMP 網路介面的"ifIndex"或分割區的裝置名稱。',
    'data_queries_types' => '您將在整個 Cacti 中看到三種類型的**資料查詢**。它們是腳本查詢、腳本伺服器查詢和 SNMP 查詢。腳本、腳本伺服器和 SNMP 查詢在功能上幾乎相同，只是在獲取資訊的方式上有所不同。腳本和腳本伺服器查詢將呼叫外部命令或腳本，SNMP 查詢將進行 SNMP 呼叫以檢索資料清單。',

    // User Interface section
    'data_queries_ui_title' => '使用者介面',
    'data_queries_ui_description' => '下面，您可以看到 Cacti 的預設**資料查詢**介面。從介面中，您可以看到資料查詢的名稱、ID、資料輸入方法和其他資訊。',
    'data_queries_interface_desc' => '資料查詢介面',
    'data_queries_edit_description' => '當您編輯現有資料查詢時，您將看到如下介面。在該介面中，您會注意到包含了 XML 檔案路徑。XML 檔案是 Cacti **資料查詢**的關鍵元件。對於基於腳本的**資料查詢**，還將有一個必須呼叫的腳本來收集有關**資料查詢**的資訊，腳本名稱包含在 XML 檔案中。',
    'data_queries_edit_interface_desc' => '資料查詢編輯介面',
    'data_queries_graph_templates' => '在此介面中，您可以看到名稱、描述、XML 路徑和**資料輸入方法**。在下面的部分中，您有"關聯圖形範本"部分，其中包括可用於**資料查詢**的所有各種**圖形範本**。',
    'data_queries_template_removal' => '一旦**資料查詢****圖形範本**正在使用中，就不能再從 Cacti 中刪除。此功能是為了防止如果有人意外刪除**圖形範本**關聯，**圖形**變得無法渲染。',
    'data_queries_template_click' => '當您點擊任何"關聯圖形範本"名稱時，您將被帶到下面的介面。',
    'data_queries_template_edit_desc' => '資料查詢關聯圖形範本編輯介面',
    'data_queries_mapping_description' => '從這裡，您將各種匹配的**資料範本** RRD 檔案資料來源名稱映射到 XML 檔案中存在的資料來源名稱。XML 檔案中可以有許多資料來源名稱，但圖形範本可能只需要其中的幾個，這解釋了**資料查詢**具有"關聯資料範本"部分的原因。要將 XML 欄位與**資料範本** RRD 檔案資料來源關聯，您只需選擇正確的一個，然後切換 XML 欄位資料來源名稱右側的核取方塊。',
    'data_queries_suggested_values' => '在"關聯資料範本"下方，您將找到兩個部分，稱為**資料來源**和**圖形**名稱的"建議值"。在建立**圖形**及其關聯的**資料來源**時，Cacti 將使用"建議值"模式中的第一個名稱，該名稱完全替換由開始和結束豎線標識的所有標籤。因此，在上面的範例中，建立介面圖形時，如果該介面沒有 ifAlias，Cacti 可能會使用第二個"建議值"，除非介面沒有 IP 位址，在這種情況下它將使用第三個"建議值"。',
    'data_queries_replacement_values' => 'Cacti 還允許"建議值"替換**圖形**和**資料來源**值，如上面的情況，"rrd_maximum"欄被網路介面最大速度替換，從 SNMP 角度來說也稱為"ifSpeed"。',
    'data_queries_two_parts' => '所有資料查詢都有兩個部分，XML 檔案和 Cacti 內的定義。必須為每個查詢建立一個 XML 檔案，該檔案定義每條資訊的位置以及如何檢索它。這可以被認為是實際的查詢。第二部分是 Cacti 內的定義，它告訴 Cacti 在哪裡找到 XML 檔案，並將資料查詢與一個或多個圖形範本關聯。',

    // Creating a Data Query section
    'creating_data_query_title' => '建立資料查詢',
    'creating_data_query_desc' => '一旦您建立了定義資料查詢的 XML 檔案，您必須在 Cacti 內新增資料查詢。要執行此操作，您必須點擊資料收集標題下的資料查詢，然後選擇新增。您將被提示輸入有關資料查詢的一些基本資訊，下面有更詳細的描述。',
    'data_queries_table_title' => '表 12-1. 欄位描述：資料查詢',
    'data_queries_name_field' => '名稱',
    'data_queries_description_field' => '描述（可選）',
    'data_queries_xml_path_field' => 'XML 路徑',
    'data_queries_data_input_method_field' => '資料輸入方法',
    'data_queries_name_desc' => '為**資料查詢**提供一個您將用來識別它的名稱。當呈現**資料查詢**清單時，此名稱將在整個 Cacti 中使用。',
    'data_queries_description_desc' => '輸入資料查詢的更詳細描述，包括它查詢的資訊或其他要求。',
    'data_queries_xml_path_desc' => '填寫定義此查詢的 XML 檔案的完整路徑。您可以選擇使用 `path_cacti` 變數，該變數將被替換為 Cacti 的完整路徑。在下一個畫面上，Cacti 將檢查以確保它可以找到 XML 檔案。',
    'data_queries_data_input_method_desc' => '這是您告訴 Cacti 如何處理從資料查詢接收的資料的方式。通常，您將為 SNMP 查詢選擇"獲取 SNMP 資料（索引）"，為腳本查詢選擇"獲取腳本資料（索引）"。',
    'data_queries_create_warning' => '當您完成填寫所有必要欄位後，點擊建立按鈕繼續。您將被重新導向回同一頁面，但這次有一些額外的資訊需要填寫。如果您收到紅色警告說"XML 檔案不存在"，請更正"XML 路徑"欄位中指定的值。',

    // Associated Graph Templates section
    'associated_graph_templates_title' => '關聯圖形範本',
    'associated_graph_templates_desc' => '每個資料查詢必須至少有一個與之關聯的圖形範本，可能更多，這取決於 XML 檔案中指定的輸出欄位數量。這是您選擇從此查詢產生什麼類型圖形的地方。例如，介面資料查詢有多個圖形範本關聯，用於繪製流量、錯誤或資料包圖形。要新增新的圖形範本關聯，只需點擊關聯圖形範本框右側的新增。您將看到一些需要填寫的欄位：',
    'associated_graph_templates_table_title' => '表 12-2. 欄位描述：關聯圖形範本',
    'associated_graph_templates_name_desc' => '提供一個描述您試圖表示或繪製的資料類型的名稱。當使用者使用此資料查詢建立圖形時，他們將看到必須從中選擇的圖形範本關聯清單。',
    'associated_graph_templates_template_desc' => '選擇您想要與之建立關聯的實際圖形範本。',
    'associated_graph_templates_finish' => '當您完成填寫這些欄位後，點擊建立按鈕。您將被重新導向回同一頁面，並有一些額外的資訊需要填寫。Cacti 將列出您選定的**圖形範本**中引用的每個**資料範本**，並在"關聯資料範本"框下顯示它們。如前所述，對於列出的每個**資料來源**項目，您必須選擇與之對應的**資料查詢**輸出欄位。*不要忘記選取每個選擇右側的核取方塊，否則您的設定將不會被儲存。*',
    'suggested_values_desc' => '"建議值"表單為您提供了一種控制使用**資料查詢**建立的**資料來源**和**圖形**欄位值的方法。如果您為同一欄位指定多個"建議值"，Cacti 將按您可以使用向上或向下箭頭圖示控制的順序評估它們。有關有效欄位名稱和變數的更多資訊，請閱讀"建議值"部分。',
    'data_queries_final_save' => '當您完成填寫此表單上的所有必要欄位後，點擊儲存按鈕返回資料查詢編輯畫面。根據需要重複此標題下的步驟多次，以表示 XML 檔案中的所有資料。完成後，您應該準備好開始將資料查詢新增到主機。',

    // Common data query terms
    'data_query' => '資料查詢',
    'data_queries' => '資料查詢',
    'script_queries' => '腳本查詢',
    'snmp_queries' => 'SNMP 查詢',
    'script_server_queries' => '腳本伺服器查詢',
    'xml_file' => 'XML 檔案',
    'associated_graph_templates' => '關聯圖形範本',
    'associated_data_templates' => '關聯資料範本',
    'suggested_values' => '建議值',

    // Device Templates page specific
    'page_title_device_templates' => 'Cacti - 裝置範本',
    'device_templates_title' => '裝置範本',
    'device_templates_intro' => '**裝置範本**是 Cacti 物件，允許您定義**裝置**類別，包括一個到多個**圖形範本**、**資料查詢**和其他**外掛**相關物件類型。',
    'device_templates_purpose' => '**裝置範本**的目的是透過預定義應為新增到 Cacti 的每個**裝置**建立的**圖形**來簡化**自動化**程序。它們與**自動化範本**配合工作，以便當 Cacti 發現**網路**時，它知道為每個**裝置**建立什麼**圖形**。',
    'device_templates_main_screen' => '**裝置範本**主畫面如下圖所示：',
    'device_templates_page_desc' => '裝置範本頁面',
    'device_templates_page_info' => '從此頁面，您可以看到每個**裝置範本**的標題、對 Cacti CLI 腳本很重要的 ID。您可以看到**裝置範本**是否可以刪除，以及使用**裝置範本**的**裝置**數量。被**裝置**使用的範本無法刪除，因此如果您嘗試刪除其中一個範本，您將收到錯誤訊息。',
    'device_templates_dropdown_options' => '從下拉選單中有三個選項，它們是：',

    // Device Templates options table
    'device_templates_option_field' => '選項',
    'device_templates_description_field' => '描述',
    'device_templates_delete_option' => '刪除',
    'device_templates_delete_desc' => '如果**裝置範本**是*可刪除的*，則刪除它',
    'device_templates_duplicate_option' => '複製',
    'device_templates_duplicate_desc' => '製作**裝置範本**的精確副本。',
    'device_templates_sync_option' => '同步裝置',
    'device_templates_sync_desc' => '使用最新定義更新所有使用此**裝置範本**的**裝置**，新增但不刪除**圖形範本**和**資料查詢**。',

    // Device Template editing
    'device_templates_edit_intro' => '編輯**裝置範本**時，您將看到如下所示的頁面。從此頁面，您可以新增和刪除**圖形範本**、**資料查詢**和其他**外掛**物件。在下面的圖像中，您可以看到*思科路由器*有一個**圖形範本**，即*思科 - CPU 使用率*和一個**資料查詢**，即*SNMP - 介面統計*。系統上沒有定義**閾值範本**，因此無法選擇一個。',
    'device_templates_edit_page_desc' => '裝置範本編輯頁面',
    'device_templates_add_remove' => '要向**裝置範本**新增**圖形範本**或**資料查詢**，只需從下拉選單中選擇它，然後按*新增*按鈕。之後無需*儲存*。要刪除其中一個項目，只需按所需**圖形範本**或**資料查詢**右側的 x 符號。',

    // Common device template terms
    'device_template' => '裝置範本',
    'device_templates' => '裝置範本',
    'automation_templates' => '自動化範本',
    'threshold_templates' => '閾值範本',
    'cisco_router' => '思科路由器',
    'cisco_cpu_usage' => '思科 - CPU 使用率',
    'snmp_interface_statistics' => 'SNMP - 介面統計',
    'deletable' => '可刪除的',
    'sync_devices' => '同步裝置',
    'duplicate' => '複製',

    // Graph Templates page specific
    'page_title_graph_templates' => 'Cacti - 圖形範本',
    'graph_templates_title' => '圖形範本',
    'graph_templates_intro' => '**圖形範本**是 Cacti 物件，允許您定義 RRDtool 如何渲染 Cacti **圖形**。支援大多數 RRDtool 選項，包括 CDEF 和 VDEF、左軸和右軸、刻度和虛線、多重自動縮放、網格和圖例選項。',
    'graph_templates_purpose' => '**圖形範本**的目的是透過預定義要在 Cacti 中監控的各種指標的**圖形**佈局來簡化**自動化**程序。當與 Cacti 的**圖形規則**結合使用時，您可以在 Cacti 的**網路發現**程序中自動建立幾乎任何基於**資料查詢**的**圖形**。',
    'graph_templates_main_screen' => '**圖形範本**主畫面如下圖所示：',
    'graph_templates_page_desc' => '圖形範本頁面',
    'graph_templates_page_info' => '從此頁面，您可以看到每個**圖形範本**的標題、對 Cacti CLI 腳本很重要的 ID。您可以看到**圖形範本**是否可以刪除，以及使用**圖形範本**的**圖形**數量，以及將要建立的**圖形**的*大小*、*圖像格式*和*垂直標籤*。被**裝置**使用的範本無法刪除，因此如果您嘗試刪除其中一個範本，您將收到錯誤訊息。',
    'graph_templates_dropdown_options' => '從下拉選單中有三個選項，它們是：',

    // Graph Templates options table
    'graph_templates_option_field' => '選項',
    'graph_templates_description_field' => '描述',
    'graph_templates_delete_option' => '刪除',
    'graph_templates_delete_desc' => '如果**圖形範本**是*可刪除的*，則刪除它',
    'graph_templates_duplicate_option' => '複製',
    'graph_templates_duplicate_desc' => '製作**圖形範本**的精確副本',
    'graph_templates_resize_option' => '調整大小',
    'graph_templates_resize_desc' => '做出影響**圖形範本**和使用此**圖形範本**建立的任何**圖形**的調整大小決定',
    'graph_templates_sync_option' => '同步圖形',
    'graph_templates_sync_desc' => '使用最新定義更新所有使用此**圖形範本**的**圖形**，新增新的*圖形項目*並刪除孤立的*圖形項目*',

    // Graph Template editing sections
    'graph_templates_edit_intro' => '編輯**圖形範本**時，將有幾個部分需要管理員提供資訊。這些部分包括：',
    'graph_templates_section_field' => '部分',
    'graph_templates_items_section' => '圖形範本項目',
    'graph_templates_items_desc' => '這些項目在**圖形**的畫布內繪製',
    'graph_templates_inputs_section' => '圖形項目輸入',
    'graph_templates_inputs_desc' => '當您向**圖形範本**新增**資料來源**時，此清單會自動建立。但是，您也可以透過向此部分新增特定命名的物件來覆蓋某些**資料範本**和**圖形範本**欄位。',
    'graph_templates_template_section' => '圖形範本',
    'graph_templates_template_desc' => '允許您命名**圖形範本**，以及是否允許此**圖形範本**的多個實例用於**裝置**，以及是否在允許建立**圖形**之前測試有效資料。當您想要利用包含可能不適用於使用**圖形範本**的所有類別**裝置**的**圖形範本**的複雜**裝置範本**時，*測試資料來源*選項很有用。',
    'graph_templates_common_section' => '通用選項',
    'graph_templates_common_desc' => '諸如標題、垂直標籤、圖像格式、高度和寬度、基值和斜率模式等',
    'graph_templates_scaling_section' => '縮放選項',
    'graph_templates_scaling_desc' => '確定圖形是否自動縮放以及透過什麼方式。確定圖形是否具有固定的上限和下限',
    'graph_templates_grid_section' => '網格選項',
    'graph_templates_grid_desc' => '定義如何渲染圖形畫布網格',
    'graph_templates_axis_section' => '軸選項',
    'graph_templates_axis_desc' => '定義是否應該有右軸以及如何格式化',
    'graph_templates_legend_section' => '圖例選項',
    'graph_templates_legend_desc' => '定義如何格式化圖例',

    // Common graph template terms
    'graph_template' => '圖形範本',
    'graph_templates' => '圖形範本',
    'graph_rules' => '圖形規則',
    'network_discovery' => '網路發現',
    'graph_items' => '圖形項目',
    'graph_item_inputs' => '圖形項目輸入',
    'consolidation_function' => '合併函數',
    'replacement_variables' => '替換變數',
    'gprint_preset' => 'GPRINT 預設',
    'horizontal_rule' => '水平規則',
    'vertical_rule' => '垂直規則',
    'area_fill' => '區域填充',
    'multiple_instances' => '多個實例',
    'test_data_sources' => '測試資料來源',
    'common_options' => '通用選項',
    'scaling_options' => '縮放選項',
    'grid_options' => '網格選項',
    'axis_options' => '軸選項',
    'legend_options' => '圖例選項',
    'vertical_label' => '垂直標籤',
    'image_format' => '圖像格式',
    'base_value' => '基值',
    'slope_mode' => '斜率模式',
    'auto_scaling' => '自動縮放',
    'rigid_scaling' => '剛性縮放',
    'right_axis' => '右軸',

    // Data Source Templates page specific
    'page_title_data_source_templates' => 'Cacti - 資料來源範本',
    'data_source_templates_title' => '資料來源範本',
    'data_source_templates_intro' => '資料來源在 Cacti 中發揮重要作用，資料來源是從您在 Cacti 中監控的裝置收集的資料點。',
    'data_source_templates_poller' => '資料來源獲取由輪詢器收集的資料。',
    'data_source_templates_graph' => '然後資料來源保存要呈現給圖形的值。',
    'data_source_templates_association' => '資料來源範本然後與圖形範本關聯。',
    'data_source_templates_examples' => '這些資料來源可以是例如介面上的傳入流量。Cacti 允許您建立資料來源範本以關聯到資料查詢，範本允許您描述 Cacti 應該期望什麼類型的資料。',
    'data_source_templates_creation' => '要建立資料來源，您需要選擇適當的資料輸入，有幾個選項，但最受歡迎的是 GET SNMP 資料或 GET SNMP 資料（索引）。',
    'data_source_templates_indexed' => '例如，您將對介面使用 Get SNMP 資料（索引），因為 Cacti 需要查詢裝置以找到介面索引。您將使用 Get SNMP 資料並放入單個 OID，用於不會更改的 OID，例如 CPU 使用率通常沒有索引，OID 不會更改',
    'data_source_templates_types' => '您還需要告訴範本資料來源類型是什麼。最常見的是 Gauge 和 Counter。這些資料類型來自 RRDtool 本身。下面是支援的資料類型及其用途。有關更多資訊，請參見',
    'rrd_tool_create_function' => 'RRD 工具建立函數',

    // RRD Data Types
    'gauge_title' => 'GAUGE',
    'gauge_desc' => 'GAUGE 用於溫度或房間中的人數或 RedHat 股票價值等。',
    'counter_title' => 'COUNTER',
    'counter_desc' => 'COUNTER 用於連續遞增計數器，如路由器中的 ifInOctets 計數器。COUNTER 資料來源假設計數器永遠不會減少，除非計數器溢位。更新函數考慮溢位。',
    'counter_storage' => '計數器以每秒速率儲存。當計數器溢位時，RRDtool 檢查溢位是否發生在 32 位或 64 位邊界，並透過向結果新增適當的值來相應地行動。',
    'dcounter_title' => 'DCOUNTER',
    'dcounter_desc' => 'DCOUNTER 與 COUNTER 相同，但用於以雙精度浮點數表示的數量。它可以用於追蹤以非整數遞增的數量，即某些例程執行所需的秒數、某些技術設備處理的總重量等。',
    'dcounter_direction' => '唯一的實質性差異是 DCOUNTER 可以是向上計數或向下計數，但不能同時兩者。當前方向在第二次非未定義計數器更新時自動檢測，方向的任何進一步變化都被視為重置。新方向由重置後的第二次更新確定並鎖定，以及它與重置時值的差異。',
    'derive_title' => 'DERIVE',
    'derive_desc' => 'DERIVE 將儲存從資料來源的最後一個值到當前值的線的導數。這對於儀表很有用，例如，測量進入或離開房間的人的速率。在內部，derive 的工作方式與 COUNTER 完全相同，但沒有溢位檢查。因此，如果您的計數器不在 32 或 64 位重置，您可能想要使用 DERIVE 並將其與 MIN 值 0 結合使用。',
    'dderive_title' => 'DDERIVE',
    'dderive_desc' => 'DDERIVE 與 DERIVE 相同，但用於以雙精度浮點數表示的數量。',
    'counter_vs_derive_note' => '**注意**：關於 COUNTER vs DERIVE',
    'counter_vs_derive_author' => '作者：Don Baarda don.baarda@baesystems.com',
    'counter_vs_derive_advice' => '如果您不能容忍偶爾將計數器重置誤認為合法的計數器包裝，並且更喜歡對所有合法的計數器包裝和重置使用"未知"，請始終使用 min=0 的 DERIVE。否則，使用具有合適最大值的 COUNTER 將為所有合法的計數器包裝返回正確的值，將一些計數器重置標記為"未知"，但可能將一些計數器重置誤認為合法的計數器包裝。',
    'counter_vs_derive_probability' => '對於 5 分鐘步長和 32 位計數器，將計數器重置誤認為合法包裝的概率可以說是每 1Mbps 最大頻寬約 0.8%。請注意，這相當於 100Mbps 介面的 80%，因此對於高頻寬介面和 32 位計數器，可能更喜歡使用 min=0 的 DERIVE。如果您使用 64 位計數器，幾乎任何最大設定都將消除將重置誤認為計數器包裝的可能性。',
    'absolute_title' => 'ABSOLUTE',
    'absolute_desc' => 'ABSOLUTE 用於在讀取時重置的計數器。這用於容易溢位的快速計數器。因此，您不是正常讀取它們，而是在每次讀取後重置它們，以確保在下次溢位之前有最大的可用時間。另一個用途是您計算的事物，如自上次更新以來的訊息數。',
    'compute_title' => 'COMPUTE',
    'compute_desc' => 'COMPUTE 用於儲存應用於 RRD 中其他資料來源的公式的結果。此資料來源在更新時不提供值，而是根據定義公式的 rpn 表達式從資料來源的 PDP 計算其主要資料點（PDP）。然後將合併函數正常應用於 COMPUTE 資料來源的 PDP（即 rpn 表達式僅用於產生 PDP）。在資料庫軟體中，此類資料集稱為"虛擬"或"計算"欄。',
    'data_source_templates_variables' => '您還可以使用變數來設定資料來源的名稱。可用變數可以在',
    'variables_documentation' => '變數',
    'data_source_templates_variables_page' => '文件頁面上看到。',
    'data_source_templates_internal_name' => '同樣重要的設定是內部資料來源名稱。這將用於將資料來源與圖形範本關聯。因此請確保命名為可識別的內容。',

    // Aggregate Templates page specific
    'page_title_aggregate_templates' => 'Cacti - 聚合範本',
    'aggregate_templates_title' => '聚合範本',
    'aggregate_overview_title' => '聚合概述',
    'aggregate_templates_intro' => '**聚合範本**是**圖形範本**的特殊形式。它們允許您輕鬆建立**圖形**，將來自多個**裝置**的多個通用**圖形**的資料組合，並允許您輕鬆管理產生的**聚合圖形**以從其他通用**圖形**新增和刪除元素。',
    'aggregate_templates_creation' => '要建立透過範本管理的**聚合圖形**，您首先必須建立**聚合範本**。然後從 Cacti **圖形**頁面，您可以選擇要用作**聚合**一部分的**圖形**。然後您從 Cacti 動作下拉選單中選擇 `從範本建立聚合`。',
    'aggregate_templates_behavior' => '一旦您建立了**聚合圖形**，它們的行為就像任何其他 Cacti 圖形一樣。它們可以是樹的一部分、縮放等。它們有一個額外的好處 - 您可以以非常受控的方式從聚合中新增和刪除**圖形**，減少在其生命週期中維護它們的工作量。',
    'aggregate_templates_changes' => '如果您希望更改由**聚合範本**管理的**圖形**的設定，只需在**聚合範本**中進行更改，它們將級聯到由範本管理的**聚合圖形**。',
    'aggregate_template_interface_title' => '聚合範本介面',
    'aggregate_template_interface_desc' => '下面的圖像顯示了流量的聚合範本。',
    'aggregate_template_edit_desc' => '當您編輯**聚合範本**時，您會看到一個介面，允許您定義圖形畫布以及其格式。您應該實驗，直到找到最適合您需求的機制。',
    'aggregate_template_prefix' => '`聚合範本` `前綴` 設定允許您提供要應用於**聚合圖形**圖例項目的模式。任何 `host`、`query` 或 `input` 引用都可以在 `前綴` 部分中使用，以便唯一識別**圖形項目**。',
    'aggregate_graph_types' => '有幾個 `圖形類型` 轉換處理如何在產生的**聚合圖形**中處理 `AREA`、`LINEX` 和 `STACK` 項目，它們包括：',
    'keep_graph_types' => '**保持圖形類型** - 不會發生轉換。所有 `AREA`、`LINE` 和 `STACKS` 將保持不變。',
    'keep_type_and_stack' => '**保持類型和堆疊** - 這意味著類型將被保留，但所有資料將被堆疊，而不是簡單的 LINEX，它將被轉換為 LINEX:STACK',
    'convert_to_area_stack' => '**轉換為區域/堆疊圖形** - 所有 `LINEX` 將被轉換為 `AREA` 並堆疊。',
    'convert_to_line1' => '**轉換為 LINE1** - 所有**圖形項目**將被轉換為 `LINE1`',
    'convert_to_line2' => '**轉換為 LINE2** - 所有**圖形項目**將被轉換為 `LINE2`',
    'convert_to_line3' => '**轉換為 LINE3** - 所有**圖形項目**將被轉換為 `LINE3`',
    'convert_to_line1_stack' => '**轉換為 LINE1/堆疊** - 所有**圖形項目**將被轉換為 `LINE1` 並堆疊。',
    'convert_to_line2_stack' => '**轉換為 LINE2/堆疊** - 所有**圖形項目**將被轉換為 `LINE2` 並堆疊。',
    'convert_to_line3_stack' => '**轉換為 LINE3/堆疊** - 所有**圖形項目**將被轉換為 `LINE3` 並堆疊。',
    'totaling_setting' => '`總計` 設定有多個值。它們包括：',
    'no_totals' => '**無總計** - 圖例中不會有資料總和',
    'print_all_legend_items' => '**列印所有圖例項目** - 意味著所選的所有圖例項目都將包含總計',
    'print_totaling_legend_items' => '**僅列印總計圖例項目** - 此選項意味著圖例將把所有圖例項目總計為單個圖例。',
    'total_type_setting' => '`總計類型` - 將在**圖形**上建立通用元素的分組，並在通用元素發生變化時重置堆疊規則。選項包括：',
    'total_similar_data_sources' => '**總計相似資料來源** - 意味著您將透過相似的**資料來源**名稱總計圖例項目和**資料來源**，例如 `traffic_out` 和 `traffic_in`。',
    'total_all_data_sources' => '**總計所有資料來源** - 意味著您將對所有**資料來源**的值求和，無論其**資料來源**名稱如何。',
    'prefix_gprint_totals' => '使用 `總計類型` 時，您可以選擇使用 `GPRINT 總計前綴` 以文字值額外為您的圖例加上前綴。預設值在大多數情況下都有效。',
    'reorder_type_setting' => '`重新排序類型` 將在圖形上重新排序**資料來源**在其各自分組內，以便它們以通用方式排序，按字母順序。選項包括：',
    'no_reordering' => '**無重新排序** - 不對排序進行任何更改。',
    'data_source_graph_order' => '**資料來源，圖形** - 按**資料來源**名稱排序，然後按**圖形**名稱',
    'graph_data_source_order' => '**圖形，資料來源** - 按**圖形**名稱排序，然後按**資料來源**名稱',
    'base_graph_order' => '**基本圖形順序** - 僅關注**圖形**名稱',
    'graph_template_items_section' => '`圖形範本項目` 部分允許您在產生的**聚合圖形**中跳過或總計（即包含）**圖形項目**。當您考慮產生的**聚合**圖形的外觀時，有些元素根本不會產生好看的**圖形**。在這些情況下，您將希望從產生的**聚合圖形**中刪除它們。',
    'color_template_option' => '`顏色範本` 選項允許您在顯示產生的**聚合圖形**上的元素時使用不同的顏色旋轉。**顏色範本**可以從 `控制台 > 範本` 下的**顏色範本**選單選擇中新增和刪除。',
    'aggregate_override_sections' => '幾個部分允許您覆蓋產生的**聚合圖形**中任何通用**圖形範本**元素。我們不會在這裡解釋這些選項，只是讓您知道您可以在產生的**聚合圖形**中覆蓋它們。',
    'aggregate_summary_title' => '摘要',
    'aggregate_summary_desc' => '在使用**聚合範本**時，您可以使用幾種選項組合。其中一些選項會導致可怕和意外的結果，因此您必須實驗，直到您想出一個理想的**聚合範本**。',

    // Color Templates page specific
    'page_title_color_templates' => 'Cacti - 顏色範本',
    'color_templates_title' => '顏色範本',
    'color_templates_intro' => '**顏色範本**定義要用於 Cacti 中**聚合圖形**的顏色清單。當您向**聚合圖形**新增**圖形**時，您需要在**聚合圖形**內區分一個**圖形**與下一個。這些**顏色範本**是將以輪詢方式循環使用以渲染**聚合圖形**的顏色清單。',
    'color_templates_example' => '因此，例如，如果您的**顏色範本**使用 8 種不同的**顏色**，而您的**聚合圖形**包含 16 個*圖形項目*，那麼每種顏色將在**聚合圖形**中使用兩次。',
    'color_templates_standard' => '下面，您可以看到四個標準**顏色範本**，您可以看到您有能力*刪除*或*複製***顏色範本**。與其他 Cacti 物件一樣，您將不被允許*刪除*正在使用的**顏色範本**。',
    'color_templates_edit_screen' => '在下面的圖像中，您可以看到**顏色範本**編輯畫面。這個簡單的畫面允許您在清單中新增、刪除和重新排序顏色。',
    'color_templates_cacti_colors' => '如下圖所示，只允許選擇 Cacti **顏色**用於聚合**顏色範本**。如果您希望搜尋大約 340 個傳統和*命名顏色*的清單，可以在**顏色**下拉選單中輸入。',

    // Common template terms
    'data_source_template' => '資料來源範本',
    'data_source_templates' => '資料來源範本',
    'aggregate_template' => '聚合範本',
    'aggregate_templates' => '聚合範本',
    'aggregate_graphs' => '聚合圖形',
    'color_template' => '顏色範本',
    'color_templates' => '顏色範本',
    'graph_items' => '圖形項目',
    'data_points' => '資料點',
    'primary_data_points' => '主要資料點',
    'rpn_expression' => 'RPN 表達式',
    'consolidation_functions' => '合併函數',
    'virtual_columns' => '虛擬欄',
    'computed_columns' => '計算欄',
    'internal_data_source_name' => '內部資料來源名稱',
    'round_robin_fashion' => '輪詢方式',
    'named_colors' => '命名顏色',
    'legacy_colors' => '傳統顏色',

    // Automation Networks page specific
    'page_title_automation_networks' => 'Cacti - 自動化網路',
    'automation_networks_title' => '自動化網路',
    'automation_networks_intro' => '本節將描述 Cacti 中的**自動化網路**。',
    'automation_networks_adding' => '在自動化外掛中新增要掃描的網路很容易。在主控制台上點擊自動化。進入下面的頁面後，點擊頁面右上角的 +。',
    'automation_networks_main_desc' => '自動化網路',
    'automation_networks_subnet_desc' => '您現在將看到下面的頁面。如果您想掃描 192.168.1.0/24，您將在子網範圍文字框中輸入該內容，然後以 CIDR 格式輸入子網。',
    'automation_networks_options' => '其他重要選項包括',

    // Automation Networks options table
    'automation_option_field' => '選項',
    'automation_description_field' => '描述',
    'schedule_type_option' => '排程類型',
    'schedule_type_desc' => '您希望多久掃描一次此子網以查找裝置',
    'discovery_threads_option' => '發現執行緒',
    'discovery_threads_desc' => '掃描期間要產生多少個程序',
    'max_runtime_option' => '最大執行時間',
    'max_runtime_desc' => '防止掃描無限期執行',
    'auto_add_option' => '自動新增到 Cacti',
    'auto_add_desc' => '如果裝置可透過 SNMP 存取並匹配來自此子網的規則，則將新增該裝置',
    'netbios_option' => 'Netbios',
    'netbios_desc' => '掃描 netbios 名稱',
    'ping_method_option' => 'Ping 方法',
    'ping_method_desc' => '要傳送的 ping 資料包類型',
    'ping_port_option' => 'Ping 連接埠',
    'ping_port_desc' => '嘗試連線的 TCP/UDP 連接埠',
    'ping_timeout_option' => 'Ping 逾時',
    'ping_timeout_desc' => '用於主機 ICMP 和 UDP ping 的逾時值。此主機 SNMP 逾時值適用於 SNMP ping',
    'ping_retries_option' => 'Ping 重試',
    'ping_retries_desc' => '初始失敗後，Cacti 在失敗前將嘗試的 ping 重試次數',
    'automation_networks_edit_desc' => '自動化網路編輯',

    // Discovered Devices page specific
    'page_title_discovered_devices' => 'Cacti - 自動化發現裝置',
    'discovered_devices_title' => '自動化發現裝置',
    'discovered_devices_intro' => '從自動化啟動掃描後，Cacti 將比較找到的裝置與您設定的裝置規則和 SNMP 選項。',
    'discovered_devices_no_match' => '如果 Cacti 無法將裝置匹配到裝置範本或無法找到適當的 SNMP 憑證。',
    'discovered_devices_auto_add_off' => '另外，如果您將自動新增到 Cacti 設定為關閉，裝置也將被放在此部分中。',
    'discovered_devices_navigation' => '可以透過導航到以下區域找到發現裝置部分。',
    'discovered_devices_dropdown_desc' => '發現裝置',
    'discovered_devices_scan_results' => '下面您可以看到在掃描期間找到的不符合匹配條件的裝置。',
    'discovered_devices_ip_hostname' => '您將看到被掃描的 IP 以及如果可用的話透過 DNS 或 netbios 解析的主機名稱。',
    'discovered_devices_list_desc' => '發現裝置',
    'discovered_devices_selection' => '然後您可以選擇您有興趣新增的裝置，點擊裝置旁邊的核取方塊',
    'discovered_devices_add_menu' => '在下拉選單中選擇新增裝置，這將彈出下面的選單。從此選單您將能夠填寫新裝置的詳細資訊。',
    'discovered_devices_add_menu_desc' => '發現裝置',

    // Device Rules page specific
    'page_title_device_rules' => 'Cacti - 裝置規則',
    'device_rules_title' => '裝置規則',
    'device_rules_intro' => '裝置規則允許您在網路發現程序中自動為裝置分配裝置範本。',
    'device_rules_creation' => '要建立裝置規則，您必須首先建立裝置範本。然後，從裝置規則頁面，您可以建立基於裝置的 SNMP 系統描述或其 SNMP 系統物件 ID 匹配裝置的規則。',
    'device_rules_matching' => '當發現裝置時，Cacti 將嘗試將裝置與裝置規則匹配。如果找到匹配項，與裝置規則關聯的裝置範本將應用於裝置。',
    'device_rules_priority' => '裝置規則按其優先級順序處理。第一個匹配的規則將應用於裝置。',

    // Graph Rules page specific
    'page_title_graph_rules' => 'Cacti - 圖形規則',
    'graph_rules_title' => '圖形規則',
    'graph_rules_intro' => '圖形規則允許您在網路發現程序中自動為裝置建立圖形。',
    'graph_rules_creation' => '要建立圖形規則，您必須首先建立圖形範本和資料查詢。然後，從圖形規則頁面，您可以建立基於各種條件自動建立圖形的規則。',
    'graph_rules_matching' => '當發現裝置並匹配裝置規則時，Cacti 將處理任何圖形規則以自動為裝置建立圖形。',
    'graph_rules_types' => '有幾種類型的圖形規則，包括圖形範本規則和基於資料查詢的圖形規則。',

    // Tree Rules page specific
    'page_title_tree_rules' => 'Cacti - 樹規則',
    'tree_rules_title' => '樹規則',
    'tree_rules_intro' => '樹規則允許您在網路發現程序中自動將裝置和圖形放置到樹中。',
    'tree_rules_creation' => '要建立樹規則，您必須首先建立樹。然後，從樹規則頁面，您可以建立自動將裝置和圖形放置到適當樹位置的規則。',
    'tree_rules_matching' => '當發現裝置時，Cacti 將處理樹規則以自動將裝置及其圖形組織到樹結構中。',
    'tree_rules_hierarchy' => '樹規則可以基於裝置屬性（如站點、裝置類型或自訂欄位）建立分層結構。',

    // SNMP Options page specific
    'page_title_snmp_options' => 'Cacti - SNMP 選項',
    'snmp_options_title' => 'SNMP 選項',
    'snmp_options_intro' => 'SNMP 選項定義在網路發現程序中將使用的 SNMP 憑證和設定。',
    'snmp_options_creation' => '要建立 SNMP 選項，您需要定義 SNMP 版本、團體字串、使用者名稱、密碼和其他與 SNMP 相關的設定。',
    'snmp_options_discovery' => '在網路發現期間，Cacti 將嘗試使用定義的 SNMP 選項連線到裝置，以確定裝置是否啟用了 SNMP。',
    'snmp_options_versions' => 'SNMP 選項支援 SNMP 版本 1、2c 和 3，每個版本都有自己的特定配置要求。',
    'snmp_options_security' => '對於 SNMP v3，您可以配置身份驗證和隱私協定以進行安全的 SNMP 通訊。',

    // Common automation terms
    'automation_networks' => '自動化網路',
    'discovered_devices' => '發現裝置',
    'device_rules' => '裝置規則',
    'graph_rules' => '圖形規則',
    'tree_rules' => '樹規則',
    'snmp_options' => 'SNMP 選項',
    'network_discovery' => '網路發現',
    'device_template_assignment' => '裝置範本分配',
    'automatic_graph_creation' => '自動圖形建立',
    'tree_organization' => '樹組織',
    'snmp_credentials' => 'SNMP 憑證',
    'discovery_process' => '發現程序',
    'automation_rules' => '自動化規則',
    'subnet_scanning' => '子網掃描',
    'device_matching' => '裝置匹配',
    'rule_priority' => '規則優先級',
    'snmp_versions' => 'SNMP 版本',
    'community_strings' => '團體字串',
    'authentication_protocols' => '身份驗證協定',
    'privacy_protocols' => '隱私協定',

    // Networks page specific
    'page_title_networks' => 'Cacti - 網路',
    'networks_title' => '網路',
    'networks_intro' => 'Cacti 中的**網路**部分提供全面的網路管理和監控功能。本節涵蓋網路發現、裝置管理和自動化功能的各個方面，幫助您高效監控網路基礎設施。',
    'networks_overview' => 'Cacti 的網路管理功能包括自動網路發現、用於自動裝置分類的裝置規則、用於自動圖形建立的圖形規則，以及用於組織網路拓撲的樹規則。',
    'networks_automation_title' => '網路自動化',
    'networks_automation_desc' => 'Cacti 提供強大的自動化功能，可以自動發現網路上的裝置，根據預定義規則對其進行分類，並建立適當的圖形並在樹中組織它們。',
    'networks_discovery_title' => '網路發現',
    'networks_discovery_desc' => '網路發現程序允許 Cacti 自動掃描網路範圍並識別可以監控的裝置。此程序使用 SNMP 和其他協定來檢測和分類網路裝置。',
    'networks_device_management_title' => '裝置管理',
    'networks_device_management_desc' => '一旦發現裝置，Cacti 可以自動應用裝置範本，建立適當的圖形，並根據您的網路拓撲和管理要求組織裝置。',
    'networks_monitoring_title' => '網路監控',
    'networks_monitoring_desc' => 'Cacti 提供全面的網路監控功能，包括介面統計、裝置效能指標，以及透過 SNMP、腳本和其他資料收集方法進行的自訂監控。',
    'networks_organization_title' => '網路組織',
    'networks_organization_desc' => '使用 Cacti 的樹和站點管理功能，以符合您的網路拓撲和組織結構的邏輯層次結構組織您的網路裝置和圖形。',
    'networks_features_title' => '主要網路功能',
    'networks_feature_automation' => '**自動化網路** - 配置網路範圍以進行自動發現',
    'networks_feature_discovered' => '**發現裝置** - 管理網路掃描期間找到的裝置',
    'networks_feature_device_rules' => '**裝置規則** - 定義自動裝置範本分配規則',
    'networks_feature_graph_rules' => '**圖形規則** - 配置自動圖形建立規則',
    'networks_feature_tree_rules' => '**樹規則** - 設定自動裝置和圖形組織',
    'networks_feature_snmp' => '**SNMP 選項** - 配置用於裝置通訊的 SNMP 憑證和設定',
    'networks_getting_started_title' => '網路管理入門',
    'networks_getting_started_desc' => '要開始使用 Cacti 的網路管理功能，首先配置您的 SNMP 選項，然後設定自動化網路以定義您要監控的網路範圍。建立裝置規則以自動分類發現的裝置，並配置圖形和樹規則以自動組織您的監控資料。',
    'networks_best_practices_title' => '最佳實務',
    'networks_best_practices_desc' => '為了實現最佳網路管理，按站點和功能組織您的裝置，使用一致的命名慣例，為不同裝置類型配置適當的 SNMP 憑證，並定期審查和更新您的自動化規則，以確保它們與您不斷發展的網路基礎設施相匹配。',

    // Data Profiles page specific
    'page_title_data_profiles' => 'Cacti - 資料來源設定檔',
    'data_profiles_title' => '資料來源設定檔',
    'data_profiles_intro' => '本節將描述 Cacti 中的**資料來源設定檔**。',
    'data_profiles_disk_usage' => '以下值是相應資料設定檔的每個資料來源的磁碟使用量',
    'data_profiles_polling_time' => '輪詢時間',
    'data_profiles_type' => '類型',
    'data_profiles_size_per_ds' => '每個資料來源大小',
    'data_profiles_30_second' => '30 秒',
    'data_profiles_daily' => '每日',
    'data_profiles_weekly' => '每週',
    'data_profiles_monthly' => '每月',
    'data_profiles_yearly' => '每年',
    'data_profiles_48kb' => '48kb',
    'data_profiles_43kb' => '43kb',
    'data_profiles_46kb' => '46kb',
    'data_profiles_140kb' => '140kb',

    // CDEFs page specific
    'page_title_cdefs' => 'Cacti - CDEF',
    'cdefs_title' => 'CDEF',
    'cdefs_background_title' => '背景',
    'cdefs_background_desc' => 'Cacti 中的 CDEF 與 RRDtool 中的 CDEF 是一對一的類比。Cacti 只是提供了一個建立和管理它們的介面。一旦在 Cacti 中建立了 CDEF，它們就可以全域匯入和匯出。',
    'cdefs_mathematical_formulas' => 'CDEF 是數學公式，可以修改來自一個到多個資料來源或您在**圖形範本**中擁有的 VNAME 的數字資料。',
    'cdefs_rpn_format' => '數學公式的格式稱為逆波蘭表示法（RPN）。RPN 是工程師將方程式輸入早期 HP 和其他計算器以解決工程問題的早期形式。我們今天仍然使用它的原因是它遵循簡單的堆疊原理。換句話說，它沒有損壞。',
    'cdefs_complexity' => 'CDEF 可能變得非常複雜，因為 RRDtool 命令集中有幾個數學函數可用。',
    'cdefs_interface_title' => 'CDEF 介面',
    'cdefs_interface_desc' => '在下面的圖像中，您可以看到預設情況下 Cacti 中包含的所有 CDEF。有相當多的。使用中的許多公式都相當簡單。如果您想檢視有關如何使用 CDEF 的教學，您應該轉到 RRDtool 教學。RRDtool 網站上也有文件。',
    'cdefs_delete_duplicate' => '在此圖像中，您可以看到您有能力刪除或複製 CDEF，但請注意，您將無法刪除與 Cacti **圖形**或**圖形範本**關聯的任何 CDEF。',
    'cdefs_edit_screen' => '當您點擊 CDEF 的名稱時，您將進入編輯畫面。從那裡您將看到堆疊的有序清單。它通常以 CURRENT_DATA_SOURCE 之類的內容開始，這意味著當您向**圖形範本**或**圖形**新增**圖形項目**時，您可以選擇 CDEF。與該**圖形項目**關聯的**資料來源**是 CURRENT_DATA_SOURCE。',
    'cdefs_stack_operations' => '之後，您可能會看到一個數字，後跟一個數學運算子。這是 CDEF 的最簡單形式。如果您啟用了拖放功能，您可以使用拖放重新排序 CDEF 項目。否則，您將看到允許您上下移動 CDEF 項目的箭頭。',
    'cdefs_data_types' => '編輯 CDEF 時，第一個決定是您要在堆疊上放置什麼類型的資料，如下圖所示的選項。它們包括：',
    'cdefs_type_function' => '函數',
    'cdefs_type_function_desc' => '我們將在下面描述的數學函數',
    'cdefs_type_operator' => '運算子',
    'cdefs_type_operator_desc' => '常見的數學運算子，包括（+、-、*、/ 和 %）',
    'cdefs_type_another_cdef' => '另一個 CDEF',
    'cdefs_type_another_cdef_desc' => '您可以在您的 CDEF 中引用另一個 CDEF',
    'cdefs_type_special_data_source' => '特殊資料來源',
    'cdefs_type_special_data_source_desc' => '這些是 RRDtool 提供的特殊變數',
    'cdefs_type_custom_string' => '自訂字串',
    'cdefs_type_custom_string_desc' => '您可以輸入任何自訂字串或數字',

    // VDEFs page specific
    'page_title_vdefs' => 'Cacti - VDEF',
    'vdefs_title' => 'VDEF',
    'vdefs_intro' => 'Cacti 中的 VDEF 用於定義可以對現有資料來源執行統計操作的虛擬資料來源。',
    'vdefs_description' => 'VDEF 允許您建立虛擬資料來源，可以計算資料的統計資訊，如平均值、最大值、最小值、總計和其他數學運算。',
    'vdefs_usage' => 'VDEF 通常在圖形範本中使用，以在常規資料來源旁邊顯示統計資訊。',

    // Colors page specific
    'page_title_colors' => 'Cacti - 顏色',
    'colors_title' => '顏色',
    'colors_intro' => '本節將描述 Cacti 中的**顏色**。',
    'colors_description' => 'Cacti 中的顏色用於定義圖形的視覺外觀。您可以建立自訂顏色或使用預定義的調色盤。',
    'colors_management' => '顏色管理介面允許您新增、編輯和刪除可在整個 Cacti 中用於圖形渲染的顏色。',
    'colors_hex_values' => '顏色使用十六進位顏色值定義（例如，#FF0000 表示紅色，#00FF00 表示綠色，#0000FF 表示藍色）。',

    // GPRINTs page specific
    'page_title_gprints' => 'Cacti - GPRINT',
    'gprints_title' => 'GPRINT',
    'gprints_intro' => '本節將描述 Cacti 中的 **GPRINT**。',
    'gprints_description' => 'GPRINT（圖形列印）用於在圖形上顯示統計資訊。它們定義數值的格式化和顯示方式。',
    'gprints_formatting' => 'GPRINT 控制圖形上顯示的數字格式，包括小數位、單位和文字格式。',
    'gprints_presets' => 'Cacti 包含幾個預定義的 GPRINT 預設，用於常見的格式需求，您可以為特定要求建立自訂 GPRINT。',
    'gprints_usage' => 'GPRINT 通常在圖形範本中使用，以顯示資料來源的目前值、平均值、最大值和最小值。',

    // Common preset terms
    'data_profiles' => '資料設定檔',
    'data_source_profiles' => '資料來源設定檔',
    'cdefs' => 'CDEF',
    'vdefs' => 'VDEF',
    'colors' => '顏色',
    'gprints' => 'GPRINT',
    'gprint_presets' => 'GPRINT 預設',
    'mathematical_formulas' => '數學公式',
    'reverse_polish_notation' => '逆波蘭表示法',
    'rpn' => 'RPN',
    'stack_operations' => '堆疊操作',
    'data_source_statistics' => '資料來源統計',
    'graph_formatting' => '圖形格式',
    'color_palette' => '調色盤',
    'hexadecimal_values' => '十六進位值',
    'statistical_operations' => '統計操作',
    'virtual_data_sources' => '虛擬資料來源',
    'numerical_formatting' => '數值格式',
    'preset_management' => '預設管理',
    'graph_rendering' => '圖形渲染',
    'data_visualization' => '資料視覺化',

    // Import Template page specific
    'page_title_import_template' => 'Cacti - 範本匯入',
    'import_template_title' => '範本匯入',
    'import_template_intro' => '本節將描述 Cacti 中的**範本匯入**。',
    'import_template_description' => '範本匯入檔案是 XML 檔案，用於新增對更多圖形類型和不同裝置的支援，可以與他人共享。這些範本檔案可以是自訂製作的，也可以從 cacti 論壇的社群下載。',
    'import_template_process' => '下載所需的圖形/裝置範本後，您需要將範本匯入到 cacti 系統中。要匯入裝置/圖形範本，請轉到 `控制台 > 匯入/匯出 > 匯入範本`，您現在將看到下面的頁面',
    'import_template_important_note' => '**重要說明**：匯入範本時，請確保將資料來源設定檔與您偏好的**資料來源設定檔**匹配。',
    'import_template_select_file' => '首先，您必須點擊**選擇檔案**並瀏覽到 XML 檔案在您電腦上的位置。Cacti 將預設預覽匯入以檢查任何問題。如果沒有發現問題，您可以選擇相同的檔案，然後取消選中預覽選項進行匯入，之後範本應該可用。',
    'import_template_remove_orphans' => '`刪除孤立項`選項只應在您的範本已損壞且糾正它們的最佳方法是重新開始時使用。此選項將從任何**圖形**中刪除不出現在要匯入的**圖形範本**中的任何**圖形項目**。請謹慎使用此選項。',

    // Export Template page specific
    'page_title_export_template' => 'Cacti - 範本匯出',
    'export_template_title' => '範本匯出',
    'export_template_intro' => 'Cacti 允許以 XML 格式匯出**裝置**、**圖形**和**資料**範本。您可以透過轉到 `控制台 > 匯入/匯出 > 範本匯出` 來存取下面的畫面。當您到達此頁面時，最受歡迎的選項是匯出**裝置範本**，但決定權在使用者。選擇物件類型後，將顯示可用範本清單。最受歡迎的選項是儲存到檔案，但您還有其他選項。',
    'export_template_guid' => '在範本內部，Cacti 使用**雜湊**全域唯一 ID (GUID) 來唯一標識每個範本元件。因此，您匯出的任何範本都可以與全球任何人共享而不會產生歧義。請參閱下面的 Linux 裝置範本範例。',
    'export_template_components' => '在此範本中有許多元件：',
    'export_template_component_1' => '裝置範本名稱本身及其 GUID',
    'export_template_component_2' => '所有圖形範本及其 GUID',
    'export_template_component_3' => '所有圖形範本輸入及其 GUID',
    'export_template_component_4' => '所有資料範本及其 GUID',
    'export_template_component_5' => '所有資料輸入方法及其 GUID',
    'export_template_component_6' => '所有 GPrint 預設及其 GUID',
    'export_template_component_7' => '所有 CDEF 和 VDEF 及其 GUID',
    'export_template_component_8' => '所有資料來源設定檔及其 GUID',
    'export_template_encoding' => '雖然輸出是人類可讀的，但某些欄被編碼以免對 XML 輸出格式造成問題。要讀取它們，您必須在 PHP 或其他語言中對它們進行 base64_decode。',
    'export_template_format' => '目前它們以 XML 格式儲存，但正在討論使這些範本採用 YAML 格式。',

    // Common template import/export terms
    'template_import' => '範本匯入',
    'template_export' => '範本匯出',
    'template_exporting' => '範本匯出',
    'xml_files' => 'XML 檔案',
    'template_files' => '範本檔案',
    'graph_types' => '圖形類型',
    'data_templates' => '資料範本',
    'import_export' => '匯入/匯出',
    'select_file' => '選擇檔案',
    'preview_import' => '預覽匯入',
    'remove_orphans' => '刪除孤立項',
    'global_unique_id' => '全域唯一 ID',
    'guid' => 'GUID',
    'hash_identifier' => '雜湊標識符',
    'template_components' => '範本元件',
    'xml_format' => 'XML 格式',
    'yaml_format' => 'YAML 格式',
    'base64_decode' => 'Base64 解碼',
    'human_readable' => '人類可讀',
    'template_sharing' => '範本共享',
    'community_templates' => '社群範本',
    'custom_templates' => '自訂範本',
    'damaged_templates' => '損壞的範本'
);
?>
