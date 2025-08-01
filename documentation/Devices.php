<?php
/**
 * Cacti Documentation - Device Management
 * 
 * This page provides a comprehensive guide on device management in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_devices', 'devices', true);
?>

<h1 id="device-management"><?php _e('devices_title'); ?></h1>

<p><?php _e('devices_intro'); ?></p>

<p><?php _e('devices_adding_methods'); ?></p>

<h2 id="web-gui-option"><?php _e('web_gui_option_title'); ?></h2>

<p><?php _e('web_gui_intro'); ?></p>

<p><img src="images/device-console-window.png" alt="<?php _e('device_console'); ?>" /></p>

<p><?php _e('add_device_button_desc'); ?></p>

<p><img src="images/add-device-button.png" alt="<?php _e('add_device_button'); ?>" /></p>

<p><?php _e('add_device_screen_desc'); ?></p>

<p><?php _e('device_important_info'); ?></p>

<ul>
<li><strong><?php _e('device_description_field'); ?></strong> - <?php _e('device_description_desc'); ?></li>
<li><strong><?php _e('device_ip_hostname_field'); ?></strong> - <?php _e('device_ip_hostname_desc'); ?></li>
<li><strong><?php _e('device_poller_association_field'); ?></strong> - <?php _e('device_poller_association_desc'); ?></li>
<li><strong><?php _e('device_template_field'); ?></strong> - <?php _e('device_template_desc'); ?></li>
<li><strong><?php _e('device_site_location_field'); ?></strong> - <?php _e('device_site_location_desc'); ?></li>
<li><strong><?php _e('device_availability_field'); ?></strong> - <?php _e('device_availability_desc'); ?></li>
<li><strong><?php _e('device_snmp_info_field'); ?></strong> - <?php _e('device_snmp_info_desc'); ?></li>
<li><strong><?php _e('device_notes_field'); ?></strong> - <?php _e('device_notes_desc'); ?></li>
</ul>

<p><img src="images/add-device-screen.png" alt="Add Device Info Screen" /></p>

<p><?php _e('device_save_and_create_graphs'); ?></p>

<h2 id="availability-reachability-settings"><?php _e('availability_reachability_settings_title'); ?></h2>

<p><?php _e('availability_intro'); ?></p>

<ul>
<li><strong><?php _e('availability_none'); ?></strong> - <?php _e('availability_none_desc'); ?></li>
<li><strong><?php _e('availability_snmp_uptime'); ?></strong> - <?php _e('availability_snmp_uptime_desc'); ?></li>
<li><strong><?php _e('availability_ping_snmp'); ?></strong> - <?php _e('availability_ping_snmp_desc'); ?></li>
<li><strong><?php _e('availability_ping'); ?></strong> - <?php _e('availability_ping_desc'); ?></li>
<li><strong><?php _e('availability_ping_or_snmp'); ?></strong> - <?php _e('availability_ping_or_snmp_desc'); ?></li>
<li><strong><?php _e('availability_snmp_desc'); ?></strong> - <?php _e('availability_snmp_desc_desc'); ?></li>
<li><strong><?php _e('availability_snmp_getnext'); ?></strong> - <?php _e('availability_snmp_getnext_desc'); ?></li>
</ul>

<h2 id="snmp-credentials"><?php _e('snmp_credentials_title'); ?></h2>

<p><?php _e('snmp_credentials_intro'); ?></p>

<ul>
<li><strong><?php _e('snmp_v1_title'); ?></strong> - <?php _e('snmp_v1_desc'); ?></li>
<li><strong><?php _e('snmp_v2_title'); ?></strong> - <?php _e('snmp_v2_desc'); ?></li>
<li><strong><?php _e('snmp_v3_title'); ?></strong> - <?php _e('snmp_v3_desc'); ?></li>
</ul>

<p><?php _e('snmp_credentials_warning'); ?></p>

<h2 id="additional-important-options"><?php _e('additional_important_options_title'); ?></h2>

<p><?php _e('additional_options_intro'); ?></p>

<ul>
<li><strong><?php _e('device_threads_option'); ?></strong> - <?php _e('device_threads_desc'); ?></li>
<li><strong><?php _e('max_oids_option'); ?></strong> - <?php _e('max_oids_desc'); ?></li>
<li><strong><?php _e('external_id_option'); ?></strong> - <?php _e('external_id_desc'); ?></li>
</ul>

<h2 id="plugin-behavior"><?php _e('plugin_behavior_title'); ?></h2>

<p><?php _e('plugin_behavior_intro'); ?></p>

<ul>
<li><strong><?php _e('notification_settings_option'); ?></strong> - <?php _e('notification_settings_desc'); ?></li>
<li><strong><?php _e('criticality_option'); ?></strong> - <?php _e('criticality_desc'); ?></li>
<li><strong><?php _e('failure_recovery_option'); ?></strong> - <?php _e('failure_recovery_desc'); ?></li>
<li><strong><?php _e('ping_thresholds_option'); ?></strong> - <?php _e('ping_thresholds_desc'); ?></li>
</ul>

<h2 id="creating-devices-via-cli-script"><?php _e('cli_creation_title'); ?></h2>

<p><?php _e('cli_creation_intro'); ?></p>

<pre class="console"><code>usage: add_device.php --description=[description] --ip=[IP] --template=[ID] [--notes="[]"] [--disable]
    [--poller=[id]] [--site=[id] [--external-id=[S]] [--proxy] [--threads=[1]
    [--avail=[ping]] --ping_method=[icmp] --ping_port=[N/A, 1-65534] --ping_timeout=[N] --ping_retries=[2]
    [--version=[0|1|2|3]] [--community=] [--port=161] [--timeout=500]
    [--username= --password=] [--authproto=] [--privpass= --privproto=] [--context=] [--engineid=]
    [--quiet]

Required:
    --description  the name that will be displayed by Cacti in the graphs
    --ip           self explanatory (can also be a FQDN)
</code></pre>

<p><?php _e('cli_usage_example'); ?></p>

<pre class="console"><code>$ php add_device.php --description=test --ip=192.168.1.15
<?php _e('cli_success_message'); ?>
</code></pre>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
