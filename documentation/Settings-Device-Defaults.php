<?php
/**
 * Cacti Documentation - Device Default Settings
 * 
 * This page explains the Device Default Settings configuration in Cacti
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

<h1 id="device-default-settings"><?php _e('device_default_settings_title'); ?></h1>

<p><?php _e('device_default_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('manual'); ?></strong> - <?php _e('manual_desc'); ?></li>
<li><strong><?php _e('cli'); ?></strong> - <?php _e('cli_desc'); ?></li>
<li><strong><?php _e('automation'); ?></strong> - <?php _e('automation_desc'); ?></li>
</ul>

<p><?php _e('device_defaults_purpose'); ?></p>

<h2 id="general-defaults"><?php _e('general_defaults'); ?></h2>

<p><?php _e('general_defaults_intro'); ?></p>

<p><img src="images/settings-device-defaults-general.png" alt="<?php _e('general_defaults'); ?>" /></p>

<p><?php _e('general_defaults_include'); ?></p>

<ul>
<li><p><strong><?php _e('template'); ?></strong> - <?php _e('template_desc'); ?></p></li>
<li><p><strong><?php _e('site'); ?></strong> - <?php _e('site_desc'); ?></p></li>
<li><p><strong><?php _e('poller'); ?></strong> - <?php _e('poller_desc'); ?></p></li>
<li><p><strong><?php _e('device_threads'); ?></strong> - <?php _e('device_threads_desc'); ?></p></li>
<li><p><strong><?php _e('reindex_method'); ?></strong> - <?php _e('reindex_method_desc'); ?></p></li>
<li><p><strong><?php _e('default_interface_speed'); ?></strong> - <?php _e('default_interface_speed_desc'); ?></p></li>
</ul>

<blockquote>
<p><strong><?php _e('note'); ?></strong>: <?php _e('device_threads_note'); ?></p>
</blockquote>

<h2 id="snmp-defaults"><?php _e('snmp_defaults'); ?></h2>

<p><?php _e('snmp_defaults_intro'); ?></p>

<p><img src="images/settings-device-defaults-snmp-defaults-v1v2.png" alt="<?php _e('snmp_defaults'); ?>" /></p>

<p><img src="images/settings-device-defaults-snmp-defaults-v3.png" alt="<?php _e('snmp_defaults'); ?>" /></p>

<p><?php _e('snmp_defaults_include'); ?></p>

<ul>
<li><p><strong><?php _e('version'); ?></strong> - <?php _e('version_desc'); ?></p></li>
<li><p><strong><?php _e('community'); ?></strong> - <?php _e('community_desc'); ?></p></li>
<li><p><strong><?php _e('port_number'); ?></strong> - <?php _e('port_number_desc'); ?></p></li>
<li><p><strong><?php _e('timeout'); ?></strong> - <?php _e('timeout_desc'); ?></p></li>
<li><p><strong><?php _e('retries'); ?></strong> - <?php _e('retries_desc'); ?></p></li>
<li><p><strong><?php _e('security_level'); ?></strong> - <?php _e('security_level_desc'); ?></p></li>
<li><p><strong><?php _e('auth_protocol'); ?></strong> - <?php _e('auth_protocol_desc'); ?></p></li>
<li><p><strong><?php _e('auth_user'); ?></strong> - <?php _e('auth_user_desc'); ?></p></li>
<li><p><strong><?php _e('auth_password'); ?></strong> - <?php _e('auth_password_desc'); ?></p></li>
<li><p><strong><?php _e('privacy_protocol'); ?></strong> - <?php _e('privacy_protocol_desc'); ?></p></li>
<li><p><strong><?php _e('privacy_passphrase'); ?></strong> - <?php _e('privacy_passphrase_desc'); ?></p></li>
<li><p><strong><?php _e('snmp_context'); ?></strong> - <?php _e('snmp_context_desc'); ?></p></li>
<li><p><strong><?php _e('snmp_engine_id'); ?></strong> - <?php _e('snmp_engine_id_desc'); ?></p></li>
</ul>

<h2 id="availability-reachability"><?php _e('availability_reachability'); ?></h2>

<p><?php _e('availability_reachability_intro'); ?></p>

<p><?php _e('availability_reachability_desc'); ?></p>

<p><img src="images/settings-device-defaults-availability.png" alt="<?php _e('snmp_defaults'); ?>" /></p>

<p><?php _e('availability_options_include'); ?></p>

<ul>
<li><p><strong><?php _e('downed_device_detection'); ?></strong> - <?php _e('downed_device_detection_desc'); ?></p>
<ul>
<li><strong><?php _e('none'); ?></strong> - <?php _e('none_desc'); ?></li>
<li><strong><?php _e('ping_and_snmp_uptime'); ?></strong> - <?php _e('ping_and_snmp_uptime_desc'); ?></li>
<li><strong><?php _e('ping_or_snmp_uptime'); ?></strong> - <?php _e('ping_or_snmp_uptime_desc'); ?></li>
<li><strong><?php _e('snmp_uptime'); ?></strong> - <?php _e('snmp_uptime_desc'); ?></li>
<li><strong><?php _e('snmp_desc'); ?></strong> - <?php _e('snmp_desc_desc'); ?></li>
<li><strong><?php _e('snmp_getnext'); ?></strong> - <?php _e('snmp_getnext_desc'); ?></li>
<li><strong><?php _e('ping'); ?></strong> - <?php _e('ping_desc'); ?></li>
</ul></li>
<li><p><strong><?php _e('ping_type'); ?></strong> - <?php _e('ping_type_desc'); ?></p></li>
<li><p><strong><?php _e('ping_port'); ?></strong> - <?php _e('ping_port_desc'); ?></p></li>
<li><p><strong><?php _e('ping_timeout_value'); ?></strong> - <?php _e('ping_timeout_value_desc'); ?></p></li>
<li><p><strong><?php _e('ping_retry_count'); ?></strong> - <?php _e('ping_retry_count_desc'); ?></p></li>
</ul>

<h2 id="up-down-settings"><?php _e('up_down_settings'); ?></h2>

<p><?php _e('up_down_settings_intro'); ?></p>

<p><img src="images/settings-device-defaults-updown.png" alt="<?php _e('snmp_defaults'); ?>" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
