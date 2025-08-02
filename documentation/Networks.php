<?php
/**
 * Cacti Documentation - Networks
 * 
 * This page provides a comprehensive overview of network management features in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_networks', 'networks', true);
?>

<h1 id="networks"><?php _e('networks_title'); ?></h1>

<p><?php _e('networks_intro'); ?></p>

<p><?php _e('networks_overview'); ?></p>

<h2 id="network-automation"><?php _e('networks_automation_title'); ?></h2>

<p><?php _e('networks_automation_desc'); ?></p>

<h2 id="network-discovery"><?php _e('networks_discovery_title'); ?></h2>

<p><?php _e('networks_discovery_desc'); ?></p>

<h2 id="device-management"><?php _e('networks_device_management_title'); ?></h2>

<p><?php _e('networks_device_management_desc'); ?></p>

<h2 id="network-monitoring"><?php _e('networks_monitoring_title'); ?></h2>

<p><?php _e('networks_monitoring_desc'); ?></p>

<h2 id="network-organization"><?php _e('networks_organization_title'); ?></h2>

<p><?php _e('networks_organization_desc'); ?></p>

<h2 id="key-features"><?php _e('networks_features_title'); ?></h2>

<ul>
<li><a href="Automation-Networks.php"><?php _e('networks_feature_automation'); ?></a></li>
<li><a href="Discovered-Devices.php"><?php _e('networks_feature_discovered'); ?></a></li>
<li><a href="Device-Rules.php"><?php _e('networks_feature_device_rules'); ?></a></li>
<li><a href="Graph-Rules.php"><?php _e('networks_feature_graph_rules'); ?></a></li>
<li><a href="Tree-Rules.php"><?php _e('networks_feature_tree_rules'); ?></a></li>
<li><a href="SNMP-Options.php"><?php _e('networks_feature_snmp'); ?></a></li>
</ul>

<h2 id="getting-started"><?php _e('networks_getting_started_title'); ?></h2>

<p><?php _e('networks_getting_started_desc'); ?></p>

<h2 id="best-practices"><?php _e('networks_best_practices_title'); ?></h2>

<p><?php _e('networks_best_practices_desc'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
