<?php
/**
 * Cacti Documentation - Settings Data
 * 
 * This page provides comprehensive information about Settings Data in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_data', 'settings_data', true);
?>

<h1 id="settings-data"><?php _e('settings_data_title'); ?></h1>

<p><?php _e('settings_data_intro'); ?></p>

<p><?php _e('settings_data_description'); ?></p>

<p><img src="images/settings-data.png" alt="<?php _e('settings_data_title'); ?>" /></p>

<h2 id="data-storage-settings"><?php _e('data_storage_settings'); ?></h2>

<p><?php _e('data_storage_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('location_data_storage'); ?></strong> - <?php _e('location_data_storage_desc'); ?></li>
<li><strong><?php _e('structured_rrd_paths'); ?></strong> - <?php _e('structured_rrd_paths_desc'); ?></li>
<li><strong><?php _e('rrdtool_version'); ?></strong> - <?php _e('rrdtool_version_desc'); ?></li>
</ul>

<h2 id="data-source-statistics"><?php _e('data_source_statistics'); ?></h2>

<p><?php _e('data_source_statistics_intro'); ?></p>

<ul>
<li><strong><?php _e('daily_stats'); ?></strong> - <?php _e('daily_stats_desc'); ?></li>
<li><strong><?php _e('boost_redirect'); ?></strong> - <?php _e('boost_redirect_desc'); ?></li>
<li><strong><?php _e('stats_poller'); ?></strong> - <?php _e('stats_poller_desc'); ?></li>
</ul>

<h2 id="data-template-defaults"><?php _e('data_template_defaults'); ?></h2>

<p><?php _e('data_template_defaults_intro'); ?></p>

<ul>
<li><strong><?php _e('data_input_method'); ?></strong> - <?php _e('data_input_method_desc'); ?></li>
<li><strong><?php _e('associated_rra'); ?></strong> - <?php _e('associated_rra_desc'); ?></li>
<li><strong><?php _e('data_source_profile'); ?></strong> - <?php _e('data_source_profile_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
