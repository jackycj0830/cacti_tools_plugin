<?php
/**
 * Cacti Documentation - Poller Settings
 * 
 * This page explains the Poller Settings configuration in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_poller', 'settings_poller', true);
?>

<h1 id="poller-settings"><?php _e('poller_settings_title'); ?></h1>

<p><?php _e('poller_settings_intro'); ?></p>

<h2 id="general-settings"><?php _e('general_settings'); ?></h2>

<p><?php _e('general_settings_intro'); ?></p>

<p><img src="images/settings-poller-general.png" alt="<?php _e('settings_poller_general'); ?>" /></p>

<p><?php _e('general_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('data_collection_enabled'); ?></strong> - <?php _e('data_collection_enabled_desc'); ?></p></li>
<li><p><strong><?php _e('snmp_agent_support_enabled'); ?></strong> - <?php _e('snmp_agent_support_enabled_desc'); ?></p></li>
<li><p><strong><?php _e('poller_type'); ?></strong> - <?php _e('poller_type_desc'); ?></p></li>
<li><p><strong><?php _e('poller_sync_interval'); ?></strong> - <?php _e('poller_sync_interval_desc'); ?></p></li>
<li><p><strong><?php _e('poller_interval'); ?></strong> - <?php _e('poller_interval_desc'); ?></p></li>
</ul>

<blockquote>
<p><strong><?php _e('note'); ?></strong>: <?php _e('poller_interval_note'); ?></p>
</blockquote>

<ul>
<li><p><strong><?php _e('cron_daemon_interval'); ?></strong> - <?php _e('cron_daemon_interval_desc'); ?></p></li>
<li><p><strong><?php _e('balance_process_load'); ?></strong> - <?php _e('balance_process_load_desc'); ?></p></li>
<li><p><strong><?php _e('debug_output_width'); ?></strong> - <?php _e('debug_output_width_desc'); ?></p></li>
<li><p><strong><?php _e('disable_decreasing_oid_check'); ?></strong> - <?php _e('disable_decreasing_oid_check_desc'); ?></p></li>
<li><p><strong><?php _e('remote_agent_timeout'); ?></strong> - <?php _e('remote_agent_timeout_desc'); ?></p></li>
<li><p><strong><?php _e('snmp_bulkwalk_fetch_size'); ?></strong> - <?php _e('snmp_bulkwalk_fetch_size_desc'); ?></p></li>
</ul>

<blockquote>
<p><strong><?php _e('note'); ?></strong>: <?php _e('snmp_bulkwalk_note'); ?></p>
</blockquote>

<ul>
<li><p><strong><?php _e('snmp_get_oid_limit'); ?></strong> - <?php _e('snmp_get_oid_limit_desc'); ?></p></li>
<li><p><strong><?php _e('disable_resource_cache_replication'); ?></strong> - <?php _e('disable_resource_cache_replication_desc'); ?></p></li>
</ul>

<h2 id="background-timeout-settings"><?php _e('background_timeout_settings'); ?></h2>

<p><?php _e('background_timeout_settings_intro'); ?></p>

<p><img src="images/settings-poller-background.png" alt="<?php _e('background_timeout_settings'); ?>" /></p>

<p><?php _e('background_timeout_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('report_generation_timeout'); ?></strong> - <?php _e('report_generation_timeout_desc'); ?></p></li>
<li><p><strong><?php _e('data_source_statistics_timeout'); ?></strong> - <?php _e('data_source_statistics_timeout_desc'); ?></p></li>
<li><p><strong><?php _e('background_commands_timeout'); ?></strong> - <?php _e('background_commands_timeout_desc'); ?></p></li>
<li><p><strong><?php _e('maintenance_background_generation_timeout'); ?></strong> - <?php _e('maintenance_background_generation_timeout_desc'); ?></p></li>
<li><p><strong><?php _e('spikekill_background_generation_timeout'); ?></strong> - <?php _e('spikekill_background_generation_timeout_desc'); ?></p></li>
</ul>

<h2 id="data-collector-defaults"><?php _e('data_collector_defaults'); ?></h2>

<p><?php _e('data_collector_defaults_intro'); ?></p>

<p><?php _e('data_collector_defaults_desc'); ?></p>

<p><img src="images/settings-poller-data-collector.png" alt="<?php _e('data_collector_defaults'); ?>" /></p>

<p><?php _e('data_collector_defaults_include'); ?></p>

<ul>
<li><p><strong><?php _e('data_collector_processes'); ?></strong> - <?php _e('data_collector_processes_desc'); ?></p></li>
<li><p><strong><?php _e('threads_per_process'); ?></strong> - <?php _e('threads_per_process_desc'); ?></p></li>
</ul>

<blockquote>
<p><strong><?php _e('note'); ?></strong>: <?php _e('threads_per_process_note'); ?></p>
</blockquote>

<h2 id="additional-spine-parameters"><?php _e('additional_spine_parameters'); ?></h2>

<p><?php _e('additional_spine_parameters_intro'); ?></p>

<p><img src="images/settings-poller-spine.png" alt="<?php _e('additional_spine_parameters'); ?>" /></p>

<p><?php _e('additional_spine_parameters_include'); ?></p>

<ul>
<li><p><strong><?php _e('invalid_data_logging'); ?></strong> - <?php _e('invalid_data_logging_desc'); ?></p></li>
<li><p><strong><?php _e('number_of_php_script_servers'); ?></strong> - <?php _e('number_of_php_script_servers_desc'); ?></p></li>
<li><p><strong><?php _e('script_and_script_server_timeout_value'); ?></strong> - <?php _e('script_and_script_server_timeout_value_desc'); ?></p></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
