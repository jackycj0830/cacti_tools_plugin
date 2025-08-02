<?php
/**
 * Cacti Documentation Main Page
 * 
 * This is the main documentation page with multilingual support.
 * Language content is managed through PHP language files.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';

// Handle language change requests
if (isset($_GET['lang'])) {
    $languageManager->setLanguage($_GET['lang']);
    // Redirect to remove language parameter from URL
    $currentUrl = strtok($_SERVER["REQUEST_URI"], '?');
    header("Location: $currentUrl");
    exit;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $languageManager->getCurrentLanguage(); ?>" xml:lang="<?php echo $languageManager->getCurrentLanguage(); ?>">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <title><?php echo $languageManager->getPageTitle('main'); ?></title>
  <link rel="stylesheet" href="Cacti-Github.css" />
  <style>
    /* Language selector styles */
    .language-controls {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.98);
        padding: 10px 15px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border: 1px solid #e0e0e0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        font-size: 14px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .language-controls:hover {
        box-shadow: 0 6px 25px rgba(0,0,0,0.2);
        transform: translateY(-1px);
    }

    .language-controls label {
        display: inline-block;
        margin-right: 8px;
        font-weight: 500;
        color: #495057;
    }

    .language-controls select {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        min-width: 140px;
        transition: all 0.3s ease;
        outline: none;
    }

    .language-controls select:hover {
        background: #f8f9fa;
        border-color: #007cba;
    }

    .language-controls select:focus {
        border-color: #007cba;
        box-shadow: 0 0 0 3px rgba(0,124,186,0.1);
    }

    /* Back button styles */
    .back-button {
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 1000;
    }

    .back-button a {
        background: linear-gradient(135deg, #007cba 0%, #005a87 100%);
        color: white;
        padding: 10px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        font-weight: 500;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,124,186,0.3);
    }

    .back-button a:hover {
        background: linear-gradient(135deg, #005a87 0%, #004066 100%);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0,124,186,0.4);
    }

    /* Ensure page content is not obscured */
    body {
        padding-top: 60px;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .language-controls {
            top: 5px;
            right: 5px;
            padding: 8px 12px;
        }
        
        .back-button {
            top: 5px;
            left: 5px;
        }
        
        .language-controls select {
            min-width: 120px;
            font-size: 13px;
            padding: 5px 8px;
        }
        
        .back-button a {
            padding: 8px 12px;
            font-size: 13px;
        }
        
        body {
            padding-top: 55px;
        }
    }

    @media (max-width: 480px) {
        .language-controls {
            padding: 6px 8px;
        }
        
        .language-controls label {
            display: block;
            margin-bottom: 5px;
            margin-right: 0;
        }
        
        .language-controls select {
            min-width: 100px;
            font-size: 12px;
        }
        
        body {
            padding-top: 70px;
        }
    }
  </style>
</head>
<body>

<!-- Language Controls -->
<div class="language-controls">
    <?php echo $languageManager->generateLanguageSelector(); ?>
</div>

<!-- Back Button (hidden on main page) -->
<?php echo $languageManager->generateBackButton(false); ?>

<h1 id="cacti-tm-documentation"><?php _e('main_title'); ?></h1>
<p><em><?php _e('main_subtitle'); ?></em></p>

<p><?php _e('welcome_message'); ?></p>

<h2 id="cacti-installation"><?php _e('section_installation'); ?></h2>
<p><?php _e('section_installation_desc'); ?></p>

<ul>
<li><a href="Known-Issues.php"><?php _e('known_issues_link'); ?></a></li>
<li><a href="Requirements.php"><?php _e('requirements'); ?></a></li>
<li><a href="General-Installing-Instructions.php"><?php _e('general_installing'); ?></a></li>
<li><a href="Installing-Under-CentOS_LAMP.php"><?php _e('installing_centos_lamp'); ?></a></li>
<li><a href="Installing-Under-CentOS_LEMP.php"><?php _e('installing_centos_lemp'); ?></a></li>
<li><a href="Installing-Under-Ubuntu-Debian.php"><?php _e('installing_ubuntu'); ?></a></li>
<li><a href="Installing-Under-Windows.php"><?php _e('installing_windows'); ?></a></li>
<li><a href="Upgrading-Cacti.php"><?php _e('upgrading_linux'); ?></a></li>
<li><a href="Upgrading-Cacti-Under-Windows.php"><?php _e('upgrading_windows'); ?></a></li>
<li><a href="Upgrading-Cacti-Under-FreeBSD.php"><?php _e('upgrading_freebsd'); ?></a></li>
</ul>

<h2 id="cacti-overview"><?php _e('section_overview'); ?></h2>
<p><?php _e('section_overview_desc'); ?></p>

<ul>
<li><a href="Navigating-The-User-Interface.php"><?php _e('navigating_ui'); ?></a></li>
<li><a href="Principles-of-Operation.php"><?php _e('principles_operation'); ?></a></li>
<li><a href="Graph-Overview.php"><?php _e('graph_overview'); ?></a></li>
<li><a href="How-to-Graph-Your-Network.php"><?php _e('how_to_graph'); ?></a></li>
<li><a href="Viewing-Graphs.php"><?php _e('viewing_graphs'); ?></a></li>
</ul>

<h3 id="management"><?php _e('management'); ?></h3>
<ul>
<li><a href="Devices.php"><?php _e('devices'); ?></a></li>
<li><a href="Sites.php"><?php _e('sites'); ?></a></li>
<li><a href="Trees.php"><?php _e('trees'); ?></a></li>
<li><a href="Graphs.php"><?php _e('graphs'); ?></a></li>
<li><a href="Data-Sources.php"><?php _e('data_sources'); ?></a></li>
<li><a href="Aggregates.php"><?php _e('aggregates'); ?></a></li>
</ul>

<h3 id="data-collection"><?php _e('data_collection'); ?></h3>
<ul>
<li><a href="Data-Collectors.php"><?php _e('data_collectors'); ?></a></li>
<li><a href="Spine-Data-Collection.php"><?php _e('spine_collection'); ?></a></li>
<li><a href="Data-Input-Methods.php"><?php _e('data_input_methods'); ?></a></li>
<li><a href="Data-Queries.php"><?php _e('data_queries'); ?></a></li>
</ul>

<h3 id="templates"><?php _e('templates'); ?></h3>
<ul>
<li><a href="Device-Templates.php"><?php _e('device_templates'); ?></a></li>
<li><a href="Graph-Templates.php"><?php _e('graph_templates'); ?></a></li>
<li><a href="Data-Source-Templates.php"><?php _e('data_source_templates'); ?></a></li>
<li><a href="Aggregate-Templates.php"><?php _e('aggregate_templates'); ?></a></li>
<li><a href="Color-Templates.php"><?php _e('color_templates'); ?></a></li>
</ul>

<h3 id="automation"><?php _e('automation'); ?></h3>
<ul>
<li><a href="Networks.php"><?php _e('networks'); ?></a></li>
<li><a href="Automation-Networks.php"><?php _e('automation_networks'); ?></a></li>
<li><a href="Discovered-Devices.php"><?php _e('discovered_devices'); ?></a></li>
<li><a href="Device-Rules.php"><?php _e('device_rules'); ?></a></li>
<li><a href="Graph-Rules.php"><?php _e('graph_rules'); ?></a></li>
<li><a href="Tree-Rules.php"><?php _e('tree_rules'); ?></a></li>
<li><a href="SNMP-Options.php"><?php _e('snmp_options'); ?></a></li>
</ul>

<h3 id="presets"><?php _e('presets'); ?></h3>
<ul>
<li><a href="Data-Profiles.php"><?php _e('data_profiles'); ?></a></li>
<li><a href="CDEFs.php"><?php _e('cdefs'); ?></a></li>
<li><a href="VDEFs.php"><?php _e('vdefs'); ?></a></li>
<li><a href="Colors.php"><?php _e('colors'); ?></a></li>
<li><a href="GPRINTs.php"><?php _e('gprints'); ?></a></li>
</ul>

<h3 id="import-export"><?php _e('import_export'); ?></h3>
<ul>
<li><a href="Import-Template.php"><?php _e('import_templates'); ?></a></li>
<li><a href="Export-Template.php"><?php _e('export_templates'); ?></a></li>
</ul>

<h2 id="advanced-operations"><?php _e('section_advanced'); ?></h2>
<p><?php _e('section_advanced_desc'); ?></p>

<h3 id="settings"><?php _e('settings'); ?></h3>
<h4 id="settings-without-auth"><?php _e('settings_without_auth'); ?></h4>
<ul>
<li><a href="Settings-General.php"><?php _e('settings_general'); ?></a></li>
<li><a href="Settings-Paths.php"><?php _e('settings_paths'); ?></a></li>
<li><a href="Settings-Device-Defaults.html"><?php _e('settings_device_defaults'); ?></a></li>
<li><a href="Settings-Poller.html"><?php _e('settings_poller'); ?></a></li>
<li><a href="Settings-Data.html"><?php _e('settings_data'); ?></a></li>
<li><a href="Settings-Visual.html"><?php _e('settings_visual'); ?></a></li>
<li><a href="Settings-Performance.html"><?php _e('settings_performance'); ?></a></li>
<li><a href="Settings-Spikes.html"><?php _e('settings_spikes'); ?></a></li>
<li><a href="Settings-Mail-Reporting-DNS.html"><?php _e('settings_mail_reporting_dns'); ?></a></li>
</ul>

<h4 id="settings-auth"><?php _e('settings_auth'); ?></h4>
<ul>
<li><a href="Settings-Auth-Local.html"><?php _e('settings_auth_local'); ?></a></li>
<li><a href="Settings-Auth-LDAP.html"><?php _e('settings_auth_ldap'); ?></a></li>
<li><a href="Settings-Auth-Basic.html"><?php _e('settings_auth_basic'); ?></a></li>
<li><a href="Settings-Domains.html"><?php _e('settings_domains'); ?></a></li>
</ul>

<h3 id="configuration"><?php _e('configuration_users_groups_domains'); ?></h3>
<ul>
<li><a href="User-Management.php"><?php _e('user_management'); ?></a></li>
<li><a href="User-Group-Management.html"><?php _e('user_group_management'); ?></a></li>
<li><a href="User-Domains.html"><?php _e('user_domains'); ?></a></li>
</ul>

<h3 id="plugins"><?php _e('configuration_plugins'); ?></h3>
<ul>
<li><a href="Plugin-Management.html"><?php _e('plugin_management'); ?></a></li>
</ul>

<h3 id="utilities"><?php _e('utilities'); ?></h3>
<ul>
<li><a href="System-Utilities.html"><?php _e('system_utilities'); ?></a></li>
<li><a href="Data-Debug.html"><?php _e('data_debug'); ?></a></li>
<li><a href="External-Links.html"><?php _e('external_links'); ?></a></li>
</ul>

<h3 id="reporting"><?php _e('reporting'); ?></h3>
<ul>
<li><a href="Reports-Admin.html"><?php _e('reports_admin'); ?></a></li>
<li><a href="Reports-User.html"><?php _e('reports_user'); ?></a></li>
<li><a href="Reports-Items.html"><?php _e('reports_items'); ?></a></li>
<li><a href="Reports-Preview.html"><?php _e('reports_preview'); ?></a></li>
<li><a href="Reports-Events.html"><?php _e('reports_events'); ?></a></li>
<li><a href="Reports-Other-Options.html"><?php _e('reports_other_options'); ?></a></li>
</ul>

<h3 id="other-advanced"><?php _e('other_advanced_topics'); ?></h3>
<ul>
<li><a href="The-Cacti-Log.html"><?php _e('cacti_log'); ?></a></li>
<li><a href="Command-Line-Scripts.html"><?php _e('command_line_scripts'); ?></a></li>
<li><a href="PHP-Script-Server.html"><?php _e('php_script_server'); ?></a></li>
<li><a href="Boost.html"><?php _e('boost'); ?></a></li>
<li><a href="Frequently-Asked-Questions.php"><?php _e('frequently_asked_questions'); ?></a></li>
<li><a href="Replacement-Variables.html"><?php _e('replacement_variables'); ?></a></li>
<li><a href="RRDtool-Specific-Features.html"><?php _e('rrdtool_specific_features'); ?></a></li>
<li><a href="RRDProxy-Specific-Features.html"><?php _e('rrdproxy_specific_features'); ?></a></li>
<li><a href="Spikekill.html"><?php _e('spikekill'); ?></a></li>
<li><a href="Debugging.html"><?php _e('debugging'); ?></a></li>
<li><a href="Version-Specific-Release-Notes.html"><?php _e('version_specific_release_notes'); ?></a></li>
</ul>

<h2 id="plugin-development"><?php _e('section_plugin_dev'); ?></h2>
<p><?php _e('section_plugin_dev_desc'); ?></p>

<ul>
<li><a href="Plugin-Overview.html"><?php _e('plugin_overview'); ?></a></li>
<li><a href="Plugin-Guidelines.html"><?php _e('plugin_guidelines'); ?></a></li>
<li><a href="Creating-Plugins.html"><?php _e('creating_plugins'); ?></a></li>
<li><a href="Plugin-References.html"><?php _e('plugin_references'); ?></a></li>
<li><a href="Plugin-Hook-API-Ref.html"><?php _e('plugin_hook_api_ref'); ?></a></li>
</ul>

<h3 id="supported-plugins"><?php _e('supported_plugins'); ?></h3>
<ul>
<li><a href="Syslog-Plugin.html"><?php _e('syslog_plugin'); ?></a></li>
<li><a href="Mactrack-Plugin.html"><?php _e('mactrack_plugin'); ?></a></li>
<li><a href="ReportIt-Plugin.html"><?php _e('reportit_plugin'); ?></a></li>
</ul>

<h2 id="how-tos"><?php _e('section_howtos'); ?></h2>
<p><?php _e('section_howtos_desc'); ?></p>

<ul>
<li><a href="How-To-Work-with-Templates.html"><?php _e('how_to_work_with_templates'); ?></a></li>
<li><a href="How-To-Create-Data-Input-Method.html"><?php _e('how_to_create_data_input_method'); ?></a></li>
<li><a href="How-To-Data-Queries.html"><?php _e('how_to_data_queries'); ?></a></li>
<li><a href="How-To-Existing-SNMP-Data-Queries.html"><?php _e('how_to_existing_snmp_data_queries'); ?></a></li>
<li><a href="How-To-New-SNMP-Data-Queries.html"><?php _e('how_to_new_snmp_data_queries'); ?></a></li>
<li><a href="How-To-Script-Data-Queries.html"><?php _e('how_to_script_data_queries'); ?></a></li>
<li><a href="How-To-Setup-Remote-Pollers.html"><?php _e('how_to_setup_remote_pollers'); ?></a></li>
<li><a href="How-To-Determine-Template-Version.html"><?php _e('how_to_determine_template_version'); ?></a></li>
<li><a href="How-To-SSH-Tunnels.html"><?php _e('how_to_ssh_tunnels'); ?></a></li>
<li><a href="Enable-SSL-for-Cacti.html"><?php _e('enable_ssl_for_cacti'); ?></a></li>
<li><a href="Graph-a-Single-SNMP-OID.html"><?php _e('graph_single_snmp_oid'); ?></a></li>
<li><a href="How-To-snmpd-custom-script.html"><?php _e('how_to_snmp_custom_script'); ?></a></li>
<li><a href="How-To-poller-5-to-1-min.html"><?php _e('how_to_poller_5_to_1_min'); ?></a></li>
<li><a href="Convert-package-to-source.html"><?php _e('convert_package_to_source'); ?></a></li>
</ul>

<h3 id="video-tutorials"><?php _e('video_tutorials'); ?></h3>
<p><?php _e('video_tutorials_desc'); ?></p>
<ul>
<li><a href="https://www.youtube.com/channel/UCE-7Zq8H5bBhJJJqJJJJJJJ" target="_blank"><?php _e('cacti_youtube_channel'); ?></a></li>
</ul>

<h2 id="contributing"><?php _e('section_contributing'); ?></h2>
<p><?php _e('section_contributing_desc'); ?></p>

<ul>
<li><a href="Open-Source-Code.html"><?php _e('open_source_code'); ?></a></li>
<li><a href="Language-Translations.html"><?php _e('language_translations'); ?></a></li>
</ul>

<h2 id="development-standards"><?php _e('section_standards'); ?></h2>
<p><?php _e('section_standards_desc'); ?></p>

<ul>
<li><a href="Standards-Documentation.html"><?php _e('standards_documentation'); ?></a></li>
<li><a href="Standards-Code-Formatting.html"><?php _e('standards_code_formatting'); ?></a></li>
<li><a href="Standards-PHP-Spec-Constructs.html"><?php _e('standards_php_spec_constructs'); ?></a></li>
<li><a href="Standards-FileSystem-Layout.html"><?php _e('standards_filesystem_layout'); ?></a></li>
<li><a href="Standards-Patch-Creation.html"><?php _e('standards_patch_creation'); ?></a></li>
<li><a href="Standards-SQL.html"><?php _e('standards_sql'); ?></a></li>
<li><a href="Standards-Security.html"><?php _e('standards_security'); ?></a></li>
</ul>

<h2 id="template-specific"><?php _e('template_specific_documentation'); ?></h2>
<p><?php _e('template_specific_desc'); ?></p>

<ul>
<li><a href="Apache-Server-Template.html"><?php _e('apache_server_template'); ?></a></li>
<li><a href="ESXi-VMWare-Template.html"><?php _e('esxi_vmware_template'); ?></a></li>
</ul>

<hr />
<p><?php _e('copyright'); ?></p>

<script type="text/javascript">
// Language change function
function changeLanguage(language) {
    // Get current URL without parameters
    var currentUrl = window.location.pathname;
    
    // Add language parameter
    window.location.href = currentUrl + '?lang=' + language;
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Cacti Documentation loaded with language: <?php echo $languageManager->getCurrentLanguage(); ?>');
});
</script>

</body>
</html>
