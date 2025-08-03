<?php
/**
 * Cacti Documentation - Visual Settings
 * 
 * This page explains the Visual Settings configuration in Cacti
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

<h1 id="visual-settings"><?php _e('visual_settings_title'); ?></h1>

<h2 id="overview"><?php _e('overview'); ?></h2>

<p><?php _e('visual_settings_overview'); ?></p>

<p><?php _e('visual_settings_subsections'); ?></p>

<blockquote>
<p><strong><?php _e('note'); ?></strong>: <?php _e('plugin_developers_note'); ?></p>
</blockquote>

<h2 id="theme-table-tree-and-filter-settings"><?php _e('theme_table_tree_filter_settings'); ?></h2>

<p><?php _e('theme_table_tree_filter_intro'); ?></p>

<p><img src="images/settings-visual-1.png" alt="<?php _e('settings_visual_theme_table_tree_filter'); ?>" /></p>

<p><?php _e('theme_table_tree_filter_include'); ?></p>

<ul>
<li><p><strong><?php _e('theme'); ?></strong> - <?php _e('theme_desc'); ?></p></li>
<li><p><strong><?php _e('rows_per_page'); ?></strong> - <?php _e('rows_per_page_desc'); ?></p></li>
<li><p><strong><?php _e('auto_complete_enabled'); ?></strong> - <?php _e('auto_complete_enabled_desc'); ?></p></li>
<li><p><strong><?php _e('auto_complete_rows'); ?></strong> - <?php _e('auto_complete_rows_desc'); ?></p></li>
<li><p><strong><?php _e('minimum_tree_width'); ?></strong> - <?php _e('minimum_tree_width_desc'); ?></p></li>
<li><p><strong><?php _e('maximum_tree_width'); ?></strong> - <?php _e('maximum_tree_width_desc'); ?></p></li>
<li><p><strong><?php _e('strip_domains_from_device_dropdowns'); ?></strong> - <?php _e('strip_domains_from_device_dropdowns_desc'); ?></p></li>
</ul>

<h2 id="graph-data-source-data-query-log-settings"><?php _e('graph_data_source_data_query_log_settings'); ?></h2>

<p><?php _e('graph_data_source_data_query_log_intro'); ?></p>

<p><img src="images/settings-visual-2.png" alt="<?php _e('graph_data_source_data_query_log_settings'); ?>" /></p>

<p><?php _e('graph_data_source_data_query_log_include'); ?></p>

<ul>
<li><p><strong><?php _e('maximum_title_length'); ?></strong> - <?php _e('maximum_title_length_desc'); ?></p></li>
<li><p><strong><?php _e('data_source_field_length'); ?></strong> - <?php _e('data_source_field_length_desc'); ?></p></li>
<li><p><strong><?php _e('default_graph_type'); ?></strong> - <?php _e('default_graph_type_desc'); ?></p></li>
<li><p><strong><?php _e('default_log_tail_lines'); ?></strong> - <?php _e('default_log_tail_lines_desc'); ?></p></li>
<li><p><strong><?php _e('maximum_number_of_rows_per_page'); ?></strong> - <?php _e('maximum_number_of_rows_per_page_desc'); ?></p></li>
<li><p><strong><?php _e('log_tail_refresh'); ?></strong> - <?php _e('log_tail_refresh_desc'); ?></p></li>
<li><p><strong><?php _e('exclusion_regex'); ?></strong> - <?php _e('exclusion_regex_desc'); ?></p></li>
</ul>

<h2 id="realtime-and-rrdtool-graph-options"><?php _e('realtime_and_rrdtool_graph_options'); ?></h2>

<p><?php _e('realtime_and_rrdtool_graph_intro'); ?></p>

<p><img src="images/settings-visual-3.png" alt="<?php _e('realtime_and_rrdtool_graph_options'); ?>" /></p>

<p><?php _e('realtime_and_rrdtool_graph_include'); ?></p>

<ul>
<li><p><strong><?php _e('enable_realtime_graphing'); ?></strong> - <?php _e('enable_realtime_graphing_desc'); ?></p></li>
<li><p><strong><?php _e('graph_timespan'); ?></strong> - <?php _e('graph_timespan_desc'); ?></p></li>
<li><p><strong><?php _e('refresh_interval'); ?></strong> - <?php _e('refresh_interval_desc'); ?></p></li>
<li><p><strong><?php _e('cacti_directory'); ?></strong> - <?php _e('cacti_directory_desc'); ?></p></li>
<li><p><strong><?php _e('custom_watermark'); ?></strong> - <?php _e('custom_watermark_desc'); ?></p></li>
<li><p><strong><?php _e('disable_rrdtool_watermark'); ?></strong> - <?php _e('disable_rrdtool_watermark_desc'); ?></p></li>
<li><p><strong><?php _e('font_selection_method'); ?></strong> - <?php _e('font_selection_method_desc'); ?></p></li>
</ul>

<blockquote>
<p><strong><?php _e('note'); ?></strong>: <?php _e('rrdtool_watermark_note'); ?></p>
</blockquote>

<h2 id="font-selection-options"><?php _e('font_selection_options'); ?></h2>

<p><?php _e('font_selection_options_intro'); ?></p>

<p><img src="images/settings-visual-4.png" alt="<?php _e('font_selection_options'); ?>" /></p>

<p><?php _e('font_selection_options_desc'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
