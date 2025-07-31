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

<h2 id="plugin-development"><?php _e('section_plugin_dev'); ?></h2>
<p><?php _e('section_plugin_dev_desc'); ?></p>

<h2 id="how-tos"><?php _e('section_howtos'); ?></h2>
<p><?php _e('section_howtos_desc'); ?></p>

<h2 id="contributing"><?php _e('section_contributing'); ?></h2>
<p><?php _e('section_contributing_desc'); ?></p>

<h2 id="development-standards"><?php _e('section_standards'); ?></h2>
<p><?php _e('section_standards_desc'); ?></p>

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
