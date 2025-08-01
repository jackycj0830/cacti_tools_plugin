<?php
/**
 * Cacti Documentation - Viewing Graphs
 * 
 * This page provides a comprehensive guide on viewing graphs in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_viewing_graphs', 'viewing_graphs', true);
?>

<h1 id="viewing-graphs"><?php _e('viewing_graphs_title'); ?></h1>

<h2 id="background"><?php _e('background_title'); ?></h2>

<p><?php _e('background_intro'); ?></p>

<h2 id="the-graphs-top-tab"><?php _e('graphs_top_tab_title'); ?></h2>

<p><?php _e('graphs_top_tab_intro'); ?></p>

<ul>
<li><p><strong><?php _e('tree_view_title'); ?></strong> - <?php _e('tree_view_description'); ?></p></li>
<li><p><strong><?php _e('preview_view_title'); ?></strong> - <?php _e('preview_view_description'); ?></p></li>
<li><p><strong><?php _e('list_view_title'); ?></strong> - <?php _e('list_view_description'); ?></p></li>
</ul>

<p><?php _e('graph_view_personalities'); ?></p>

<p><?php _e('classic_theme_layout'); ?></p>

<p><img src="images/graph-view-classic.png" alt="Classic Theme Graph View" /></p>

<p><?php _e('alternate_theme_layout'); ?></p>

<p><img src="images/graph-view-alternate.png" alt="Alternate Theme Graph View" /></p>

<h2 id="graph-manipulation-and-options"><?php _e('graph_manipulation_title'); ?></h2>

<p><?php _e('graph_manipulation_intro'); ?></p>

<p><img src="images/graph-filter-panel.png" alt="Graph Filter Panel" /></p>

<p><?php _e('filter_panel_options'); ?></p>

<ul>
<li><?php _e('search_regex'); ?></li>
<li><?php _e('select_graph_templates'); ?></li>
<li><?php _e('graphs_per_page'); ?></li>
<li><?php _e('display_columns'); ?></li>
<li><?php _e('view_thumbnails_or_full'); ?></li>
<li><?php _e('preset_timespans'); ?></li>
<li><?php _e('shift_time'); ?></li>
</ul>

<p><?php _e('save_defaults'); ?></p>

<p><?php _e('action_icons_intro'); ?></p>

<p><?php _e('action_icons_example'); ?></p>

<p><img src="images/graph-action-icons.png" alt="Graph Action Icons" /></p>

<p><?php _e('action_icons_description'); ?></p>

<table>
<thead>
<tr class="header">
<th><?php _e('action_icon_name_column'); ?></th>
<th><?php _e('action_icon_description_column'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('graph_details_icon'); ?></td>
<td><?php _e('graph_details_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('csv_export_icon'); ?></td>
<td><?php _e('csv_export_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('realtime_view_icon'); ?></td>
<td><?php _e('realtime_view_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('spike_kill_icon'); ?></td>
<td><?php _e('spike_kill_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('create_threshold_icon'); ?></td>
<td><?php _e('create_threshold_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('add_to_quicktree_icon'); ?></td>
<td><?php _e('add_to_quicktree_desc'); ?></td>
</tr>
</tbody>
</table>

<h2 id="graph-zooming"><?php _e('graph_zooming_title'); ?></h2>

<p><?php _e('graph_zooming_intro'); ?></p>

<p><img src="images/graph-zoom-menu.png" alt="Graph Zoom Menu" /></p>

<p><?php _e('zoom_options_note'); ?></p>

<?php
// Generate page footer
generatePageFooter();
?>
