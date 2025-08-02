<?php
/**
 * Cacti Documentation - Graph Templates
 * 
 * This page provides a comprehensive guide on graph templates in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_graph_templates', 'graph_templates', true);
?>

<h1 id="graph-templates"><?php _e('graph_templates_title'); ?></h1>

<p><?php _e('graph_templates_intro'); ?></p>

<p><?php _e('graph_templates_purpose'); ?></p>

<p><?php _e('graph_templates_main_screen'); ?></p>

<p><img src="images/graph-templates.png" alt="<?php _e('graph_templates_page_desc'); ?>" /></p>

<p><?php _e('graph_templates_page_info'); ?></p>

<p><?php _e('graph_templates_dropdown_options'); ?></p>

<table>
<thead>
<tr class="header">
<th><?php _e('graph_templates_option_field'); ?></th>
<th><?php _e('graph_templates_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('graph_templates_delete_option'); ?></td>
<td><?php _e('graph_templates_delete_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('graph_templates_duplicate_option'); ?></td>
<td><?php _e('graph_templates_duplicate_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('graph_templates_resize_option'); ?></td>
<td><?php _e('graph_templates_resize_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('graph_templates_sync_option'); ?></td>
<td><?php _e('graph_templates_sync_desc'); ?></td>
</tr>
</tbody>
</table>

<p><?php _e('graph_templates_edit_intro'); ?></p>

<table>
<thead>
<tr class="header">
<th><?php _e('graph_templates_section_field'); ?></th>
<th><?php _e('graph_templates_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('graph_templates_items_section'); ?></td>
<td><?php _e('graph_templates_items_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('graph_templates_inputs_section'); ?></td>
<td><?php _e('graph_templates_inputs_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('graph_templates_template_section'); ?></td>
<td><?php _e('graph_templates_template_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('graph_templates_common_section'); ?></td>
<td><?php _e('graph_templates_common_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('graph_templates_scaling_section'); ?></td>
<td><?php _e('graph_templates_scaling_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('graph_templates_grid_section'); ?></td>
<td><?php _e('graph_templates_grid_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('graph_templates_axis_section'); ?></td>
<td><?php _e('graph_templates_axis_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('graph_templates_legend_section'); ?></td>
<td><?php _e('graph_templates_legend_desc'); ?></td>
</tr>
</tbody>
</table>

<p><img src="images/graph-template-edit.png" alt="<?php _e('graph_items_edit_desc'); ?>" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
