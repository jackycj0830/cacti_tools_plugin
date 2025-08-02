<?php
/**
 * Cacti Documentation - Settings Performance
 * 
 * This page provides comprehensive information about Settings Performance in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_performance', 'settings_performance', true);
?>

<h1 id="settings-performance"><?php _e('settings_performance_title'); ?></h1>

<p><?php _e('settings_performance_intro'); ?></p>

<p><?php _e('settings_performance_description'); ?></p>

<p><img src="images/settings-performance.png" alt="<?php _e('settings_performance_title'); ?>" /></p>

<h2 id="image-caching"><?php _e('image_caching'); ?></h2>

<p><?php _e('image_caching_intro'); ?></p>

<ul>
<li><strong><?php _e('image_cache_method'); ?></strong> - <?php _e('image_cache_method_desc'); ?></li>
<li><strong><?php _e('structured_rrd_paths'); ?></strong> - <?php _e('structured_rrd_paths_desc'); ?></li>
<li><strong><?php _e('rrd_autoclean'); ?></strong> - <?php _e('rrd_autoclean_desc'); ?></li>
<li><strong><?php _e('rrd_autoclean_method'); ?></strong> - <?php _e('rrd_autoclean_method_desc'); ?></li>
</ul>

<h2 id="boost-performance"><?php _e('boost_performance'); ?></h2>

<p><?php _e('boost_performance_intro'); ?></p>

<ul>
<li><strong><?php _e('enable_boost'); ?></strong> - <?php _e('enable_boost_desc'); ?></li>
<li><strong><?php _e('boost_png_cache_directory'); ?></strong> - <?php _e('boost_png_cache_directory_desc'); ?></li>
<li><strong><?php _e('boost_rrd_update_interval'); ?></strong> - <?php _e('boost_rrd_update_interval_desc'); ?></li>
<li><strong><?php _e('boost_redirect'); ?></strong> - <?php _e('boost_redirect_desc'); ?></li>
</ul>

<h2 id="spine-performance"><?php _e('spine_performance'); ?></h2>

<p><?php _e('spine_performance_intro'); ?></p>

<ul>
<li><strong><?php _e('spine_poller_enabled'); ?></strong> - <?php _e('spine_poller_enabled_desc'); ?></li>
<li><strong><?php _e('spine_path'); ?></strong> - <?php _e('spine_path_desc'); ?></li>
<li><strong><?php _e('spine_config_file'); ?></strong> - <?php _e('spine_config_file_desc'); ?></li>
<li><strong><?php _e('spine_log_level'); ?></strong> - <?php _e('spine_log_level_desc'); ?></li>
</ul>

<h2 id="memory-limits"><?php _e('memory_limits'); ?></h2>

<p><?php _e('memory_limits_intro'); ?></p>

<ul>
<li><strong><?php _e('memory_limit'); ?></strong> - <?php _e('memory_limit_desc'); ?></li>
<li><strong><?php _e('max_execution_time'); ?></strong> - <?php _e('max_execution_time_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
