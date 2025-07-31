<?php
/**
 * English Language File for Cacti Documentation
 * 
 * This file contains all English text content for the documentation system.
 * Modify this file to update English content.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 * @language English
 */

$lang = array(
    // Page titles
    'page_title_main' => 'Cacti (tm) Documentation',
    'page_title_requirements' => 'Cacti - Requirements',
    'page_title_installation' => 'Cacti - Installation',
    'page_title_configuration' => 'Cacti - Configuration',
    'page_title_toc' => 'Cacti - Table of Contents',
    
    // Navigation
    'language_selector_label' => 'Language',
    'back_button' => '← Back',
    'home' => 'Home',
    'documentation' => 'Documentation',
    'table_of_contents' => 'Table of Contents',
    
    // Main page content
    'main_title' => 'Cacti (tm) Documentation',
    'main_subtitle' => 'The complete guide to Cacti network monitoring',
    'welcome_message' => 'Welcome to the Cacti documentation. This documentation will help you install, configure, and use Cacti to monitor your network infrastructure.',
    
    // Documentation sections
    'section_installation' => 'Cacti Installation',
    'section_installation_desc' => 'This section contains information on how to install and/or upgrade the Cacti system. It covers requirements, different platforms and the steps needed to get your system working under normal circumstances.',
    
    'section_overview' => 'Cacti Overview',
    'section_overview_desc' => 'This section describes Cacti components and their purpose as well as providing examples including on how to create <strong>Templates</strong> in Cacti.',
    
    'section_advanced' => 'Advanced Operations',
    'section_advanced_desc' => 'This section covers more advanced material such as using a advanced data collection and replacement variables that can be used within <strong>Templates</strong>, etc.',
    
    'section_plugin_dev' => 'Plugin Development',
    'section_plugin_dev_desc' => 'This section contains all Plugin development related information. Guidelines, hooks, references, etc. More information can be found on the <a href="https://forums.cacti.net/viewforum.php?f=6">Cacti Forums</a>.',
    
    'section_howtos' => 'How To\'s',
    'section_howtos_desc' => 'This section contains how to\'s for several topics.',
    
    'section_contributing' => 'Contributing',
    'section_contributing_desc' => 'This section contains information on how to contribute to Cacti.',
    
    'section_standards' => 'Development Standards',
    'section_standards_desc' => 'This section contains the relevant information on how to ensure that any contribution is kept to the same standards that are applied for the Cacti Group. It should be noted that non-compliance does not mean automatically exclusion of proposed changes.',
    
    // Installation subsections
    'known_issues' => 'Known Issues',
    'known_issues_link' => 'List of Known issues',
    'requirements' => 'Requirements',
    'general_installing' => 'General Installing Instructions',
    'installing_linux' => 'Installing Cacti on Linux',
    'installing_centos_lamp' => 'Installation Under CentOS 7 - LAMP Stack',
    'installing_centos_lemp' => 'Installation Under CentOS 7 - LEMP Stack',
    'installing_ubuntu' => 'Installation Under Ubuntu/Debian - LAMP Stack',
    'installing_windows' => 'Installing Under Windows',
    'upgrading_linux' => 'Upgrading Cacti Under Linux/UNIX',
    'upgrading_windows' => 'Upgrading Cacti Under Windows',
    'upgrading_freebsd' => 'Upgrading Cacti Under FreeBSD',
    
    // Overview subsections
    'overview' => 'Overview',
    'navigating_ui' => 'Navigating the User Interface',
    'principles_operation' => 'Principles of Operation',
    'graph_overview' => 'Graph Overview',
    'how_to_graph' => 'How to Graph Your Network',
    'viewing_graphs' => 'Viewing Graphs',
    
    // Management
    'management' => 'Management',
    'devices' => 'Devices',
    'sites' => 'Sites',
    'trees' => 'Trees',
    'graphs' => 'Graphs',
    'data_sources' => 'Data Sources',
    'aggregates' => 'Aggregates',
    
    // Data Collection
    'data_collection' => 'Data Collection',
    'data_collectors' => 'Data Collectors',
    'spine_collection' => 'Spine Data Collection',
    'data_input_methods' => 'Data Input Methods',
    'data_queries' => 'Data Queries',
    
    // Templates
    'templates' => 'Templates',
    'device_templates' => 'Device Templates',
    'graph_templates' => 'Graph Templates',
    'data_source_templates' => 'Data Source Templates',
    'aggregate_templates' => 'Aggregate Templates',
    'color_templates' => 'Color Templates',
    
    // Automation
    'automation' => 'Automation',
    'networks' => 'Networks',
    'discovered_devices' => 'Discovered Devices',
    'device_rules' => 'Device Rules',
    'graph_rules' => 'Graph Rules',
    'tree_rules' => 'Tree Rules',
    'snmp_options' => 'SNMP Options',
    
    // Presets
    'presets' => 'Presets',
    'data_profiles' => 'Data Profiles',
    'cdefs' => 'CDEFs',
    'vdefs' => 'VDEFs',
    'colors' => 'Colors',
    'gprints' => 'GPRINTs',
    
    // Import/Export
    'import_export' => 'Import/Export',
    'import_templates' => 'Import Templates',
    'export_templates' => 'Export Templates',
    
    // Settings
    'settings' => 'Settings',
    'settings_general' => 'General',
    'settings_paths' => 'Paths',
    'settings_device_defaults' => 'Device Defaults',
    'settings_poller' => 'Poller',
    'settings_data' => 'Data',
    'settings_visual' => 'Visual',
    'settings_performance' => 'Performance',
    'settings_spikes' => 'Spikes',
    'settings_mail' => 'Mail/Reporting/DNS',
    
    // Authentication
    'auth_settings' => 'Settings - Auth',
    'local_auth' => 'Local Auth',
    'ldap_auth' => 'LDAP Auth',
    'basic_auth' => 'Basic Auth',
    'domains_auth' => 'Domains Auth',
    
    // Users and Groups
    'users_groups' => 'Configuration - Users, Groups and Domains',
    'users' => 'Users',
    'user_groups' => 'User Groups',
    'user_domains' => 'User Domains',
    
    // Plugins
    'plugins' => 'Configuration - Plugins',
    
    // Utilities
    'utilities' => 'Utilities',
    'system_utilities' => 'System Utilities',
    'data_debug' => 'Data Debug',
    'external_links' => 'External Links',
    
    // Reporting
    'reporting' => 'Reporting',
    'reports_admin' => 'Reports Administrative Interface',
    'reports_user' => 'Reports User Interface',
    'reports_items' => 'Report Items Page',
    'reports_preview' => 'Report Preview Page',
    'reports_events' => 'Report Events Page',
    'reports_other' => 'Other Options for Adding Report Items',
    
    // Cacti Log
    'cacti_log' => 'The Cacti Log',
    
    // Footer
    'copyright' => 'Copyright (c) 2004-2024 The Cacti Group',
    
    // Common terms
    'video_tutorials' => 'Video Tutorials',
    'template_specific' => 'Template Specific Documentation',
    'template_desc' => 'This section will be for template specific configuration requirements',

    // Requirements page specific
    'requirements_intro' => 'Cacti requires that the following software is installed on your system.',
    'web_server_req' => 'Web Server that supports PHP e.g. Apache, Nginx, or IIS',
    'build_env_req' => 'Build environment when using spine (gcc, automake, autoconf, libtool, help2man)',
    'rrdtool_req' => 'RRDtool 1.3 or greater, 1.5+ recommended',
    'php_req' => 'PHP 5.4 or greater, 5.5+ recommended',
    'required_modules' => 'Required modules:',
    'optional_modules' => 'Optional modules:',
    'mysql_req' => 'MySQL 5.6 or MariaDB 5.5 or greater',
    'timezone_support' => 'Timezone support must be enabled',
    'mycnf_recommendations' => 'The following are my.cnf recommendations:',
    'problematic_software' => 'Problematic software and configuration',
    'browser_requirements' => 'Browser Requirements',
    'browser_requirements_desc' => 'Cacti has been tested to work on the following browsers:',
    'network_requirements' => 'Network Requirements',
    'performance_considerations' => 'Performance Considerations',
    'performance_desc' => 'The following factors affect Cacti performance:',
    'cpu_requirements' => 'CPU',
    'cpu_desc' => 'Multi-core processors recommended for large installations',
    'memory_requirements' => 'Memory',
    'memory_desc' => 'Minimum 1GB RAM, 4GB+ recommended for large installations',
    'storage_requirements' => 'Storage',
    'storage_desc' => 'Fast storage (SSD) recommended for RRD files',
    'network_bandwidth' => 'Network',
    'network_desc' => 'Sufficient bandwidth for SNMP polling',
    'security_considerations' => 'Security Considerations',
    'security_ssl' => 'Use SSL/TLS for web interface access',
    'security_passwords' => 'Use strong passwords for all accounts',
    'security_updates' => 'Keep all software components updated',
    'security_firewall' => 'Configure firewall to restrict access',
    'security_snmp' => 'Use SNMPv3 when possible for device monitoring',

    // Navigating UI page specific
    'page_title_navigating_ui' => 'Cacti - Navigating the User Interface',
    'navigating_ui_title' => 'Navigating the Cacti User Interface',
    'ui_intro' => 'The Cacti User Interface is visually broken into multiple panels. Each major panel is designed to hold content. Depending on the Cacti Theme you use some of these panels may not be visible at the Theme Developers discretion. The common panels are:',
    'top_tabs' => 'Top Tabs',
    'top_tabs_desc' => 'Where you perform major navigation separate content',
    'navigation_area' => 'Navigation Area',
    'navigation_area_desc' => 'If the content in navigated to by the Top Tab has a menu, it will be found here.',
    'breadcrumb_bar' => 'Breadcrumb Bar',
    'breadcrumb_bar_desc' => 'This is where you can see where in the Cacti interface you are currently pointed to',
    'content_area' => 'Content Area',
    'content_area_desc' => 'This is where you present tables, charts, forms, etc. It is where your main Content resides',
    'footer' => 'Footer',
    'footer_desc' => 'This section is left for Theme Developers to insert content that belongs at the bottom of the screen.',
    'default_layout_desc' => 'You can see the default Cacti layout with its various panels in the image below. You will note, in this Modern Theme, the Theme Author has decided to dispense with the Footer.',
    'top_tabs_navigation' => 'In Cacti, when you click on the Top Tab, you will by default enter a completely different section of Cacti. Cacti\'s Top Tabs are Designed to mimic browser tabs, this helps with users orienting themselves to the various sections of Cacti. When you have many Plugins installed as in the example above, you can see clearly the benefit of these navigation aids.',
    'sub_panels_desc' => 'Inside each of these panels, a page can be broken into sub-panels. Two panels customarily broken into sub-panels include the Navigation Area and the Content Area.',
    'device_page_example' => 'In the example below, we show the Device page in Cacti calling out the various sub-panels.',
    'content_control' => 'Most of Cacti\'s pages are laid out in this fashion. However, what goes into the Cacti Content Area is completely under the Plugin authors control.',
    'theme_requirements' => 'At the Theme developers discretion, all pages should include both the Top Tab and Breadcrumb Bar. Inside of the Breadcrumb Bar or Top Tab panels you should always see the User Profile and Menu on the right.',
    'understanding_sections' => 'To use Cacti properly, you should first understand these sections. We will start by describing the Cacti Console.',
    'core_panels_title' => 'Cacti Core Panels and Sub-Panels',
    'top_tabs_detail' => 'Cacti Top Tabs provide Cacti with multiple Navigation Areas. By default, Cacti includes four Top Tabs. They are Console, Graphs, Log and Reports.',
    'breadcrumbs' => 'Breadcrumbs',
    'breadcrumbs_detail' => 'Breadcrumbs appear directly below the Top Tabs. Note that some Cacti Themes disable the Breadcrumbs. You can click on a Breadcrumb area to navigate to that area if desired.',
    'cacti_content_area' => 'Cacti Content Area',
    'content_area_detail' => 'This is where the main page content will be displayed. It is directly below the Breadcrumbs or the Top Tabs with some Cacti Themes. They can include any HTML that the Plugin Author or Cacti Administrator desires in the case of External Links.',
    'navigation_menu' => 'Navigation Menu',
    'navigation_menu_detail' => 'If you click on the Cacti Console, you will see an example Navigation Menu. These menus can appear on any Plugin based Top Tab page in addition to the Cacti Console.',
    'cacti_tables' => 'Cacti Tables',
    'cacti_tables_detail' => 'These tables are where table based data is rendered in Cacti. Cacti Tables are presented using an arcane, though easy to use API.',
    'table_filters' => 'Table Filters',
    'table_filters_detail' => 'Any Cacti Table can include a Table Filters. These filters can be used to limit the data returned to a Cacti Table.',
    'actions_dropdown' => 'Actions Dropdown',
    'actions_dropdown_detail' => 'Any page that includes a Cacti Table will generally include an Actions Dropdown. These Actions Dropdown menus allow you to take action on a table row or rows.',
    'user_profile_menu' => 'User Profile and Menu',
    'user_profile_menu_detail' => 'This is where a Cacti User can edit their profile, change their password, logout, or find links to other Cacti information and support.',
    'non_admin_access' => 'Non-Administrative users, such as the Cacti Guest account should not have access to the Cacti Console. The Cacti Guest account should additionally not have access to their User Profile as that account is shared with many users.',

    // Graphs Top Tab section
    'graphs_top_tab_title' => 'The Cacti Graphs Top Tab',
    'graphs_top_tab_desc' => 'The Cacti Graphs Top Tab is where most Cacti Graphs are viewed. By default, the Cacti Graphs Top Tab includes three distinct views. They include:',
    'tree_view' => 'Tree View',
    'tree_view_desc' => 'Allows Cacti Users to view Graphs in the form of hierarchical Trees. These Trees are generally constructed by the Cacti Administrator and are controlled either at the User or User Group level.',
    'preview_view' => 'Preview View',
    'preview_view_desc' => 'The Preview View provides a view of all Graphs that a Cacti User has access to. Table Filters are provided to constrain the list of Graphs returned to the page.',
    'list_view' => 'List View',
    'list_view_desc' => 'The List View allows the Cacti user to Create their own Preview Page by allowing them to select graphs from various pages, and then finally view those pages from the Preview View.',
    'tree_view_example' => 'In the example Tree View page below, you can see the Tree Navigation Area to the left, and in the Cacti Content Area, you can see the Graphs and a Table Filter area for constraining the list of Graphs returned. You can Search the Tree View from the Search area above the Tree Navigation Area.',

    // Console section
    'console_title' => 'The Cacti Console',
    'console_intro' => 'In the image below, you can see a basic Cacti Console menu area. It is divided into separate sub-menus. We will describe the purpose of each next.',
    'main_console' => 'Main Console',
    'main_console_desc' => 'This sub-menu pick is fairly benign. It provides an open area. This screen feels like it needs more content if it\'s the Main Console. Fortunately, Plugin developers have solved this problem. The intropage plugin for example can fulfill that need.',
    'create' => 'Create',
    'create_desc' => 'This sub-menu allows you to create both Devices and Graphs. They are essentially shortcuts to other sub-menu picks.',
    'management' => 'Management',
    'management_desc' => 'This is where all core Cacti Site, Graph, Device, Tree, Data Source, and Aggregate non-templated objects reside. When you install Cacti Plugins, you will find they they extend this sub-menu.',
    'data_collection' => 'Data Collection',
    'data_collection_desc' => 'This is where you define rules for Data Collection Examples include: Data Collectors, Data Input Methods and Data Queries',
    'templates' => 'Templates',
    'templates_desc' => 'This is where you find all of Cacti\'s various Templates outside of Automation. By default, You will find Templates for Graphs, Data Sources, Devices, Aggregates, and Colors.',
    'automation' => 'Automation',
    'automation_desc' => 'This sub-menu is where you find rules for automating Device Discovery, and Rules for creating Devices, Graphs, and Trees.',
    'presets' => 'Presets',
    'presets_desc' => 'This area contains meta objects that cross Template boundaries and are Global in nature. They include; Data Source Profiles, CDEFs, VDEFs, GPrint Presets, and Colors',
    'import_export' => 'Import Export',
    'import_export_desc' => 'This is how you can import and export various Cacti Template objects.',
    'configuration' => 'Configuration',
    'configuration_desc' => 'This is where you manage Users, User Groups, User Domains, Global Settings, and Plugins.',
    'utilities' => 'Utilities',
    'utilities_desc' => 'This is where Cacti includes common utilities that can be use in the Web Portal without having to goto the Command line.',
    'troubleshooting' => 'Troubleshooting',
    'troubleshooting_desc' => 'There are some handy utilities here that help diagnose common problems with Cacti.',
    'objects_explanation' => 'All of these objects types will be explained in subsequent sections of the Cacti documentation. For now, it\'s important just to know that these pages exist.',

    // Principles of Operation page specific
    'page_title_principles_operation' => 'Cacti - Principles of Operation',
    'principles_operation_title' => 'Principles of Operation',
    'principles_intro' => 'To understand Cacti\'s principal of operation, you have to start at the top and work down. Cacti\'s operational model is divided into multiple layers. They include',
    'operational_layers' => 'Operational Layers',
    'devices_layer' => 'Devices',
    'sites_layer' => 'Sites',
    'data_collectors_layer' => 'Data Collectors (Pollers)',
    'data_retrieval_layer' => 'Data Retrieval',
    'data_storage_layer' => 'Data Storage',
    'graphing_layer' => 'Graphing',

    // Devices section
    'devices_title' => 'Devices',
    'devices_desc' => 'Cacti **Devices** are either physical hosts, sensors, clusters, services, or any type of object with a name and that can provide information about it self that should go into a **Graph** or could be used to provide additional information useful for Operations.',
    'devices_center' => 'The Cacti **Device** object serves as the center Cacti\'s world it\'s where stores information on how gather data about it. You can have from one to tens of thousands of **Devices** monitored from one Cacti system. It\'s very scalable. They can be discovered using Cacti\'s Automation sub-system, added manually, or gathered from a CMDB and added to Cacti using it\'s command line interface.',

    // Sites section
    'sites_title' => 'Sites',
    'sites_desc' => 'Cacti works with **Sites**. So, when you add a phyical **Device** to Cacti, you can associate it with a **Site**. Sites are designed to be physical locations. Cacti can organize **Devices** and it\'s **Graphs** by Site in a convenient fashion.',

    // Data Collectors section
    'data_collectors_title' => 'Data Collectors',
    'data_collectors_desc' => 'These are the physical or virtual hosts or containers that gather data about a group of devices either within a network or a site. They are resiliant in that if the central Cacti server is not reachable, they will cache data and wait for it to become available again.',
    'data_collectors_support' => 'Cacti supports upto dozens of Data Collectors today. Some customers use somethings as simple as a Raspberry Pi or Nuk for Data Collectors. However, Virtual Machines are preferred as they can be migrated live which does not interrupt data collection.',

    // Data Retrieval section
    'data_retrieval_title' => 'Data Retrieval',
    'data_retrieval_desc' => 'The Data Collectors first and foremost task it to retrieve data and forward it to the main Cacti server for storage. Cacti will do so using its poller which is a part of the Data Collector. The Poller is executed from the operating system\'s scheduler or from systemd depending on the OS and the version of the OS. It collects data as frequently as every 10 seconds to hours dynamically in the same system. So, one Cacti system can be monitoring objects at a 10 second granularity, a 30 second granularity, 1 minute all the way to once per several hours.',
    'data_flow_desc' => 'In the image below, you can see the general flow of data from the device to the Cacti database.',
    'enterprise_installations' => 'In enterprise installations, you\'re dealing with potentially thousands of devices of different type, e.g. Servers, Network Equipment, Appliances, Sensors, PDU\'s, Static Transfer Switches and the like. To retrieve data from remote targets/hosts, Cacti will mainly use the Simple Network Management Protocol SNMP. Thus, all devices capable of using SNMP will be eligible to be monitored by Cacti. But that\'s just the simplest case.',
    'hmib_plugin_desc' => 'Many customers gather data using out of band processes like using the Cacti hmib Plugin, which stores data in transient tables, and then Cacti can do device data collection directly from those transient tables. That design, since no device can be nearer in latency than the database, can scale to 30, 40, even 50 thousand devices with relative ease in Cacti depending on the size of your database and data collector infrastructure (sockets, cores, threads). When using this N-Tiered methology, most customers will use Cacti\'s `script server` which is a pool of memory resident PHP interpreters that preloads all scripts used to gather data, therefore, it\'s super fast, and parallel in nature. However, most customers will use SNMP, or SSH to gather metrics from their Devices. I mean, how many companies have 50 thousand devices that they monitor with regularity?',
    'rrd_storage_desc' => 'Once the data has been gathered, Cacti then uses either an out-of-band or in-band process to store the data into Round Robin Archive files, which represent a flat very well performing Time Series Databases called RRDfiles. See below for details on that storage mechanism.',

    // Data Storage section
    'data_storage_title' => 'Data Storage',
    'data_storage_desc' => 'In the industry, storage of the resulting data can take many forms. In Cacti, the RRDfile has been the tool of choice for many years. There are only so many ways to make a hammer, and RRDtool\'s a great hammer. Other approaches in the industry use SQL database, others flat files or document stores like ElasticSearch, Splunk, Mongo DB, InfluxDB. There are a number of options out there. You can get more information about RRDfile from the RRDtool Website.',
    'rrd_acronym' => '`RRD` is an acronym for **Round Robin Database**. RRD is a system to store and display time-series data (i.e. network bandwidth, machine-room temperature, server load average). It stores the data in a very compact way that will not expand over time, and it can create beautiful graphs. Data that ages beyond a certain point is consolidated and very old data just rolls off the end of the RRDfile. It ages out. This keeps storage requirements at bay.',
    'rrd_consolidation' => 'As mentioned, performs consolidation to combine raw data (a `primary data point` in RRDtool lingo) to consolidated data (a `consolidated data point`). This way, historical data is compressed to save space. RRDtool knows different consolidation functions: AVERAGE, MAXIMUM, MINIMUM and LAST.',

    // Data Presentation section
    'data_presentation_title' => 'Data Presentation',
    'data_presentation_desc' => 'One of the most appreciated features of RRDtool is the built-in graphing function. This comes in useful when combining this with some commonly used web server. Such, it is possible to access the graphs from merely any browser on any platform.',
    'graphing_engine_desc' => 'The Graphing engine is quite flexible. It is possible, to graph one or many items in one graph. Auto-scaling is supported and logarithmic y-axis, left and right axes, and much much more. You may stack items onto another and print pretty legends denoting characteristics such as minimum, average, maximum and lots more.',

    // Extending Capabilities section
    'extending_capabilities_title' => 'Extending Built-in capabilities',
    'extending_capabilities_desc' => 'As mentioned, scripts and Queries extend Cacti\'s capabilities beyond just SNMP. They allow for data retrieval using custom-made code. This is not even restricted to certain programming languages; you will find PHP, Perl, Python, shell/batch and more. These scripts and queries are executed locally by Cacti\'s Poller. But they may retrieve data from remote hosts by different protocols, e.g.',

    // Protocol table
    'protocol_column' => 'Protocol',
    'description_column' => 'Description',
    'icmp_protocol' => 'ICMP',
    'icmp_desc' => 'ping to measure round trip times and availability',
    'telnet_protocol' => 'telnet',
    'telnet_desc' => 'programming telnet scripts to retrieve data available to sysadmins only',
    'ssh_protocol' => 'ssh',
    'ssh_desc' => 'much like telnet, but more secure (and more complicated)',
    'http_protocol' => 'http(s)',
    'http_desc' => 'invoke remote cgi scripts to retrieve data via a web server or parse web pages for statistical data (e.g. some network printers)',
    'snmp_protocol' => 'snmp',
    'snmp_desc' => 'use Net-SNMP\'s exec/pass functions to call remote scripts and get data',
    'ldap_protocol' => 'ldap',
    'ldap_desc' => 'to retrieve statistical about your ldap server\'s activities',
    'custom_protocol' => 'use your own',
    'custom_desc' => 'invoke Nagios agents',
    'and_more' => 'and much more...',

    // Ways to extend Cacti
    'extending_ways' => 'There a two ways extending Cacti\'s build-in capabilities:',
    'data_input_methods_desc' => 'Data Input Methods for querying **single or multiple**, but **non-indexed** readings',
    'data_input_examples' => 'temperature, humidity, wind, ...',
    'cpu_memory_example' => 'cpu, memory usage',
    'users_logged_example' => 'number of users logged in',
    'ip_readings_example' => 'IP readings like ipInReceives (number of ip packets received per host)',
    'tcp_readings_example' => 'TCP readings like tcpActiveOpens (number of tcp open sockets)',
    'udp_readings_example' => 'UDP readings like udpInDatagrams (number of UDP packets received)',

    'data_queries_desc' => 'Data Queries for **indexed** readings',
    'network_interfaces_example' => 'network interfaces with e.g. traffic, errors, discards',
    'snmp_tables_example' => 'other SNMP Tables, e.g. hrStorageTable for disk usage',
    'data_queries_script_example' => 'you may even create Data Queries as scripts e.g. for querying a name server (index = domain) for requests per domain',

    'export_import_desc' => 'By using the Exporting and Importing facilities, it is possible to share your results with others.',

    // Beyond Graphs section
    'beyond_graphs_title' => 'Beyond Graphs',
    'beyond_graphs_desc' => 'Cacti is not just a Graphing platform, it\'s also a Network Operations Framework. Thought the dozens of plugins and user contributed Graph Templates, the sky is the limit as to what can be done using the Cacti Framework. It\'s stood the test of time now in it\'s 19th year of existence in the Open Source world.'
);
?>
