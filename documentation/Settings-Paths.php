<?php
/**
 * Cacti Documentation - Settings Paths
 * 
 * This page provides comprehensive information about Settings Paths in Cacti
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

<h1 id="settings-paths"><?php _e('settings_paths_title'); ?></h1>

<p><?php _e('settings_paths_intro'); ?></p>

<p><?php _e('settings_paths_description'); ?></p>

<p><img src="images/settings-paths.png" alt="<?php _e('settings_paths_title'); ?>" /></p>

<p><?php _e('settings_paths_note'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
