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
    'quicktree' => '快速樹'
);
?>
