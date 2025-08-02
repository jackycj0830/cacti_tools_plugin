<?php
/**
 * Cacti Documentation - Settings Device Defaults
 * 
 * This page provides comprehensive information about Settings Device Defaults in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_device_defaults', 'settings_device_defaults', true);
?>

<h1 id="settings-device-defaults"><?php _e('settings_device_defaults_title'); ?></h1>

<p><?php _e('settings_device_defaults_intro'); ?></p>

<p><?php _e('settings_device_defaults_description'); ?></p>

<p><img src="images/settings-device-defaults.png" alt="<?php _e('settings_device_defaults_title'); ?>" /></p>

<h2 id="snmp-defaults"><?php _e('snmp_defaults'); ?></h2>

<p><?php _e('snmp_defaults_intro'); ?></p>

<ul>
<li><strong><?php _e('snmp_version'); ?></strong> - <?php _e('snmp_version_desc'); ?></li>
<li><strong><?php _e('snmp_community'); ?></strong> - <?php _e('snmp_community_desc'); ?></li>
<li><strong><?php _e('snmp_port'); ?></strong> - <?php _e('snmp_port_desc'); ?></li>
<li><strong><?php _e('snmp_timeout'); ?></strong> - <?php _e('snmp_timeout_desc'); ?></li>
<li><strong><?php _e('snmp_retries'); ?></strong> - <?php _e('snmp_retries_desc'); ?></li>
</ul>

<h2 id="availability-defaults"><?php _e('availability_defaults'); ?></h2>

<p><?php _e('availability_defaults_intro'); ?></p>

<ul>
<li><strong><?php _e('downed_device_detection'); ?></strong> - <?php _e('downed_device_detection_desc'); ?></li>
<li><strong><?php _e('ping_method'); ?></strong> - <?php _e('ping_method_desc'); ?></li>
<li><strong><?php _e('ping_port'); ?></strong> - <?php _e('ping_port_desc'); ?></li>
<li><strong><?php _e('ping_timeout'); ?></strong> - <?php _e('ping_timeout_desc'); ?></li>
<li><strong><?php _e('ping_retries'); ?></strong> - <?php _e('ping_retries_desc'); ?></li>
</ul>

<h2 id="general-defaults"><?php _e('general_defaults'); ?></h2>

<p><?php _e('general_defaults_intro'); ?></p>

<ul>
<li><strong><?php _e('default_site'); ?></strong> - <?php _e('default_site_desc'); ?></li>
<li><strong><?php _e('default_poller'); ?></strong> - <?php _e('default_poller_desc'); ?></li>
<li><strong><?php _e('default_device_template'); ?></strong> - <?php _e('default_device_template_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
