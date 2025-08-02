<?php
/**
 * Cacti Documentation - SNMP Options
 * 
 * This page provides a comprehensive guide on SNMP options in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_snmp_options', 'snmp_options', true);
?>

<h1 id="snmp-options"><?php _e('snmp_options_title'); ?></h1>

<p><?php _e('snmp_options_intro'); ?></p>

<p><?php _e('snmp_options_creation'); ?></p>

<p><?php _e('snmp_options_discovery'); ?></p>

<p><?php _e('snmp_options_versions'); ?></p>

<p><?php _e('snmp_options_security'); ?></p>

<p><img src="images/automation-snmp-options.png" alt="SNMP Options" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
