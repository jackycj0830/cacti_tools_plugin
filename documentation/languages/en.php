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
    'beyond_graphs_desc' => 'Cacti is not just a Graphing platform, it\'s also a Network Operations Framework. Thought the dozens of plugins and user contributed Graph Templates, the sky is the limit as to what can be done using the Cacti Framework. It\'s stood the test of time now in it\'s 19th year of existence in the Open Source world.',

    // Graph Overview page specific
    'page_title_graph_overview' => 'Cacti - Graph Overview',
    'graph_overview_title' => 'Graph Overview',
    'graph_overview_intro' => 'Almost everything in Cacti is somehow related to a **Graph**. At any time, you can list all available **Graph** by clicking on `Console > Management > Graphs` menu pick. While it is possible to manually create graphs through this interface, new users should follow the instructions provided in the next chapter for creating **New Graphs** in Cacti.',
    'graph_rrdtool_relation' => 'For users who are familiar with RRDtool, you will immediately recognize that a **Graph** in Cacti is closely modeled after RRDtool\'s graphs. This makes sense since Cacti provides a user friendly interface to RRDtool without requiring users to understand how RRDtool works. With this in mind, every **Graph** in Cacti has certain settings and at least one **Graph Item** associated with it. While graph settings define the overall properties of a **Graph**, the **Graph Items** define the data that is to be represented on the **Graph**. So the **Graph Items** define which data to display and how it should displayed, and also define what should be displayed on the legend.',
    'graph_templates_benefit' => 'Each **Graph** and **Graph Item** has a set of parameters which control various aspects of the **Graph**. Fortunately through the use of **Graph Templates**, it is not necessary to understand the function of each field to create **Graphs** for your network. When you are ready to take on the task of creating your own **Graph Templates**, extensive field descriptions for both **Graphs** and **Graph Items** are provided in that section of the manual.',
    'graph_management_interface' => 'Below, you can see a simple version of the Graph Management interface found by going to `Console > Management > Graphs`',
    'graph_management_features' => 'From this interface, you can see the Name, and ID of the **Graph**, the Source **Graph Template**, and it\'s size. At the bottom of the page, there is a list of Action that can be taken on **Graphs**. These actions are fairly extensive, and are also extended as you add **Plugins** to Cacti.',
    'graph_edit_page' => 'When you click on the Name of the **Graph**, you will be taken to a `Graph Edit` page as shown below.',
    'graph_template_limitations' => 'In most cases, where the **Graph** is owned by a **Graph Template**, there is not much your can do on this page. However, in the case that a **Graph** is not managed by a template as in the image below, there are many more options you will have when working with the **Graph**. The downside of not leveraging a **Graph Template** for your **Graphs** is that you have to duplicate the work for each **Graph** created.',
    'non_templated_graph_control' => 'When viewing a Non-Templated **Graph**, you have complete control of the **Graphs** Canvas and all the **Graph Items** as you would in a **Graph Template**, and the Graph Configuration as shown below.',
    'graph_settings_reference' => 'The settings in both the Canvas and Configuration components of the **Graph** will be covered in the **Graph Template** section of the manual and not covered here.',

    // Graph related terms
    'graph_item' => 'Graph Item',
    'graph_items' => 'Graph Items',
    'graph_template_single' => 'Graph Template',
    'graph_edit' => 'Graph Edit',
    'graph_management' => 'Graph Management',
    'graph_configuration' => 'Graph Configuration',
    'graph_canvas' => 'Graph Canvas',
    'non_templated_graph' => 'Non-Templated Graph',
    'templated_graph' => 'Templated Graph',
    'new_graphs' => 'New Graphs',
    'console_management_graphs' => 'Console > Management > Graphs',

    // How to Graph Your Network page specific
    'page_title_how_to_graph' => 'Cacti - How to Graph Your Network',
    'how_to_graph_title' => 'How to Graph Your Network',
    'how_to_graph_intro' => 'At this point, you probably realize that graphing is Cacti\'s greatest strength. Cacti has many powerful features that provide complex graphing and data acquisition, some which have a slight learning curve. Do not let that stop you however, because graphing your network is incredibly simple.',
    'basic_steps_intro' => 'The next two sections will outline the two basic steps which are typically required to create **Graphs** for most **Devices** or **Device Types**.',
    'automation_note' => '**NOTE**: The process described below is the Classic way for you to create and manage **Devices** and **Graphs**. However, Cacti now allows your to Automate many of these tasks in the **Automation** section of the Console. That topic is covered in the Automation Chapter.',

    // Creating a Device section
    'creating_device_title' => 'Creating a Device',
    'creating_device_intro' => 'The first step to creating **Graphs** for your network is adding a **Device** for each network device that you want to create **Graphs** for. A **Device** contains important details such as the network hostname, SNMP parameters, and **Device Type** (aka **Device Template**).',
    'device_management_intro' => 'To manage **Devices** within Cacti, click on the Devices menu item. Clicking Add will bring up a new device form. The first two fields, Description and Hostname are the only two fields that require your input beyond the defaults. If your host type is defined under the host template dropdown, be sure to select it here. You can always choose "Generic SNMP-enabled Host" if you are just graphing traffic or "None" if you are unsure. It is important to remember that the host template you choose will not lock you into any particular configuration, it will just provide more intelligent defaults for that type of host.',

    // Device Field Definitions
    'device_field_definitions' => 'Device Field Definitions',
    'description_field' => 'Description',
    'description_field_desc' => 'This description will show up in the first column of the device list. You may refer to it e.g. in graph titles.',
    'hostname_field' => 'Hostname',
    'hostname_field_desc' => 'Either an IP address or a hostname. The hostname will be resolved using the standard host resolving mechanisms, e.g. Dynamic Name Services (DNS)',
    'host_template_field' => 'Host Template',
    'host_template_field_desc' => 'A Host Template is a container for a list of graph templates that will be related to this host.',
    'notes_field' => 'Notes',
    'notes_field_desc' => 'Notes for a given device.',
    'disable_host_field' => 'Disable Host',
    'disable_host_field_desc' => 'Exclude this host from being polled. This is of particular value, if a device is no longer available, but should be kept e.g. as a reference.',

    // Availability/Reachability Options
    'availability_reachability_options' => 'Availability/Reachability Options',
    'downed_device_detection' => 'Downed Device Detection',
    'detection_none' => 'NONE',
    'detection_none_desc' => 'Deactivate downed host detection',
    'detection_ping_snmp' => 'PING and SNMP Uptime',
    'detection_ping_snmp_desc' => 'Ping and then also check SNMP Uptime',
    'detection_ping_or_snmp' => 'PING or SNMP Uptime',
    'detection_ping_or_snmp_desc' => 'Ping and if successful, move on, if not check SNMP Uptime',
    'detection_snmp_uptime' => 'SNMP Uptime',
    'detection_snmp_uptime_desc' => 'verify the SNMP Uptime only',
    'detection_snmp_desc' => 'SNMP Desc',
    'detection_snmp_desc_desc' => 'verify the SNMP System Description',
    'detection_snmp_getnext' => 'SNMP GetNext',
    'detection_snmp_getnext_desc' => 'verify the very next SNMP OID after .1.3',
    'detection_ping' => 'PING',
    'detection_ping_desc' => 'perform a ping test, see below',

    'ping_method' => 'Ping Method',
    'ping_method_desc' => 'Available only for **PING and SNMP** or **PING**',
    'ping_icmp' => 'ICMP',
    'ping_icmp_desc' => 'perform ICMP tests. Requires permissions',
    'ping_udp' => 'UDP',
    'ping_udp_desc' => 'perform a UDP test',
    'ping_tcp' => 'TCP',
    'ping_tcp_desc' => 'perform a TCP test',

    'ping_port' => 'Ping Port',
    'ping_port_desc' => 'Available only for UDP/TCP PING test types. Please define the port to be tested here. Make sure, that no firewall intercepts the test ping.',
    'timeout_value' => 'Timeout Value',
    'timeout_value_desc' => 'After this time, the test fails. Measured in units of milliseconds.',
    'ping_retry_count' => 'Ping Retry Count',
    'ping_retry_count_desc' => 'The number of times Cacti will attempt to ping a host before failing.',

    // SNMP Options
    'snmp_options_title' => 'SNMP Options',
    'snmp_version' => 'SNMP Version',
    'snmp_version_1' => 'Version 1',
    'snmp_version_1_desc' => 'Use SNMP Version 1. Be aware, that 64bit counters are not supported in this SNMP version.',
    'snmp_version_2' => 'Version 2',
    'snmp_version_2_desc' => 'Referred to as SNMP V2c in most SNMP documentations',
    'snmp_version_3' => 'Version 3',
    'snmp_version_3_desc' => 'SNMP V3, supporting authentication and encryption',
    'snmp_community' => 'SNMP Community',
    'snmp_community_desc' => 'SNMP read community for this device',
    'snmp_port' => 'SNMP Port',
    'snmp_port_desc' => 'UDP port number to use for SNMP (default is 161).',
    'snmp_timeout' => 'SNMP Timeout',
    'snmp_timeout_desc' => 'Maximum number of milliseconds Cacti will wait for an SNMP response (does not work with php-snmp support).',
    'max_oids_per_request' => 'Maximum OID\'s Per Get Request',
    'max_oids_per_request_desc' => 'This is a performance feature. Specifies the number of OID\'s that can be obtained in a single SNMP Get request. **WARNING**: This feature only works when using Spine. **WARNING** Some devices do not support values greater than `1` and/or may reports as unknown data if this value is too high.',

    // Security Options for SNMP V3
    'snmp_v3_security_options' => 'Security Options for SNMP V3',
    'snmp_username' => 'SNMP Username',
    'snmp_username_desc' => '`username` of an SNMP V3 `createUser` statement or equivalent',
    'snmp_password' => 'SNMP Password',
    'snmp_password_desc' => '`authpassphrase` of an SNMP V3 `createUser` statement or equivalent',
    'snmp_auth_protocol' => 'SNMP Auth Protocol',
    'snmp_auth_protocol_desc' => 'Authentication type of an SNMP V3 `createUser` statement or equivalent. Select either MD5, SHA, SHA-224, SHA-256, SHA-392, or SHA-512. Defaults to MD5.',
    'snmp_privacy_passphrase' => 'SNMP Privacy Passphrase',
    'snmp_privacy_passphrase_desc' => 'The `privacy passphrase` of an SNMP V3 `createUser` statement or equivalent.',
    'snmp_privacy_protocol' => 'SNMP Privacy Protocol',
    'snmp_privacy_protocol_desc' => 'The `privacy protocol` of an SNMP V3 `createUser` statement or equivalent. Select DES (if available), AES-128, AES-192, or AES-256. Defaults to DES.',
    'snmp_privacy_protocol_note' => '**NOTE** Spine may not support DES today as some Net-SNMP distributions have disabled it.',
    'snmp_context' => 'SNMP Context',
    'snmp_context_desc' => 'When using the View-Based Access Control Model (VACM), it is possible to specify an SNMP Context when mapping a community name to a security name with a `com2sec` directive, with the `group` directive and the `access` directive. This allows for defining special access models. If using such a parameter with your target\'s SNMP configuration, specify the context name to be used to access that target here.',

    // Device creation results
    'device_creation_results' => 'After saving your new device, you should be redirected back to the same edit form with some additional information. If you configured SNMP for this host by providing a valid community string, you should see various statistics listed at the top of the page. If you see "SNMP error" instead, this indicates an SNMP problem between Cacti and your device.',
    'associated_queries_templates' => 'Towards the bottom of the page there will be two addition boxes, Associated Data Queries, and Associated Graph Templates. If you selected a host template on the previous page, there will probably be a few items in each box. If there is nothing listed in either box, you will need to associate at least one data query or graph template with your new device or you will not be able to create graphs in the next step. If no available graph template or data query applies to your device, you can check the Cacti templates repository or create your own if nothing currently exists.',

    // A Word About SNMP
    'word_about_snmp' => 'A Word About SNMP',
    'snmp_version_choice' => 'The SNMP version that you choose can have a great effect on how SNMP works for you in Cacti. Version 1 should be used for everything unless you have reason to choose otherwise. If you plan on utilizing (and your device supports) high-speed (64-bit) counters, you must select version 2. Starting with Cacti 0.8.7, version 3 is fully implemented.',
    'snmp_retrieval_methods' => 'The way in which Cacti retrieves SNMP information from a host has an effect on which SNMP-related options are supported. Currently there are three types of SNMP retrieval methods in Cacti and are outlined below.',

    // SNMP Retrieval Types
    'snmp_retrieval_types' => 'SNMP Retrieval Types',
    'snmp_type_column' => 'Type',
    'snmp_description_column' => 'Description',
    'snmp_supported_options_column' => 'Supported Options',
    'snmp_where_used_column' => 'Where Used',
    'external_snmp' => 'External SNMP',
    'external_snmp_desc' => 'Calls the net-snmp snmpwalk and snmpget binaries that are installed on your system.',
    'external_snmp_options' => 'All SNMP options',
    'external_snmp_usage' => 'Web interface and PHP poller',
    'internal_snmp' => 'Internal SNMP',
    'internal_snmp_desc' => 'Uses PHP\'s SNMP functions which are linked against `net-snmp` at compile time.',
    'internal_snmp_options' => 'Version 1 Only',
    'internal_snmp_usage' => 'Web interface and PHP poller',
    'spine_snmp' => 'Spine SNMP',
    'spine_snmp_desc' => 'Links directly against `net-snmp` and directly uses the SNMP APIs.',
    'spine_snmp_options' => 'All SNMP options',
    'spine_snmp_usage' => 'Spine Poller',

    // SNMP V3 Options Explained
    'snmp_v3_options_explained' => 'SNMP V3 Options Explained',
    'snmp_v3_intro' => 'SNMP supports authentication and encryption features when using SNMP protocol version 3 known as **View-Based Access Control Model (VACM)**. This requires, that the target device in question supports and is configured for SNMP V3 use. In general, configuration of V3 options is target type dependent. The following is cited from `man snmpd.conf` concerning user definitions',
    'snmp_v3_users_title' => 'SNMPv3 Users',
    'snmp_v3_createuser_syntax' => 'createUser [-e ENGINEID] username (MD5|SHA) authpassphrase [DES|AES] [privpassphrase]',
    'snmp_v3_auth_types' => 'MD5 and SHA are the authentication types to use. DES and AES are the privacy protocols to use. If the privacy passphrase is not specified, it is assumed to be the same as the authentication passphrase. Note that the users created will be useless unless they are also added to the VACM access control tables described above.',
    'snmp_v3_openssl_note' => 'SHA authentication and DES/AES privacy require OpenSSL to be installed and the agent to be built with OpenSSL support. MD5 authentication may be used without OpenSSL.',
    'snmp_v3_passphrase_warning' => 'Warning: the minimum pass phrase length is 8 characters.',

    // VACM Configuration
    'vacm_configuration' => 'VACM Configuration',
    'vacm_intro' => 'The full flexibility of the VACM is available using four configuration directives - com2sec, group, view and access. These provide direct configuration of the underlying VACM tables.',
    'vacm_com2sec' => 'com2sec [-Cn CONTEXT] SECNAME SOURCE COMMUNITY',
    'vacm_com2sec_desc' => 'map an SNMPv1 or SNMPv2c community string to a security name - either from a particular range of source addresses, or globally ("default"). A restricted source can either be a specific hostname (or address), or a subnet - represented as IP/MASK (e.g. 10.10.10.0/255.255.255.0), or IP/BITS (e.g. 10.10.10.0/24), or the IPv6 equivalents.',

    // Creating the Graphs
    'creating_graphs_title' => 'Creating the Graphs',
    'creating_graphs_intro' => 'Now that you have created some devices, it is time to create graphs for these devices. To do this, select the New Graphs menu option under the Create heading. If you\'re still at the device edit screen, select Create Graphs for this Host to see a screen similar to the image pictured below.',
    'new_graphs_concept' => 'The dropdown menu that contains each device should be used to select the host that you want to create new graphs for. The basic concept to this page is simple, place a check in each row that you want to create a graph for and click Create.',
    'data_query_considerations' => 'If you are creating graphs from inside a "Data Query" box, there are a few additional things to keep in mind. First is that you may encounter the situation as pictured above with the "SNMP - Interface Statistics" data query. If this occurs you may want to consult the section on debugging data queries to see why your data query is not returning any results. Also, you may see a "Select a graph type" dropdown box under some data query boxes. Changing the value of this dropdown box affects which type of graph Cacti will make after clicking the Create button. Cacti only displays this dropdown box when there is more than one type to choose from, so it may not be displayed in all cases.',
    'graph_creation_final_step' => 'Once you have selected the graphs that you want to create, simply click the Create button at the bottom of the page. You will be taken to a new page that allows you to specify additional information about the graphs you are about to create. You only see the fields here that are not part of each template, otherwise the value automatically comes from the template. When all of the values on this page look correct, click the Create button one last time to actually create your graphs.',
    'graph_management_note' => 'If you would like to edit or delete your graphs after they have been created, use the Graph Management item on the menu. Likewise, the Data Source menu item allows you to manage your data sources in Cacti.',

    // Viewing Graphs page specific
    'page_title_viewing_graphs' => 'Cacti - Viewing Graphs',
    'viewing_graphs_title' => 'Viewing Graphs',

    // Background section
    'background_title' => 'Background',
    'background_intro' => 'Cacti, when it was first invented in 2001 by Ian Berry, his vision was to make it the fastest and easiest way to view and render Network Monitoring **Graphs** for people in the Network, Site, and Data Center Operations Space. As such, it\'s focus from the very beginning was on render just one thing, **Graphs**. So, as such, the second **Top Tab** on a Cacti system is the **Graphs** tab.',

    // The Graphs Top Tab section
    'graphs_top_tab_title' => 'The Graphs Top Tab',
    'graphs_top_tab_intro' => 'The **Graphs** **Top Tab** has a few personalities. They include:',
    'tree_view_title' => 'Tree View',
    'tree_view_description' => 'Allows Cacti Users to view **Graphs** in the form of hierarchical **Trees**. These **Trees** are generally constructed by the Cacti Administrator and are controlled either at the **User** or **User Group** level.',
    'preview_view_title' => 'Preview View',
    'preview_view_description' => 'The **Preview View** provides a view of all **Graphs** that a Cacti User has access to. **Table Filters** are provided to constrain the list of **Graphs** returned to the page.',
    'list_view_title' => 'List View',
    'list_view_description' => 'The **List View** allows the Cacti user to Create their own **Preview Page** by allowing them to select graphs from various pages, and then finally view those pages from the **Preview View**.',

    'graph_view_personalities' => 'The way these various personalities appear in Cacti is somewhat different depending on your Theme. Review the two images below, for how you navigate to the various **Graph View** modes.',
    'classic_theme_layout' => 'In this first image, we see the way the **Graph View** options are displayed to the end user. This is the layout of the Classic, Modern and Dark themes.',
    'alternate_theme_layout' => 'In this second image, you can see the way the **Graph View** page will appear for users of the Paw, Paper-Plane, and Sunrise themes.',

    // Graph Manipulation and Options section
    'graph_manipulation_title' => 'Graph Manipulation and Options',
    'graph_manipulation_intro' => 'Once you can view the **Graphs**, there will be a Filter Panel that will provide you multiple options to limit your view of them. Below, you can see an image of that Filter Panel.',
    'filter_panel_options' => 'From this sub-panel, you can do the following:',
    'search_regex' => 'Search by regular expression',
    'select_graph_templates' => 'Select one to many, or all **Graph Templates** to view',
    'graphs_per_page' => 'Specify the number of Graphs per Page',
    'display_columns' => 'Specify the number of columns to Display',
    'view_thumbnails_or_full' => 'View either Legendless Thumbnails or full Graphs with their legends',
    'preset_timespans' => 'Set various Preset Time-spans, or select a Time Range',
    'shift_time' => 'Shift the Time either forward or backward by the Shift Time-span',

    'save_defaults' => 'Once you have the Filter where you like it from a Columns, Thumbnails, and Graphs per Page setting, you can press the `Save` button, if you have the correct permissions and save those defaults for your next login.',
    'action_icons_intro' => 'Depending again on permissions, to the right of the **Graphs**, you will find a number of action icons that allow you to operate on the **Graphs**',
    'action_icons_example' => 'The image below shows what that might look like if you have the **Thold** and **QuickTree** **Plugins** installed.',
    'action_icons_description' => 'From top to bottom, the Graph Action Icons do the following.',

    // Graph Action Icons table
    'action_icon_name_column' => 'Name',
    'action_icon_description_column' => 'Description',
    'graph_details_icon' => 'Graph Details',
    'graph_details_desc' => 'Allow you to perform precision zooming, view RRDtool debug information and perform CSV exports of your Graph Data.',
    'csv_export_icon' => 'CSV Export',
    'csv_export_desc' => 'Allows you to directly CSV Export your Graph Data',
    'realtime_view_icon' => 'Realtime View',
    'realtime_view_desc' => 'Allows you to view your Graphs at down to a 1 second granularity either in place, or in a pop-up Window',
    'spike_kill_icon' => 'Spike Kill',
    'spike_kill_desc' => 'Allow you to clear up Spikes and Gaps in your Graph',
    'create_threshold_icon' => 'Create Threshold',
    'create_threshold_desc' => 'Create a Threshold for the Graph',
    'add_to_quicktree_icon' => 'Add to QuickTree',
    'add_to_quicktree_desc' => 'Allow you to select Graphs to add to Trees by simply tooling around the Graphs page.',

    // Graph Zooming section
    'graph_zooming_title' => 'Graph Zooming',
    'graph_zooming_intro' => 'Cacti also has a powerful Graph Zoom interface built in. You can discover what it allows you to do by simply right clicking in the Graph area. When zooming, you will zoom all the **Graphs** on a page. It\'s quite powerful.',
    'zoom_options_note' => 'There are many options for the Zoom menu. Instead of explaining them here try them out for yourself.',

    // Common graph viewing terms
    'graph_view_modes' => 'Graph View Modes',
    'filter_panel' => 'Filter Panel',
    'action_icons' => 'Action Icons',
    'zoom_interface' => 'Zoom Interface',
    'context_menu' => 'Context Menu',
    'time_range' => 'Time Range',
    'time_span' => 'Time Span',
    'thumbnails' => 'Thumbnails',
    'legends' => 'Legends',
    'precision_zooming' => 'Precision Zooming',
    'rrdtool_debug' => 'RRDtool Debug',
    'graph_data' => 'Graph Data',
    'granularity' => 'Granularity',
    'popup_window' => 'Pop-up Window',
    'spikes_and_gaps' => 'Spikes and Gaps',
    'threshold' => 'Threshold',
    'quicktree' => 'QuickTree',

    // Devices page specific
    'page_title_devices' => 'Cacti - Device Management',
    'devices_title' => 'Device Management',
    'devices_intro' => 'This section will describe **Device** management in Cacti.',
    'devices_adding_methods' => 'Adding a **Device** to Cacti can be done in a few different ways, either via the Web GUI, Cacti\'s Automation, or the Command Line Interface (CLI).',

    // Web GUI Option section
    'web_gui_option_title' => 'Web GUI Option',
    'web_gui_intro' => 'To add a device via the Web GUI first click on `Console > Management > Devices` and you will see the below device console window which will show existing devices if any',
    'add_device_button_desc' => 'You will now select the + on the top right hand corner',
    'add_device_screen_desc' => 'Once you select the + otherwise known as the add device button you will see the below screen which will ask you for device specific information',
    'device_important_info' => 'Some of the most important information about the device will be required in this window which includes',

    // Device fields
    'device_description_field' => 'Description',
    'device_description_desc' => 'The name that will appear on **Graphs** by default',
    'device_ip_hostname_field' => 'IP/Hostname',
    'device_ip_hostname_desc' => 'The DNS or IP address of the actual **Device**. IPv6 address insert into brackets (example: [2001:abcd:1234::1])',
    'device_poller_association_field' => 'Poller Association',
    'device_poller_association_desc' => 'Defines which **Data Collector** is responsible for pulling information about the **Device**',
    'device_template_field' => 'Device Template',
    'device_template_desc' => 'Cisco, Net-SNMP, Linux, etc - The Cacti object that holds all the **Graph Templates** and **Data Queries** to be graphed',
    'device_site_location_field' => 'Site, Location',
    'device_site_location_desc' => 'Very important to performing Meta queries, or for Site level Graph organization on Cacti **Graph Trees**',
    'device_availability_field' => 'Availability/Reachability',
    'device_availability_desc' => 'Settings that describe **Device** timeouts and availability methods.',
    'device_snmp_info_field' => 'SNMP information',
    'device_snmp_info_desc' => 'SNMP Credentials for connecting to the **Device**',
    'device_notes_field' => 'Device Notes',
    'device_notes_desc' => 'Arbitrary unstructured information about the **Device**',

    'device_save_and_create_graphs' => 'Cacti requires this basic information to be able to monitor the device and once entered, click save on the bottom right corner. With the device created you will need to add graphs for the device by clicking **Create graphs for this device** on the top right hand corner.',

    // Availability/Reachability Settings section
    'availability_reachability_settings_title' => 'Availability/Reachability Settings',
    'availability_intro' => 'Cacti prefers to use the Simple Network Management Protocol (SNMP) to communicate with **Devices**. Therefore, when creating a **Device**, you need to provide SNMP credentials to obtain information about the **Device** in order to collect data from it. Before Cacti will query the **Device** for data, it first verifies that the **Device** is up and responding. When doing so, you have several options. They include:',

    // Availability options
    'availability_none' => 'None',
    'availability_none_desc' => 'Always assume the device is up. This is generally reserved for **Device** objects that do not have a state.',
    'availability_snmp_uptime' => 'SNMP Uptime',
    'availability_snmp_uptime_desc' => 'Query the SNMP Uptime Instance OID',
    'availability_ping_snmp' => 'Ping and SNMP Uptime',
    'availability_ping_snmp_desc' => 'Ping the device but also check the SNMP Uptime Instance OID',
    'availability_ping' => 'Ping',
    'availability_ping_desc' => 'Either ICMP, TCP at a port, or UDP as a port. Newer version has an additional method TCP Ping Closed. The device is considered UP even if the tcp ping returns closed',
    'availability_ping_or_snmp' => 'Ping or SNMP Uptime',
    'availability_ping_or_snmp_desc' => 'Only one needs to be working for Cacti to collect data',
    'availability_snmp_desc' => 'SNMP Desc',
    'availability_snmp_desc_desc' => 'Query the SNMP sysDescription in cases where the SNMP Uptime OID is not available',
    'availability_snmp_getnext' => 'SNMP GetNext',
    'availability_snmp_getnext_desc' => 'Query the first available OID in the OID tree for the **Device** Used for certain devices that have limited SNMP support.',

    // SNMP Credentials section
    'snmp_credentials_title' => 'SNMP Credentials',
    'snmp_credentials_intro' => 'When providing the SNMP credentials, Cacti currently supports the following versions:',
    'snmp_v1_title' => 'Version 1',
    'snmp_v1_desc' => 'Rarely used any more. Reserved for very old hardware',
    'snmp_v2_title' => 'Version 2',
    'snmp_v2_desc' => 'Still very popular, and support 64 bit counters except on Windows',
    'snmp_v3_title' => 'Version 3',
    'snmp_v3_desc' => 'Support is provided, but there are presently a limitation. If you are using advanced settings such as SHA224+ or AES192+ with SNMPv3, you must uninstall the php-snmp module if it\'s in use in php and leverage the Net-SNMP binaries instead.',
    'snmp_credentials_warning' => 'When providing the SNMP Credentials, Cacti will warn you if you have provided incomplete information depending on the SNMP Version and SNMP Security Level you have specified.',

    // Additional Important Options section
    'additional_important_options_title' => 'Additional Important Options',
    'additional_options_intro' => 'There are some additional options that you should note before starting to use Cacti. They include the following:',
    'device_threads_option' => 'Device Threads',
    'device_threads_desc' => 'If your device is far away, and can tolerate multiple threads querying information, you can increase this number to reduce the time it takes to collect all information.',
    'max_oids_option' => 'Maximum OIDs Per Get Request',
    'max_oids_desc' => 'Otherwise known as MaxOID\'s, this SNMP option will allow the SNMP client to gather more metrics per get request. Please keep in mind that the higher you make this number, the longer a SNMP respond may take. So, you have to be sensitive about the SNMP timeout as the number get\'s larger. Since, by default SNMP is generally collected over UDP, you will also be limited in the number of responses depending on how many routers or VPN\'s you traverse to reach a device. When traversing VPN connections, many VPN\'s limit the MTU to around 500 bytes, which will significantly limit how large the Max OID\'s can be. In some cases, it may be better to deploy a **Remote Data Collector** when your device is either far way from a latency perspective, or that you must traverse VPN\'s to communicate with.',
    'external_id_option' => 'External ID',
    'external_id_desc' => 'This field is normally used for Asset Tracking information for the **Device**, but it use is entirely up to the System Administrator.',

    // Plugin Behavior section
    'plugin_behavior_title' => 'Plugin Behavior',
    'plugin_behavior_intro' => 'Many Cacti Plugins can and do add additional columns to the Device table in Cacti. Depending on the Plugin you have installed, you will find other information that you can provide about the device including things like:',
    'notification_settings_option' => 'Notification Settings',
    'notification_settings_desc' => 'Who to notify when the **Device** changes state',
    'criticality_option' => 'Criticality',
    'criticality_desc' => 'How important is the device',
    'failure_recovery_option' => 'Failure and Recovery Counts',
    'failure_recovery_desc' => 'How long till a device is treated as truly down.',
    'ping_thresholds_option' => 'Ping Thresholds',
    'ping_thresholds_desc' => 'What RTL is considered bad when reaching a device',

    // CLI section
    'cli_creation_title' => 'Creating devices via CLI script',
    'cli_creation_intro' => 'You can also create device by using the CLI script located at /cactidir/cli/',
    'cli_usage_example' => 'To add a device using the bare minimum information would look something like this',
    'cli_success_message' => 'Adding test (192.168.1.15) as "Cacti Stats" using SNMP v3 with community "public"\nSuccess - new device-id: (45)',

    // Common device management terms
    'device_console' => 'Device Console',
    'add_device_button' => 'Add Device Button',
    'create_graphs_for_device' => 'Create graphs for this device',
    'device_management' => 'Device Management',
    'data_collector' => 'Data Collector',
    'remote_data_collector' => 'Remote Data Collector',
    'asset_tracking' => 'Asset Tracking',
    'system_administrator' => 'System Administrator',

    // Sites page specific
    'page_title_sites' => 'Cacti - Site Management',
    'sites_title' => 'Site Management',
    'sites_intro' => 'This section will describe **Site** management in Cacti.',
    'sites_purpose' => 'Sites in Cacti can be used to separate different parts of your company with the respective location devices. For example, you can have a site called **123 main street** in which you can associate all of the devices that are in the physical location to the Cacti site. This could also be a customer site or data center location',
    'sites_page_image_desc' => 'Cacti Sites page',
    'sites_attribute_data' => 'Below is an example of some of the attribute data you can enter for the site/location',
    'sites_create_instruction' => 'Enter the appropriate information for the site and click create on the below right side',
    'sites_add_image_desc' => 'cacti add sites',
    'sites_device_association' => 'Once you have created a site while you are creating a device manually you can now associate the device to the site',
    'sites_device_site_image_desc' => 'cacti add device site',
    'sites_automation_association' => 'You can also associate the discovered devices via automation to a particular site.',
    'sites_automation_image_desc' => 'cacti sites automation',

    // Common site management terms
    'site_management' => 'Site Management',
    'physical_location' => 'Physical Location',
    'customer_site' => 'Customer Site',
    'data_center_location' => 'Data Center Location',
    'attribute_data' => 'Attribute Data',
    'device_association' => 'Device Association',
    'discovered_devices' => 'Discovered Devices',
    'automation_association' => 'Automation Association',

    // Trees page specific
    'page_title_trees' => 'Cacti - Cacti Trees',
    'trees_title' => 'Cacti Trees',
    'trees_section_title' => 'Trees',
    'trees_intro' => 'A **Tree** can be thought of as a hierarchical way of organizing your graphs. Each **Tree** consists of zero or more branches that contain leaf nodes such as **Graphs**, **Devices** and **Sites**. It\'s a very powerful way of organizing your **Graphs**.',
    'trees_current_setup' => 'Below we can see the current **Trees** we have setup on our Cacti server. To get to this screen click `Console > Management > Trees`.',
    'trees_add_remove' => 'From this page you can add or remove **Trees** as required.',
    'tree_management_page_desc' => 'Tree Management Page',
    'trees_graph_view' => 'Below is how a **Tree** is displayed in **Graph View**. We can see the **Device** that is being monitored - clicking on this **Device** will result in seeing all of the **Graph** data generated for the **Device**.',
    'tree_view_desc' => 'Tree View',

    // Creating a Tree section
    'creating_tree_title' => 'Creating a Tree',
    'creating_tree_intro' => 'To create a new tree simply click the Add button (+) on the top right hand corner and enter a name for your **Tree**. After the tree has been created you will see the below page where you are able to add **Devices** to the **Tree**.',
    'tree_options_desc' => 'Tree Options',
    'tree_device_adding' => 'To add devices to the new tree simply drag an available device to the tree and it will be added to the tree. Cacti currently supports four `Sort Types`, which can be either inherited, of left to the author to define inheritance and at what level. See the image below for a visual representation of how Tree Sorting is accomplished.',
    'tree_sorting_desc' => 'Tree Sorting',

    // Tree Sorting Type Definitions table
    'tree_sorting_table_title' => 'Table 8-1. Tree Sporting Type Definitions',
    'tree_field_column' => 'Field',
    'tree_value_column' => 'Value',
    'tree_description_column' => 'Description',
    'tree_name_field' => 'Name',
    'tree_name_value' => 'Name of the tree entry.',
    'tree_name_desc' => 'The sort order of all trees themselves is',
    'tree_alphabetical_note' => 'always alphabetical',
    'tree_sorting_type_field' => 'Sorting Type',
    'tree_manual_ordering' => 'Manual Ordering (No Sorting)',
    'tree_manual_ordering_value' => 'Y',
    'tree_manual_ordering_desc' => 'ou may chance the sequence at your will',
    'tree_alphabetical_ordering' => 'Alphabetical Ordering',
    'tree_alphabetical_value' => '1, Ab, ab',
    'tree_alphabetical_desc' => 'All sub-trees are ordered alphabetically,',
    'tree_alphabetical_note_desc' => 'unless specifies otherwise (you may chance sort options at sub-tree label)',
    'tree_natural_ordering' => 'Natural Ordering',
    'tree_natural_value' => 'ab1, ab2, ab7, ab10, ab20',
    'tree_natural_desc' => 'N/A',
    'tree_numeric_ordering' => 'Numeric Ordering',
    'tree_numeric_value' => '01, 02, 4, 04',
    'tree_numeric_desc' => 'Leading zeroes are not taken into account',
    'tree_numeric_note' => 'when ordering numerically',

    // Tree management and editing
    'tree_publishing' => 'End users will not be able to view the **Tree** or it\'s Graphs until you publish it. To edit a **Tree**, you will be required to lock it for your use. The locking is designed to prevent multiple users from editing a **Tree** simultaneously.',
    'tree_drag_drop' => 'When a Tree is locked, you can drag & drop the **Sites**, **Devices** and **Graphs** over to the Tree menu. To add a \'Root Branch\', simply press the button to do so, once you have Root Branches, you may right click on the to create sub-branches on the Tree.',
    'tree_site_interaction' => 'When you single click on a **Site**, the **Devices**, and **Graphs** associated with that **Site** should appear in their respective sections. You can also type into the Search fields above the various sections to drill into them. You can also shift-click and control-click on the objects within a section to drag & drop multiple objects at one time.',
    'tree_unlock_reminder' => 'Don\'t forget to unlock your **Tree** before finishing your editing session.',

    // Common tree management terms
    'tree_management' => 'Tree Management',
    'hierarchical_organization' => 'Hierarchical Organization',
    'leaf_nodes' => 'Leaf Nodes',
    'root_branch' => 'Root Branch',
    'sub_branches' => 'Sub-branches',
    'sort_types' => 'Sort Types',
    'manual_ordering' => 'Manual Ordering',
    'alphabetical_ordering' => 'Alphabetical Ordering',
    'natural_ordering' => 'Natural Ordering',
    'numeric_ordering' => 'Numeric Ordering',
    'tree_locking' => 'Tree Locking',
    'tree_publishing' => 'Tree Publishing',
    'drag_and_drop' => 'Drag & Drop',

    // Graphs page specific
    'page_title_graphs' => 'Cacti - Graph Management',
    'graphs_title' => 'Graph Management',
    'graphs_intro' => 'This section will describe **Graph** management in Cacti.',
    'graphs_console_view' => 'Cacti features a way to view the graphs per device via the console. This allows the administrator to view the graphs that are attached to a specific device. You can also search by type of graph. Below we search for graphs that are associated with the local linux server',
    'graph_management_image_desc' => 'graph management',
    'graphs_menu_description' => 'Clicking on one of the graphs in the list shows the below menu. From this menu you can enable debugging on the specific graph you can also change the template of the graph amongst other things',
    'graph_management_click_desc' => 'Graph management click',

    // Modifying the graph template section
    'modifying_graph_template_title' => 'Modifying the graph template',
    'modifying_graph_template_desc' => 'Cacti allows you to change many aspects of the graph template. You can change parameters such the title of the graph as well the size of the graphs. These changes will be pushed to the graph template so other devices using the template will also be updated.',
    'graph_template_options_desc' => 'Graph template options',

    // Common graph management terms
    'graph_management_console' => 'Graph Management Console',
    'graph_debugging' => 'Graph Debugging',
    'graph_template_modification' => 'Graph Template Modification',
    'graph_parameters' => 'Graph Parameters',
    'graph_title' => 'Graph Title',
    'graph_size' => 'Graph Size',
    'template_updates' => 'Template Updates',

    // Data Sources page specific
    'page_title_data_sources' => 'Cacti - Data Source Management',
    'data_sources_title' => 'Data Source Management',
    'data_sources_intro' => 'Data sources in Cacti are the points of data that Cacti will collect from a device. The following are examples of different sources that can be utililised for graphing, though is just the surface of what is achievable:',
    'data_source_ping_example' => 'Monitoring a device via ping will usually count as 1 data source.',
    'data_source_switch_example' => 'A 24 port switch and you poll the device via snmp and graph all of the ports then there will be 24 data sources',
    'data_source_note' => '**Note**: if you add more graphs that base their data on the original **Data source** that would not count as another **Data Source** since it uses the already existing source.',
    'data_source_example_explanation' => 'For example, if you have a 24 port switch that you create an **In/Out Bits** graph for each interface, and you then add the **In/Out Bits with 95th Percentile** for each interface, you would still only have 24 data sources.',
    'data_source_resource_importance' => 'Keeping on top of the amount of data sources you have is important as the more data sources you have the more resources you will need to allocate to your server.',
    'data_source_device_view' => 'You can see how many data sources are associated with a single device by going to management then clicking on devices.',
    'device_datasources_image_desc' => 'device datasources',
    'data_source_total_view' => 'You can also see the total amount of data sources by checking the poller stats on the system. Click the log tab and filter by stats and lookout for the below messege',
    'data_source_stats_example' => '2019/05/24 17:21:11 - SYSTEM STATS: Time:9.5913 Method:spine Processes:2 Threads:2 Hosts:14 HostsPerProcess:7 DataSources:162 RRDsProcessed:117',
    'data_source_stats_explanation' => 'This output tells us we have 162 data sources on the system.',

    // Storage considerations section
    'storage_considerations_title' => 'Storage considerations and datasources',
    'storage_considerations_intro' => 'The amount of data sources on your system has an impact on the amount of storage you will need. You will also need to consider what rate you are polling your devices. e.g. 1 minute or 5 Minute polls',
    'storage_per_datasource' => 'Here is the approximate amount of storage you can expect to consume per data source',

    // Storage table headers
    'polling_time_column' => 'Polling time',
    'retention_column' => 'Retention',
    'file_size_column' => 'File size',

    // Storage table data
    'thirty_second' => '30 second',
    'one_minute' => '1 minute',
    'five_minute' => '5 minute',
    'daily' => 'Daily',
    'weekly' => 'Weekly',
    'monthly' => 'Monthly',
    'yearly' => 'Yearly',

    // Common data source terms
    'data_source_management' => 'Data Source Management',
    'data_collection_points' => 'Data Collection Points',
    'polling_rate' => 'Polling Rate',
    'storage_requirements' => 'Storage Requirements',
    'poller_statistics' => 'Poller Statistics',
    'system_resources' => 'System Resources',

    // Aggregates page specific
    'page_title_aggregates' => 'Cacti - Aggregate Graphs',
    'aggregates_title' => 'Aggregate Graphs',
    'aggregates_intro' => 'This section will describe **Aggregate Graphs** in Cacti.',

    // Common aggregate terms
    'aggregate_graphs' => 'Aggregate Graphs',
    'aggregation' => 'Aggregation',
    'graph_aggregation' => 'Graph Aggregation',

    // Data Collectors page specific
    'page_title_data_collectors' => 'Cacti - Data Collectors',
    'data_collectors_title' => 'Data Collectors',
    'data_collector_background_title' => 'Data Collector Background',
    'data_collectors_intro' => 'Cacti can support from one to many **Data Collectors**. There are two types of **Data Collectors** they are:',
    'main_data_collector' => '**Main Data Collector** - This is essentially your core Cacti server and database. The **Main Data Collector** is also referred to as the **Primary Server**.',
    'remote_data_collector' => '**Remote Data Collector** - These Data Collectors are located in distant locations, or where reaching devices is blocked due to firewall or security policies. The **Remote Data Collectors** are also referred to as **Remote Pollers**.',
    'remote_collector_design' => 'Due to the design of the Cacti **Remote Data Collector**, somone at the remote site, can actually login to that **Data Collector** and interact with it as if their **Data Collector** was the **Main Data Collector**. Additionally, if for some reason the **Main Data Collector** becomes unavailable due to a WAN outage for example, the data for the **Devices** it manages will be cached locally until such time as the **Main Data Collector** is reachable again.',
    'collector_normalization' => 'Once the **Main Data Collector** becomes reachable, the **Remote Data Collector** will flush it cache back to the **Main Data Collector** and the system will normalize. Therefore, this is generally considered to be a more Highly Available (HA) design.',
    'enterprise_architecture' => 'A good Enterprise Architecture for Cacti would include three **Main Data Collectors** which cactid systemd service was managed by keepalived, using GlusterFS as fully replicated File system for the Web Server, the logs, and the RRDfiles using MariaDB Galera as the fully fault tolerant database server.',
    'load_balancing' => 'Then, either using keepalived to a load balancer, you could load balance the connections across all three **Main Data Collectors**, using the MariaDB Galera database to maintain login session data. There are many good articles on setting up and using MariaDB Galera along with HAProxy or load balancers from Citrix and others to direct read and write traffic to the correct Galera instance server. The bottom line is that Cacti provides the opportunity to have a Highly Available (HA) setup today.',
    'ha_setup_note' => 'That HA setup will not be covered in this chapter, but may be included at a later date.',
    'boost_module_requirement' => 'When using multiple **Data Collectors**, Cacti requires the use of the `boost` module, which is now included in the main Cacti package. Therefore if you are planning on deploying multiple **Data Collectors**, you should become familiar with its use and why it is critical to a HA design.',
    'network_requirements' => 'In order for a **Remote Data Collector** to work with a **Main Data Collector** the **Remote Data Collector** must be able to talk to the **Main Data Collector** over both https and the MySQL protocol in a bidirectional fashion. Therefore, there are only two ports that are required to be open in order to fully leverage the multiple **Data Collector** architecture in Cacti.',

    // Data Collector User Interface section
    'data_collector_ui_title' => 'Data Collector User Interface',
    'data_collector_ui_description' => 'The image below shows the current online collector (aka pollers). On this page, we can see the current, average, and max data collection times, the **Data Collector** processes and threads used, the number of **Devices** as well as what those **Devices** are polling. The Actions drop-down allows your to Enable, Disable, and Delete **Remote Data Collectors**. There is also a `Full Sync` option there. The `Full Sync` option will replicate key Cacti tables to the selected **Remote Data Collectors** for things like authentication, global settings, etc.',
    'full_sync_usage' => 'In the current Cacti design, you should not have to perform a `Full Sync` very often. It would mainly be used to push the user database and global settings to the remotes, after an outage if there were database changes during that outage.',
    'data_collectors_image_desc' => 'Data Collectors',
    'main_collector_description' => 'The **Main Data Collector** resides on the central Cacti server. It also serves as the master **Data Collector** performing key maintenance operations for the entire system.',
    'main_collector_edit_description' => 'In the edit page below, you can see what options are available when editing the **Main Data Collector**. It is important the the hostname used is resolvable by the **Remote Data Collectors**.',
    'data_collectors_edit_main_desc' => 'Data Collectors Edit Main',
    'remote_collector_edit_description' => 'When editing the **Remote Data Collector** in the images below, you can see that it shares many of the settings of the **Main Data Collector** with the addition of a `TimeZone` setting and MySQL/MariaDB credentials and a `Test Connection` button. Generally, these setting are only use during the initial setup of Cacti, and afterwards for diagnostics only.',
    'data_collectors_edit_remote_desc' => 'Data Collectors Edit Remote',
    'data_collectors_edit_remote_test_desc' => 'Data Collectors Edit Remote Connection Test',

    // Setup section
    'setup_main_collector_title' => 'Setup Main Data Collector to accept connections Remotes',
    'mysql_config_changes' => 'We will need to make some config changes to the MySQL configuration to allow the **Remote Data Collector** to talk to the **Main Data Collector**.',
    'mysql_grant_commands' => 'mysql -u root mysql -e "GRANT ALL ON cacti.* TO cactidb@<ip of remote poller host>  IDENTIFIED BY \'password\';"
mysql -u root mysql -e "GRANT SELECT ON mysql.time_zone_name TO cacti@<ip of remote poller host> IDENTIFIED BY \'password\';"',
    'remote_config_setup' => 'Next setup the **Remote Data Collectors** config.php located in `<path_cacti>/include/config.php` with the remote database details and credentials. Generally, you will not have to do this as part of the direct maintenance of the **Remote Data Collector**, the **Remote Data Collector** install process will force you to take these steps to complete the install. However, it\'s provided here for reference so that you understand the process.',
    'remote_config_example' => '#$rdatabase_type     = \'mysql\';
#$rdatabase_default  = \'cacti\';
#$rdatabase_hostname = \'localhost\'; <<< IP/Hostname of main server
#$rdatabase_username = \'cactiuser\';
#$rdatabase_password = \'cactiuser\';
#$rdatabase_port     = \'3306\';
#$rdatabase_retries  = 5;
#$rdatabase_ssl      = false;
#$rdatabase_ssl_key  = \'\';
#$rdatabase_ssl_cert = \'\';
#$rdatabase_ssl_ca   = \'\';',
    'remote_install_instruction' => 'You will now need to install Cacti on the remote server selecting the **New Remote Poller** install option as shown below.',
    'remote_setup_image_desc' => 'Remote Data Collector Setup',

    // Common data collector terms
    'data_collector_management' => 'Data Collector Management',
    'main_data_collector_term' => 'Main Data Collector',
    'remote_data_collector_term' => 'Remote Data Collector',
    'primary_server' => 'Primary Server',
    'remote_pollers' => 'Remote Pollers',
    'highly_available' => 'Highly Available',
    'full_sync' => 'Full Sync',
    'boost_module' => 'Boost Module',
    'enterprise_architecture' => 'Enterprise Architecture'
);
?>
