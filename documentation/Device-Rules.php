<?php
/**
 * Cacti Documentation - Device Rules
 * 
 * This page provides a comprehensive guide on device rules in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_device_rules', 'device_rules', true);
?>

<h1 id="device-rules"><?php _e('device_rules_title'); ?></h1>

<p><?php _e('device_rules_intro'); ?></p>

<p><?php _e('device_rules_creation'); ?></p>

<p><?php _e('device_rules_matching'); ?></p>

<p><?php _e('device_rules_priority'); ?></p>

<p><img src="images/automation-device-rules.png" alt="Device Rules" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
