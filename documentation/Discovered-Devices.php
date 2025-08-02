<?php
/**
 * Cacti Documentation - Discovered Devices
 * 
 * This page provides a comprehensive guide on discovered devices in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_discovered_devices', 'discovered_devices', true);
?>

<h1 id="discovered-devices"><?php _e('discovered_devices_title'); ?></h1>

<p><?php _e('discovered_devices_intro'); ?></p>

<p><?php _e('discovered_devices_no_match'); ?></p>

<p><?php _e('discovered_devices_auto_add_off'); ?></p>

<p><?php _e('discovered_devices_navigation'); ?></p>

<p><img src="images/automation-discovered-devices.png" alt="<?php _e('discovered_devices_dropdown_desc'); ?>" /></p>

<p><?php _e('discovered_devices_scan_results'); ?></p>

<p><?php _e('discovered_devices_ip_hostname'); ?></p>

<p><img src="images/automation-discovered-devices-list.png" alt="<?php _e('discovered_devices_list_desc'); ?>" /></p>

<p><?php _e('discovered_devices_selection'); ?></p>

<p><?php _e('discovered_devices_add_menu'); ?></p>

<p><img src="images/automation-discovered-devices-add.png" alt="<?php _e('discovered_devices_add_menu_desc'); ?>" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
