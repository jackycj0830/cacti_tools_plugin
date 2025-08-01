<?php
/**
 * Simplified Chinese Language File for Cacti Documentation
 * 
 * This file contains all Simplified Chinese text content for the documentation system.
 * Modify this file to update Simplified Chinese content.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 * @language 简体中文 (Simplified Chinese)
 */

$lang = array(
    // Page titles
    'page_title_main' => 'Cacti (tm) 文档',
    'page_title_requirements' => 'Cacti - 系统要求',
    'page_title_installation' => 'Cacti - 安装',
    'page_title_configuration' => 'Cacti - 配置',
    'page_title_toc' => 'Cacti - 目录',
    
    // Navigation
    'language_selector_label' => '语言',
    'back_button' => '← 返回',
    'home' => '首页',
    'documentation' => '文档',
    'table_of_contents' => '目录',
    
    // Main page content
    'main_title' => 'Cacti (tm) 文档',
    'main_subtitle' => 'Cacti 网络监控完整指南',
    'welcome_message' => '欢迎使用 Cacti 文档。本文档将帮助您安装、配置和使用 Cacti 来监控您的网络基础设施。',
    
    // Documentation sections
    'section_installation' => 'Cacti 安装',
    'section_installation_desc' => '本节包含有关如何安装和/或升级 Cacti 系统的信息。它涵盖了要求、不同平台以及在正常情况下使系统正常工作所需的步骤。',
    
    'section_overview' => 'Cacti 概述',
    'section_overview_desc' => '本节描述 Cacti 组件及其用途，并提供示例，包括如何在 Cacti 中创建<strong>模板</strong>。',
    
    'section_advanced' => '高级操作',
    'section_advanced_desc' => '本节涵盖更高级的内容，例如使用高级数据收集和可在<strong>模板</strong>中使用的替换变量等。',
    
    'section_plugin_dev' => '插件开发',
    'section_plugin_dev_desc' => '本节包含所有插件开发相关信息。指南、钩子、参考等。更多信息可以在 <a href="https://forums.cacti.net/viewforum.php?f=6">Cacti 论坛</a>上找到。',
    
    'section_howtos' => '操作指南',
    'section_howtos_desc' => '本节包含多个主题的操作指南。',
    
    'section_contributing' => '贡献',
    'section_contributing_desc' => '本节包含有关如何为 Cacti 做出贡献的信息。',
    
    'section_standards' => '开发标准',
    'section_standards_desc' => '本节包含相关信息，说明如何确保任何贡献都保持与 Cacti 团队应用的相同标准。应该注意的是，不合规并不意味着自动排除建议的更改。',
    
    // Installation subsections
    'known_issues' => '已知问题',
    'known_issues_link' => '已知问题列表',
    'requirements' => '系统要求',
    'general_installing' => '通用安装说明',
    'installing_linux' => '在 Linux 上安装 Cacti',
    'installing_centos_lamp' => '在 CentOS 7 上安装 - LAMP 堆栈',
    'installing_centos_lemp' => '在 CentOS 7 上安装 - LEMP 堆栈',
    'installing_ubuntu' => '在 Ubuntu/Debian 上安装 - LAMP 堆栈',
    'installing_windows' => '在 Windows 上安装',
    'upgrading_linux' => '在 Linux/UNIX 上升级 Cacti',
    'upgrading_windows' => '在 Windows 上升级 Cacti',
    'upgrading_freebsd' => '在 FreeBSD 上升级 Cacti',
    
    // Overview subsections
    'overview' => '概述',
    'navigating_ui' => '导航用户界面',
    'principles_operation' => '操作原理',
    'graph_overview' => '图形概述',
    'how_to_graph' => '如何绘制网络图形',
    'viewing_graphs' => '查看图形',
    
    // Management
    'management' => '管理',
    'devices' => '设备',
    'sites' => '站点',
    'trees' => '树形结构',
    'graphs' => '图形',
    'data_sources' => '数据源',
    'aggregates' => '聚合',
    
    // Data Collection
    'data_collection' => '数据收集',
    'data_collectors' => '数据收集器',
    'spine_collection' => 'Spine 数据收集',
    'data_input_methods' => '数据输入方法',
    'data_queries' => '数据查询',
    
    // Templates
    'templates' => '模板',
    'device_templates' => '设备模板',
    'graph_templates' => '图形模板',
    'data_source_templates' => '数据源模板',
    'aggregate_templates' => '聚合模板',
    'color_templates' => '颜色模板',
    
    // Automation
    'automation' => '自动化',
    'networks' => '网络',
    'discovered_devices' => '发现的设备',
    'device_rules' => '设备规则',
    'graph_rules' => '图形规则',
    'tree_rules' => '树形规则',
    'snmp_options' => 'SNMP 选项',
    
    // Presets
    'presets' => '预设',
    'data_profiles' => '数据配置文件',
    'cdefs' => 'CDEF',
    'vdefs' => 'VDEF',
    'colors' => '颜色',
    'gprints' => 'GPRINT',
    
    // Import/Export
    'import_export' => '导入/导出',
    'import_templates' => '导入模板',
    'export_templates' => '导出模板',
    
    // Settings
    'settings' => '设置',
    'settings_general' => '常规',
    'settings_paths' => '路径',
    'settings_device_defaults' => '设备默认值',
    'settings_poller' => '轮询器',
    'settings_data' => '数据',
    'settings_visual' => '视觉',
    'settings_performance' => '性能',
    'settings_spikes' => '峰值',
    'settings_mail' => '邮件/报告/DNS',
    
    // Authentication
    'auth_settings' => '设置 - 认证',
    'local_auth' => '本地认证',
    'ldap_auth' => 'LDAP 认证',
    'basic_auth' => '基本认证',
    'domains_auth' => '域认证',
    
    // Users and Groups
    'users_groups' => '配置 - 用户、组和域',
    'users' => '用户',
    'user_groups' => '用户组',
    'user_domains' => '用户域',
    
    // Plugins
    'plugins' => '配置 - 插件',
    
    // Utilities
    'utilities' => '实用工具',
    'system_utilities' => '系统实用工具',
    'data_debug' => '数据调试',
    'external_links' => '外部链接',
    
    // Reporting
    'reporting' => '报告',
    'reports_admin' => '报告管理界面',
    'reports_user' => '报告用户界面',
    'reports_items' => '报告项目页面',
    'reports_preview' => '报告预览页面',
    'reports_events' => '报告事件页面',
    'reports_other' => '添加报告项目的其他选项',
    
    // Cacti Log
    'cacti_log' => 'Cacti 日志',
    
    // Footer
    'copyright' => '版权所有 (c) 2004-2024 Cacti 团队',
    
    // Common terms
    'video_tutorials' => '视频教程',
    'template_specific' => '模板特定文档',
    'template_desc' => '本节将用于模板特定配置要求',

    // Requirements page specific
    'requirements_intro' => 'Cacti 需要在您的系统上安装以下软件。',
    'web_server_req' => '支持 PHP 的 Web 服务器，如 Apache、Nginx 或 IIS',
    'build_env_req' => '使用 spine 时的构建环境（gcc、automake、autoconf、libtool、help2man）',
    'rrdtool_req' => 'RRDtool 1.3 或更高版本，推荐 1.5+',
    'php_req' => 'PHP 5.4 或更高版本，推荐 5.5+',
    'required_modules' => '必需模块：',
    'optional_modules' => '可选模块：',
    'mysql_req' => 'MySQL 5.6 或 MariaDB 5.5 或更高版本',
    'timezone_support' => '必须启用时区支持',
    'mycnf_recommendations' => '以下是 my.cnf 建议：',
    'problematic_software' => '有问题的软件和配置',
    'browser_requirements' => '浏览器要求',
    'browser_requirements_desc' => 'Cacti 已测试可在以下浏览器上运行：',
    'network_requirements' => '网络要求',
    'performance_considerations' => '性能考虑',
    'performance_desc' => '以下因素影响 Cacti 性能：',
    'cpu_requirements' => 'CPU',
    'cpu_desc' => '大型安装推荐多核处理器',
    'memory_requirements' => '内存',
    'memory_desc' => '最低 1GB RAM，大型安装推荐 4GB+',
    'storage_requirements' => '存储',
    'storage_desc' => 'RRD 文件推荐快速存储（SSD）',
    'network_bandwidth' => '网络',
    'network_desc' => 'SNMP 轮询需要足够的带宽',
    'security_considerations' => '安全考虑',
    'security_ssl' => '使用 SSL/TLS 访问 Web 界面',
    'security_passwords' => '为所有账户使用强密码',
    'security_updates' => '保持所有软件组件更新',
    'security_firewall' => '配置防火墙限制访问',
    'security_snmp' => '尽可能使用 SNMPv3 进行设备监控',

    // Navigating UI page specific
    'page_title_navigating_ui' => 'Cacti - 导航用户界面',
    'navigating_ui_title' => '导航 Cacti 用户界面',
    'ui_intro' => 'Cacti 用户界面在视觉上分为多个面板。每个主要面板都设计用于容纳内容。根据您使用的 Cacti 主题，某些面板可能在主题开发者的决定下不可见。常见的面板包括：',
    'top_tabs' => '顶部标签',
    'top_tabs_desc' => '您在此执行主要导航分离内容',
    'navigation_area' => '导航区域',
    'navigation_area_desc' => '如果顶部标签导航到的内容有菜单，将在此处找到。',
    'breadcrumb_bar' => '面包屑栏',
    'breadcrumb_bar_desc' => '这是您可以看到当前在 Cacti 界面中所指向位置的地方',
    'content_area' => '内容区域',
    'content_area_desc' => '这是您展示表格、图表、表单等的地方。这是您的主要内容所在的地方',
    'footer' => '页脚',
    'footer_desc' => '此部分留给主题开发者插入属于屏幕底部的内容。',
    'default_layout_desc' => '您可以在下面的图像中看到默认的 Cacti 布局及其各种面板。您会注意到，在这个现代主题中，主题作者决定省略页脚。',
    'top_tabs_navigation' => '在 Cacti 中，当您点击顶部标签时，默认情况下您将进入 Cacti 的完全不同的部分。Cacti 的顶部标签设计为模仿浏览器标签，这有助于用户定位到 Cacti 的各个部分。当您安装了许多插件时，如上面的示例所示，您可以清楚地看到这些导航辅助工具的好处。',
    'sub_panels_desc' => '在这些面板中的每一个内部，页面可以分解为子面板。通常分解为子面板的两个面板包括导航区域和内容区域。',
    'device_page_example' => '在下面的示例中，我们展示了 Cacti 中的设备页面，标出了各种子面板。',
    'content_control' => 'Cacti 的大多数页面都是以这种方式布局的。但是，进入 Cacti 内容区域的内容完全由插件作者控制。',
    'theme_requirements' => '在主题开发者的决定下，所有页面都应包括顶部标签和面包屑栏。在面包屑栏或顶部标签面板内，您应该始终在右侧看到用户配置文件和菜单。',
    'understanding_sections' => '要正确使用 Cacti，您应该首先了解这些部分。我们将从描述 Cacti 控制台开始。',
    'core_panels_title' => 'Cacti 核心面板和子面板',
    'top_tabs_detail' => 'Cacti 顶部标签为 Cacti 提供多个导航区域。默认情况下，Cacti 包括四个顶部标签。它们是控制台、图形、日志和报告。',
    'breadcrumbs' => '面包屑',
    'breadcrumbs_detail' => '面包屑直接出现在顶部标签下方。请注意，某些 Cacti 主题会禁用面包屑。如果需要，您可以点击面包屑区域导航到该区域。',
    'cacti_content_area' => 'Cacti 内容区域',
    'content_area_detail' => '这是主页面内容将显示的地方。它直接位于面包屑或某些 Cacti 主题的顶部标签下方。在外部链接的情况下，它们可以包括插件作者或 Cacti 管理员所需的任何 HTML。',
    'navigation_menu' => '导航菜单',
    'navigation_menu_detail' => '如果您点击 Cacti 控制台，您将看到一个示例导航菜单。除了 Cacti 控制台之外，这些菜单可以出现在任何基于插件的顶部标签页面上。',
    'cacti_tables' => 'Cacti 表格',
    'cacti_tables_detail' => '这些表格是在 Cacti 中呈现基于表格的数据的地方。Cacti 表格使用一个神秘但易于使用的 API 呈现。',
    'table_filters' => '表格过滤器',
    'table_filters_detail' => '任何 Cacti 表格都可以包括表格过滤器。这些过滤器可用于限制返回到 Cacti 表格的数据。',
    'actions_dropdown' => '操作下拉菜单',
    'actions_dropdown_detail' => '包含 Cacti 表格的任何页面通常都会包括操作下拉菜单。这些操作下拉菜单允许您对表格行或多行采取操作。',
    'user_profile_menu' => '用户配置文件和菜单',
    'user_profile_menu_detail' => '这是 Cacti 用户可以编辑其配置文件、更改密码、注销或查找其他 Cacti 信息和支持链接的地方。',
    'non_admin_access' => '非管理用户，如 Cacti 访客账户，不应有权访问 Cacti 控制台。Cacti 访客账户还不应有权访问其用户配置文件，因为该账户与许多用户共享。',

    // Graphs Top Tab section
    'graphs_top_tab_title' => 'Cacti 图形顶部标签',
    'graphs_top_tab_desc' => 'Cacti 图形顶部标签是查看大多数 Cacti 图形的地方。默认情况下，Cacti 图形顶部标签包括三个不同的视图。它们包括：',
    'tree_view' => '树形视图',
    'tree_view_desc' => '允许 Cacti 用户以分层树的形式查看图形。这些树通常由 Cacti 管理员构建，并在用户或用户组级别进行控制。',
    'preview_view' => '预览视图',
    'preview_view_desc' => '预览视图提供 Cacti 用户有权访问的所有图形的视图。提供表格过滤器来约束返回到页面的图形列表。',
    'list_view' => '列表视图',
    'list_view_desc' => '列表视图允许 Cacti 用户通过允许他们从各种页面选择图形，然后最终从预览视图查看这些页面来创建自己的预览页面。',
    'tree_view_example' => '在下面的示例树形视图页面中，您可以看到左侧的树导航区域，在 Cacti 内容区域中，您可以看到图形和用于约束返回的图形列表的表格过滤器区域。您可以从树导航区域上方的搜索区域搜索树形视图。',

    // Console section
    'console_title' => 'Cacti 控制台',
    'console_intro' => '在下面的图像中，您可以看到基本的 Cacti 控制台菜单区域。它分为单独的子菜单。我们接下来将描述每个的目的。',
    'main_console' => '主控制台',
    'main_console_desc' => '这个子菜单选择相当温和。它提供了一个开放区域。如果这是主控制台，这个屏幕感觉需要更多内容。幸运的是，插件开发者已经解决了这个问题。例如，intropage 插件可以满足这种需求。',
    'create' => '创建',
    'create_desc' => '此子菜单允许您创建设备和图形。它们本质上是其他子菜单选择的快捷方式。',
    'management' => '管理',
    'management_desc' => '这是所有核心 Cacti 站点、图形、设备、树、数据源和聚合非模板化对象所在的地方。当您安装 Cacti 插件时，您会发现它们扩展了此子菜单。',
    'data_collection' => '数据收集',
    'data_collection_desc' => '这是您定义数据收集规则的地方。示例包括：数据收集器、数据输入方法和数据查询',
    'templates' => '模板',
    'templates_desc' => '这是您在自动化之外找到 Cacti 各种模板的地方。默认情况下，您将找到图形、数据源、设备、聚合和颜色的模板。',
    'automation' => '自动化',
    'automation_desc' => '此子菜单是您找到自动化设备发现规则以及创建设备、图形和树的规则的地方。',
    'presets' => '预设',
    'presets_desc' => '此区域包含跨越模板边界且本质上是全局的元对象。它们包括：数据源配置文件、CDEF、VDEF、GPrint 预设和颜色',
    'import_export' => '导入导出',
    'import_export_desc' => '这是您可以导入和导出各种 Cacti 模板对象的方式。',
    'configuration' => '配置',
    'configuration_desc' => '这是您管理用户、用户组、用户域、全局设置和插件的地方。',
    'utilities' => '实用工具',
    'utilities_desc' => '这是 Cacti 包含可在 Web 门户中使用而无需转到命令行的常用实用工具的地方。',
    'troubleshooting' => '故障排除',
    'troubleshooting_desc' => '这里有一些方便的实用工具，可以帮助诊断 Cacti 的常见问题。',
    'objects_explanation' => '所有这些对象类型将在 Cacti 文档的后续部分中解释。现在，重要的是要知道这些页面存在。',

    // Principles of Operation page specific
    'page_title_principles_operation' => 'Cacti - 操作原理',
    'principles_operation_title' => '操作原理',
    'principles_intro' => '要理解 Cacti 的操作原理，您必须从顶部开始向下工作。Cacti 的操作模型分为多个层次。它们包括',
    'operational_layers' => '操作层次',
    'devices_layer' => '设备',
    'sites_layer' => '站点',
    'data_collectors_layer' => '数据收集器（轮询器）',
    'data_retrieval_layer' => '数据检索',
    'data_storage_layer' => '数据存储',
    'graphing_layer' => '图形化',

    // Devices section
    'devices_title' => '设备',
    'devices_desc' => 'Cacti **设备**是物理主机、传感器、集群、服务或任何类型的具有名称并且可以提供关于自身信息的对象，这些信息应该进入**图形**或可用于为运营提供额外有用信息。',
    'devices_center' => 'Cacti **设备**对象作为 Cacti 世界的中心，它存储有关如何收集数据的信息。您可以从一个 Cacti 系统监控一个到数万个**设备**。它非常可扩展。它们可以使用 Cacti 的自动化子系统发现，手动添加，或从 CMDB 收集并使用其命令行界面添加到 Cacti。',

    // Sites section
    'sites_title' => '站点',
    'sites_desc' => 'Cacti 与**站点**一起工作。因此，当您向 Cacti 添加物理**设备**时，您可以将其与**站点**关联。站点设计为物理位置。Cacti 可以方便地按站点组织**设备**及其**图形**。',

    // Data Collectors section
    'data_collectors_title' => '数据收集器',
    'data_collectors_desc' => '这些是收集网络或站点内一组设备数据的物理或虚拟主机或容器。它们具有弹性，如果中央 Cacti 服务器不可达，它们将缓存数据并等待其再次可用。',
    'data_collectors_support' => 'Cacti 今天支持多达数十个数据收集器。一些客户使用像树莓派或 Nuk 这样简单的东西作为数据收集器。但是，虚拟机是首选的，因为它们可以实时迁移，不会中断数据收集。',

    // Data Retrieval section
    'data_retrieval_title' => '数据检索',
    'data_retrieval_desc' => '数据收集器的首要任务是检索数据并将其转发到主 Cacti 服务器进行存储。Cacti 将使用其轮询器来执行此操作，轮询器是数据收集器的一部分。轮询器从操作系统的调度程序或 systemd 执行，具体取决于操作系统和操作系统的版本。它在同一系统中动态地以每 10 秒到数小时的频率收集数据。因此，一个 Cacti 系统可以以 10 秒粒度、30 秒粒度、1 分钟一直到每几小时一次的方式监控对象。',
    'data_flow_desc' => '在下面的图像中，您可以看到从设备到 Cacti 数据库的数据的一般流程。',
    'enterprise_installations' => '在企业安装中，您可能要处理数千个不同类型的设备，例如服务器、网络设备、设备、传感器、PDU、静态传输开关等。要从远程目标/主机检索数据，Cacti 主要使用简单网络管理协议 SNMP。因此，所有能够使用 SNMP 的设备都有资格被 Cacti 监控。但这只是最简单的情况。',
    'hmib_plugin_desc' => '许多客户使用带外进程收集数据，如使用 Cacti hmib 插件，该插件将数据存储在临时表中，然后 Cacti 可以直接从这些临时表进行设备数据收集。该设计，由于没有设备在延迟方面比数据库更近，可以在 Cacti 中相对容易地扩展到 30、40，甚至 50 千个设备，这取决于您的数据库和数据收集器基础设施的大小（套接字、核心、线程）。当使用这种 N 层方法时，大多数客户将使用 Cacti 的 `脚本服务器`，这是一个内存驻留 PHP 解释器池，预加载用于收集数据的所有脚本，因此，它超级快速且并行。但是，大多数客户将使用 SNMP 或 SSH 从其设备收集指标。我的意思是，有多少公司有 50 千个设备需要定期监控？',
    'rrd_storage_desc' => '一旦收集了数据，Cacti 然后使用带外或带内进程将数据存储到轮询存档文件中，这些文件代表称为 RRDfiles 的平面性能非常好的时间序列数据库。有关该存储机制的详细信息，请参见下文。',

    // Data Storage section
    'data_storage_title' => '数据存储',
    'data_storage_desc' => '在行业中，结果数据的存储可以采用多种形式。在 Cacti 中，RRDfile 多年来一直是首选工具。制作锤子的方法只有这么多，而 RRDtool 是一个很棒的锤子。行业中的其他方法使用 SQL 数据库，其他使用平面文件或文档存储，如 ElasticSearch、Splunk、Mongo DB、InfluxDB。有很多选择。您可以从 RRDtool 网站获取有关 RRDfile 的更多信息。',
    'rrd_acronym' => '`RRD` 是 **轮询数据库** 的缩写。RRD 是一个存储和显示时间序列数据（即网络带宽、机房温度、服务器负载平均值）的系统。它以非常紧凑的方式存储数据，不会随时间扩展，并且可以创建美丽的图形。超过某个点的数据会被合并，非常旧的数据只是从 RRDfile 的末端滚落。它会老化。这使存储需求得到控制。',
    'rrd_consolidation' => '如前所述，执行合并以将原始数据（RRDtool 术语中的 `主要数据点`）组合为合并数据（`合并数据点`）。这样，历史数据被压缩以节省空间。RRDtool 知道不同的合并函数：AVERAGE、MAXIMUM、MINIMUM 和 LAST。',

    // Data Presentation section
    'data_presentation_title' => '数据呈现',
    'data_presentation_desc' => 'RRDtool 最受赞赏的功能之一是内置的图形功能。当与一些常用的 Web 服务器结合使用时，这非常有用。因此，可以从任何平台上的几乎任何浏览器访问图形。',
    'graphing_engine_desc' => '图形引擎非常灵活。可以在一个图形中绘制一个或多个项目。支持自动缩放和对数 y 轴、左轴和右轴，以及更多更多。您可以将项目堆叠到另一个项目上，并打印表示最小值、平均值、最大值等特征的漂亮图例。',

    // Extending Capabilities section
    'extending_capabilities_title' => '扩展内置功能',
    'extending_capabilities_desc' => '如前所述，脚本和查询将 Cacti 的功能扩展到 SNMP 之外。它们允许使用自定义代码进行数据检索。这甚至不限于某些编程语言；您会发现 PHP、Perl、Python、shell/batch 等等。这些脚本和查询由 Cacti 的轮询器在本地执行。但它们可以通过不同的协议从远程主机检索数据，例如',

    // Protocol table
    'protocol_column' => '协议',
    'description_column' => '描述',
    'icmp_protocol' => 'ICMP',
    'icmp_desc' => 'ping 测量往返时间和可用性',
    'telnet_protocol' => 'telnet',
    'telnet_desc' => '编程 telnet 脚本以检索仅对系统管理员可用的数据',
    'ssh_protocol' => 'ssh',
    'ssh_desc' => '很像 telnet，但更安全（也更复杂）',
    'http_protocol' => 'http(s)',
    'http_desc' => '调用远程 cgi 脚本通过 Web 服务器检索数据或解析网页以获取统计数据（例如一些网络打印机）',
    'snmp_protocol' => 'snmp',
    'snmp_desc' => '使用 Net-SNMP 的 exec/pass 函数调用远程脚本并获取数据',
    'ldap_protocol' => 'ldap',
    'ldap_desc' => '检索有关您的 ldap 服务器活动的统计信息',
    'custom_protocol' => '使用您自己的',
    'custom_desc' => '调用 Nagios 代理',
    'and_more' => '以及更多...',

    // Ways to extend Cacti
    'extending_ways' => '有两种扩展 Cacti 内置功能的方法：',
    'data_input_methods_desc' => '用于查询**单个或多个**，但**非索引**读数的数据输入方法',
    'data_input_examples' => '温度、湿度、风...',
    'cpu_memory_example' => 'cpu、内存使用',
    'users_logged_example' => '登录用户数',
    'ip_readings_example' => 'IP 读数，如 ipInReceives（每个主机接收的 ip 数据包数）',
    'tcp_readings_example' => 'TCP 读数，如 tcpActiveOpens（tcp 打开套接字数）',
    'udp_readings_example' => 'UDP 读数，如 udpInDatagrams（接收的 UDP 数据包数）',

    'data_queries_desc' => '用于**索引**读数的数据查询',
    'network_interfaces_example' => '网络接口，例如流量、错误、丢弃',
    'snmp_tables_example' => '其他 SNMP 表，例如用于磁盘使用的 hrStorageTable',
    'data_queries_script_example' => '您甚至可以创建数据查询作为脚本，例如查询名称服务器（索引 = 域）以获取每个域的请求',

    'export_import_desc' => '通过使用导出和导入功能，可以与他人分享您的结果。',

    // Beyond Graphs section
    'beyond_graphs_title' => '超越图形',
    'beyond_graphs_desc' => 'Cacti 不仅仅是一个图形平台，它也是一个网络运营框架。通过数十个插件和用户贡献的图形模板，使用 Cacti 框架可以做的事情是无限的。它在开源世界中已经经受了 19 年的时间考验。',

    // Graph Overview page specific
    'page_title_graph_overview' => 'Cacti - 图形概述',
    'graph_overview_title' => '图形概述',
    'graph_overview_intro' => 'Cacti 中的几乎所有内容都与**图形**有某种关系。您可以随时通过点击 `控制台 > 管理 > 图形` 菜单选项来列出所有可用的**图形**。虽然可以通过此界面手动创建图形，但新用户应该按照下一章中提供的说明在 Cacti 中创建**新图形**。',
    'graph_rrdtool_relation' => '对于熟悉 RRDtool 的用户，您会立即认识到 Cacti 中的**图形**是紧密模仿 RRDtool 图形的。这是有道理的，因为 Cacti 为 RRDtool 提供了用户友好的界面，而不需要用户了解 RRDtool 的工作原理。考虑到这一点，Cacti 中的每个**图形**都有某些设置和至少一个与之关联的**图形项目**。虽然图形设置定义了**图形**的整体属性，但**图形项目**定义了要在**图形**上表示的数据。因此，**图形项目**定义了要显示哪些数据以及应该如何显示，还定义了应该在图例上显示什么。',
    'graph_templates_benefit' => '每个**图形**和**图形项目**都有一组参数来控制**图形**的各个方面。幸运的是，通过使用**图形模板**，不需要了解每个字段的功能就可以为您的网络创建**图形**。当您准备承担创建自己的**图形模板**的任务时，手册的该部分提供了**图形**和**图形项目**的详细字段描述。',
    'graph_management_interface' => '下面，您可以看到通过转到 `控制台 > 管理 > 图形` 找到的图形管理界面的简单版本',
    'graph_management_features' => '从此界面，您可以看到**图形**的名称和 ID、源**图形模板**及其大小。在页面底部，有一个可以对**图形**执行的操作列表。这些操作相当广泛，并且随着您向 Cacti 添加**插件**而扩展。',
    'graph_edit_page' => '当您点击**图形**的名称时，您将被带到如下所示的 `图形编辑` 页面。',
    'graph_template_limitations' => '在大多数情况下，当**图形**由**图形模板**拥有时，您在此页面上无法做太多事情。但是，如果**图形**不由模板管理，如下图所示，您在使用**图形**时将有更多选项。不利用**图形模板**为您的**图形**的缺点是您必须为创建的每个**图形**重复工作。',
    'non_templated_graph_control' => '查看非模板化**图形**时，您可以完全控制**图形**画布和所有**图形项目**，就像在**图形模板**中一样，以及如下所示的图形配置。',
    'graph_settings_reference' => '**图形**的画布和配置组件中的设置将在手册的**图形模板**部分中介绍，这里不涉及。',

    // Graph related terms
    'graph_item' => '图形项目',
    'graph_items' => '图形项目',
    'graph_template_single' => '图形模板',
    'graph_edit' => '图形编辑',
    'graph_management' => '图形管理',
    'graph_configuration' => '图形配置',
    'graph_canvas' => '图形画布',
    'non_templated_graph' => '非模板化图形',
    'templated_graph' => '模板化图形',
    'new_graphs' => '新图形',
    'console_management_graphs' => '控制台 > 管理 > 图形',

    // How to Graph Your Network page specific
    'page_title_how_to_graph' => 'Cacti - 如何绘制您的网络图形',
    'how_to_graph_title' => '如何绘制您的网络图形',
    'how_to_graph_intro' => '此时，您可能意识到图形化是 Cacti 的最大优势。Cacti 具有许多强大的功能，提供复杂的图形化和数据采集，其中一些有轻微的学习曲线。但是不要让这阻止您，因为绘制您的网络图形非常简单。',
    'basic_steps_intro' => '接下来的两个部分将概述通常为大多数**设备**或**设备类型**创建**图形**所需的两个基本步骤。',
    'automation_note' => '**注意**：下面描述的过程是您创建和管理**设备**和**图形**的经典方式。但是，Cacti 现在允许您在控制台的**自动化**部分自动化许多这些任务。该主题在自动化章节中介绍。',

    // Creating a Device section
    'creating_device_title' => '创建设备',
    'creating_device_intro' => '为您的网络创建**图形**的第一步是为您想要创建**图形**的每个网络设备添加一个**设备**。**设备**包含重要的详细信息，如网络主机名、SNMP 参数和**设备类型**（又名**设备模板**）。',
    'device_management_intro' => '要在 Cacti 中管理**设备**，请点击设备菜单项。点击添加将弹出一个新的设备表单。前两个字段，描述和主机名是除了默认值之外唯一需要您输入的两个字段。如果您的主机类型在主机模板下拉菜单中定义，请确保在此处选择它。如果您只是绘制流量图，您总是可以选择"通用启用 SNMP 的主机"，或者如果您不确定，可以选择"无"。重要的是要记住，您选择的主机模板不会将您锁定到任何特定配置，它只会为该类型的主机提供更智能的默认值。',

    // Device Field Definitions
    'device_field_definitions' => '设备字段定义',
    'description_field' => '描述',
    'description_field_desc' => '此描述将显示在设备列表的第一列中。您可以在图形标题中引用它。',
    'hostname_field' => '主机名',
    'hostname_field_desc' => 'IP 地址或主机名。主机名将使用标准主机解析机制解析，例如动态名称服务（DNS）',
    'host_template_field' => '主机模板',
    'host_template_field_desc' => '主机模板是与此主机相关的图形模板列表的容器。',
    'notes_field' => '备注',
    'notes_field_desc' => '给定设备的备注。',
    'disable_host_field' => '禁用主机',
    'disable_host_field_desc' => '排除此主机被轮询。如果设备不再可用，但应保留作为参考，这特别有价值。',

    // Availability/Reachability Options
    'availability_reachability_options' => '可用性/可达性选项',
    'downed_device_detection' => '宕机设备检测',
    'detection_none' => '无',
    'detection_none_desc' => '停用宕机主机检测',
    'detection_ping_snmp' => 'PING 和 SNMP 正常运行时间',
    'detection_ping_snmp_desc' => 'Ping 然后也检查 SNMP 正常运行时间',
    'detection_ping_or_snmp' => 'PING 或 SNMP 正常运行时间',
    'detection_ping_or_snmp_desc' => 'Ping，如果成功则继续，如果不成功则检查 SNMP 正常运行时间',
    'detection_snmp_uptime' => 'SNMP 正常运行时间',
    'detection_snmp_uptime_desc' => '仅验证 SNMP 正常运行时间',
    'detection_snmp_desc' => 'SNMP 描述',
    'detection_snmp_desc_desc' => '验证 SNMP 系统描述',
    'detection_snmp_getnext' => 'SNMP GetNext',
    'detection_snmp_getnext_desc' => '验证 .1.3 之后的下一个 SNMP OID',
    'detection_ping' => 'PING',
    'detection_ping_desc' => '执行 ping 测试，见下文',

    'ping_method' => 'Ping 方法',
    'ping_method_desc' => '仅适用于 **PING 和 SNMP** 或 **PING**',
    'ping_icmp' => 'ICMP',
    'ping_icmp_desc' => '执行 ICMP 测试。需要权限',
    'ping_udp' => 'UDP',
    'ping_udp_desc' => '执行 UDP 测试',
    'ping_tcp' => 'TCP',
    'ping_tcp_desc' => '执行 TCP 测试',

    'ping_port' => 'Ping 端口',
    'ping_port_desc' => '仅适用于 UDP/TCP PING 测试类型。请在此处定义要测试的端口。确保没有防火墙拦截测试 ping。',
    'timeout_value' => '超时值',
    'timeout_value_desc' => '在此时间后，测试失败。以毫秒为单位测量。',
    'ping_retry_count' => 'Ping 重试次数',
    'ping_retry_count_desc' => 'Cacti 在失败之前尝试 ping 主机的次数。',

    // SNMP Options
    'snmp_options_title' => 'SNMP 选项',
    'snmp_version' => 'SNMP 版本',
    'snmp_version_1' => '版本 1',
    'snmp_version_1_desc' => '使用 SNMP 版本 1。请注意，此 SNMP 版本不支持 64 位计数器。',
    'snmp_version_2' => '版本 2',
    'snmp_version_2_desc' => '在大多数 SNMP 文档中称为 SNMP V2c',
    'snmp_version_3' => '版本 3',
    'snmp_version_3_desc' => 'SNMP V3，支持身份验证和加密',
    'snmp_community' => 'SNMP 团体',
    'snmp_community_desc' => '此设备的 SNMP 读取团体',
    'snmp_port' => 'SNMP 端口',
    'snmp_port_desc' => '用于 SNMP 的 UDP 端口号（默认为 161）。',
    'snmp_timeout' => 'SNMP 超时',
    'snmp_timeout_desc' => 'Cacti 等待 SNMP 响应的最大毫秒数（不适用于 php-snmp 支持）。',
    'max_oids_per_request' => '每个获取请求的最大 OID 数',
    'max_oids_per_request_desc' => '这是一个性能功能。指定在单个 SNMP 获取请求中可以获得的 OID 数量。**警告**：此功能仅在使用 Spine 时有效。**警告** 某些设备不支持大于 `1` 的值和/或如果此值太高可能报告为未知数据。',

    // Security Options for SNMP V3
    'snmp_v3_security_options' => 'SNMP V3 的安全选项',
    'snmp_username' => 'SNMP 用户名',
    'snmp_username_desc' => 'SNMP V3 `createUser` 语句或等效语句的 `用户名`',
    'snmp_password' => 'SNMP 密码',
    'snmp_password_desc' => 'SNMP V3 `createUser` 语句或等效语句的 `authpassphrase`',
    'snmp_auth_protocol' => 'SNMP 身份验证协议',
    'snmp_auth_protocol_desc' => 'SNMP V3 `createUser` 语句或等效语句的身份验证类型。选择 MD5、SHA、SHA-224、SHA-256、SHA-392 或 SHA-512。默认为 MD5。',
    'snmp_privacy_passphrase' => 'SNMP 隐私密码短语',
    'snmp_privacy_passphrase_desc' => 'SNMP V3 `createUser` 语句或等效语句的 `隐私密码短语`。',
    'snmp_privacy_protocol' => 'SNMP 隐私协议',
    'snmp_privacy_protocol_desc' => 'SNMP V3 `createUser` 语句或等效语句的 `隐私协议`。选择 DES（如果可用）、AES-128、AES-192 或 AES-256。默认为 DES。',
    'snmp_privacy_protocol_note' => '**注意** Spine 今天可能不支持 DES，因为一些 Net-SNMP 发行版已禁用它。',
    'snmp_context' => 'SNMP 上下文',
    'snmp_context_desc' => '使用基于视图的访问控制模型（VACM）时，可以在使用 `com2sec` 指令、`group` 指令和 `access` 指令将团体名称映射到安全名称时指定 SNMP 上下文。这允许定义特殊的访问模型。如果在目标的 SNMP 配置中使用此类参数，请在此处指定用于访问该目标的上下文名称。',

    // Device creation results
    'device_creation_results' => '保存新设备后，您应该被重定向回同一编辑表单，并显示一些附加信息。如果您通过提供有效的团体字符串为此主机配置了 SNMP，您应该在页面顶部看到列出的各种统计信息。如果您看到"SNMP 错误"，这表明 Cacti 和您的设备之间存在 SNMP 问题。',
    'associated_queries_templates' => '在页面底部将有两个附加框，关联数据查询和关联图形模板。如果您在上一页选择了主机模板，每个框中可能会有一些项目。如果任一框中没有列出任何内容，您需要将至少一个数据查询或图形模板与您的新设备关联，否则您将无法在下一步中创建图形。如果没有可用的图形模板或数据查询适用于您的设备，您可以检查 Cacti 模板存储库或创建自己的模板（如果当前不存在）。',

    // A Word About SNMP
    'word_about_snmp' => '关于 SNMP 的说明',
    'snmp_version_choice' => '您选择的 SNMP 版本可能对 SNMP 在 Cacti 中的工作方式产生很大影响。除非您有理由选择其他版本，否则应该对所有内容使用版本 1。如果您计划利用（并且您的设备支持）高速（64 位）计数器，您必须选择版本 2。从 Cacti 0.8.7 开始，版本 3 已完全实现。',
    'snmp_retrieval_methods' => 'Cacti 从主机检索 SNMP 信息的方式对支持哪些 SNMP 相关选项有影响。目前 Cacti 中有三种类型的 SNMP 检索方法，概述如下。',

    // SNMP Retrieval Types
    'snmp_retrieval_types' => 'SNMP 检索类型',
    'snmp_type_column' => '类型',
    'snmp_description_column' => '描述',
    'snmp_supported_options_column' => '支持的选项',
    'snmp_where_used_column' => '使用位置',
    'external_snmp' => '外部 SNMP',
    'external_snmp_desc' => '调用安装在系统上的 net-snmp snmpwalk 和 snmpget 二进制文件。',
    'external_snmp_options' => '所有 SNMP 选项',
    'external_snmp_usage' => 'Web 界面和 PHP 轮询器',
    'internal_snmp' => '内部 SNMP',
    'internal_snmp_desc' => '使用 PHP 的 SNMP 函数，这些函数在编译时链接到 `net-snmp`。',
    'internal_snmp_options' => '仅版本 1',
    'internal_snmp_usage' => 'Web 界面和 PHP 轮询器',
    'spine_snmp' => 'Spine SNMP',
    'spine_snmp_desc' => '直接链接到 `net-snmp` 并直接使用 SNMP API。',
    'spine_snmp_options' => '所有 SNMP 选项',
    'spine_snmp_usage' => 'Spine 轮询器',

    // SNMP V3 Options Explained
    'snmp_v3_options_explained' => 'SNMP V3 选项说明',
    'snmp_v3_intro' => '使用 SNMP 协议版本 3 时，SNMP 支持身份验证和加密功能，称为**基于视图的访问控制模型（VACM）**。这要求相关目标设备支持并配置为使用 SNMP V3。通常，V3 选项的配置取决于目标类型。以下引自 `man snmpd.conf` 关于用户定义的内容',
    'snmp_v3_users_title' => 'SNMPv3 用户',
    'snmp_v3_createuser_syntax' => 'createUser [-e ENGINEID] username (MD5|SHA) authpassphrase [DES|AES] [privpassphrase]',
    'snmp_v3_auth_types' => 'MD5 和 SHA 是要使用的身份验证类型。DES 和 AES 是要使用的隐私协议。如果未指定隐私密码短语，则假定它与身份验证密码短语相同。请注意，创建的用户将无用，除非它们也添加到上述 VACM 访问控制表中。',
    'snmp_v3_openssl_note' => 'SHA 身份验证和 DES/AES 隐私需要安装 OpenSSL 并且代理使用 OpenSSL 支持构建。MD5 身份验证可以在没有 OpenSSL 的情况下使用。',
    'snmp_v3_passphrase_warning' => '警告：最小密码短语长度为 8 个字符。',

    // VACM Configuration
    'vacm_configuration' => 'VACM 配置',
    'vacm_intro' => 'VACM 的完全灵活性可通过四个配置指令实现 - com2sec、group、view 和 access。这些提供了对底层 VACM 表的直接配置。',
    'vacm_com2sec' => 'com2sec [-Cn CONTEXT] SECNAME SOURCE COMMUNITY',
    'vacm_com2sec_desc' => '将 SNMPv1 或 SNMPv2c 团体字符串映射到安全名称 - 可以是来自特定范围的源地址，也可以是全局的（"default"）。受限源可以是特定的主机名（或地址），或子网 - 表示为 IP/MASK（例如 10.10.10.0/255.255.255.0），或 IP/BITS（例如 10.10.10.0/24），或 IPv6 等效项。',

    // Creating the Graphs
    'creating_graphs_title' => '创建图形',
    'creating_graphs_intro' => '现在您已经创建了一些设备，是时候为这些设备创建图形了。要做到这一点，请在创建标题下选择新图形菜单选项。如果您仍在设备编辑屏幕，请选择为此主机创建图形，以查看类似于下图所示的屏幕。',
    'new_graphs_concept' => '包含每个设备的下拉菜单应用于选择您想要为其创建新图形的主机。此页面的基本概念很简单，在您想要为其创建图形的每一行中放置一个复选标记，然后点击创建。',
    'data_query_considerations' => '如果您从"数据查询"框内创建图形，有几个额外的事项需要记住。首先是您可能会遇到上图所示的情况，即"SNMP - 接口统计"数据查询。如果发生这种情况，您可能需要查阅有关调试数据查询的部分，以了解为什么您的数据查询没有返回任何结果。此外，您可能会在某些数据查询框下看到"选择图形类型"下拉框。更改此下拉框的值会影响点击创建按钮后 Cacti 将制作的图形类型。Cacti 仅在有多种类型可供选择时显示此下拉框，因此在所有情况下可能不会显示。',
    'graph_creation_final_step' => '一旦您选择了要创建的图形，只需点击页面底部的创建按钮。您将被带到一个新页面，允许您指定有关即将创建的图形的附加信息。您只会看到这里不是每个模板一部分的字段，否则值会自动来自模板。当此页面上的所有值看起来正确时，最后一次点击创建按钮以实际创建您的图形。',
    'graph_management_note' => '如果您想在创建图形后编辑或删除它们，请使用菜单上的图形管理项。同样，数据源菜单项允许您管理 Cacti 中的数据源。',

    // Viewing Graphs page specific
    'page_title_viewing_graphs' => 'Cacti - 查看图形',
    'viewing_graphs_title' => '查看图形',

    // Background section
    'background_title' => '背景',
    'background_intro' => 'Cacti 于 2001 年由 Ian Berry 首次发明时，他的愿景是使其成为为网络、站点和数据中心运营空间的人员查看和渲染网络监控**图形**的最快和最简单的方式。因此，从一开始它的重点就是渲染一件事，**图形**。因此，Cacti 系统上的第二个**顶部标签**是**图形**标签。',

    // The Graphs Top Tab section
    'graphs_top_tab_title' => '图形顶部标签',
    'graphs_top_tab_intro' => '**图形****顶部标签**有几种个性。它们包括：',
    'tree_view_title' => '树状视图',
    'tree_view_description' => '允许 Cacti 用户以分层**树**的形式查看**图形**。这些**树**通常由 Cacti 管理员构建，并在**用户**或**用户组**级别进行控制。',
    'preview_view_title' => '预览视图',
    'preview_view_description' => '**预览视图**提供 Cacti 用户有权访问的所有**图形**的视图。提供**表格过滤器**来约束返回到页面的**图形**列表。',
    'list_view_title' => '列表视图',
    'list_view_description' => '**列表视图**允许 Cacti 用户通过允许他们从各种页面选择图形，然后最终从**预览视图**查看这些页面来创建自己的**预览页面**。',

    'graph_view_personalities' => '这些各种个性在 Cacti 中的显示方式根据您的主题有所不同。查看下面的两个图像，了解如何导航到各种**图形视图**模式。',
    'classic_theme_layout' => '在第一个图像中，我们看到**图形视图**选项向最终用户显示的方式。这是经典、现代和深色主题的布局。',
    'alternate_theme_layout' => '在第二个图像中，您可以看到**图形视图**页面对于 Paw、Paper-Plane 和 Sunrise 主题的用户的显示方式。',

    // Graph Manipulation and Options section
    'graph_manipulation_title' => '图形操作和选项',
    'graph_manipulation_intro' => '一旦您可以查看**图形**，将有一个过滤器面板，为您提供多个选项来限制您对它们的查看。下面，您可以看到该过滤器面板的图像。',
    'filter_panel_options' => '从此子面板，您可以执行以下操作：',
    'search_regex' => '按正则表达式搜索',
    'select_graph_templates' => '选择一个到多个，或所有**图形模板**来查看',
    'graphs_per_page' => '指定每页图形数',
    'display_columns' => '指定要显示的列数',
    'view_thumbnails_or_full' => '查看无图例缩略图或带图例的完整图形',
    'preset_timespans' => '设置各种预设时间跨度，或选择时间范围',
    'shift_time' => '按移位时间跨度向前或向后移动时间',

    'save_defaults' => '一旦您从列、缩略图和每页图形设置中获得您喜欢的过滤器，如果您有正确的权限，您可以按 `保存` 按钮，并为您的下次登录保存这些默认值。',
    'action_icons_intro' => '再次取决于权限，在**图形**的右侧，您将找到许多操作图标，允许您对**图形**进行操作',
    'action_icons_example' => '如果您安装了 **Thold** 和 **QuickTree** **插件**，下面的图像显示了可能的样子。',
    'action_icons_description' => '从上到下，图形操作图标执行以下操作。',

    // Graph Action Icons table
    'action_icon_name_column' => '名称',
    'action_icon_description_column' => '描述',
    'graph_details_icon' => '图形详细信息',
    'graph_details_desc' => '允许您执行精确缩放、查看 RRDtool 调试信息并执行图形数据的 CSV 导出。',
    'csv_export_icon' => 'CSV 导出',
    'csv_export_desc' => '允许您直接 CSV 导出图形数据',
    'realtime_view_icon' => '实时视图',
    'realtime_view_desc' => '允许您以低至 1 秒粒度查看图形，可以就地查看或在弹出窗口中查看',
    'spike_kill_icon' => '峰值清除',
    'spike_kill_desc' => '允许您清除图形中的峰值和间隙',
    'create_threshold_icon' => '创建阈值',
    'create_threshold_desc' => '为图形创建阈值',
    'add_to_quicktree_icon' => '添加到快速树',
    'add_to_quicktree_desc' => '允许您通过简单地在图形页面周围工具来选择图形添加到树中。',

    // Graph Zooming section
    'graph_zooming_title' => '图形缩放',
    'graph_zooming_intro' => 'Cacti 还内置了强大的图形缩放界面。您可以通过简单地在图形区域右键单击来发现它允许您做什么。缩放时，您将缩放页面上的所有**图形**。它非常强大。',
    'zoom_options_note' => '缩放菜单有许多选项。与其在这里解释它们，不如自己尝试一下。',

    // Common graph viewing terms
    'graph_view_modes' => '图形查看模式',
    'filter_panel' => '过滤器面板',
    'action_icons' => '操作图标',
    'zoom_interface' => '缩放界面',
    'context_menu' => '上下文菜单',
    'time_range' => '时间范围',
    'time_span' => '时间跨度',
    'thumbnails' => '缩略图',
    'legends' => '图例',
    'precision_zooming' => '精确缩放',
    'rrdtool_debug' => 'RRDtool 调试',
    'graph_data' => '图形数据',
    'granularity' => '粒度',
    'popup_window' => '弹出窗口',
    'spikes_and_gaps' => '峰值和间隙',
    'threshold' => '阈值',
    'quicktree' => '快速树'
);
?>
