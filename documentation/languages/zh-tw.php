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

    // Principles of Operation page specific
    'page_title_principles_operation' => 'Cacti - 操作原理',
    'principles_operation_title' => '操作原理',
    'principles_intro' => '要理解 Cacti 的操作原理，您必須從頂部開始向下工作。Cacti 的操作模型分為多個層次。它們包括',
    'operational_layers' => '操作層次',
    'devices_layer' => '裝置',
    'sites_layer' => '站點',
    'data_collectors_layer' => '資料收集器（輪詢器）',
    'data_retrieval_layer' => '資料檢索',
    'data_storage_layer' => '資料儲存',
    'graphing_layer' => '圖形化',

    // Devices section
    'devices_title' => '裝置',
    'devices_desc' => 'Cacti **裝置**是實體主機、感測器、叢集、服務或任何類型的具有名稱並且可以提供關於自身資訊的物件，這些資訊應該進入**圖形**或可用於為營運提供額外有用資訊。',
    'devices_center' => 'Cacti **裝置**物件作為 Cacti 世界的中心，它儲存有關如何收集資料的資訊。您可以從一個 Cacti 系統監控一個到數萬個**裝置**。它非常可擴展。它們可以使用 Cacti 的自動化子系統發現，手動新增，或從 CMDB 收集並使用其命令列介面新增到 Cacti。',

    // Sites section
    'sites_title' => '站點',
    'sites_desc' => 'Cacti 與**站點**一起工作。因此，當您向 Cacti 新增實體**裝置**時，您可以將其與**站點**關聯。站點設計為實體位置。Cacti 可以方便地按站點組織**裝置**及其**圖形**。',

    // Data Collectors section
    'data_collectors_title' => '資料收集器',
    'data_collectors_desc' => '這些是收集網路或站點內一組裝置資料的實體或虛擬主機或容器。它們具有彈性，如果中央 Cacti 伺服器不可達，它們將快取資料並等待其再次可用。',
    'data_collectors_support' => 'Cacti 今天支援多達數十個資料收集器。一些客戶使用像樹莓派或 Nuk 這樣簡單的東西作為資料收集器。但是，虛擬機是首選的，因為它們可以即時遷移，不會中斷資料收集。',

    // Data Retrieval section
    'data_retrieval_title' => '資料檢索',
    'data_retrieval_desc' => '資料收集器的首要任務是檢索資料並將其轉發到主 Cacti 伺服器進行儲存。Cacti 將使用其輪詢器來執行此操作，輪詢器是資料收集器的一部分。輪詢器從作業系統的排程器或 systemd 執行，具體取決於作業系統和作業系統的版本。它在同一系統中動態地以每 10 秒到數小時的頻率收集資料。因此，一個 Cacti 系統可以以 10 秒粒度、30 秒粒度、1 分鐘一直到每幾小時一次的方式監控物件。',
    'data_flow_desc' => '在下面的圖像中，您可以看到從裝置到 Cacti 資料庫的資料的一般流程。',
    'enterprise_installations' => '在企業安裝中，您可能要處理數千個不同類型的裝置，例如伺服器、網路裝置、設備、感測器、PDU、靜態傳輸開關等。要從遠端目標/主機檢索資料，Cacti 主要使用簡單網路管理協議 SNMP。因此，所有能夠使用 SNMP 的裝置都有資格被 Cacti 監控。但這只是最簡單的情況。',
    'hmib_plugin_desc' => '許多客戶使用帶外程序收集資料，如使用 Cacti hmib 外掛，該外掛將資料儲存在臨時表中，然後 Cacti 可以直接從這些臨時表進行裝置資料收集。該設計，由於沒有裝置在延遲方面比資料庫更近，可以在 Cacti 中相對容易地擴展到 30、40，甚至 50 千個裝置，這取決於您的資料庫和資料收集器基礎設施的大小（套接字、核心、執行緒）。當使用這種 N 層方法時，大多數客戶將使用 Cacti 的 `腳本伺服器`，這是一個記憶體駐留 PHP 解釋器池，預載用於收集資料的所有腳本，因此，它超級快速且並行。但是，大多數客戶將使用 SNMP 或 SSH 從其裝置收集指標。我的意思是，有多少公司有 50 千個裝置需要定期監控？',
    'rrd_storage_desc' => '一旦收集了資料，Cacti 然後使用帶外或帶內程序將資料儲存到輪詢存檔檔案中，這些檔案代表稱為 RRDfiles 的平面效能非常好的時間序列資料庫。有關該儲存機制的詳細資訊，請參見下文。',

    // Data Storage section
    'data_storage_title' => '資料儲存',
    'data_storage_desc' => '在行業中，結果資料的儲存可以採用多種形式。在 Cacti 中，RRDfile 多年來一直是首選工具。製作錘子的方法只有這麼多，而 RRDtool 是一個很棒的錘子。行業中的其他方法使用 SQL 資料庫，其他使用平面檔案或文件儲存，如 ElasticSearch、Splunk、Mongo DB、InfluxDB。有很多選擇。您可以從 RRDtool 網站獲取有關 RRDfile 的更多資訊。',
    'rrd_acronym' => '`RRD` 是 **輪詢資料庫** 的縮寫。RRD 是一個儲存和顯示時間序列資料（即網路頻寬、機房溫度、伺服器負載平均值）的系統。它以非常緊湊的方式儲存資料，不會隨時間擴展，並且可以建立美麗的圖形。超過某個點的資料會被合併，非常舊的資料只是從 RRDfile 的末端滾落。它會老化。這使儲存需求得到控制。',
    'rrd_consolidation' => '如前所述，執行合併以將原始資料（RRDtool 術語中的 `主要資料點`）組合為合併資料（`合併資料點`）。這樣，歷史資料被壓縮以節省空間。RRDtool 知道不同的合併函數：AVERAGE、MAXIMUM、MINIMUM 和 LAST。',

    // Data Presentation section
    'data_presentation_title' => '資料呈現',
    'data_presentation_desc' => 'RRDtool 最受讚賞的功能之一是內建的圖形功能。當與一些常用的 Web 伺服器結合使用時，這非常有用。因此，可以從任何平台上的幾乎任何瀏覽器存取圖形。',
    'graphing_engine_desc' => '圖形引擎非常靈活。可以在一個圖形中繪製一個或多個項目。支援自動縮放和對數 y 軸、左軸和右軸，以及更多更多。您可以將項目堆疊到另一個項目上，並列印表示最小值、平均值、最大值等特徵的漂亮圖例。',

    // Extending Capabilities section
    'extending_capabilities_title' => '擴展內建功能',
    'extending_capabilities_desc' => '如前所述，腳本和查詢將 Cacti 的功能擴展到 SNMP 之外。它們允許使用自訂程式碼進行資料檢索。這甚至不限於某些程式語言；您會發現 PHP、Perl、Python、shell/batch 等等。這些腳本和查詢由 Cacti 的輪詢器在本機執行。但它們可以透過不同的協定從遠端主機檢索資料，例如',

    // Protocol table
    'protocol_column' => '協定',
    'description_column' => '描述',
    'icmp_protocol' => 'ICMP',
    'icmp_desc' => 'ping 測量往返時間和可用性',
    'telnet_protocol' => 'telnet',
    'telnet_desc' => '程式設計 telnet 腳本以檢索僅對系統管理員可用的資料',
    'ssh_protocol' => 'ssh',
    'ssh_desc' => '很像 telnet，但更安全（也更複雜）',
    'http_protocol' => 'http(s)',
    'http_desc' => '呼叫遠端 cgi 腳本透過 Web 伺服器檢索資料或解析網頁以獲取統計資料（例如一些網路印表機）',
    'snmp_protocol' => 'snmp',
    'snmp_desc' => '使用 Net-SNMP 的 exec/pass 函數呼叫遠端腳本並獲取資料',
    'ldap_protocol' => 'ldap',
    'ldap_desc' => '檢索有關您的 ldap 伺服器活動的統計資訊',
    'custom_protocol' => '使用您自己的',
    'custom_desc' => '呼叫 Nagios 代理',
    'and_more' => '以及更多...',

    // Ways to extend Cacti
    'extending_ways' => '有兩種擴展 Cacti 內建功能的方法：',
    'data_input_methods_desc' => '用於查詢**單個或多個**，但**非索引**讀數的資料輸入方法',
    'data_input_examples' => '溫度、濕度、風...',
    'cpu_memory_example' => 'cpu、記憶體使用',
    'users_logged_example' => '登入使用者數',
    'ip_readings_example' => 'IP 讀數，如 ipInReceives（每個主機接收的 ip 資料包數）',
    'tcp_readings_example' => 'TCP 讀數，如 tcpActiveOpens（tcp 開啟套接字數）',
    'udp_readings_example' => 'UDP 讀數，如 udpInDatagrams（接收的 UDP 資料包數）',

    'data_queries_desc' => '用於**索引**讀數的資料查詢',
    'network_interfaces_example' => '網路介面，例如流量、錯誤、丟棄',
    'snmp_tables_example' => '其他 SNMP 表，例如用於磁碟使用的 hrStorageTable',
    'data_queries_script_example' => '您甚至可以建立資料查詢作為腳本，例如查詢名稱伺服器（索引 = 網域）以獲取每個網域的請求',

    'export_import_desc' => '透過使用匯出和匯入功能，可以與他人分享您的結果。',

    // Beyond Graphs section
    'beyond_graphs_title' => '超越圖形',
    'beyond_graphs_desc' => 'Cacti 不僅僅是一個圖形平台，它也是一個網路營運框架。透過數十個外掛和使用者貢獻的圖形範本，使用 Cacti 框架可以做的事情是無限的。它在開源世界中已經經受了 19 年的時間考驗。'
);
?>
