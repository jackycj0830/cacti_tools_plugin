<?php
/**
 * Cacti Documentation - Settings Visual
 * 
 * This page provides comprehensive information about Settings Visual in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_visual', 'settings_visual', true);
?>

<h1 id="settings-visual"><?php _e('settings_visual_title'); ?></h1>

<p><?php _e('settings_visual_intro'); ?></p>

<p><?php _e('settings_visual_description'); ?></p>

<p><img src="images/settings-visual.png" alt="<?php _e('settings_visual_title'); ?>" /></p>

<h2 id="general-visual-settings"><?php _e('general_visual_settings'); ?></h2>

<p><?php _e('general_visual_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('theme'); ?></strong> - <?php _e('theme_desc'); ?></li>
<li><strong><?php _e('menu_type'); ?></strong> - <?php _e('menu_type_desc'); ?></li>
<li><strong><?php _e('default_view_mode'); ?></strong> - <?php _e('default_view_mode_desc'); ?></li>
<li><strong><?php _e('show_graph_title'); ?></strong> - <?php _e('show_graph_title_desc'); ?></li>
<li><strong><?php _e('show_tree_navigation'); ?></strong> - <?php _e('show_tree_navigation_desc'); ?></li>
</ul>

<h2 id="graph-display-options"><?php _e('graph_display_options'); ?></h2>

<p><?php _e('graph_display_options_intro'); ?></p>

<ul>
<li><strong><?php _e('default_date_format'); ?></strong> - <?php _e('default_date_format_desc'); ?></li>
<li><strong><?php _e('datechar'); ?></strong> - <?php _e('datechar_desc'); ?></li>
<li><strong><?php _e('default_datechar'); ?></strong> - <?php _e('default_datechar_desc'); ?></li>
<li><strong><?php _e('page_refresh'); ?></strong> - <?php _e('page_refresh_desc'); ?></li>
<li><strong><?php _e('log_refresh'); ?></strong> - <?php _e('log_refresh_desc'); ?></li>
</ul>

<h2 id="thumbnail-options"><?php _e('thumbnail_options'); ?></h2>

<p><?php _e('thumbnail_options_intro'); ?></p>

<ul>
<li><strong><?php _e('thumbnail_sections'); ?></strong> - <?php _e('thumbnail_sections_desc'); ?></li>
<li><strong><?php _e('thumbnail_graphs'); ?></strong> - <?php _e('thumbnail_graphs_desc'); ?></li>
<li><strong><?php _e('thumbnail_height'); ?></strong> - <?php _e('thumbnail_height_desc'); ?></li>
<li><strong><?php _e('thumbnail_width'); ?></strong> - <?php _e('thumbnail_width_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
