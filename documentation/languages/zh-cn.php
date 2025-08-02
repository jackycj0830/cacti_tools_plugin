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
    'quicktree' => '快速树',

    // Devices page specific
    'page_title_devices' => 'Cacti - 设备管理',
    'devices_title' => '设备管理',
    'devices_intro' => '本节将描述 Cacti 中的**设备**管理。',
    'devices_adding_methods' => '向 Cacti 添加**设备**可以通过几种不同的方式完成，可以通过 Web GUI、Cacti 的自动化或命令行界面 (CLI)。',

    // Web GUI Option section
    'web_gui_option_title' => 'Web GUI 选项',
    'web_gui_intro' => '要通过 Web GUI 添加设备，首先点击 `控制台 > 管理 > 设备`，您将看到下面的设备控制台窗口，如果有的话，它将显示现有设备',
    'add_device_button_desc' => '您现在将选择右上角的 +',
    'add_device_screen_desc' => '一旦您选择了 +（也称为添加设备按钮），您将看到下面的屏幕，它将要求您提供设备特定信息',
    'device_important_info' => '此窗口中需要一些关于设备的最重要信息，包括',

    // Device fields
    'device_description_field' => '描述',
    'device_description_desc' => '默认情况下将出现在**图形**上的名称',
    'device_ip_hostname_field' => 'IP/主机名',
    'device_ip_hostname_desc' => '实际**设备**的 DNS 或 IP 地址。IPv6 地址插入括号中（例如：[2001:abcd:1234::1]）',
    'device_poller_association_field' => '轮询器关联',
    'device_poller_association_desc' => '定义哪个**数据收集器**负责拉取关于**设备**的信息',
    'device_template_field' => '设备模板',
    'device_template_desc' => 'Cisco、Net-SNMP、Linux 等 - 包含所有要绘制图形的**图形模板**和**数据查询**的 Cacti 对象',
    'device_site_location_field' => '站点、位置',
    'device_site_location_desc' => '对于执行元查询或在 Cacti **图形树**上进行站点级图形组织非常重要',
    'device_availability_field' => '可用性/可达性',
    'device_availability_desc' => '描述**设备**超时和可用性方法的设置。',
    'device_snmp_info_field' => 'SNMP 信息',
    'device_snmp_info_desc' => '连接到**设备**的 SNMP 凭据',
    'device_notes_field' => '设备备注',
    'device_notes_desc' => '关于**设备**的任意非结构化信息',

    'device_save_and_create_graphs' => 'Cacti 需要这些基本信息才能监控设备，输入后，点击右下角的保存。创建设备后，您需要通过点击右上角的**为此设备创建图形**来为设备添加图形。',

    // Availability/Reachability Settings section
    'availability_reachability_settings_title' => '可用性/可达性设置',
    'availability_intro' => 'Cacti 更喜欢使用简单网络管理协议 (SNMP) 与**设备**通信。因此，在创建**设备**时，您需要提供 SNMP 凭据以获取关于**设备**的信息，以便从中收集数据。在 Cacti 查询**设备**数据之前，它首先验证**设备**是否正常运行并响应。这样做时，您有几个选项。它们包括：',

    // Availability options
    'availability_none' => '无',
    'availability_none_desc' => '始终假设设备正常运行。这通常保留给没有状态的**设备**对象。',
    'availability_snmp_uptime' => 'SNMP 正常运行时间',
    'availability_snmp_uptime_desc' => '查询 SNMP 正常运行时间实例 OID',
    'availability_ping_snmp' => 'Ping 和 SNMP 正常运行时间',
    'availability_ping_snmp_desc' => 'Ping 设备但也检查 SNMP 正常运行时间实例 OID',
    'availability_ping' => 'Ping',
    'availability_ping_desc' => 'ICMP、端口上的 TCP 或端口上的 UDP。较新版本有一个额外的方法 TCP Ping 关闭。即使 tcp ping 返回关闭，设备也被认为是正常的',
    'availability_ping_or_snmp' => 'Ping 或 SNMP 正常运行时间',
    'availability_ping_or_snmp_desc' => '只需要一个工作即可让 Cacti 收集数据',
    'availability_snmp_desc' => 'SNMP 描述',
    'availability_snmp_desc_desc' => '在 SNMP 正常运行时间 OID 不可用的情况下查询 SNMP sysDescription',
    'availability_snmp_getnext' => 'SNMP GetNext',
    'availability_snmp_getnext_desc' => '查询**设备**的 OID 树中第一个可用的 OID，用于具有有限 SNMP 支持的某些设备。',

    // SNMP Credentials section
    'snmp_credentials_title' => 'SNMP 凭据',
    'snmp_credentials_intro' => '在提供 SNMP 凭据时，Cacti 目前支持以下版本：',
    'snmp_v1_title' => '版本 1',
    'snmp_v1_desc' => '很少再使用。保留给非常旧的硬件',
    'snmp_v2_title' => '版本 2',
    'snmp_v2_desc' => '仍然非常流行，支持 64 位计数器，除了在 Windows 上',
    'snmp_v3_title' => '版本 3',
    'snmp_v3_desc' => '提供支持，但目前有限制。如果您使用 SNMPv3 的高级设置，如 SHA224+ 或 AES192+，您必须卸载 php-snmp 模块（如果在 php 中使用），并改用 Net-SNMP 二进制文件。',
    'snmp_credentials_warning' => '在提供 SNMP 凭据时，如果您根据指定的 SNMP 版本和 SNMP 安全级别提供了不完整的信息，Cacti 将警告您。',

    // Additional Important Options section
    'additional_important_options_title' => '其他重要选项',
    'additional_options_intro' => '在开始使用 Cacti 之前，您应该注意一些其他选项。它们包括以下内容：',
    'device_threads_option' => '设备线程',
    'device_threads_desc' => '如果您的设备很远，并且可以容忍多个线程查询信息，您可以增加此数字以减少收集所有信息所需的时间。',
    'max_oids_option' => '每个获取请求的最大 OID 数',
    'max_oids_desc' => '也称为 MaxOID，此 SNMP 选项将允许 SNMP 客户端在每个获取请求中收集更多指标。请记住，您使此数字越高，SNMP 响应可能需要的时间就越长。因此，随着数字变大，您必须对 SNMP 超时敏感。由于默认情况下 SNMP 通常通过 UDP 收集，您还将受到响应数量的限制，这取决于您到达设备需要穿越多少路由器或 VPN。当穿越 VPN 连接时，许多 VPN 将 MTU 限制在大约 500 字节，这将显著限制最大 OID 的大小。在某些情况下，当您的设备从延迟角度来看很远，或者您必须穿越 VPN 进行通信时，最好部署**远程数据收集器**。',
    'external_id_option' => '外部 ID',
    'external_id_desc' => '此字段通常用于**设备**的资产跟踪信息，但其使用完全取决于系统管理员。',

    // Plugin Behavior section
    'plugin_behavior_title' => '插件行为',
    'plugin_behavior_intro' => '许多 Cacti 插件可以并且确实向 Cacti 中的设备表添加额外的列。根据您安装的插件，您将找到可以提供的关于设备的其他信息，包括以下内容：',
    'notification_settings_option' => '通知设置',
    'notification_settings_desc' => '当**设备**更改状态时通知谁',
    'criticality_option' => '关键性',
    'criticality_desc' => '设备有多重要',
    'failure_recovery_option' => '故障和恢复计数',
    'failure_recovery_desc' => '设备被视为真正宕机需要多长时间。',
    'ping_thresholds_option' => 'Ping 阈值',
    'ping_thresholds_desc' => '到达设备时什么 RTL 被认为是坏的',

    // CLI section
    'cli_creation_title' => '通过 CLI 脚本创建设备',
    'cli_creation_intro' => '您还可以使用位于 /cactidir/cli/ 的 CLI 脚本创建设备',
    'cli_usage_example' => '使用最少信息添加设备看起来像这样',
    'cli_success_message' => '添加测试 (192.168.1.15) 作为 "Cacti 统计" 使用 SNMP v3 与社区 "public"\n成功 - 新设备 ID：(45)',

    // Common device management terms
    'device_console' => '设备控制台',
    'add_device_button' => '添加设备按钮',
    'create_graphs_for_device' => '为此设备创建图形',
    'device_management' => '设备管理',
    'data_collector' => '数据收集器',
    'remote_data_collector' => '远程数据收集器',
    'asset_tracking' => '资产跟踪',
    'system_administrator' => '系统管理员',

    // Sites page specific
    'page_title_sites' => 'Cacti - 站点管理',
    'sites_title' => '站点管理',
    'sites_intro' => '本节将描述 Cacti 中的**站点**管理。',
    'sites_purpose' => 'Cacti 中的站点可用于将公司的不同部分与相应的位置设备分开。例如，您可以有一个名为 **123 主街** 的站点，您可以将物理位置中的所有设备关联到 Cacti 站点。这也可以是客户站点或数据中心位置',
    'sites_page_image_desc' => 'Cacti 站点页面',
    'sites_attribute_data' => '以下是您可以为站点/位置输入的一些属性数据示例',
    'sites_create_instruction' => '为站点输入适当的信息，然后点击右下方的创建',
    'sites_add_image_desc' => 'cacti 添加站点',
    'sites_device_association' => '创建站点后，在手动创建设备时，您现在可以将设备关联到站点',
    'sites_device_site_image_desc' => 'cacti 添加设备站点',
    'sites_automation_association' => '您还可以通过自动化将发现的设备关联到特定站点。',
    'sites_automation_image_desc' => 'cacti 站点自动化',

    // Common site management terms
    'site_management' => '站点管理',
    'physical_location' => '物理位置',
    'customer_site' => '客户站点',
    'data_center_location' => '数据中心位置',
    'attribute_data' => '属性数据',
    'device_association' => '设备关联',
    'discovered_devices' => '发现的设备',
    'automation_association' => '自动化关联',

    // Trees page specific
    'page_title_trees' => 'Cacti - Cacti 树',
    'trees_title' => 'Cacti 树',
    'trees_section_title' => '树',
    'trees_intro' => '**树**可以被认为是组织图形的分层方式。每个**树**由零个或多个分支组成，这些分支包含叶节点，如**图形**、**设备**和**站点**。这是组织**图形**的一种非常强大的方式。',
    'trees_current_setup' => '下面我们可以看到我们在 Cacti 服务器上设置的当前**树**。要到达此屏幕，请点击 `控制台 > 管理 > 树`。',
    'trees_add_remove' => '从此页面您可以根据需要添加或删除**树**。',
    'tree_management_page_desc' => '树管理页面',
    'trees_graph_view' => '下面是**树**在**图形视图**中的显示方式。我们可以看到正在监控的**设备** - 点击此**设备**将导致看到为**设备**生成的所有**图形**数据。',
    'tree_view_desc' => '树视图',

    // Creating a Tree section
    'creating_tree_title' => '创建树',
    'creating_tree_intro' => '要创建新树，只需点击右上角的添加按钮 (+) 并为您的**树**输入名称。创建树后，您将看到下面的页面，您可以在其中向**树**添加**设备**。',
    'tree_options_desc' => '树选项',
    'tree_device_adding' => '要向新树添加设备，只需将可用设备拖到树中，它将被添加到树中。Cacti 目前支持四种 `排序类型`，可以继承，或留给作者定义继承和在什么级别。请参见下面的图像，了解如何完成树排序的可视化表示。',
    'tree_sorting_desc' => '树排序',

    // Tree Sorting Type Definitions table
    'tree_sorting_table_title' => '表 8-1. 树排序类型定义',
    'tree_field_column' => '字段',
    'tree_value_column' => '值',
    'tree_description_column' => '描述',
    'tree_name_field' => '名称',
    'tree_name_value' => '树条目的名称。',
    'tree_name_desc' => '所有树本身的排序顺序是',
    'tree_alphabetical_note' => '始终按字母顺序',
    'tree_sorting_type_field' => '排序类型',
    'tree_manual_ordering' => '手动排序（无排序）',
    'tree_manual_ordering_value' => 'Y',
    'tree_manual_ordering_desc' => '您可以随意更改序列',
    'tree_alphabetical_ordering' => '字母排序',
    'tree_alphabetical_value' => '1, Ab, ab',
    'tree_alphabetical_desc' => '所有子树都按字母顺序排序，',
    'tree_alphabetical_note_desc' => '除非另有说明（您可以在子树标签处更改排序选项）',
    'tree_natural_ordering' => '自然排序',
    'tree_natural_value' => 'ab1, ab2, ab7, ab10, ab20',
    'tree_natural_desc' => 'N/A',
    'tree_numeric_ordering' => '数字排序',
    'tree_numeric_value' => '01, 02, 4, 04',
    'tree_numeric_desc' => '数字排序时不考虑前导零',
    'tree_numeric_note' => '数字排序时',

    // Tree management and editing
    'tree_publishing' => '最终用户将无法查看**树**或其图形，直到您发布它。要编辑**树**，您需要锁定它供您使用。锁定旨在防止多个用户同时编辑**树**。',
    'tree_drag_drop' => '当树被锁定时，您可以将**站点**、**设备**和**图形**拖放到树菜单上。要添加"根分支"，只需按下按钮即可，一旦您有了根分支，您可以右键单击它们在树上创建子分支。',
    'tree_site_interaction' => '当您单击**站点**时，与该**站点**关联的**设备**和**图形**应该出现在它们各自的部分中。您还可以在各个部分上方的搜索字段中输入以深入了解它们。您还可以在部分内的对象上进行 shift-click 和 control-click，以一次拖放多个对象。',
    'tree_unlock_reminder' => '在完成编辑会话之前，不要忘记解锁您的**树**。',

    // Common tree management terms
    'tree_management' => '树管理',
    'hierarchical_organization' => '分层组织',
    'leaf_nodes' => '叶节点',
    'root_branch' => '根分支',
    'sub_branches' => '子分支',
    'sort_types' => '排序类型',
    'manual_ordering' => '手动排序',
    'alphabetical_ordering' => '字母排序',
    'natural_ordering' => '自然排序',
    'numeric_ordering' => '数字排序',
    'tree_locking' => '树锁定',
    'tree_publishing' => '树发布',
    'drag_and_drop' => '拖放',

    // Graphs page specific
    'page_title_graphs' => 'Cacti - 图形管理',
    'graphs_title' => '图形管理',
    'graphs_intro' => '本节将描述 Cacti 中的**图形**管理。',
    'graphs_console_view' => 'Cacti 具有通过控制台查看每个设备图形的功能。这允许管理员查看附加到特定设备的图形。您还可以按图形类型搜索。下面我们搜索与本地 linux 服务器关联的图形',
    'graph_management_image_desc' => '图形管理',
    'graphs_menu_description' => '点击列表中的一个图形会显示下面的菜单。从此菜单中，您可以在特定图形上启用调试，还可以更改图形模板等',
    'graph_management_click_desc' => '图形管理点击',

    // Modifying the graph template section
    'modifying_graph_template_title' => '修改图形模板',
    'modifying_graph_template_desc' => 'Cacti 允许您更改图形模板的许多方面。您可以更改参数，如图形的标题以及图形的大小。这些更改将推送到图形模板，因此使用该模板的其他设备也将被更新。',
    'graph_template_options_desc' => '图形模板选项',

    // Common graph management terms
    'graph_management_console' => '图形管理控制台',
    'graph_debugging' => '图形调试',
    'graph_template_modification' => '图形模板修改',
    'graph_parameters' => '图形参数',
    'graph_title' => '图形标题',
    'graph_size' => '图形大小',
    'template_updates' => '模板更新',

    // Data Sources page specific
    'page_title_data_sources' => 'Cacti - 数据源管理',
    'data_sources_title' => '数据源管理',
    'data_sources_intro' => 'Cacti 中的数据源是 Cacti 将从设备收集的数据点。以下是可用于图形化的不同源的示例，尽管这只是可实现内容的表面：',
    'data_source_ping_example' => '通过 ping 监控设备通常算作 1 个数据源。',
    'data_source_switch_example' => '一个 24 端口交换机，您通过 snmp 轮询设备并绘制所有端口的图形，那么将有 24 个数据源',
    'data_source_note' => '**注意**：如果您添加更多基于原始**数据源**的图形，那不会算作另一个**数据源**，因为它使用已经存在的源。',
    'data_source_example_explanation' => '例如，如果您有一个 24 端口交换机，为每个接口创建一个**输入/输出位**图形，然后为每个接口添加**带 95% 百分位的输入/输出位**，您仍然只有 24 个数据源。',
    'data_source_resource_importance' => '掌握您拥有的数据源数量很重要，因为数据源越多，您需要为服务器分配的资源就越多。',
    'data_source_device_view' => '您可以通过转到管理然后点击设备来查看与单个设备关联的数据源数量。',
    'device_datasources_image_desc' => '设备数据源',
    'data_source_total_view' => '您还可以通过检查系统上的轮询器统计信息来查看数据源的总数。点击日志选项卡并按统计信息过滤，查找下面的消息',
    'data_source_stats_example' => '2019/05/24 17:21:11 - 系统统计：时间:9.5913 方法:spine 进程:2 线程:2 主机:14 每进程主机:7 数据源:162 已处理RRD:117',
    'data_source_stats_explanation' => '此输出告诉我们系统上有 162 个数据源。',

    // Storage considerations section
    'storage_considerations_title' => '存储考虑和数据源',
    'storage_considerations_intro' => '系统上的数据源数量对您需要的存储量有影响。您还需要考虑轮询设备的速率。例如 1 分钟或 5 分钟轮询',
    'storage_per_datasource' => '以下是您可以期望每个数据源消耗的大致存储量',

    // Storage table headers
    'polling_time_column' => '轮询时间',
    'retention_column' => '保留',
    'file_size_column' => '文件大小',

    // Storage table data
    'thirty_second' => '30 秒',
    'one_minute' => '1 分钟',
    'five_minute' => '5 分钟',
    'daily' => '每日',
    'weekly' => '每周',
    'monthly' => '每月',
    'yearly' => '每年',

    // Common data source terms
    'data_source_management' => '数据源管理',
    'data_collection_points' => '数据收集点',
    'polling_rate' => '轮询速率',
    'storage_requirements' => '存储要求',
    'poller_statistics' => '轮询器统计',
    'system_resources' => '系统资源',

    // Aggregates page specific
    'page_title_aggregates' => 'Cacti - 聚合图形',
    'aggregates_title' => '聚合图形',
    'aggregates_intro' => '本节将描述 Cacti 中的**聚合图形**。',

    // Common aggregate terms
    'aggregate_graphs' => '聚合图形',
    'aggregation' => '聚合',
    'graph_aggregation' => '图形聚合',

    // Data Collectors page specific
    'page_title_data_collectors' => 'Cacti - 数据收集器',
    'data_collectors_title' => '数据收集器',
    'data_collector_background_title' => '数据收集器背景',
    'data_collectors_intro' => 'Cacti 可以支持一个到多个**数据收集器**。有两种类型的**数据收集器**：',
    'main_data_collector' => '**主数据收集器** - 这本质上是您的核心 Cacti 服务器和数据库。**主数据收集器**也被称为**主服务器**。',
    'remote_data_collector' => '**远程数据收集器** - 这些数据收集器位于远程位置，或者由于防火墙或安全策略而无法访问设备的地方。**远程数据收集器**也被称为**远程轮询器**。',
    'remote_collector_design' => '由于 Cacti **远程数据收集器**的设计，远程站点的某人实际上可以登录到该**数据收集器**并与其交互，就像他们的**数据收集器**是**主数据收集器**一样。此外，如果由于某种原因**主数据收集器**变得不可用（例如由于 WAN 中断），它管理的**设备**的数据将在本地缓存，直到**主数据收集器**再次可达。',
    'collector_normalization' => '一旦**主数据收集器**变得可达，**远程数据收集器**将把其缓存刷新回**主数据收集器**，系统将恢复正常。因此，这通常被认为是更高可用性（HA）的设计。',
    'enterprise_architecture' => '一个好的 Cacti 企业架构将包括三个**主数据收集器**，其 cactid systemd 服务由 keepalived 管理，使用 GlusterFS 作为 Web 服务器、日志和 RRD 文件的完全复制文件系统，使用 MariaDB Galera 作为完全容错的数据库服务器。',
    'load_balancing' => '然后，使用 keepalived 到负载均衡器，您可以在所有三个**主数据收集器**之间负载均衡连接，使用 MariaDB Galera 数据库来维护登录会话数据。有许多关于设置和使用 MariaDB Galera 以及来自 Citrix 和其他公司的 HAProxy 或负载均衡器的好文章，以将读写流量定向到正确的 Galera 实例服务器。底线是 Cacti 今天提供了拥有高可用性（HA）设置的机会。',
    'ha_setup_note' => '该 HA 设置不会在本章中涵盖，但可能会在以后的日期包含。',
    'boost_module_requirement' => '当使用多个**数据收集器**时，Cacti 需要使用 `boost` 模块，该模块现在包含在主 Cacti 包中。因此，如果您计划部署多个**数据收集器**，您应该熟悉其使用以及为什么它对 HA 设计至关重要。',
    'network_requirements' => '为了让**远程数据收集器**与**主数据收集器**一起工作，**远程数据收集器**必须能够通过 https 和 MySQL 协议以双向方式与**主数据收集器**通信。因此，只需要打开两个端口即可充分利用 Cacti 中的多个**数据收集器**架构。',

    // Data Collector User Interface section
    'data_collector_ui_title' => '数据收集器用户界面',
    'data_collector_ui_description' => '下面的图像显示了当前在线收集器（又名轮询器）。在此页面上，我们可以看到当前、平均和最大数据收集时间，使用的**数据收集器**进程和线程，**设备**的数量以及这些**设备**正在轮询什么。操作下拉菜单允许您启用、禁用和删除**远程数据收集器**。那里还有一个 `完全同步` 选项。`完全同步` 选项将把关键的 Cacti 表复制到选定的**远程数据收集器**，用于身份验证、全局设置等。',
    'full_sync_usage' => '在当前的 Cacti 设计中，您不应该经常执行 `完全同步`。它主要用于在中断后将用户数据库和全局设置推送到远程，如果在该中断期间有数据库更改。',
    'data_collectors_image_desc' => '数据收集器',
    'main_collector_description' => '**主数据收集器**驻留在中央 Cacti 服务器上。它还充当主**数据收集器**，为整个系统执行关键维护操作。',
    'main_collector_edit_description' => '在下面的编辑页面中，您可以看到编辑**主数据收集器**时可用的选项。重要的是使用的主机名可以被**远程数据收集器**解析。',
    'data_collectors_edit_main_desc' => '数据收集器编辑主',
    'remote_collector_edit_description' => '在下面的图像中编辑**远程数据收集器**时，您可以看到它与**主数据收集器**共享许多设置，另外还有 `时区` 设置和 MySQL/MariaDB 凭据以及 `测试连接` 按钮。通常，这些设置仅在 Cacti 的初始设置期间使用，之后仅用于诊断。',
    'data_collectors_edit_remote_desc' => '数据收集器编辑远程',
    'data_collectors_edit_remote_test_desc' => '数据收集器编辑远程连接测试',

    // Setup section
    'setup_main_collector_title' => '设置主数据收集器以接受远程连接',
    'mysql_config_changes' => '我们需要对 MySQL 配置进行一些配置更改，以允许**远程数据收集器**与**主数据收集器**通信。',
    'mysql_grant_commands' => 'mysql -u root mysql -e "GRANT ALL ON cacti.* TO cactidb@<远程轮询器主机的ip>  IDENTIFIED BY \'password\';"
mysql -u root mysql -e "GRANT SELECT ON mysql.time_zone_name TO cacti@<远程轮询器主机的ip> IDENTIFIED BY \'password\';"',
    'remote_config_setup' => '接下来设置位于 `<path_cacti>/include/config.php` 的**远程数据收集器** config.php，包含远程数据库详细信息和凭据。通常，您不必作为**远程数据收集器**直接维护的一部分来执行此操作，**远程数据收集器**安装过程将强制您采取这些步骤来完成安装。但是，这里提供它作为参考，以便您了解该过程。',
    'remote_config_example' => '#$rdatabase_type     = \'mysql\';
#$rdatabase_default  = \'cacti\';
#$rdatabase_hostname = \'localhost\'; <<< 主服务器的IP/主机名
#$rdatabase_username = \'cactiuser\';
#$rdatabase_password = \'cactiuser\';
#$rdatabase_port     = \'3306\';
#$rdatabase_retries  = 5;
#$rdatabase_ssl      = false;
#$rdatabase_ssl_key  = \'\';
#$rdatabase_ssl_cert = \'\';
#$rdatabase_ssl_ca   = \'\';',
    'remote_install_instruction' => '您现在需要在远程服务器上安装 Cacti，选择如下所示的**新远程轮询器**安装选项。',
    'remote_setup_image_desc' => '远程数据收集器设置',

    // Common data collector terms
    'data_collector_management' => '数据收集器管理',
    'main_data_collector_term' => '主数据收集器',
    'remote_data_collector_term' => '远程数据收集器',
    'primary_server' => '主服务器',
    'remote_pollers' => '远程轮询器',
    'highly_available' => '高可用性',
    'full_sync' => '完全同步',
    'boost_module' => 'Boost 模块',
    'enterprise_architecture' => '企业架构',

    // Spine page specific
    'page_title_spine' => 'Cacti - Spine',
    'spine_title' => 'Spine',
    'spine_intro' => 'Spine 是 `cmd.php` 的快速替代品。它用 C 语言编写，以确保设备轮询的最佳性能，并且是多线程的。预期轮询时间会有数量级的减少。例如，在配备 4 GB RAM 和标准本地磁盘的双 XEON 系统上，约 20,000 个数据源的轮询时间远少于 60 秒是可以实现的。',
    'spine_warning' => '使用 Spine 时，不要更改 crontab 或 systemd 设置！始终使用 poller.php 与 crontab 或 cactid.php 与 systemd！',
    'spine_activation' => '要激活 Spine 而不是 cmd.php，请访问 `控制台 > 配置 > 设置 > 轮询器` 并选择 spine 并保存为 `轮询器类型`。如果它没有显示为可用的 `轮询器类型`，这意味着它要么没有安装，要么它的路径没有在设置中的 `路径` 选项卡中定义。',
    'spine_testing' => '保存后，poller.php 将在所有后续轮询周期中使用 Spine。在进行此更改之前，请确保 Spine 使用以下测试从命令行正常运行：',
    'spine_test_command' => 'cd /usr/local/spine/bin
./spine -R -V 3 -S',
    'spine_output_note' => '您应该收到相当多的输出，具体取决于系统的大小。要增加线程数和并发进程数，您必须在 `控制台 > 数据收集 > 数据收集器` 下编辑数据收集器时修改设置。',
    'spine_performance' => '虽然 Spine 真的很快，但选择正确的设置将确保使用所有处理器资源。最大并发轮询器进程的必需设置是可用于 Spine 的 CPU 核心数的 1-2 倍。',
    'spine_mysql_connections' => '使用 spine 时，您必须对 MySQL 或 MariaDB 可用的连接数敏感。在 `控制台 > 实用程序 > 系统实用程序 > 常规` 下，Cacti 将为 MySQL/MariaDB 提供推荐的 `max_connection`。',

    // Spine parameters tables
    'spine_system_params_title' => '表 15-1. 在系统级别维护的 Spine 参数',
    'spine_collector_params_title' => '表 15-2. 在数据收集器级别维护的 Spine 参数',
    'spine_device_params_title' => '表 15-3. 在设备级别维护的 Spine 参数',
    'spine_param_name' => '名称',
    'spine_param_description' => '描述',

    // System level parameters
    'spine_script_timeout_name' => '脚本和脚本服务器超时值',
    'spine_script_timeout_desc' => 'Spine 等待脚本完成的最长时间，以秒为单位。如果脚本服务器脚本由于超时条件而终止，则输入到 RRD 文件中的值将为 NaN',

    // Data collector level parameters
    'spine_max_threads_name' => '每个进程的最大线程数',
    'spine_max_threads_desc' => '每个进程允许的最大线程数。使用 Spine 时使用更高的数字将提高性能。必需设置为 10-15。超过 50 的值通常是不合理的，可能会降低性能而不是提高性能。',
    'spine_script_servers_name' => 'PHP 脚本服务器数量',
    'spine_script_servers_desc' => '每个 Spine 进程运行的并发脚本服务器进程数。接受 1 到 10 之间的设置。脚本服务器将预加载 PHP 环境。然后，脚本服务器脚本被包含到该环境中，以节省重新加载 PHP 和重新解释每次调用的二进制文件的开销。',

    // Device level parameters
    'spine_snmp_oids_name' => '每个 SNMP Get 请求的最大 SNMP OID 数',
    'spine_snmp_oids_desc' => '每个 SNMP 请求发出的最大 SNMP get OID 数。增加此值可提高慢速链路上的轮询器性能。最大值为 60 个 OID，但该值高度依赖于到远程设备的链路的 MTU。在某些情况下，使用**远程数据收集器**对轮询远程**设备**更有效。此外，某些**设备类型**不处理大型 SNMP OID get 请求。最好进行实验，直到找到正确的设置。',
    'spine_device_threads_name' => '设备线程',
    'spine_device_threads_desc' => '用于从**设备**收集信息的最大 spine 线程数。在**设备**级别使用此设置时，您必须确保为进程分配了足够的线程，以免阻止从同一 spine 二进制文件轮询的其他**设备**。',

    // Installing Spine section
    'installing_spine_title' => '安装 Spine',
    'spine_compile_note' => '由于 Spine 是用 C 编写的，必须在要安装的本地系统上编译，下面是在 centos 和 Ubuntu 上编译的示例',
    'ubuntu_title' => 'Ubuntu',
    'ubuntu_packages' => '安装所需的系统包',
    'ubuntu_install_command' => 'apt-get install -y build-essential dos2unix dh-autoreconf libtool help2man libssl-dev libmysql++-dev librrds-perl libsnmp-dev',
    'spine_download_note' => '接下来，下载您要查找的 spine 版本。通常这应该与您使用的 Cacti 版本匹配。在这种情况下，我们将下载 Spine 的 1.2.3 版本',
    'spine_download_commands' => 'wget <https://github.com/Cacti/spine/archive/release/1.2.3.zip>
unzip 1.2.3
cd spine-release-1.2.3',
    'spine_compile_note2' => '一旦您进入 spine 目录，就是通过发出以下命令编译轮询器的时候了：',
    'spine_compile_commands' => './bootstrap
./configure
make
make install
chown root:root /usr/local/spine/bin/spine
chmod u+s /usr/local/spine/bin/spine',
    'spine_config_note' => '完成后，您需要配置 spine 的配置文件',
    'spine_config_command' => 'vi /usr/local/spine/etc/spine.conf',
    'spine_config_example_note' => '下面是一个配置示例，但您的配置应该与您的 cacti 数据库用户名和密码匹配',
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
    'centos_packages' => '安装所需的系统包',
    'centos_install_command' => 'yum install -y gcc mysql-devel net-snmp-devel autoconf automake libtool dos2unix help2man',
    'centos_compile_note' => '然后使用以下命令编译',
    'centos_compile_commands' => './bootstrap
./configure
make
make install
chown root:root /usr/local/spine/bin/spine
chmod u+s /usr/local/spine/bin/spine',

    // Testing/Debugging section
    'testing_debugging_title' => '通过命令行测试/调试 spine',
    'spine_testing_intro' => 'spine 在命令行提供了几种不同的方式来测试其功能。以下是您可以通过执行 spine 运行的一些测试示例。',
    'test_without_db_title' => '测试 Spine 而不将结果写入数据库',
    'test_without_db_desc' => '此测试允许您运行 spine 并将结果显示到控制台。通过指定 -R 选项，这不会将任何数据提交到数据库。',
    'test_specific_host_title' => '为特定主机运行 spine',
    'test_specific_host_desc' => '如果您想为特定主机运行 spine，您可以使用以下命令执行此操作：',
    'spine_debug_gui_title' => '通过 GUI 调试 Spine',
    'spine_debug_gui_desc' => '您还可以通过日志文件查看 spine 调试信息，spine 还允许您提高它在日志中提供的详细级别，如果您想调试特定设备并查看 spine 输出，请点击启用设备调试。',
    'spine_debug_gui_example' => '下面是通过日志文件输出的 Spine 调试信息示例',
    'spine_debug_image_desc' => 'spine',
    'spine_logging_settings' => '要启用更详细的 spine 日志记录，请转到 `控制台 > 配置 > 设置 > 轮询器`',
    'spine_logging_options' => '您可以选择详细、摘要或无效数据的无日志记录',
    'spine_logging_detailed' => '详细日志记录将类似于 cmd.php，您将获得每个有问题的数据源的报告',
    'spine_logging_summary' => '摘要提供每个设备有多少数据源有问题的计数',
    'spine_parameters_image_desc' => 'spine',

    // Common errors section
    'spine_errors_title' => '常见的 Spine 相关错误',
    'spine_error_config_missing' => '2021/01/08 14:38:44 - SPINE: Poller[1] PID[14838] FATAL: Unable to read configuration file! (Spine init)',
    'spine_error_config_solution' => '确保您在 /usr/local/spine/etc 中有 spine.conf，在首次安装时 `spine.conf` 可能是 `spine.conf.dist`。',
    'spine_error_setuid' => 'DEBUG Falling back to UDP Ping Due to SetUID Issues',
    'spine_error_setuid_desc' => '这是 spine 的权限问题，确保您已给 spine 适当的权限',
    'spine_error_setuid_solution' => 'chmod u+s /usr/local/spine/bin/spine',

    // Common spine terms
    'spine_data_collection' => 'Spine 数据收集',
    'multi_threaded' => '多线程',
    'poller_type' => '轮询器类型',
    'script_server' => '脚本服务器',
    'snmp_oids' => 'SNMP OID',
    'device_threads' => '设备线程',
    'spine_collection' => 'Spine 数据收集',

    // Data Input Methods page specific
    'page_title_data_input_methods' => 'Cacti - 数据输入方法',
    'data_input_methods_title' => '数据输入方法',
    'data_input_methods_intro' => '数据输入方法允许 Cacti 根据由**数据模板**及其相应的**数据源**控制的映射检索数据以插入到 RRD 文件中。这些生成的**数据模板**和**数据源**然后可以用于创建**图形模板**和**图形**。',
    'data_input_methods_builtin' => 'Cacti 包含许多内置的**数据输入方法**，用于**SNMP**数据以及**脚本**、**脚本服务器**和**SNMP 数据查询**。',
    'data_input_methods_custom' => '除了内置的**数据输入方法**之外，Cacti 管理员可以基于**脚本**或 PHP **脚本服务器**脚本创建几乎任何**数据输入方法**。基于**脚本**的**数据输入方法**允许 Cacti 从几乎任何地方收集数据，尽管内置的**SNMP**和**脚本服务器**方法在 Cacti 中提供最大的可扩展性。**数据查询**和 PHP **脚本服务器**主题将在文档的后续部分中介绍。',

    // Creating a Data Input Method section
    'creating_data_input_method_title' => '创建数据输入方法',
    'creating_data_input_method_desc' => '要创建新的**数据输入方法**，从 Cacti 控制台选择**数据收集 > 数据输入方法**。进入该屏幕后，点击右侧的加号 (+) 符号，这将允许您添加新的**数据输入方法**。您将在以下屏幕上看到一些需要填充的字段。',
    'data_input_methods_table_title' => '表 11-1. 字段描述：数据输入方法',
    'data_input_methods_name_field' => '名称',
    'data_input_methods_description_field' => '描述',
    'data_input_methods_name_desc' => '为数据查询提供一个您将用来识别它的名称',
    'data_input_methods_input_type_field' => '输入类型',
    'data_input_methods_input_type_desc' => '选择您要创建的**数据输入方法**的类型',
    'data_input_methods_input_string_field' => '输入字符串',
    'data_input_methods_input_string_desc' => '此字段仅在输入类型设置为**脚本/命令**时使用',

    'data_input_methods_name_consideration' => '指定的 `名称` 将在整个 Cacti 中用于识别给予**数据输入方法**的人类可读名称。应该仔细考虑以帮助唯一识别**数据源**。拥有非常相似的名称可能会在您的 Cacti 系统增长时使用它们时导致混乱。',
    'data_input_methods_input_types' => '`输入类型` 的有效选项是**脚本/命令**和**脚本服务器**。如前所述，Cacti 为 SNMP 数据收集以及基于 SNMP、**脚本**和**脚本服务器**的**数据查询**提供内置的**数据输入方法**。虽然存在于 Cacti 数据库中，但它们对用户视图是隐藏的。',
    'data_input_methods_script_command' => '当类型设置为 `脚本/命令` 时，`输入字符串` 指定脚本的完整路径，包括任何每个**数据源**的输入变量。**数据源**输入变量必须用大于号和小于号字符括起来。例如，如果您要将 IP 地址传递给脚本，您的输入字符串可能看起来像：`/path/to/script.pl <ip>` 当用户基于此**数据输入方法**创建**数据源**时，他们将被提示输入 IP 地址以传递给脚本。',
    'data_input_methods_after_create' => '当您完成填写所有必要字段后，点击创建按钮继续。保存新的**数据输入方法**后，您将看到两个新的部分需要完成。这些部分将指示 Cacti 传递给脚本的内容，称为 `输入字段`，也称为 `输入参数`，以及如何处理输出数据，我们称之为 `输出字段`。',
    'data_input_methods_input_fields_desc' => '`输入字段` 框用于定义需要用户信息或来自 Cacti 数据库中各种数据（如主机名、IP 地址、主机 ID 等）的任何字段。输入字符串中引用的任何输入字段都必须在此处定义。',
    'data_input_methods_output_fields_desc' => '`输出字段` 框用于定义您期望从脚本返回的每个字段，最终将存储在数据库和 RRD 文件中。',
    'data_input_methods_output_requirement' => '*所有**数据输入方法**必须至少定义一个输出字段*，但根据类型可能有多个。',

    // Data Input Fields section
    'data_input_fields_title' => '数据输入字段',
    'data_input_fields_desc' => '要定义新字段，请点击输入或输出字段框旁边的加号 (+)。根据您是添加输入字段还是输出字段，您将看到以下部分或全部字段。',
    'data_input_fields_table_title' => '表 11-2. 字段描述：数据输入字段',
    'data_input_field_name' => '字段/字段名称',
    'data_input_field_name_desc' => '您将看到来自命令的未使用的大括号输入字段的下拉列表',
    'data_input_friendly_name' => '友好名称',
    'data_input_friendly_name_desc' => '为此字段输入更具描述性的名称',
    'data_input_regex_match' => '正则表达式匹配（仅输入）',
    'data_input_regex_match_desc' => '输入有效的正则表达式以修改输出',
    'data_input_allow_empty' => '允许空输入（仅输入）',
    'data_input_allow_empty_desc' => '此字段的输入值是否可以为空',
    'data_input_special_type' => '特殊类型代码（仅输入）',
    'data_input_special_type_desc' => '从 Cacti 数据库中提取输入数据，不提示用户输入此输入值',
    'data_input_update_rrd' => '更新 RRD 文件（仅输出）',
    'data_input_update_rrd_desc' => '如果您打算将此输出数据存储在 RRD 文件中，请选中',

    'data_input_field_name_rules' => '`字段名称` 不得包含空格或其他非字母数字字符（除了 \'-\' 或 \'_\'）。',
    'data_input_regex_rules' => '如果您想在用户为此数据输入字段的 `正则表达式匹配（仅输入）` 输入值时强制执行某种正则表达式模式，它必须遵循 POSIX 语法，因为它将传递给 PHP 的 preg() 函数。',
    'data_input_special_type_usage' => '如果数据输入字段需要在内部引用另一个字段，您可以将其输入到 `特殊类型代码` 中。例如，如果您的字段需要用户的 IP 地址，您可以在此处输入 \'management_ip\'，Cacti 将使用所选主机的当前 IP 地址填充此字段。',

    // Special Type Codes table
    'special_type_codes_table_title' => '表 11-3. 特殊类型代码',
    'special_type_field_name' => '字段名称',
    'special_type_hostname' => 'hostname',
    'special_type_hostname_desc' => '主机名',
    'special_type_management_ip' => 'management_ip',
    'special_type_management_ip_desc' => 'IP 地址',
    'special_type_snmp_community' => 'snmp_community',
    'special_type_snmp_community_desc' => 'SNMP 团体',
    'special_type_snmp_username' => 'snmp_username',
    'special_type_snmp_username_desc' => 'SNMP 用户名',
    'special_type_snmp_password' => 'snmp_password',
    'special_type_snmp_password_desc' => 'SNMP 版本',

    'data_input_update_rrd_note' => '如果您启用 `更新 RRD 文件`，Cacti 将把此字段的返回值插入到 RRD 文件中。每个数据输入源至少需要为一个输出字段选中此框，但可以留空以让 Cacti 仅将值存储在数据库中。',
    'data_input_create_finish' => '当您完成填写所有必要字段后，点击创建按钮继续。您将被重定向回**数据输入方法**编辑页面。从这里您可以继续添加其他字段，或在完成时点击此屏幕上的保存。',

    // Making Your Scripts Work With Cacti section
    'scripts_work_with_cacti_title' => '使您的脚本与 Cacti 配合工作',
    'scripts_work_intro' => '扩展 Cacti 数据收集功能的最简单方法是通过外部脚本。Cacti 开箱即用地提供了许多脚本，这些脚本位于 `scripts/` 目录中。这些脚本由 Cacti 新安装中存在的**数据输入方法**使用。',
    'scripts_work_create_method' => '要让 Cacti 调用外部脚本来收集数据，您必须创建新的**数据输入方法**，确保为输入类型字段指定脚本/命令。有关如何创建**数据输入方法**的更多信息，请参见上一节"创建数据输入方法"。要使用您的**数据输入方法**收集数据，Cacti 只需执行输入字符串字段中指定的 shell 命令。因此，您可以让 Cacti 运行任何 shell 命令或调用几乎可以用任何语言编写的任何脚本。',
    'scripts_output_format' => 'Cacti 关心的是脚本的输出。当您定义**数据输入方法**时，您需要定义一个或多个输出字段。您在此处定义的输出字段数量对脚本的输出很重要。对于只有一个输出字段的**数据输入方法**，您的脚本应该以以下格式输出其值：',
    'scripts_single_output_format' => '<数值>',
    'scripts_single_output_example' => '因此，如果我编写了一个输出正在运行的进程数的脚本，其输出可能如下所示：',
    'scripts_single_output_value' => '67',
    'scripts_multiple_output_desc' => '具有多个输出字段的数据输入方法在编写脚本时处理方式略有不同。输出多个值的脚本应格式化如下：',
    'scripts_multiple_output_format' => '<字段名_1>:<值_1> <字段名_2>:<值_2> ... <字段名_n>:<值_n>',
    'scripts_multiple_output_example' => '如果您编写了一个输出 Unix 机器的 1、5 和 10 分钟负载平均值的脚本，并在 Cacti 中将输出字段命名为 \'1min\'、\'5min\' 和 \'10min\'，脚本的输出应如下所示：',
    'scripts_load_average_example' => '1min:0.40 5min:0.32 10min:0.01',
    'scripts_permissions_note' => '为 Cacti 编写脚本时要记住的最后一件事是，它们将以数据收集器运行的用户身份执行。有时脚本在以 root 身份执行时可能正常工作，但在以较低权限用户身份执行时由于权限问题而失败。',

    // Walkthrough section
    'walkthrough_title' => '演练',
    'walkthrough_desc' => '您可以在以下示例中找到如何从简单命令输出创建完整图形的详细示例：如何创建数据输入方法。',

    // Common data input method terms
    'data_input_method' => '数据输入方法',
    'input_fields' => '输入字段',
    'output_fields' => '输出字段',
    'input_parameters' => '输入参数',
    'script_command' => '脚本/命令',
    'script_server' => '脚本服务器',
    'special_type_codes' => '特殊类型代码',
    'regular_expression_match' => '正则表达式匹配',
    'data_input_methods' => '数据输入方法',

    // Data Queries page specific
    'page_title_data_queries' => 'Cacti - 数据查询',
    'data_queries_title' => '数据查询',
    'data_queries_overview_title' => '概述',
    'data_queries_overview_intro' => 'Cacti **数据查询**不是 Cacti 中**数据输入方法**的替代品。相反，它们提供了一种简单的方法来扩展数据输入方法，以解释多维对象或基于索引列出数据，使数据更容易绘制图形。在 Cacti 中**数据查询**最常见的用途是通过 SNMP 检索网络接口列表。',
    'data_queries_overview_process' => '如果您想绘制网络接口的流量图，首先 Cacti 必须检索主机上的接口列表。其次，Cacti 可以使用该信息创建必要的**图形**和**数据源**。**数据查询**只关心过程的第一步，即获取网络接口列表，而不是为它们创建图形/数据源。虽然列出网络接口是**数据查询**的常见用途，但它们也有其他用途，如列出分区、处理器，甚至路由器中的卡。',
    'data_queries_unique_requirement' => 'Cacti 中任何**数据查询**的一个要求是，它有一些唯一值来定义列表中的每一行。这个概念遵循 SQL 中"主键"的概念，并确保列表中的每一行都可以被唯一引用。这些索引值的示例是 SNMP 网络接口的"ifIndex"或分区的设备名称。',
    'data_queries_types' => '您将在整个 Cacti 中看到三种类型的**数据查询**。它们是脚本查询、脚本服务器查询和 SNMP 查询。脚本、脚本服务器和 SNMP 查询在功能上几乎相同，只是在获取信息的方式上有所不同。脚本和脚本服务器查询将调用外部命令或脚本，SNMP 查询将进行 SNMP 调用以检索数据列表。',

    // User Interface section
    'data_queries_ui_title' => '用户界面',
    'data_queries_ui_description' => '下面，您可以看到 Cacti 的默认**数据查询**界面。从界面中，您可以看到数据查询的名称、ID、数据输入方法和其他信息。',
    'data_queries_interface_desc' => '数据查询界面',
    'data_queries_edit_description' => '当您编辑现有数据查询时，您将看到如下界面。在该界面中，您会注意到包含了 XML 文件路径。XML 文件是 Cacti **数据查询**的关键组件。对于基于脚本的**数据查询**，还将有一个必须调用的脚本来收集有关**数据查询**的信息，脚本名称包含在 XML 文件中。',
    'data_queries_edit_interface_desc' => '数据查询编辑界面',
    'data_queries_graph_templates' => '在此界面中，您可以看到名称、描述、XML 路径和**数据输入方法**。在下面的部分中，您有"关联图形模板"部分，其中包括可用于**数据查询**的所有各种**图形模板**。',
    'data_queries_template_removal' => '一旦**数据查询****图形模板**正在使用中，就不能再从 Cacti 中删除。此功能是为了防止如果有人意外删除**图形模板**关联，**图形**变得无法渲染。',
    'data_queries_template_click' => '当您点击任何"关联图形模板"名称时，您将被带到下面的界面。',
    'data_queries_template_edit_desc' => '数据查询关联图形模板编辑界面',
    'data_queries_mapping_description' => '从这里，您将各种匹配的**数据模板** RRD 文件数据源名称映射到 XML 文件中存在的数据源名称。XML 文件中可以有许多数据源名称，但图形模板可能只需要其中的几个，这解释了**数据查询**具有"关联数据模板"部分的原因。要将 XML 字段与**数据模板** RRD 文件数据源关联，您只需选择正确的一个，然后切换 XML 字段数据源名称右侧的复选框。',
    'data_queries_suggested_values' => '在"关联数据模板"下方，您将找到两个部分，称为**数据源**和**图形**名称的"建议值"。在创建**图形**及其关联的**数据源**时，Cacti 将使用"建议值"模式中的第一个名称，该名称完全替换由开始和结束竖线标识的所有标签。因此，在上面的示例中，创建接口图形时，如果该接口没有 ifAlias，Cacti 可能会使用第二个"建议值"，除非接口没有 IP 地址，在这种情况下它将使用第三个"建议值"。',
    'data_queries_replacement_values' => 'Cacti 还允许"建议值"替换**图形**和**数据源**值，如上面的情况，"rrd_maximum"列被网络接口最大速度替换，从 SNMP 角度来说也称为"ifSpeed"。',
    'data_queries_two_parts' => '所有数据查询都有两个部分，XML 文件和 Cacti 内的定义。必须为每个查询创建一个 XML 文件，该文件定义每条信息的位置以及如何检索它。这可以被认为是实际的查询。第二部分是 Cacti 内的定义，它告诉 Cacti 在哪里找到 XML 文件，并将数据查询与一个或多个图形模板关联。',

    // Creating a Data Query section
    'creating_data_query_title' => '创建数据查询',
    'creating_data_query_desc' => '一旦您创建了定义数据查询的 XML 文件，您必须在 Cacti 内添加数据查询。要执行此操作，您必须点击数据收集标题下的数据查询，然后选择添加。您将被提示输入有关数据查询的一些基本信息，下面有更详细的描述。',
    'data_queries_table_title' => '表 12-1. 字段描述：数据查询',
    'data_queries_name_field' => '名称',
    'data_queries_description_field' => '描述（可选）',
    'data_queries_xml_path_field' => 'XML 路径',
    'data_queries_data_input_method_field' => '数据输入方法',
    'data_queries_name_desc' => '为**数据查询**提供一个您将用来识别它的名称。当呈现**数据查询**列表时，此名称将在整个 Cacti 中使用。',
    'data_queries_description_desc' => '输入数据查询的更详细描述，包括它查询的信息或其他要求。',
    'data_queries_xml_path_desc' => '填写定义此查询的 XML 文件的完整路径。您可以选择使用 `path_cacti` 变量，该变量将被替换为 Cacti 的完整路径。在下一个屏幕上，Cacti 将检查以确保它可以找到 XML 文件。',
    'data_queries_data_input_method_desc' => '这是您告诉 Cacti 如何处理从数据查询接收的数据的方式。通常，您将为 SNMP 查询选择"获取 SNMP 数据（索引）"，为脚本查询选择"获取脚本数据（索引）"。',
    'data_queries_create_warning' => '当您完成填写所有必要字段后，点击创建按钮继续。您将被重定向回同一页面，但这次有一些额外的信息需要填写。如果您收到红色警告说"XML 文件不存在"，请更正"XML 路径"字段中指定的值。',

    // Associated Graph Templates section
    'associated_graph_templates_title' => '关联图形模板',
    'associated_graph_templates_desc' => '每个数据查询必须至少有一个与之关联的图形模板，可能更多，这取决于 XML 文件中指定的输出字段数量。这是您选择从此查询生成什么类型图形的地方。例如，接口数据查询有多个图形模板关联，用于绘制流量、错误或数据包图形。要添加新的图形模板关联，只需点击关联图形模板框右侧的添加。您将看到一些需要填写的字段：',
    'associated_graph_templates_table_title' => '表 12-2. 字段描述：关联图形模板',
    'associated_graph_templates_name_desc' => '提供一个描述您试图表示或绘制的数据类型的名称。当用户使用此数据查询创建图形时，他们将看到必须从中选择的图形模板关联列表。',
    'associated_graph_templates_template_desc' => '选择您想要与之建立关联的实际图形模板。',
    'associated_graph_templates_finish' => '当您完成填写这些字段后，点击创建按钮。您将被重定向回同一页面，并有一些额外的信息需要填写。Cacti 将列出您选定的**图形模板**中引用的每个**数据模板**，并在"关联数据模板"框下显示它们。如前所述，对于列出的每个**数据源**项目，您必须选择与之对应的**数据查询**输出字段。*不要忘记选中每个选择右侧的复选框，否则您的设置将不会被保存。*',
    'suggested_values_desc' => '"建议值"表单为您提供了一种控制使用**数据查询**创建的**数据源**和**图形**字段值的方法。如果您为同一字段指定多个"建议值"，Cacti 将按您可以使用向上或向下箭头图标控制的顺序评估它们。有关有效字段名称和变量的更多信息，请阅读"建议值"部分。',
    'data_queries_final_save' => '当您完成填写此表单上的所有必要字段后，点击保存按钮返回数据查询编辑屏幕。根据需要重复此标题下的步骤多次，以表示 XML 文件中的所有数据。完成后，您应该准备好开始将数据查询添加到主机。',

    // Common data query terms
    'data_query' => '数据查询',
    'data_queries' => '数据查询',
    'script_queries' => '脚本查询',
    'snmp_queries' => 'SNMP 查询',
    'script_server_queries' => '脚本服务器查询',
    'xml_file' => 'XML 文件',
    'associated_graph_templates' => '关联图形模板',
    'associated_data_templates' => '关联数据模板',
    'suggested_values' => '建议值',

    // Device Templates page specific
    'page_title_device_templates' => 'Cacti - 设备模板',
    'device_templates_title' => '设备模板',
    'device_templates_intro' => '**设备模板**是 Cacti 对象，允许您定义**设备**类别，包括一个到多个**图形模板**、**数据查询**和其他**插件**相关对象类型。',
    'device_templates_purpose' => '**设备模板**的目的是通过预定义应为添加到 Cacti 的每个**设备**创建的**图形**来简化**自动化**过程。它们与**自动化模板**配合工作，以便当 Cacti 发现**网络**时，它知道为每个**设备**创建什么**图形**。',
    'device_templates_main_screen' => '**设备模板**主屏幕如下图所示：',
    'device_templates_page_desc' => '设备模板页面',
    'device_templates_page_info' => '从此页面，您可以看到每个**设备模板**的标题、对 Cacti CLI 脚本很重要的 ID。您可以看到**设备模板**是否可以删除，以及使用**设备模板**的**设备**数量。被**设备**使用的模板无法删除，因此如果您尝试删除其中一个模板，您将收到错误消息。',
    'device_templates_dropdown_options' => '从下拉菜单中有三个选项，它们是：',

    // Device Templates options table
    'device_templates_option_field' => '选项',
    'device_templates_description_field' => '描述',
    'device_templates_delete_option' => '删除',
    'device_templates_delete_desc' => '如果**设备模板**是*可删除的*，则删除它',
    'device_templates_duplicate_option' => '复制',
    'device_templates_duplicate_desc' => '制作**设备模板**的精确副本。',
    'device_templates_sync_option' => '同步设备',
    'device_templates_sync_desc' => '使用最新定义更新所有使用此**设备模板**的**设备**，添加但不删除**图形模板**和**数据查询**。',

    // Device Template editing
    'device_templates_edit_intro' => '编辑**设备模板**时，您将看到如下所示的页面。从此页面，您可以添加和删除**图形模板**、**数据查询**和其他**插件**对象。在下面的图像中，您可以看到*思科路由器*有一个**图形模板**，即*思科 - CPU 使用率*和一个**数据查询**，即*SNMP - 接口统计*。系统上没有定义**阈值模板**，因此无法选择一个。',
    'device_templates_edit_page_desc' => '设备模板编辑页面',
    'device_templates_add_remove' => '要向**设备模板**添加**图形模板**或**数据查询**，只需从下拉菜单中选择它，然后按*添加*按钮。之后无需*保存*。要删除其中一个项目，只需按所需**图形模板**或**数据查询**右侧的 x 符号。',

    // Common device template terms
    'device_template' => '设备模板',
    'device_templates' => '设备模板',
    'automation_templates' => '自动化模板',
    'threshold_templates' => '阈值模板',
    'cisco_router' => '思科路由器',
    'cisco_cpu_usage' => '思科 - CPU 使用率',
    'snmp_interface_statistics' => 'SNMP - 接口统计',
    'deletable' => '可删除的',
    'sync_devices' => '同步设备',
    'duplicate' => '复制',

    // Graph Templates page specific
    'page_title_graph_templates' => 'Cacti - 图形模板',
    'graph_templates_title' => '图形模板',
    'graph_templates_intro' => '**图形模板**是 Cacti 对象，允许您定义 RRDtool 如何渲染 Cacti **图形**。支持大多数 RRDtool 选项，包括 CDEF 和 VDEF、左轴和右轴、刻度和虚线、多重自动缩放、网格和图例选项。',
    'graph_templates_purpose' => '**图形模板**的目的是通过预定义要在 Cacti 中监控的各种指标的**图形**布局来简化**自动化**过程。当与 Cacti 的**图形规则**结合使用时，您可以在 Cacti 的**网络发现**过程中自动创建几乎任何基于**数据查询**的**图形**。',
    'graph_templates_main_screen' => '**图形模板**主屏幕如下图所示：',
    'graph_templates_page_desc' => '图形模板页面',
    'graph_templates_page_info' => '从此页面，您可以看到每个**图形模板**的标题、对 Cacti CLI 脚本很重要的 ID。您可以看到**图形模板**是否可以删除，以及使用**图形模板**的**图形**数量，以及将要创建的**图形**的*大小*、*图像格式*和*垂直标签*。被**设备**使用的模板无法删除，因此如果您尝试删除其中一个模板，您将收到错误消息。',
    'graph_templates_dropdown_options' => '从下拉菜单中有三个选项，它们是：',

    // Graph Templates options table
    'graph_templates_option_field' => '选项',
    'graph_templates_description_field' => '描述',
    'graph_templates_delete_option' => '删除',
    'graph_templates_delete_desc' => '如果**图形模板**是*可删除的*，则删除它',
    'graph_templates_duplicate_option' => '复制',
    'graph_templates_duplicate_desc' => '制作**图形模板**的精确副本',
    'graph_templates_resize_option' => '调整大小',
    'graph_templates_resize_desc' => '做出影响**图形模板**和使用此**图形模板**创建的任何**图形**的调整大小决定',
    'graph_templates_sync_option' => '同步图形',
    'graph_templates_sync_desc' => '使用最新定义更新所有使用此**图形模板**的**图形**，添加新的*图形项目*并删除孤立的*图形项目*',

    // Graph Template editing sections
    'graph_templates_edit_intro' => '编辑**图形模板**时，将有几个部分需要管理员提供信息。这些部分包括：',
    'graph_templates_section_field' => '部分',
    'graph_templates_items_section' => '图形模板项目',
    'graph_templates_items_desc' => '这些项目在**图形**的画布内绘制',
    'graph_templates_inputs_section' => '图形项目输入',
    'graph_templates_inputs_desc' => '当您向**图形模板**添加**数据源**时，此列表会自动创建。但是，您也可以通过向此部分添加特定命名的对象来覆盖某些**数据模板**和**图形模板**字段。',
    'graph_templates_template_section' => '图形模板',
    'graph_templates_template_desc' => '允许您命名**图形模板**，以及是否允许此**图形模板**的多个实例用于**设备**，以及是否在允许创建**图形**之前测试有效数据。当您想要利用包含可能不适用于使用**图形模板**的所有类别**设备**的**图形模板**的复杂**设备模板**时，*测试数据源*选项很有用。',
    'graph_templates_common_section' => '通用选项',
    'graph_templates_common_desc' => '诸如标题、垂直标签、图像格式、高度和宽度、基值和斜率模式等',
    'graph_templates_scaling_section' => '缩放选项',
    'graph_templates_scaling_desc' => '确定图形是否自动缩放以及通过什么方式。确定图形是否具有固定的上限和下限',
    'graph_templates_grid_section' => '网格选项',
    'graph_templates_grid_desc' => '定义如何渲染图形画布网格',
    'graph_templates_axis_section' => '轴选项',
    'graph_templates_axis_desc' => '定义是否应该有右轴以及如何格式化',
    'graph_templates_legend_section' => '图例选项',
    'graph_templates_legend_desc' => '定义如何格式化图例',

    // Common graph template terms
    'graph_template' => '图形模板',
    'graph_templates' => '图形模板',
    'graph_rules' => '图形规则',
    'network_discovery' => '网络发现',
    'graph_items' => '图形项目',
    'graph_item_inputs' => '图形项目输入',
    'consolidation_function' => '合并函数',
    'replacement_variables' => '替换变量',
    'gprint_preset' => 'GPRINT 预设',
    'horizontal_rule' => '水平规则',
    'vertical_rule' => '垂直规则',
    'area_fill' => '区域填充',
    'multiple_instances' => '多个实例',
    'test_data_sources' => '测试数据源',
    'common_options' => '通用选项',
    'scaling_options' => '缩放选项',
    'grid_options' => '网格选项',
    'axis_options' => '轴选项',
    'legend_options' => '图例选项',
    'vertical_label' => '垂直标签',
    'image_format' => '图像格式',
    'base_value' => '基值',
    'slope_mode' => '斜率模式',
    'auto_scaling' => '自动缩放',
    'rigid_scaling' => '刚性缩放',
    'right_axis' => '右轴'
);
?>
