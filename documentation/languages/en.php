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
    'enterprise_architecture' => 'Enterprise Architecture',

    // Spine page specific
    'page_title_spine' => 'Cacti - Spine',
    'spine_title' => 'Spine',
    'spine_intro' => 'Spine is the fast replacement for `cmd.php`. It is written in C to ensure ultimate performance for device polling and is multi-threaded. Expect a decrease in polling time of an order of magnitude. Polling times far less than 60 seconds for about 20,000 data sources are achievable e.g. on a dual XEON system supplied with 4 GB RAM and standard local disks.',
    'spine_warning' => 'When using Spine, don\'t change crontab or systemd settings! Always use poller.php with crontab or cactid.php for systemd!',
    'spine_activation' => 'To activate Spine instead of cmd.php, please visit `Console > Configuration > Settings > Poller` and select spine and save as the `Poller Type`. If it\'s not showing as an available `Poller Type` this means either it has not been installed, or it\'s path has not been defined on the `Paths` tab within Settings.',
    'spine_testing' => 'Once saved, poller.php will use Spine on all subsequent polling cycles. Before making this change, ensure that Spine runs properly from the command line using the following test:',
    'spine_test_command' => 'cd /usr/local/spine/bin
./spine -R -V 3 -S',
    'spine_output_note' => 'You should receive quite a bit of output depending on the size of your system. To increase the number of Threads and concurrent processes, you must modify the setting when editing your Data Collector under `Console > Data Collection > Data Collectors`.',
    'spine_performance' => 'While Spine is really fast, choosing the correct setup will ensure that all processor resources are used. Required settings for Maximum Concurrent Poller Processes are 1-2 times the number of CPU cores available for Spine.',
    'spine_mysql_connections' => 'When using spine, you must be senstivive to the number of connections that are available for MySQL or MariaDB. Under `Console > Utilities > System Utilities > General` Cacti will provide a recommended `max_connection` for MySQL/MariaDB.',

    // Spine parameters tables
    'spine_system_params_title' => 'Table 15-1. Spine Parameters maintained at the System Level',
    'spine_collector_params_title' => 'Table 15-2. Spine Parameters maintained at the Data Collector Level',
    'spine_device_params_title' => 'Table 15-3. Spine Parameters maintained at the Device Level',
    'spine_param_name' => 'Name',
    'spine_param_description' => 'Description',

    // System level parameters
    'spine_script_timeout_name' => 'Script and Script Server Timeout Value',
    'spine_script_timeout_desc' => 'The maximum time that Spine will wait on a script to complete, in units of seconds. If a Script Server Script is terminated due to timeout conditions, the value entered into the RRDfile will be NaN',

    // Data collector level parameters
    'spine_max_threads_name' => 'Maximum Threads per Process',
    'spine_max_threads_desc' => 'The maximum threads allowed per process. Using a higher number when using Spine will improve performance. Required settings are 10-15. Values above 50 are most often insane and may degrade performance vs. improve it.',
    'spine_script_servers_name' => 'Number of PHP Script Servers',
    'spine_script_servers_desc' => 'The number of concurrent script server processes to run per Spine process. Settings between 1 and 10 are accepted. Script Servers will pre-load a PHP environment. Then, the Script Server Scripts are included into that environment to save the overhead of reloading PHP and re-interpreting the binary for each call.',

    // Device level parameters
    'spine_snmp_oids_name' => 'The Maximum SNMP OIDs Per SNMP Get Request',
    'spine_snmp_oids_desc' => 'The maximum number of SNMP get OIDs to issue per SNMP request. Increasing this value increases poller performance over slow links. The maximum value is 60 OIDs, but that value is highly dependent on the MTU for your links to the remote devices. In some cases, using a **Remote Data Collector** is much more effective for polling remote **Davices**. Additionally, some **Device Types** do not handle large SNMP OID get requests. It\'s best to experiment until you find the correct setting.',
    'spine_device_threads_name' => 'Device Threads',
    'spine_device_threads_desc' => 'The maximum number spine threads used to gather information from a **Device**. When using this setting at the **Device** level, you have to ensure that you have enough threads allocated to a process so as to not block other **Devices** being polled from the same spine binary.',

    // Installing Spine section
    'installing_spine_title' => 'Installing Spine',
    'spine_compile_note' => 'As Spine is written in C is must be compiled on the local system that it is to be installed on below is an example of compiling on centos and Ubuntu',
    'ubuntu_title' => 'Ubuntu',
    'ubuntu_packages' => 'Install the required system packages',
    'ubuntu_install_command' => 'apt-get install -y build-essential dos2unix dh-autoreconf libtool help2man libssl-dev libmysql++-dev librrds-perl libsnmp-dev',
    'spine_download_note' => 'Next, download the version of spine you are looking for Typically this should match the version of Cacti you are using. In this case we will download Version 1.2.3 of Spine',
    'spine_download_commands' => 'wget <https://github.com/Cacti/spine/archive/release/1.2.3.zip>
unzip 1.2.3
cd spine-release-1.2.3',
    'spine_compile_note2' => 'Once you are in the spine directory its time to compile the poller by issuing the following commands:',
    'spine_compile_commands' => './bootstrap
./configure
make
make install
chown root:root /usr/local/spine/bin/spine
chmod u+s /usr/local/spine/bin/spine',
    'spine_config_note' => 'Once that has completed, you will need to configure spine\'s config file',
    'spine_config_command' => 'vi /usr/local/spine/etc/spine.conf',
    'spine_config_example_note' => 'Below is an example of a configuration however yours should match your cacti database username and password',
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
    'centos_packages' => 'Install required system packages',
    'centos_install_command' => 'yum install -y gcc mysql-devel net-snmp-devel autoconf automake libtool dos2unix help2man',
    'centos_compile_note' => 'Then compile using the following commands',
    'centos_compile_commands' => './bootstrap
./configure
make
make install
chown root:root /usr/local/spine/bin/spine
chmod u+s /usr/local/spine/bin/spine',

    // Testing/Debugging section
    'testing_debugging_title' => 'Testing/Debugging spine via command line',
    'spine_testing_intro' => 'spine offer a a few different ways at the command line to test its functionality. Here are a few examples of some tests you can run by executing spine.',
    'test_without_db_title' => 'Test Spine without writing results to database',
    'test_without_db_desc' => 'This test allows you to run spine and display the results to the console. This will not commit any of the data to the database by specifying the -R option.',
    'test_specific_host_title' => 'Running spine for a specific host',
    'test_specific_host_desc' => 'If you want to run spine for a specific host you are able to do that with the following command:',
    'spine_debug_gui_title' => 'Spine debug via GUI',
    'spine_debug_gui_desc' => 'You are also able to view spine debug information via the log file also spine allows you to raise the level of detail it provides in the log if you want to debug a specific device and see the spine output click enable device debug.',
    'spine_debug_gui_example' => 'Below is an example output of Spine debug info via the log file',
    'spine_debug_image_desc' => 'spine',
    'spine_logging_settings' => 'To enable more detailed spine logging go to `Console > Configuration > Settings > Poller`',
    'spine_logging_options' => 'You can choose from Detailed,Summary or No logging for Invalid data',
    'spine_logging_detailed' => 'Detailed Logging will be similar to cmd.php in that you will get a report for each data source that is having an issue',
    'spine_logging_summary' => 'Summary provides a count of how many data sources are having an issue per device',
    'spine_parameters_image_desc' => 'spine',

    // Common errors section
    'spine_errors_title' => 'Common Spine related errors',
    'spine_error_config_missing' => '2021/01/08 14:38:44 - SPINE: Poller[1] PID[14838] FATAL: Unable to read configuration file! (Spine init)',
    'spine_error_config_solution' => 'Ensure that you have spine.conf in /usr/local/spine/etc on first install `spine.conf` may be `spine.conf.dist`.',
    'spine_error_setuid' => 'DEBUG Falling back to UDP Ping Due to SetUID Issues',
    'spine_error_setuid_desc' => 'This is a permissions issue with spine ensure you have give spine the proper permissions',
    'spine_error_setuid_solution' => 'chmod u+s /usr/local/spine/bin/spine',

    // Common spine terms
    'spine_data_collection' => 'Spine Data Collection',
    'multi_threaded' => 'Multi-threaded',
    'poller_type' => 'Poller Type',
    'script_server' => 'Script Server',
    'snmp_oids' => 'SNMP OIDs',
    'device_threads' => 'Device Threads',
    'spine_collection' => 'Spine Data Collection',

    // Data Input Methods page specific
    'page_title_data_input_methods' => 'Cacti - Data Input Methods',
    'data_input_methods_title' => 'Data Input Methods',
    'data_input_methods_intro' => 'Data Input Methods allow Cacti to retrieve data to insert into RRDfiles based upon a mapping controlled by **Data Templates** and their corresponding **Data Sources**. These resulting **Data Templates** and **Data Sources** can then be used to create **Graph Templates** and **Graphs**.',
    'data_input_methods_builtin' => 'Cacti includes a number of build in **Data Input Methods** for **SNMP** data and for **Script**, **Script Server** and **SNMP Data Queries**.',
    'data_input_methods_custom' => 'Outside of the built in **Data Input Methods**, the Cacti Administrator can create virtually any **Data Input Method** based upon a **Script**, or a PHP **Script Server** script. The **Script** based **Data Input Method** allows Cacti to virtually collect data from anywhere, though the built in **SNMP** and **Script Server** methods provide the greatest scalability in Cacti. Both **Data Queries**, and PHP **Script Server** topics will be covered in later sections of the documentation.',

    // Creating a Data Input Method section
    'creating_data_input_method_title' => 'Creating a Data Input Method',
    'creating_data_input_method_desc' => 'To create a new **Data Input Method**, from the Cacti Console, select **Data Collection > Data Input Methods**. Once on that screen, click the plus (+) glyph on the right which will allow you to add a new **Data Input Method**. You will be presented with a few fields to populate on the following screen.',
    'data_input_methods_table_title' => 'Table 11-1. Field Description: Data Input Methods',
    'data_input_methods_name_field' => 'Name',
    'data_input_methods_description_field' => 'Description',
    'data_input_methods_name_desc' => 'Give the data query a name that you will use to identify it',
    'data_input_methods_input_type_field' => 'Input Type',
    'data_input_methods_input_type_desc' => 'Select the type of **Data Input Method** you are trying to create',
    'data_input_methods_input_string_field' => 'Input String',
    'data_input_methods_input_string_desc' => 'This field is only used when the Input Type is set to **Script/Command**',

    'data_input_methods_name_consideration' => 'The `Name` specified will be used throughout Cacti to identify the human readable name given to the **Data Input Method**. Careful consideration should be made to help uniquely identify the **Data Source**. Having very similar names can lead to confusion when utilizing them as your Cacti system grows.',
    'data_input_methods_input_types' => 'Valid options for `Input Type` are **Script/Command**, and **Script Server**. As mentioned previously, Cacti provides built in **Data Input Methods** for SNMP data gathering and for SNMP, **Script**, and **Script Server** based **Data Queries**. Though present in the Cacti database, they are hidden from user view.',
    'data_input_methods_script_command' => 'When the type is set to `Script/Command`, the `Input String` specifies the full path to the script including any per **Data Source** input variables. **Data Source** input variables must be enclosed in greater than and less than characters. For instance, if you are passing an IP address to a script, your input string might look something like: `/path/to/script.pl <ip>` When the user creates a **Data Source** based on this **Data Input Method**, they will be prompted for an IP address to pass onto the script.',
    'data_input_methods_after_create' => 'When you are finished filling in all necessary fields, click the Create button to continue. Upon saving the new **Data Input Method**, you will be presented with two new sections to complete. Those sections will instruct Cacti what to pass to the Script, known as `Input Fields` otherwise known as `Input Parameters` and how to handle the output data, which we refer to as `Output Fields`.',
    'data_input_methods_input_fields_desc' => 'The `Input Fields` box is used to define any fields that require information from the user or from various data within the Cacti Database such as the hostname, ip address, host id, etc. Any input fields referenced to in the input string must be defined here.',
    'data_input_methods_output_fields_desc' => 'The `Output Fields` box is used to define each field that you expect back from the script and will be eventually stored in both the database and RRDfiles.',
    'data_input_methods_output_requirement' => '*All **Data Input Methods** must have at least one output field defined*, but may have more than one depending on the type.',

    // Data Input Fields section
    'data_input_fields_title' => 'Data Input Fields',
    'data_input_fields_desc' => 'To define a new field, click the plus sign (+) next to the input or output field boxes. You will be presented with some or all of the fields below depending on whether you are adding an input or output field.',
    'data_input_fields_table_title' => 'Table 11-2. Field Description: Data Input Fields',
    'data_input_field_name' => 'Field/Field Name',
    'data_input_field_name_desc' => 'You will be presented a drop down list of the unused braced input fields from the command',
    'data_input_friendly_name' => 'Friendly Name',
    'data_input_friendly_name_desc' => 'Enter a more descriptive name for this field',
    'data_input_regex_match' => 'Regular Expression Match (Input Only)',
    'data_input_regex_match_desc' => 'Enter a valid regular expression as to how to modify the output',
    'data_input_allow_empty' => 'Allow Empty Input (Input Only)',
    'data_input_allow_empty_desc' => 'Can the input value of this field blank or not',
    'data_input_special_type' => 'Special Type Code (Input Only)',
    'data_input_special_type_desc' => 'Pull the input data from the Cacti database and don\'t prompt the user for this input value',
    'data_input_update_rrd' => 'Update RRDfile (Output Only)',
    'data_input_update_rrd_desc' => 'Checked if you intend this output data to be stored in an RRDfile',

    'data_input_field_name_rules' => 'The `Field Name` must contain no spaces or other non-alphanumeric characters (except \'-\' or \'_\').',
    'data_input_regex_rules' => 'If you want to enforce a certain regular expression pattern when the user enters a value into `Regular Expression Match (Input Only)` for this Data Input Field, it must follow POSIX syntax as it will be passed to PHP\'s preg() functions.',
    'data_input_special_type_usage' => 'If the Data Input Field needs to reference another field internally, you can enter this into the `Special Type Code`. For instance, if your field requires an IP address from the user, you can enter \'management_ip\' here and Cacti will fill this field in with the current IP address of the selected host.',

    // Special Type Codes table
    'special_type_codes_table_title' => 'Table 11-3. Special Type Codes',
    'special_type_field_name' => 'Field Name',
    'special_type_hostname' => 'hostname',
    'special_type_hostname_desc' => 'The hostname',
    'special_type_management_ip' => 'management_ip',
    'special_type_management_ip_desc' => 'The ip',
    'special_type_snmp_community' => 'snmp_community',
    'special_type_snmp_community_desc' => 'The SNMP community',
    'special_type_snmp_username' => 'snmp_username',
    'special_type_snmp_username_desc' => 'The SNMP username',
    'special_type_snmp_password' => 'snmp_password',
    'special_type_snmp_password_desc' => 'The SNMP version',

    'data_input_update_rrd_note' => 'If you enable the `Update RRDfile`, Cacti will insert the return value from this field into the RRDfile. This box needs to be checked for at least one output field per data input source, but can be left blank to have Cacti store the value only in the database instead.',
    'data_input_create_finish' => 'When you are finished filling in all necessary fields, click the Create button to continue. You will be redirected back to the **Data Input Method** edit page. From here you can continue to add additional fields, or click Save on this screen when finished.',

    // Making Your Scripts Work With Cacti section
    'scripts_work_with_cacti_title' => 'Making Your Scripts Work With Cacti',
    'scripts_work_intro' => 'The simplest way to extend Cacti\'s data gathering functionality is through external scripts. Cacti comes with a number of scripts out of the box which are located in the `scripts/` directory. These scripts are used by the **Data Input Methods** that are present in a new installation of Cacti.',
    'scripts_work_create_method' => 'To have Cacti call an external script to gather data you must create a new **Data Input Method**, making sure to specify Script/Command for the Input Type field. See the previous section, Creating a Data Input Method for more information about how to create a **Data Input Method**. To gather data using your **Data Input Method**, Cacti simply executes the shell command specified in the Input String field. Because of this, you can have Cacti run any shell command or call any script which can be written in almost any language.',
    'scripts_output_format' => 'What Cacti is concerned with is the output of the script. When you define your **Data Input Method**, you are required to define one or more output fields. The number of output fields that you define here is important to your script\'s output. For a **Data Input Method** with only one output field, your script should output its value in the following format:',
    'scripts_single_output_format' => '<numeric value>',
    'scripts_single_output_example' => 'So if I wrote a script that outputs the number of running processes, its output might look like the following:',
    'scripts_single_output_value' => '67',
    'scripts_multiple_output_desc' => 'Data Input Methods with more than one output field are handled a bit differently when writing scripts. Scripts that output more than one value should be formatted like the following:',
    'scripts_multiple_output_format' => '<fieldname_1>:<value_1> <fieldname_2>:<value_2> ... <fieldname_n>:<value_n>',
    'scripts_multiple_output_example' => 'If you wrote a script that outputs the 1, 5, and 10 minute load average of a Unix machine and in Cacti named the output fields \'1min\', \'5min\', and \'10min\', the output of the script should look like the following:',
    'scripts_load_average_example' => '1min:0.40 5min:0.32 10min:0.01',
    'scripts_permissions_note' => 'One last thing to keep in mind when writing scripts for Cacti is that they will be executed as the user the data gatherer runs as. Sometimes a script may work correctly when executed as root, but fails due to permissions problems when executed as a less privileged user.',

    // Walkthrough section
    'walkthrough_title' => 'Walkthough',
    'walkthrough_desc' => 'You can find a detailed example of how to create a complete Graph from simple command output in the following example How To Create a Data Input Method.',

    // Common data input method terms
    'data_input_method' => 'Data Input Method',
    'input_fields' => 'Input Fields',
    'output_fields' => 'Output Fields',
    'input_parameters' => 'Input Parameters',
    'script_command' => 'Script/Command',
    'script_server' => 'Script Server',
    'special_type_codes' => 'Special Type Codes',
    'regular_expression_match' => 'Regular Expression Match',
    'data_input_methods' => 'Data Input Methods',

    // Data Queries page specific
    'page_title_data_queries' => 'Cacti - Data Queries',
    'data_queries_title' => 'Data Queries',
    'data_queries_overview_title' => 'Overview',
    'data_queries_overview_intro' => 'Cacti **Data Queries** are not a replacement for **Data Input Methods** in Cacti. Instead they provide an easy way to extend Data Input methods to interpret multidimensional objects, or list data based upon an index, making the data easier to graph. The most common use of a **Data Query** within Cacti is to retrieve a list of network interfaces via SNMP.',
    'data_queries_overview_process' => 'If you want to graph the traffic of a network interface, first Cacti must retrieve a list of interfaces on the host. Second, Cacti can use that information to create the necessary **Graphs** and **Data Sources**. **Data Queries** are only concerned with the first step of the process, that is obtaining a list of network interfaces and not creating the graphs/data sources for them. While listing network interfaces is a common use for **Data Queries**, they also have other uses such as listing partitions, processors, or even cards in a router.',
    'data_queries_unique_requirement' => 'One requirement for any **Data Query** in Cacti, is that it has some unique value that defines each row in the list. This concept follows that of a \'primary key\' in SQL, and makes sure that each row in the list can be uniquely referenced. Examples of these index values are \'ifIndex\' for SNMP network interfaces or the device name for partitions.',
    'data_queries_types' => 'There are three types of **Data queries** that you will see referred to throughout Cacti. They are script queries, script server queries, and SNMP queries. Script, Script Server and SNMP queries are virtually identical in their functionality and only differ in how they obtain their information. Script and Script Server queries will call an external command or script and an SNMP query will make an SNMP call to retrieve a list of data.',

    // User Interface section
    'data_queries_ui_title' => 'User Interface',
    'data_queries_ui_description' => 'Below, you can see Cacti\'s default **Data Queries** interface. From the interface, you can see the Name, ID, Data Input Method, and other information about the Data Query.',
    'data_queries_interface_desc' => 'Data Query Interface',
    'data_queries_edit_description' => 'When you edit an existing Data Query, you will see an interface like the one below. In that interface, you will note that there is an XML file path included. The XML file is a key component of a Cacti **Data Query**. For Script based **Data Queries**, there will also be a script that must be called to gather information about the **Data Query**, the script name is included in the XML file.',
    'data_queries_edit_interface_desc' => 'Data Query Edit Interface',
    'data_queries_graph_templates' => 'In this Interface, you can see the Name, Description, XML Path, and **Data Input Method**. In the section below that, you have the `Associated Graph Templates` section which includes all the various **Graph Templates** that can be used for the **Data Query**.',
    'data_queries_template_removal' => 'Once a **Data Query** **Graph Template** is in use, it can not longer be removed from Cacti. This feature is there to prevent **Graphs** from becoming unrenderable if someone accidentally were to remove the **Graph Template** association.',
    'data_queries_template_click' => 'When you click on any of the `Associated Graph Template` name, you will be taken to the interface below.',
    'data_queries_template_edit_desc' => 'Data Query Associated Graph Template Edit Interface',
    'data_queries_mapping_description' => 'From here, you map the various matching **Data Template** RRDfile Data Source names to Data Source names that exist in the XML file. There can be many Data Source names in the XML file, but a Graph Template may only require a few of them, which explains the reason for having the `Associated Data Templates` section of the **Data Query**. To associate the XML field with the **Data Templates** RRDfile Data Source, you simply select the correct one, and then toggle on the checkbox to the right of the XML field Data Source name.',
    'data_queries_suggested_values' => 'Below the `Associated Data Templates`, you will find two sections which are referred to as `Suggested Values` for both the **Data Source** and the **Graph** names. When creating **Graphs** and their associated **Data Sources** Cacti will use the first name in the `Suggested Values` pattern that fully replaces all the tags that are identified by opening and closing vertical bars. So, in the example above, when creating an Interface Graph, if that Interface does not have an ifAlias, Cacti will likely use the second `Suggested Value`, unless the interface does not have an IP Address, in which case it will use the third `Suggested Value`.',
    'data_queries_replacement_values' => 'Cacti also allows `Suggested Values`, to replace both **Graph** and **Data Source** values, as in the case above, the "rrd_maximum" column is replaced by the Network Interfaces maximum speed, otherwise known as the "ifSpeed" from an SNMP perspective.',
    'data_queries_two_parts' => 'All data queries have two parts, the XML file and the definition within Cacti. An XML file must be created for each query, that defines where each piece of information is and how to retrieve it. This could be thought of as the actual query. The second part is a definition within Cacti, which tells Cacti where to find the XML file and associates the data query with one or more graph templates.',

    // Creating a Data Query section
    'creating_data_query_title' => 'Creating a Data Query',
    'creating_data_query_desc' => 'Once you have created the XML file that defines your data query, you must add the data query within Cacti. To do this you must click on Data Queries under the Data Gathering heading, and select Add. You will be prompted for some basic information about the data query, described in more detail below.',
    'data_queries_table_title' => 'Table 12-1. Field Description: Data Queries',
    'data_queries_name_field' => 'Name',
    'data_queries_description_field' => 'Description (Optional)',
    'data_queries_xml_path_field' => 'XML Path',
    'data_queries_data_input_method_field' => 'Data Input Method',
    'data_queries_name_desc' => 'Give the **Data Query** a name that you will use to identify it. This name will be used throughout Cacti when presented with a list of **Data Queries**.',
    'data_queries_description_desc' => 'Enter a more detailed description of the data query including the information it queries or additional requirements.',
    'data_queries_xml_path_desc' => 'Fill in the full path to the XML file that defines this query. You can optionally use the `path_cacti` variable that will be substituted with the full path to Cacti. On the next screen, Cacti will check to make sure that it can find the XML file.',
    'data_queries_data_input_method_desc' => 'This is how you tell Cacti to handle the data it receives from the data query. Typically, you will select `Get SNMP Data (Indexed)` for an SNMP query and `Get Script Data (Indexed)` for a script query.',
    'data_queries_create_warning' => 'When you are finished filling in all necessary fields, click the Create button to continue. You will be redirected back to the same page, but this time with some additional information to fill in. If you receive a red warning that says \'XML File Does Not Exist\', correct the value specified in the \'XML Path\' field.',

    // Associated Graph Templates section
    'associated_graph_templates_title' => 'Associated Graph Templates',
    'associated_graph_templates_desc' => 'Every data query must have at least one graph template associated with it, and possibly more depending on the number of output fields specified in the XML file. This is where you get to choose what kind of graphs to generate from this query. For instance, the interface data query has multiple graph template associations, used to graph traffic, errors, or packets. To add a new graph template association, simply click Add at the right of the Associated Graph Templates box. You will be presented with a few fields to fill in:',
    'associated_graph_templates_table_title' => 'Table 12-2. Field Description: Associated Graph Templates',
    'associated_graph_templates_name_desc' => 'Give a name describing what kind of data you are trying to represent or graph. When the user creates a graph using this data query, they will see a list of graph template associations that they will have to choose from.',
    'associated_graph_templates_template_desc' => 'Choose the actual graph template that you want to make the association with.',
    'associated_graph_templates_finish' => 'When you are finished filling in these fields, click the Create button. You will be redirected back to the same page with some additional information to fill in. Cacti will make a list of each **Data Template** referenced to in your selected **Graph Template** and display them under the `Associated Data Templates` box. As previously mentioned, for each **Data Source** item listed, you must selected the **Data Query** output field that corresponds with it. *Do not forget to check the checkbox to the right of each selection, or your settings will not be saved.*',
    'suggested_values_desc' => 'The `Suggested Values` form provides you a way to control field values of **Data Sources** and **Graphs** created using the **Data Query**. If you specify multiple `Suggested Values` for the same field, Cacti will evaluate them in order which you can control using the up or down arrow icons. For more information about valid field names and variables, read the section on `Suggested Values`.',
    'data_queries_final_save' => 'When you are finished filling in all necessary fields on this form, click the Save button to return to the data queries edit screen. Repeat the steps under this heading as many times as necessary to represent all data in your XML file. When you are finished with this, you should be ready to start adding your data query to hosts.',

    // Common data query terms
    'data_query' => 'Data Query',
    'data_queries' => 'Data Queries',
    'script_queries' => 'Script Queries',
    'snmp_queries' => 'SNMP Queries',
    'script_server_queries' => 'Script Server Queries',
    'xml_file' => 'XML File',
    'associated_graph_templates' => 'Associated Graph Templates',
    'associated_data_templates' => 'Associated Data Templates',
    'suggested_values' => 'Suggested Values',

    // Device Templates page specific
    'page_title_device_templates' => 'Cacti - Device Templates',
    'device_templates_title' => 'Device Templates',
    'device_templates_intro' => '**Device Templates** are Cacti objects that allows you to define classes of **Devices** that includes from one to many **Graph Templates**, **Data Queries** and other **Plugin** related object types.',
    'device_templates_purpose' => 'The purpose of **Device Templates** is to simplify the **Automation** process by pre-defining the **Graphs** that should be created for every **Device** that is added to Cacti. They work in conjunction with **Automation Templates** so that when Cacti discovers a **Network** it knows what **Graphs** to create for each **Device**.',
    'device_templates_main_screen' => 'The **Device Templates** main screen looks like the image below:',
    'device_templates_page_desc' => 'Device Templates Page',
    'device_templates_page_info' => 'From this page, you can see the title of each **Device Template**, it\'s ID which is important for the Cacti CLI scripts. You can see if the **Device Template** can be removed, and the number of **Devices** using the **Device Template**. Templates that are used by **Devices** can not be removed and therefore if you attempt to remove one of these Templates, you will receive and error message.',
    'device_templates_dropdown_options' => 'From the drop down there are three options, they are:',

    // Device Templates options table
    'device_templates_option_field' => 'Option',
    'device_templates_description_field' => 'Description',
    'device_templates_delete_option' => 'Delete',
    'device_templates_delete_desc' => 'Remove the **Device Template** if it\'s *Deletable*',
    'device_templates_duplicate_option' => 'Duplicate',
    'device_templates_duplicate_desc' => 'Make an exact copy of the **Device Template**.',
    'device_templates_sync_option' => 'Sync Devices',
    'device_templates_sync_desc' => 'Update all **Devices** using this **Device Template** with the latest definition, adding, but not removing **Graph Templates**, and **Data Queries**.',

    // Device Template editing
    'device_templates_edit_intro' => 'When editing a **Device Template**, you will see the page as displayed below. From this page, you can add and remove **Graph Templates**, **Data Queries**, and other **Plugin** objects. In the image below, you can see that the *Cisco Router* has one **Graph Template** that of *Cisco - CPU Usage* and one **Data Query** that of *SNMP - Interface Statistics*. There are no **Threshold Templates** defined on the system, so there is no way to select one.',
    'device_templates_edit_page_desc' => 'Device Template Edit Page',
    'device_templates_add_remove' => 'To add a **Graph Template** or **Data Query** to the **Device Template**, simply select it from the drop down, and press the *Add* button. There is no need to *Save* afterwards. To removed one of these items, simply press the x glyph to the right of the desired **Graph Template** or **Data Query**.',

    // Common device template terms
    'device_template' => 'Device Template',
    'device_templates' => 'Device Templates',
    'automation_templates' => 'Automation Templates',
    'threshold_templates' => 'Threshold Templates',
    'cisco_router' => 'Cisco Router',
    'cisco_cpu_usage' => 'Cisco - CPU Usage',
    'snmp_interface_statistics' => 'SNMP - Interface Statistics',
    'deletable' => 'Deletable',
    'sync_devices' => 'Sync Devices',
    'duplicate' => 'Duplicate',

    // Graph Templates page specific
    'page_title_graph_templates' => 'Cacti - Graph Templates',
    'graph_templates_title' => 'Graph Templates',
    'graph_templates_intro' => '**Graph Templates** are Cacti objects that allows you to define how RRDtool is to render a Cacti **Graph**. Most RRDtool options are supported including CDEF\'s and VDEF\'s, Left and Right Axis, Ticks and Dashes, multiple Auto Scaling, Grid, and Legend Options.',
    'graph_templates_purpose' => 'The purpose of **Graph Templates** is to simplify the **Automation** process by pre-defining the layout of **Graphs** for various metrics that are to be monitored in Cacti. When used in Conjunction with Cacti\'s **Graph Rules**, you can automatically create just about any **Data Query** based **Graph** during Cacti\'s **Network Discovery** process.',
    'graph_templates_main_screen' => 'The **Graph Templates** main screen looks like the image below:',
    'graph_templates_page_desc' => 'Graph Templates Page',
    'graph_templates_page_info' => 'From this page, you can see the title of each **Graph Template**, it\'s ID which is important for the Cacti CLI scripts. You can see if the **Graph Template** can be removed, and the number of **Graphs** using the **Graph Template** as well as the *Size* of the **Graphs** that will be created, the *Image Format*, and *Vertical Label*. Templates that are used by **Devices** can not be removed and therefore if you attempt to remove one of these Templates, you will receive and error message.',
    'graph_templates_dropdown_options' => 'From the drop down there are three options, they are:',

    // Graph Templates options table
    'graph_templates_option_field' => 'Option',
    'graph_templates_description_field' => 'Description',
    'graph_templates_delete_option' => 'Delete',
    'graph_templates_delete_desc' => 'Remove the **Graph Template** if it\'s *Deletable*',
    'graph_templates_duplicate_option' => 'Duplicate',
    'graph_templates_duplicate_desc' => 'Make an exact copy of the **Graph Template**',
    'graph_templates_resize_option' => 'Resize',
    'graph_templates_resize_desc' => 'Make a resize decision that affects both the **Graph Template** and any **Graphs** created using this **Graph Template**',
    'graph_templates_sync_option' => 'Sync Graphs',
    'graph_templates_sync_desc' => 'Update all **Graphs** using this **Graph Template** with the latest definition, adding new *Graph Items* and removing orphaned *Graph Items*',

    // Graph Template editing sections
    'graph_templates_edit_intro' => 'When Editing a **Graph Template**, there will be several sections that will require information from the Administrator. Those sections include:',
    'graph_templates_section_field' => 'Section',
    'graph_templates_items_section' => 'Graph Template Items',
    'graph_templates_items_desc' => 'These items paint inside the canvas of the **Graph**',
    'graph_templates_inputs_section' => 'Graph Item Inputs',
    'graph_templates_inputs_desc' => 'This list is created automatically when you add **Data Sources** to a **Graph Template**. However, you can also override certain **Data Template** and **Graph Template** fields by adding specifically named objects to this section as well.',
    'graph_templates_template_section' => 'Graph Template',
    'graph_templates_template_desc' => 'Allows you to name the **Graph Template**, and whether or not you will allow multiple instances of this **Graph Template** to be used for a **Device**, and whether or not to test for valid data before allowing the creation of **Graphs**. The *Test Data Source* option is useful when you want to leverage complex **Device Template** that contains **Graph Templates** that may not be applicable for all classes of **Devices** using the **Graph Template**.',
    'graph_templates_common_section' => 'Common Options',
    'graph_templates_common_desc' => 'Things like Title, Vertical Label, Image Format, Height and Width, Base Value and Slope Mode',
    'graph_templates_scaling_section' => 'Scaling Options',
    'graph_templates_scaling_desc' => 'Which determine if the Graph is auto-scaled and by what means. Determines if the Graph will have fixed upper and lower limits',
    'graph_templates_grid_section' => 'Grid Options',
    'graph_templates_grid_desc' => 'Defines how the Graph canvas grid is rendered',
    'graph_templates_axis_section' => 'Axis Options',
    'graph_templates_axis_desc' => 'Defines if there should be a right Axis and how it should be formatted',
    'graph_templates_legend_section' => 'Legend Options',
    'graph_templates_legend_desc' => 'Defines how the Legends should be formatted',

    // Graph Item Types
    'graph_items_intro' => 'The *Graph Items* make up what is draw within the canvas of the Graph. There are several *Graph Item* types including:',
    'graph_item_type_field' => 'Type',
    'graph_item_area' => 'AREA',
    'graph_item_area_desc' => 'Place an *Area Fill* on the canvas',
    'graph_item_area_stack' => 'AREA:STACK',
    'graph_item_area_stack_desc' => 'The second item of an *Area Fill* to be stacked upon the first',
    'graph_item_comment' => 'COMMENT',
    'graph_item_comment_desc' => 'A written comment. Can include: |host_*|, |query_*|, |input_*| *Replacement Variables*',
    'graph_item_gprint' => 'GPRINT',
    'graph_item_gprint_desc' => 'Print a numeric value from the RRDfile with an optional **CDEF** or **VDEF** and formatted using a **GPRINT Preset**.',
    'graph_item_gprint_average' => 'GPRINT:AVERAGE',
    'graph_item_gprint_average_desc' => 'Print a numeric value from the RRDfile from the *AVERAGE* *Consolidation Function* within the RRA, modified by an optional **CDEF**, or **VDEF**, and formatted using a **GPRINT Preset**.',
    'graph_item_gprint_last' => 'GPRINT:LAST',
    'graph_item_gprint_last_desc' => 'Print a numeric value from the RRDfile from the *LAST* *Consolidation Function* within the RRA, modified by an optional **CDEF**, or **VDEF**, and formatted using a **GPRINT Preset**.',
    'graph_item_gprint_max' => 'GPRINT:MAX',
    'graph_item_gprint_max_desc' => 'Print a numeric value from the RRDfile from the *MAX* *Consolidation Function* within the RRA, modified by an optional **CDEF**, or **VDEF**, and formatted using a **GPRINT Preset**.',
    'graph_item_gprint_min' => 'GPRINT:MIN',
    'graph_item_gprint_min_desc' => 'Print a numeric value from the RRDfile from the *MIN* *Consolidation Function* within the RRA, modified by an optional **CDEF**, or **VDEF**, and formatted using a **GPRINT Preset**.',
    'graph_item_hrule' => 'HRULE',
    'graph_item_hrule_desc' => 'Draw an *Horizontal Rule* at the given point on the canvas. You can NOT use any Data Source element or an optional **CDEF** or **VDEF**, but may be able to use either a |query_*|, or |input_*| *Replacement Variable*.',
    'graph_item_legend' => 'LEGEND',
    'graph_item_legend_desc' => 'Draw a *Legend* from three *GPRINTS* using the same **GPRINT Preset**, and **VDEF** or **CDEF**. The *Current*, *Average*, and *Max* *Consolidation Functions* are used.',
    'graph_item_legend_camm' => 'LEGEND_CAMM',
    'graph_item_legend_camm_desc' => 'Draw a *Legend* from four *GPRINTS* using the same **GPRINT Preset**, and **VDEF** or **CDEF**. The *Current*, *Average*, *Min*, and *Max* functions are used for this *Legend*.',
    'graph_item_line' => 'LINE[1,2,3]',
    'graph_item_line_desc' => 'Draw a 1, 2, 3 or used defined thickness pixel *Line* from the RRDfile onto the canvas, modified by an optional **CDEF**, or **VDEF**.',
    'graph_item_line_stack' => 'LINE:STACK',
    'graph_item_line_stack_desc' => 'Stack a Line of a user defined thickness on top of another *Line*, modified by an optional **CDEF**, or **VDEF**.',
    'graph_item_textalign' => 'TEXTALIGN',
    'graph_item_textalign_desc' => 'Modify future text using the alignment provided.',
    'graph_item_vrule' => 'VRULE',
    'graph_item_vrule_desc' => 'Place a *Vertical Rule* on the canvas of a specific color and time position.',

    'graph_items_canvas_note' => 'The canvas is painted from the first *Graph Item* till the last with each successive *Graph Item* rendered on top of the previous. Please keep this in mind when creating a **Graph Template**.',
    'graph_items_edit_desc' => 'Graph Items and Item Inputs',

    // Graph Template sections
    'graph_template_general_title' => 'Graph Template - General and Common Options',
    'graph_template_name_option' => '**Name** - This is the name that you provide to the **Graph Template**. Since Cacti does not presently have the concept of **Graph Template Class** many authors will prefix the **Name** with a **Class** prefix like *Net-SNMP* for example.',
    'graph_template_multiple_option' => '**Multiple Instances** - This setting tells Cacti that a device can have more than one instance of the Template. This will allow you to select the **Graph Template** from the **Create** option of **New Graphs** interface more than once.',
    'graph_template_test_option' => '**Test Data Sources** - This option will test that the **Data Source** returns good data before allowing the creation of the **Graph**. You should be aware that if your **Data Source** calls a script that runs for a long time, selecting this option can really slow the **Graph** creation process. However, it\'s quite useful if you have a hybrid **Device Template** that includes a myriad of **Graph Templates** that may not work with all **Devices** that you create using the **Device Template**.',
    'graph_template_common_options' => 'Under the *Common Options*, for each **Graph Template** you will specify patterns for the *Graph Name*, assign it\'s *Vertical Label*, specify the *Width* and *Height*, and *Image Format* for the resulting **Graph**. The *Base Value* is important as some units of measure can be for example: MB (for Mega Bytes - 1024) and MiB (for Mega integer Bytes - 1000). Lastly, the *Slope Mode* gives the resulting **Graphs** a smoother look.',
    'graph_template_common_edit_desc' => 'Graph Name and Common Options',

    'graph_template_scaling_title' => 'Graph Template - Scaling Options',
    'graph_template_scaling_options' => 'The *Scaling Options* allow the Administrator to apply either *Rigid* or *Auto Scaling* settings to the resulting *Graph*. These options are fairly self explanatory. However, you can always view the RRDtool Documentation online for more information.',
    'graph_template_scaling_edit_desc' => 'Scaling Options',

    'graph_template_grid_title' => 'Graph Template - Grid Options',
    'graph_template_grid_options' => 'The *Grid Options* are rarely necessary unless you have specific requirements to render the resulting **Graphs** with some exotic unit.',
    'graph_template_grid_edit_desc' => 'Grid Options',

    'graph_template_axis_title' => 'Graph Template - Axis Options',
    'graph_template_axis_options' => 'The *Axis Options* allow you to define a *Right Axis* and optional *Formatters*.',
    'graph_template_axis_edit_desc' => 'Axis Options',

    'graph_template_legend_title' => 'Graph Template - Legend Options',
    'graph_template_legend_options' => 'The *Legend* options allow you to specify how the *Legend* should be placed on the resulting **Graph** modern RRDtool has several options that were not available in Cacti prior to Cacti 1.0.',
    'graph_template_legend_edit_desc' => 'Legend Options',

    'rrdtool_reference' => 'Each of these sections are displayed below for reference. For more information on how to use these options, please visit the RRDtool Website.',

    // Common graph template terms
    'graph_template' => 'Graph Template',
    'graph_templates' => 'Graph Templates',
    'graph_rules' => 'Graph Rules',
    'network_discovery' => 'Network Discovery',
    'graph_items' => 'Graph Items',
    'graph_item_inputs' => 'Graph Item Inputs',
    'consolidation_function' => 'Consolidation Function',
    'replacement_variables' => 'Replacement Variables',
    'gprint_preset' => 'GPRINT Preset',
    'horizontal_rule' => 'Horizontal Rule',
    'vertical_rule' => 'Vertical Rule',
    'area_fill' => 'Area Fill',
    'multiple_instances' => 'Multiple Instances',
    'test_data_sources' => 'Test Data Sources',
    'common_options' => 'Common Options',
    'scaling_options' => 'Scaling Options',
    'grid_options' => 'Grid Options',
    'axis_options' => 'Axis Options',
    'legend_options' => 'Legend Options',
    'vertical_label' => 'Vertical Label',
    'image_format' => 'Image Format',
    'base_value' => 'Base Value',
    'slope_mode' => 'Slope Mode',
    'auto_scaling' => 'Auto Scaling',
    'rigid_scaling' => 'Rigid Scaling',
    'right_axis' => 'Right Axis',

    // Data Source Templates page specific
    'page_title_data_source_templates' => 'Cacti - Data Source Templates',
    'data_source_templates_title' => 'Data Source Templates',
    'data_source_templates_intro' => 'Data sources serve an important role in Cacti data sources are data points collected from the devices you monitor in Cacti.',
    'data_source_templates_poller' => 'Data sources take the data that has been collected by the poller.',
    'data_source_templates_graph' => 'The Data source then holds the value to be presented to the graph.',
    'data_source_templates_association' => 'The Data source template is then associated with a graph template.',
    'data_source_templates_examples' => 'These data sources can be for example incoming traffic on an interface. Cacti allows you to create data source templates to associate to data queries the template allows you to describe what type of data Cacti should expect.',
    'data_source_templates_creation' => 'To create a Data source you will need to select the proper data input there are several options but the most popular ones would be GET SNMP data or GET SNMP data (indexed.)',
    'data_source_templates_indexed' => 'You would use Get SNMP data (indexed) for interfaces for example as Cacti would need to query the device to find the interface index. You would use Get SNMP data and put in a single OID for an OID that won\'t change for example CPU usage generally does not have an index and the OID won\'t change',
    'data_source_templates_types' => 'You will also need to tell the template what the data source type is. The most common ones being Gauge and Counter. These data types come from the RRDtool its self. Below are the supported data types and their uses. For more information see',
    'rrd_tool_create_function' => 'RRD Tool Create Function',

    // RRD Data Types
    'gauge_title' => 'GAUGE',
    'gauge_desc' => 'GUAGE is for things like temperatures or number of people in a room or the value of a RedHat share.',
    'counter_title' => 'COUNTER',
    'counter_desc' => 'COUNTER is for continuous incrementing counters like the ifInOctets counter in a router. The COUNTER data source assumes that the counter never decreases, except when a counter overflows. The update function takes the overflow into account.',
    'counter_storage' => 'The counter is stored as a per-second rate. When the counter overflows, RRDtool checks if the overflow happened at the 32bit or 64bit border and acts accordingly by adding an appropriate value to the result.',
    'dcounter_title' => 'DCOUNTER',
    'dcounter_desc' => 'DCOUNTER the same as COUNTER, but for quantities expressed as double-precision floating point number. It could be used to track quantities that increment by non-integer numbers, i.e. number of seconds that some routine has taken to run, total weight processed by some technology equipment etc.',
    'dcounter_direction' => 'The only substantial difference is that DCOUNTER can either be upward counting or downward counting, but not both at the same time. The current direction is detected automatically on the second non-undefined counter update and any further change in the direction is considered a reset. The new direction is determined and locked in by the second update after reset and its difference to the value at reset.',
    'derive_title' => 'DERIVE',
    'derive_desc' => 'DERIVE will store the derivative of the line going from the last to the current value of the data source. This can be useful for gauges, for example, to measure the rate of people entering or leaving a room. Internally, derive works exactly like COUNTER but without overflow checks. So if your counter does not reset at 32 or 64 bit you might want to use DERIVE and combine it with a MIN value of 0.',
    'dderive_title' => 'DDERIVE',
    'dderive_desc' => 'DDERIVE the same as DERIVE, but for quantities expressed as double-precision floating point number.',
    'counter_vs_derive_note' => '**NOTE**: on COUNTER vs DERIVE',
    'counter_vs_derive_author' => 'by Don Baarda don.baarda@baesystems.com',
    'counter_vs_derive_advice' => 'If you cannot tolerate ever mistaking the occasional counter reset for a legitimate counter wrap, and would prefer "Unknowns" for all legitimate counter wraps and resets, always use DERIVE with min=0. Otherwise, using COUNTER with a suitable max will return correct values for all legitimate counter wraps, mark some counter resets as "Unknown", but can mistake some counter resets for a legitimate counter wrap.',
    'counter_vs_derive_probability' => 'For a 5 minute step and 32-bit counter, the probability of mistaking a counter resetfor a legitimate wrap is arguably about 0.8% per 1Mbps of maximum bandwidth. Note that this equates to 80% for 100Mbps interfaces, so for high bandwidth interfaces and a 32bit counter, DERIVE with min=0 is probably preferable. If you are using a 64bit counter, just about any max setting will eliminate the possibility of mistaking a reset for a counter wrap.',
    'absolute_title' => 'ABSOLUTE',
    'absolute_desc' => 'ABSOLUTE is for counters which get reset upon reading. This is used for fast counters which tend to overflow. So instead of reading them normally you reset them after every read to make sure you have a maximum time available before the next overflow. Another usage is for things you count like number of messages since the last update.',
    'compute_title' => 'COMPUTE',
    'compute_desc' => 'COMPUTE is for storing the result of a formula applied to other data sources in the RRD. This data source is not supplied a value on update, but rather its Primary Data Points (PDPs) are computed from the PDPs of the data sources according to the rpn-expression that defines the formula. Consolidation functions are then applied normally to the PDPs of the COMPUTE data source (that is the rpn-expression is only applied to generate PDPs). In database software, such data sets are referred to as "virtual" or "computed" columns.',
    'data_source_templates_variables' => 'You are also able to use Variables to set the name for the data source. The available Variables can be seen on the',
    'variables_documentation' => 'Variables',
    'data_source_templates_variables_page' => 'documentation page.',
    'data_source_templates_internal_name' => 'What is also an important setting is the internal data source name. This will be used to asociate the Data source with the Graph template. so be sure to name is something that is recognizable.',

    // Aggregate Templates page specific
    'page_title_aggregate_templates' => 'Cacti - Aggregate Templates',
    'aggregate_templates_title' => 'Aggregate Templates',
    'aggregate_overview_title' => 'Aggregate Overview',
    'aggregate_templates_intro' => '**Aggregate Templates** are a special form of a **Graph Template**. They allow you to easily create **Graphs** that combine data from multiple common **Graphs** from multiple **Devices**, and allow you to easily manage the resulting **Aggregate Graphs** to add and remove elements from other common **Graphs**.',
    'aggregate_templates_creation' => 'To create **Aggregate Graphs** that are managed through a Template, you first must create the **Aggregate Template**. Then from the Cacti **Graphs** page, you can select the **Graphs** that you want used as part of the **Aggregate**. You then select `Create Aggregate from Template` from the Cacti Actions drop-down.',
    'aggregate_templates_behavior' => 'Once you have created your **Aggregate Graphs**, they behave like any other Cacti Graph. They can be a part of a Tree, zoomed, etc. They have an added bonus - you can add and remove **Graphs** from aggregate in a very controlled way, reducing the effort to maintain them during their life-cycle.',
    'aggregate_templates_changes' => 'If you wish to change settings for **Graphs** managed by the **Aggregate Template**, simply make the changes in the **Aggregate Template**, and they will cascade to **Aggregate Graphs** managed by the Template.',
    'aggregate_template_interface_title' => 'Aggregate Template Interface',
    'aggregate_template_interface_desc' => 'The images below shows an Aggregate Template for Traffic.',
    'aggregate_template_edit_desc' => 'When you edit the **Aggregate Template**, you are presented with an interface that allows you to define the Graph Canvas as well as it\'s formatting. You should experiment until you find the mechanism that works best to suite your needs.',
    'aggregate_template_prefix' => 'The `Aggregate Template` `Prefix` setting allows you to provide a pattern to be applied to the **Aggregate Graph** legend items. Any `host`, `query` or `input` references can be used in the `Prefix` section in order to uniquely identify the **Graph Item**.',
    'aggregate_graph_types' => 'There are several `Graph Types` transformations that deal with how `AREA`, `LINEX` and `STACK` items are handled in the resulting **Aggeregate Graph**, they include:',
    'keep_graph_types' => '**Keep Graph Types** - No transformation will occur. All `AREA`, `LINE`, and `STACKS` will be unchanged.',
    'keep_type_and_stack' => '**Keep Type and Stack** - Which means the types will be preserved, but all data will be stacked instead of simply LINEX it will be transformed to LINEX:STACK',
    'convert_to_area_stack' => '**Convert to Area/STACK Graph** - All `LINEX` will be converted to `AREA` and stacked.',
    'convert_to_line1' => '**Convert to LINE1** - All **Graph Items** will be converted to `LINE1`',
    'convert_to_line2' => '**Convert to LINE2** - All **Graph Items** will be converted to `LINE2`',
    'convert_to_line3' => '**Convert to LINE3** - All **Graph Items** will be converted to `LINE3`',
    'convert_to_line1_stack' => '**Convert to LINE1/Stack** - All **Graph Items** will be converted to `LINE1` and stacked.',
    'convert_to_line2_stack' => '**Convert to LINE2/Stack** - All **Graph Items** will be converted to `LINE2` and stacked.',
    'convert_to_line3_stack' => '**Convert to LINE3/Stack** - All **Graph Items** will be converted to `LINE3` and stacked.',
    'totaling_setting' => 'The `Totaling` setting has multiple values. They include:',
    'no_totals' => '**No Totals** - There will be no Summation of Data in the Legend',
    'print_all_legend_items' => '**Print All Legend Items** - Means that all Legend Items selected will be included with a Total',
    'print_totaling_legend_items' => '**Print Totaling Legend Items Only** - This option means that the Legend will total all the Legend items into a single Legend.',
    'total_type_setting' => 'The `Total Type` - Will create groupings of common elements on the **Graph**, and reset stacking rules when a change in the common element occurs. The options include:',
    'total_similar_data_sources' => '**Total Similar Data Sources** - Means that you will Total legend items and **Data Sources** through similar **Data Source** names, for example `traffic_out` and `traffic_in`.',
    'total_all_data_sources' => '**Total All Data Sources** - It means that you will sum the values for all **Data Sources** regardless of their **Data Source** name.',
    'prefix_gprint_totals' => 'When using `Total Type`, you are provided an option to additionally prefix your legends using the `Prefix for GPRINT Totals` with a text value. The default works in most cases.',
    'reorder_type_setting' => 'The `Reorder Type` will re-order the **Data Sources** within their respective grouping on the Graph so that they are ordered in a common way, in alphabetic order. The options include:',
    'no_reordering' => '**No Reordering** - Don\'t make any changes in ordering.',
    'data_source_graph_order' => '**Data Source, Graph** - Order by **Data Source** name and then by **Graph** name',
    'graph_data_source_order' => '**Graph, Data Source** - Order by **Graph** name and then by **Data Source** name',
    'base_graph_order' => '**Base Graph Order** - Focus on the **Graph** name only',
    'graph_template_items_section' => 'The `Graph Template Items` section allows you to either Skip or Total (aka include) the **Graph Items** in the resulting **Aggregate Graphs**. When you think about how a resulting **Aggregate** graph will look, there are some elements that simply will not result in a good looking **Graph**. In those cases you will want to remove them from the resulting **Aggregate Graphs**.',
    'color_template_option' => 'The `Color Template` option allows you to use differing Color rotations when displaying elements on the resulting **Aggregate Graphs**. **Color Templates** can be added and removed from the **Color Templates** menu pick under `Console > Templates`.',
    'aggregate_override_sections' => 'The several sections allow you to override any of the common **Graph Template** elements from the resulting **Aggregate Graph**. We will not explain those options here, only let you know that you can override them in your resulting **Aggregate Graph**.',
    'aggregate_summary_title' => 'Summary',
    'aggregate_summary_desc' => 'There are several combinations of options that you can use when working with an **Aggregate Template**. Some of these options will results in horrible and unexpected outcomes, so you will have to experiment until you come up with a desirable **Aggregate Template**.',

    // Color Templates page specific
    'page_title_color_templates' => 'Cacti - Color Templates',
    'color_templates_title' => 'Color Templates',
    'color_templates_intro' => '**Color Templates** define a list of Colors to be used for **Aggregate Graphs** in Cacti. As you add **Graphs** to an **Aggregate Graph**, you need to distinguish one **Graph** from the next within the **Aggregate Graph**. These **Color Templates** are a list of colors that will be looped through in Round Robin fashion to render the **Aggregate Graph**.',
    'color_templates_example' => 'So, for example, if your **Color Template** uses 8 differing **Colors**, and your **Aggregate Graph** includes 16 *Graph Items*, then each color will be used twice in the **Aggregate Graph**.',
    'color_templates_standard' => 'Below, you can see the four standard **Color Templates**, you can see that you have the ability to either *Delete* or *Duplicate* the **Color Templates**. As with other Cacti objects, you will not be allowed to *Delete* a **Color Template** in use.',
    'color_templates_edit_screen' => 'In the image below, you can see the **Color Template** edit screen. This simply screen allows you to add, remove and re-order colors in the list.',
    'color_templates_cacti_colors' => 'Shown in the image below, only Cacti **Colors** are allowed to be selected for Aggregate **Color Templates**. The **Color** drop down can by typed into if you wish to search through the list of approximately 340 legacy and *Named Colors*.',

    // Common template terms
    'data_source_template' => 'Data Source Template',
    'data_source_templates' => 'Data Source Templates',
    'aggregate_template' => 'Aggregate Template',
    'aggregate_templates' => 'Aggregate Templates',
    'aggregate_graphs' => 'Aggregate Graphs',
    'color_template' => 'Color Template',
    'color_templates' => 'Color Templates',
    'graph_items' => 'Graph Items',
    'data_points' => 'Data Points',
    'primary_data_points' => 'Primary Data Points',
    'rpn_expression' => 'RPN Expression',
    'consolidation_functions' => 'Consolidation Functions',
    'virtual_columns' => 'Virtual Columns',
    'computed_columns' => 'Computed Columns',
    'internal_data_source_name' => 'Internal Data Source Name',
    'round_robin_fashion' => 'Round Robin Fashion',
    'named_colors' => 'Named Colors',
    'legacy_colors' => 'Legacy Colors',

    // Automation Networks page specific
    'page_title_automation_networks' => 'Cacti - Automation Networks',
    'automation_networks_title' => 'Automation Networks',
    'automation_networks_intro' => 'This section will describe **Automation Networks** in Cacti.',
    'automation_networks_adding' => 'Adding a network to scan in the automation plugin is easy. On the main console click Automation. Once on the below page click the + on the top right of the page.',
    'automation_networks_main_desc' => 'Automation Networks',
    'automation_networks_subnet_desc' => 'You will now see the below page. If you want to scan 192.168.1.0/24, you would enter that in the subnet range textbox then enter the subnet in CIDR format.',
    'automation_networks_options' => 'Other important options are',

    // Automation Networks options table
    'automation_option_field' => 'Option',
    'automation_description_field' => 'Description',
    'schedule_type_option' => 'Schedule type',
    'schedule_type_desc' => 'How often you want to scan this subnet for devices',
    'discovery_threads_option' => 'Discovery threads',
    'discovery_threads_desc' => 'How many proccessess to spawn during the scan',
    'max_runtime_option' => 'Max Runtime',
    'max_runtime_desc' => 'to prevent the scan from running indefinitely',
    'auto_add_option' => 'Automatically add to Cacti',
    'auto_add_desc' => 'If a device is SNMP reachable and matches a rule from this subnet the device will be added',
    'netbios_option' => 'Netbios',
    'netbios_desc' => 'Scan for netbios name',
    'ping_method_option' => 'Ping Method',
    'ping_method_desc' => 'The type of ping packet to send',
    'ping_port_option' => 'Ping Port',
    'ping_port_desc' => 'TCP/UDP port to attempt connection',
    'ping_timeout_option' => 'Ping Timeout',
    'ping_timeout_desc' => 'The timeout value to use for host ICMP and UDP pinging. This host SNMP timeout value applies for SNMP pings',
    'ping_retries_option' => 'Ping Retries',
    'ping_retries_desc' => 'After an initial failure, the number of ping retries Cacti will attempt before failing',
    'automation_networks_edit_desc' => 'Automation Networks Edit',

    // Discovered Devices page specific
    'page_title_discovered_devices' => 'Cacti - Automation Discovered Devices',
    'discovered_devices_title' => 'Automation Discovered Devices',
    'discovered_devices_intro' => 'After you initiate a scan from automation Cacti will compare devices found to the device rules and SNMP options you set.',
    'discovered_devices_no_match' => 'If Cacti is unable to match the device to a device template or unable to find a proper SNMP credential.',
    'discovered_devices_auto_add_off' => 'Also if you have the automatically add to Cacti set to off the devices will also be put in this section.',
    'discovered_devices_navigation' => 'The Discovered Devices section can be found by navigating to the following area.',
    'discovered_devices_dropdown_desc' => 'Discovered Devices',
    'discovered_devices_scan_results' => 'Below you can see devices that have been found during the scan that did not meet a match criteria.',
    'discovered_devices_ip_hostname' => 'You will see the IP that was scanned as well if available the resolved hostname either via DNS or netbios.',
    'discovered_devices_list_desc' => 'Discovered Devices',
    'discovered_devices_selection' => 'You can then select the device you are interested in adding click the checkbox next to the device',
    'discovered_devices_add_menu' => 'on the dropdown you select add device this will bring up the below menu. From this Menu you will be able to fill out the details of the new device.',
    'discovered_devices_add_menu_desc' => 'Discovered Devices',

    // Device Rules page specific
    'page_title_device_rules' => 'Cacti - Device Rules',
    'device_rules_title' => 'Device Rules',
    'device_rules_intro' => 'Device Rules allow you to automatically assign a Device Template to a Device during the Network Discovery process.',
    'device_rules_creation' => 'To create a Device Rule, you must first have a Device Template created. Then, from the Device Rules page, you can create a rule that will match devices based upon their SNMP System Description, or their SNMP System Object ID.',
    'device_rules_matching' => 'When a device is discovered, Cacti will attempt to match the device to a Device Rule. If a match is found, the Device Template associated with the Device Rule will be applied to the device.',
    'device_rules_priority' => 'Device Rules are processed in order of their priority. The first rule that matches will be applied to the device.',

    // Graph Rules page specific
    'page_title_graph_rules' => 'Cacti - Graph Rules',
    'graph_rules_title' => 'Graph Rules',
    'graph_rules_intro' => 'Graph Rules allow you to automatically create Graphs for Devices during the Network Discovery process.',
    'graph_rules_creation' => 'To create a Graph Rule, you must first have Graph Templates and Data Queries created. Then, from the Graph Rules page, you can create rules that will automatically create graphs based upon various criteria.',
    'graph_rules_matching' => 'When a device is discovered and matches a Device Rule, Cacti will then process any Graph Rules to automatically create graphs for the device.',
    'graph_rules_types' => 'There are several types of Graph Rules including rules for Graph Templates and Data Query based graphs.',

    // Tree Rules page specific
    'page_title_tree_rules' => 'Cacti - Tree Rules',
    'tree_rules_title' => 'Tree Rules',
    'tree_rules_intro' => 'Tree Rules allow you to automatically place Devices and Graphs into Trees during the Network Discovery process.',
    'tree_rules_creation' => 'To create a Tree Rule, you must first have Trees created. Then, from the Tree Rules page, you can create rules that will automatically place devices and graphs into the appropriate tree locations.',
    'tree_rules_matching' => 'When a device is discovered, Cacti will process Tree Rules to automatically organize the device and its graphs into the tree structure.',
    'tree_rules_hierarchy' => 'Tree Rules can create hierarchical structures based on device properties such as site, device type, or custom fields.',

    // SNMP Options page specific
    'page_title_snmp_options' => 'Cacti - SNMP Options',
    'snmp_options_title' => 'SNMP Options',
    'snmp_options_intro' => 'SNMP Options define the SNMP credentials and settings that will be used during the Network Discovery process.',
    'snmp_options_creation' => 'To create SNMP Options, you define the SNMP version, community strings, usernames, passwords, and other SNMP-related settings.',
    'snmp_options_discovery' => 'During network discovery, Cacti will attempt to connect to devices using the defined SNMP Options to determine if the device is SNMP-enabled.',
    'snmp_options_versions' => 'SNMP Options support SNMP versions 1, 2c, and 3, each with their own specific configuration requirements.',
    'snmp_options_security' => 'For SNMP v3, you can configure authentication and privacy protocols for secure SNMP communication.',

    // Common automation terms
    'automation_networks' => 'Automation Networks',
    'discovered_devices' => 'Discovered Devices',
    'device_rules' => 'Device Rules',
    'graph_rules' => 'Graph Rules',
    'tree_rules' => 'Tree Rules',
    'snmp_options' => 'SNMP Options',
    'network_discovery' => 'Network Discovery',
    'device_template_assignment' => 'Device Template Assignment',
    'automatic_graph_creation' => 'Automatic Graph Creation',
    'tree_organization' => 'Tree Organization',
    'snmp_credentials' => 'SNMP Credentials',
    'discovery_process' => 'Discovery Process',
    'automation_rules' => 'Automation Rules',
    'subnet_scanning' => 'Subnet Scanning',
    'device_matching' => 'Device Matching',
    'rule_priority' => 'Rule Priority',
    'snmp_versions' => 'SNMP Versions',
    'community_strings' => 'Community Strings',
    'authentication_protocols' => 'Authentication Protocols',
    'privacy_protocols' => 'Privacy Protocols',

    // Networks page specific
    'page_title_networks' => 'Cacti - Networks',
    'networks_title' => 'Networks',
    'networks_intro' => 'The **Networks** section in Cacti provides comprehensive network management and monitoring capabilities. This section covers various aspects of network discovery, device management, and automation features that help you efficiently monitor your network infrastructure.',
    'networks_overview' => 'Cacti\'s network management features include automated network discovery, device rules for automatic device classification, graph rules for automatic graph creation, and tree rules for organizing your network topology.',
    'networks_automation_title' => 'Network Automation',
    'networks_automation_desc' => 'Cacti provides powerful automation features that can automatically discover devices on your network, classify them according to predefined rules, and create appropriate graphs and organize them in trees.',
    'networks_discovery_title' => 'Network Discovery',
    'networks_discovery_desc' => 'The network discovery process allows Cacti to automatically scan network ranges and identify devices that can be monitored. This process uses SNMP and other protocols to detect and classify network devices.',
    'networks_device_management_title' => 'Device Management',
    'networks_device_management_desc' => 'Once devices are discovered, Cacti can automatically apply device templates, create appropriate graphs, and organize devices according to your network topology and management requirements.',
    'networks_monitoring_title' => 'Network Monitoring',
    'networks_monitoring_desc' => 'Cacti provides comprehensive network monitoring capabilities including interface statistics, device performance metrics, and custom monitoring through SNMP, scripts, and other data collection methods.',
    'networks_organization_title' => 'Network Organization',
    'networks_organization_desc' => 'Use Cacti\'s tree and site management features to organize your network devices and graphs in a logical hierarchy that matches your network topology and organizational structure.',
    'networks_features_title' => 'Key Network Features',
    'networks_feature_automation' => '**Automation Networks** - Configure network ranges for automatic discovery',
    'networks_feature_discovered' => '**Discovered Devices** - Manage devices found during network scans',
    'networks_feature_device_rules' => '**Device Rules** - Define rules for automatic device template assignment',
    'networks_feature_graph_rules' => '**Graph Rules** - Configure automatic graph creation rules',
    'networks_feature_tree_rules' => '**Tree Rules** - Set up automatic device and graph organization',
    'networks_feature_snmp' => '**SNMP Options** - Configure SNMP credentials and settings for device communication',
    'networks_getting_started_title' => 'Getting Started with Network Management',
    'networks_getting_started_desc' => 'To get started with Cacti\'s network management features, begin by configuring your SNMP options, then set up automation networks to define the network ranges you want to monitor. Create device rules to automatically classify discovered devices, and configure graph and tree rules to automatically organize your monitoring data.',
    'networks_best_practices_title' => 'Best Practices',
    'networks_best_practices_desc' => 'For optimal network management, organize your devices by site and function, use consistent naming conventions, configure appropriate SNMP credentials for different device types, and regularly review and update your automation rules to ensure they match your evolving network infrastructure.',

    // Data Profiles page specific
    'page_title_data_profiles' => 'Cacti - Data Source Profiles',
    'data_profiles_title' => 'Data Source Profiles',
    'data_profiles_intro' => 'This section will describe **Data Source Profiles** in Cacti.',
    'data_profiles_disk_usage' => 'The following values are for the disk usage per Data source for the respective data profile',
    'data_profiles_polling_time' => 'polling time',
    'data_profiles_type' => 'type',
    'data_profiles_size_per_ds' => 'size per ds',
    'data_profiles_30_second' => '30 second',
    'data_profiles_daily' => 'Daily',
    'data_profiles_weekly' => 'Weekly',
    'data_profiles_monthly' => 'Monthly',
    'data_profiles_yearly' => 'Yearly',
    'data_profiles_48kb' => '48kb',
    'data_profiles_43kb' => '43kb',
    'data_profiles_46kb' => '46kb',
    'data_profiles_140kb' => '140kb',

    // CDEFs page specific
    'page_title_cdefs' => 'Cacti - CDEFs',
    'cdefs_title' => 'CDEFs',
    'cdefs_background_title' => 'Background',
    'cdefs_background_desc' => 'CDEF\'s in Cacti are a one to one analog to CDEF\'s in RRDtool. Cacti simply provides and interface to create and manage them. Once the CDEF\'s are created in Cacti they can be imported and exported globally.',
    'cdefs_mathematical_formulas' => 'CDEF\'s are mathematical formulas that either modify the numeric data from one to many data sources or VNAMES that you have in your **Graph Template**.',
    'cdefs_rpn_format' => 'The format of the mathematical formulas is called Reverse Polish Notation (RPN). RPN was and is an early form of how Engineers entered equations into early HP and other Calculators to solve Engineering problems. The reason we still use it today, is that it follows a simple Stack principle. In other words, it\'s not broken.',
    'cdefs_complexity' => 'CDEF\'s can get very complex as there are several mathematical functions available in the RRDtool command set.',
    'cdefs_interface_title' => 'CDEF Interface',
    'cdefs_interface_desc' => 'In the image below, you can see all the CDEF\'s that are included in Cacti by default. There are quite a few of them. Many of the formulas in use are quite simple. If you want to view Tutorials on how to work with CDEF\'s you should go to the RRDtool Tutorial. There is also documentation at the RRDtool Website.',
    'cdefs_delete_duplicate' => 'In this image you can see that you have the ability to Delete or Duplicate a CDEF, but note you will not be able to Delete any CDEF that is associated with a Cacti **Graph** or **Graph Template**.',
    'cdefs_edit_screen' => 'When you Click on the CDEF\'s name, you will enter into an Edit screen. From there you will see an ordered list of your Stack. It normally will begin with something like the CURRENT_DATA_SOURCE which means that when you Add a **Graph Item** to either a **Graph Template** or **Graph**, you can select a CDEF. The **Data Source** associated with that **Graph Items** is the CURRENT_DATA_SOURCE.',
    'cdefs_stack_operations' => 'After that, you may see a numeric number, followed by a math operator. That the simplest form of a CDEF. If you have drag & drop enabled, you can re-order the CDEF items using drag & drop. Otherwise you will see arrows that allow you to move the CDEF Items up and down.',
    'cdefs_data_types' => 'When editing a CDEF, the first decision is what Type of Data you want to put on the Stack, you options as shown in the image below. They include:',
    'cdefs_type_function' => 'Function',
    'cdefs_type_function_desc' => 'A mathematical function that we will describe below',
    'cdefs_type_operator' => 'Operator',
    'cdefs_type_operator_desc' => 'Common mathematical operators including (+, -, *, /, and %)',
    'cdefs_type_another_cdef' => 'Another CDEF',
    'cdefs_type_another_cdef_desc' => 'You can reference another CDEF in your CDEF',
    'cdefs_type_special_data_source' => 'Special Data Source',
    'cdefs_type_special_data_source_desc' => 'These are special variables that RRDtool provides',
    'cdefs_type_custom_string' => 'Custom String',
    'cdefs_type_custom_string_desc' => 'You can enter any custom string or number',

    // VDEFs page specific
    'page_title_vdefs' => 'Cacti - VDEFs',
    'vdefs_title' => 'VDEFs',
    'vdefs_intro' => 'VDEFs in Cacti are used to define virtual data sources that can perform statistical operations on existing data sources.',
    'vdefs_description' => 'VDEFs allow you to create virtual data sources that can calculate statistics like AVERAGE, MAXIMUM, MINIMUM, TOTAL, and other mathematical operations on your data.',
    'vdefs_usage' => 'VDEFs are commonly used in graph templates to display statistical information alongside your regular data sources.',

    // Colors page specific
    'page_title_colors' => 'Cacti - Colors',
    'colors_title' => 'Colors',
    'colors_intro' => 'This section will describe **Colors** in Cacti.',
    'colors_description' => 'Colors in Cacti are used to define the visual appearance of graphs. You can create custom colors or use the predefined color palette.',
    'colors_management' => 'The color management interface allows you to add, edit, and delete colors that can be used throughout Cacti for graph rendering.',
    'colors_hex_values' => 'Colors are defined using hexadecimal color values (e.g., #FF0000 for red, #00FF00 for green, #0000FF for blue).',

    // GPRINTs page specific
    'page_title_gprints' => 'Cacti - GPRINTs',
    'gprints_title' => 'GPRINTs',
    'gprints_intro' => 'This section will describe **GPRINTs** in Cacti.',
    'gprints_description' => 'GPRINTs (Graph Prints) are used to display statistical information on graphs. They define how numerical values are formatted and displayed.',
    'gprints_formatting' => 'GPRINTs control the formatting of numbers displayed on graphs, including decimal places, units, and text formatting.',
    'gprints_presets' => 'Cacti includes several predefined GPRINT presets for common formatting needs, and you can create custom GPRINTs for specific requirements.',
    'gprints_usage' => 'GPRINTs are typically used in graph templates to display current, average, maximum, and minimum values for data sources.',

    // Common preset terms
    'data_profiles' => 'Data Profiles',
    'data_source_profiles' => 'Data Source Profiles',
    'cdefs' => 'CDEFs',
    'vdefs' => 'VDEFs',
    'colors' => 'Colors',
    'gprints' => 'GPRINTs',
    'gprint_presets' => 'GPRINT Presets',
    'mathematical_formulas' => 'Mathematical Formulas',
    'reverse_polish_notation' => 'Reverse Polish Notation',
    'rpn' => 'RPN',
    'stack_operations' => 'Stack Operations',
    'data_source_statistics' => 'Data Source Statistics',
    'graph_formatting' => 'Graph Formatting',
    'color_palette' => 'Color Palette',
    'hexadecimal_values' => 'Hexadecimal Values',
    'statistical_operations' => 'Statistical Operations',
    'virtual_data_sources' => 'Virtual Data Sources',
    'numerical_formatting' => 'Numerical Formatting',
    'preset_management' => 'Preset Management',
    'graph_rendering' => 'Graph Rendering',
    'data_visualization' => 'Data Visualization',

    // Import Template page specific
    'page_title_import_template' => 'Cacti - Template Import',
    'import_template_title' => 'Template Import',
    'import_template_intro' => 'This section will describe **Template Import** in Cacti.',
    'import_template_description' => 'Template Import files are XML files used to add support for more graph types and different devices that can be shared with others. These template files can either be custom made or you could download them from the community on the cacti forums.',
    'import_template_process' => 'Once you have downloaded the graph/device template you are looking for you will need to import the template into the cacti system. To import a device/graph template go to `Console > Import/Export > Import Templates` you will now see the below page',
    'import_template_important_note' => '**Important note**: When importing the template be sure to match the data source profile with your preferred **Data Source Profile**.',
    'import_template_select_file' => 'First you must click on **Select File** and browse to where the XML file is located on your computer. Cacti will default to preview the import to check for any issues. If none are found, you can select the same file and then untick the preview option to import after which the template should be available.',
    'import_template_remove_orphans' => 'The `Remove Orphans` option should only be used if you have Templates that have become damaged and the best way to correct them is to start over. This option will remove any **Graph Items** from any **Graph** that do not appear in the **Graph Template** to be imported. Use this option with care.',

    // Export Template page specific
    'page_title_export_template' => 'Cacti - Template Exporting',
    'export_template_title' => 'Template Exporting',
    'export_template_intro' => 'Cacti allows **Device**, **Graph**, and **Data** Templates to be exported in XML format. You can access the screen below by going to `Console > Import / Export > Template Export`. When you get to this page, the most popular option is to export the **Device Template**, but the discretion is upto the user. Once you pick the object type, the list of available templates is presented. The most popular option is to save to a file, but you have additional options.',
    'export_template_guid' => 'Inside of the Template, Cacti uses a **hash** Global Uniqueue ID (GUID) to uniquely identify every Template component. So, any Template that you export can be shared with anyone around the globe without ambiguity. See the Linux Device Template Example below.',
    'export_template_components' => 'In this Template thaere are Many Components:',
    'export_template_component_1' => 'The Device Template Name itself and it\'s GUID',
    'export_template_component_2' => 'All the Graph Templates and their GUID\'s',
    'export_template_component_3' => 'All the Graph Template inputs and their GUID\'s',
    'export_template_component_4' => 'All the Data Templates and their GUID\'s',
    'export_template_component_5' => 'All the Data Input Method\'s and their GUID\'s',
    'export_template_component_6' => 'All the GPrint Presets and their GUID\'s',
    'export_template_component_7' => 'All the CDEF\'s and VDEF\'s and their GUID\'s',
    'export_template_component_8' => 'All the Data Source Profiles and their GUID\'s',
    'export_template_encoding' => 'Although the output is human readable, some columns are encoded so as to not cause problems with the XML output format. To read them, you must base64_decode them in PHP or some other language.',
    'export_template_format' => 'Presently they are saved in XML format, but there are discussions with making these templates YAML formatted.',

    // Common template import/export terms
    'template_import' => 'Template Import',
    'template_export' => 'Template Export',
    'template_exporting' => 'Template Exporting',
    'xml_files' => 'XML Files',
    'template_files' => 'Template Files',
    'graph_types' => 'Graph Types',
    'device_templates' => 'Device Templates',
    'graph_templates' => 'Graph Templates',
    'data_templates' => 'Data Templates',
    'import_export' => 'Import/Export',
    'select_file' => 'Select File',
    'preview_import' => 'Preview Import',
    'remove_orphans' => 'Remove Orphans',
    'global_unique_id' => 'Global Unique ID',
    'guid' => 'GUID',
    'hash_identifier' => 'Hash Identifier',
    'template_components' => 'Template Components',
    'xml_format' => 'XML Format',
    'yaml_format' => 'YAML Format',
    'base64_decode' => 'Base64 Decode',
    'human_readable' => 'Human Readable',
    'template_sharing' => 'Template Sharing',
    'community_templates' => 'Community Templates',
    'custom_templates' => 'Custom Templates',
    'damaged_templates' => 'Damaged Templates'
);
?>
