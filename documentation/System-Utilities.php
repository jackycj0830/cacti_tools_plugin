<?php
/**
 * Cacti Documentation - System Utilities
 * 
 * This page provides comprehensive information about System Utilities in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_system_utilities', 'system_utilities', true);
?>

<h1 id="system-utilities"><?php _e('system_utilities_title'); ?></h1>

<p><?php _e('system_utilities_intro'); ?></p>

<p><?php _e('system_utilities_description'); ?></p>

<p><img src="images/system-utilities.png" alt="<?php _e('system_utilities_title'); ?>" /></p>

<h2 id="technical-support"><?php _e('technical_support'); ?></h2>

<p><?php _e('technical_support_intro'); ?></p>

<ul>
<li><strong><?php _e('technical_support_log'); ?></strong> - <?php _e('technical_support_log_desc'); ?></li>
<li><strong><?php _e('technical_support_summary'); ?></strong> - <?php _e('technical_support_summary_desc'); ?></li>
</ul>

<h2 id="system-maintenance"><?php _e('system_maintenance'); ?></h2>

<p><?php _e('system_maintenance_intro'); ?></p>

<ul>
<li><strong><?php _e('rebuild_poller_cache'); ?></strong> - <?php _e('rebuild_poller_cache_desc'); ?></li>
<li><strong><?php _e('rebuild_resource_cache'); ?></strong> - <?php _e('rebuild_resource_cache_desc'); ?></li>
<li><strong><?php _e('clear_user_log'); ?></strong> - <?php _e('clear_user_log_desc'); ?></li>
<li><strong><?php _e('clear_logfile'); ?></strong> - <?php _e('clear_logfile_desc'); ?></li>
</ul>

<h2 id="database-utilities"><?php _e('database_utilities'); ?></h2>

<p><?php _e('database_utilities_intro'); ?></p>

<ul>
<li><strong><?php _e('database_repair'); ?></strong> - <?php _e('database_repair_desc'); ?></li>
<li><strong><?php _e('database_optimize'); ?></strong> - <?php _e('database_optimize_desc'); ?></li>
<li><strong><?php _e('database_backup'); ?></strong> - <?php _e('database_backup_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
