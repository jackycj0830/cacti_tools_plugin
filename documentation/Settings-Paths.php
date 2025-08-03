<?php
/**
 * Cacti Documentation - Path Settings
 * 
 * This page explains the path settings configuration in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_paths', 'settings_paths', true);
?>

<h1 id="path-settings"><?php _e('settings_paths_title'); ?></h1>

<p><?php _e('settings_paths_intro'); ?></p>

<ul>
<li><strong><?php _e('required_tool_paths'); ?></strong> - <?php _e('required_tool_paths_desc'); ?></li>
<li><strong><?php _e('logging'); ?></strong> - <?php _e('logging_desc'); ?></li>
<li><strong><?php _e('alternate_poller_path'); ?></strong> - <?php _e('alternate_poller_path_desc'); ?></li>
<li><strong><?php _e('rrd_cleaner'); ?></strong> - <?php _e('rrd_cleaner_desc'); ?></li>
</ul>

<p><?php _e('remote_data_collectors_note'); ?></p>

<h2 id="required-tools-paths"><?php _e('required_tool_paths'); ?></h2>

<p><?php _e('required_tools_paths_intro'); ?></p>

<p><img src="images/settings-paths-required.png" alt="<?php _e('required_tool_paths'); ?>" /></p>

<p><?php _e('required_tools_include'); ?></p>

<p><strong><?php _e('snmpwalk_binary_path'); ?></strong> - <?php _e('snmpwalk_binary_path_desc'); ?></p>

<p><strong><?php _e('snmpget_binary_path'); ?></strong> - <?php _e('snmpget_binary_path_desc'); ?></p>

<p><strong><?php _e('snmpbulkwalk_binary_path'); ?></strong> - <?php _e('snmpbulkwalk_binary_path_desc'); ?></p>

<p><strong><?php _e('snmpgetnext_binary_path'); ?></strong> - <?php _e('snmpgetnext_binary_path_desc'); ?></p>

<p><strong><?php _e('snmptrap_binary_path'); ?></strong> - <?php _e('snmptrap_binary_path_desc'); ?></p>

<p><strong><?php _e('rrdtool_binary_path'); ?></strong> - <?php _e('rrdtool_binary_path_desc'); ?></p>

<p><strong><?php _e('php_binary_path'); ?></strong> - <?php _e('php_binary_path_desc'); ?></p>

<h2 id="logging"><?php _e('logging'); ?></h2>

<p><?php _e('logging_intro'); ?></p>

<p><img src="images/settings-paths-logging.png" alt="<?php _e('logfile_settings'); ?>" /></p>

<p><?php _e('logging_settings_include'); ?></p>

<p><strong><?php _e('cacti_log_path'); ?></strong> - <?php _e('cacti_log_path_desc'); ?></p>

<p><strong><?php _e('poller_stderr_log_path'); ?></strong> - <?php _e('poller_stderr_log_path_desc'); ?></p>

<p><strong><?php _e('rotate_cacti_log'); ?></strong> - <?php _e('rotate_cacti_log_desc'); ?></p>

<p><strong><?php _e('rotation_frequency'); ?></strong> - <?php _e('rotation_frequency_desc'); ?></p>

<p><strong><?php _e('log_retention'); ?></strong> - <?php _e('log_retention_desc'); ?></p>

<blockquote>
<p><strong><?php _e('note'); ?></strong>: <?php _e('package_maintainer_note'); ?></p>
</blockquote>

<h2 id="alternate-poller-path"><?php _e('alternate_poller_path'); ?></h2>

<p><?php _e('alternate_poller_path_intro'); ?></p>

<p><img src="images/settings-paths-alternate.png" alt="<?php _e('alternate_poller_path'); ?>" /></p>

<p><?php _e('alternate_poller_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('spine_binary_file_location'); ?></strong> - <?php _e('spine_binary_file_location_desc'); ?></p></li>
<li><p><strong><?php _e('spine_config_file_path'); ?></strong> - <?php _e('spine_config_file_path_desc'); ?></p>
<ul>
<li><strong><?php _e('pwd'); ?></strong> - <?php _e('pwd_desc'); ?></li>
<li><strong><?php _e('etc_sibling'); ?></strong> - <?php _e('etc_sibling_desc'); ?></li>
<li><strong><?php _e('system_etc'); ?></strong> - <?php _e('system_etc_desc'); ?></li>
</ul></li>
</ul>

<h2 id="rrd-cleaner"><?php _e('rrd_cleaner'); ?></h2>

<p><?php _e('rrd_cleaner_intro'); ?></p>

<p><img src="images/settings-paths-rrd-cleaner.png" alt="<?php _e('rrd_cleaner'); ?>" /></p>

<p><?php _e('rrd_cleaner_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('rrdfile_auto_clean'); ?></strong> - <?php _e('rrdfile_auto_clean_desc'); ?></p></li>
<li><p><strong><?php _e('rrdfile_auto_clean_method'); ?></strong> - <?php _e('rrdfile_auto_clean_method_desc'); ?></p>
<ul>
<li><strong><?php _e('delete_method'); ?></strong> - <?php _e('delete_method_desc'); ?></li>
<li><strong><?php _e('archive_method'); ?></strong> - <?php _e('archive_method_desc'); ?></li>
</ul></li>
<li><p><strong><?php _e('archive_directory'); ?></strong> - <?php _e('archive_directory_desc'); ?></p></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
