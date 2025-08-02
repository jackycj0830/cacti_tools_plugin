<?php
/**
 * Cacti Documentation - Settings Poller
 * 
 * This page provides comprehensive information about Settings Poller in Cacti
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

<h1 id="settings-poller"><?php _e('settings_poller_title'); ?></h1>

<p><?php _e('settings_poller_intro'); ?></p>

<p><?php _e('settings_poller_description'); ?></p>

<p><img src="images/settings-poller.png" alt="<?php _e('settings_poller_title'); ?>" /></p>

<h2 id="general-poller-settings"><?php _e('general_poller_settings'); ?></h2>

<p><?php _e('general_poller_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('poller_type'); ?></strong> - <?php _e('poller_type_desc'); ?></li>
<li><strong><?php _e('poller_interval'); ?></strong> - <?php _e('poller_interval_desc'); ?></li>
<li><strong><?php _e('cron_interval'); ?></strong> - <?php _e('cron_interval_desc'); ?></li>
<li><strong><?php _e('concurrent_processes'); ?></strong> - <?php _e('concurrent_processes_desc'); ?></li>
<li><strong><?php _e('threads_per_process'); ?></strong> - <?php _e('threads_per_process_desc'); ?></li>
</ul>

<h2 id="spine-specific-settings"><?php _e('spine_specific_settings'); ?></h2>

<p><?php _e('spine_specific_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('spine_log_level'); ?></strong> - <?php _e('spine_log_level_desc'); ?></li>
<li><strong><?php _e('maximum_threads'); ?></strong> - <?php _e('maximum_threads_desc'); ?></li>
<li><strong><?php _e('php_servers'); ?></strong> - <?php _e('php_servers_desc'); ?></li>
<li><strong><?php _e('script_timeout'); ?></strong> - <?php _e('script_timeout_desc'); ?></li>
<li><strong><?php _e('max_oids'); ?></strong> - <?php _e('max_oids_desc'); ?></li>
</ul>

<h2 id="availability-logging"><?php _e('availability_logging'); ?></h2>

<p><?php _e('availability_logging_intro'); ?></p>

<ul>
<li><strong><?php _e('log_verbosity'); ?></strong> - <?php _e('log_verbosity_desc'); ?></li>
<li><strong><?php _e('log_destination'); ?></strong> - <?php _e('log_destination_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
