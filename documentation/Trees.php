<?php
/**
 * Cacti Documentation - Cacti Trees
 * 
 * This page provides a comprehensive guide on tree management in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_trees', 'trees', true);
?>

<h1 id="cacti-trees"><?php _e('trees_title'); ?></h1>

<h2 id="trees"><?php _e('trees_section_title'); ?></h2>

<p><?php _e('trees_intro'); ?></p>

<p><?php _e('trees_current_setup'); ?></p>

<p><?php _e('trees_add_remove'); ?></p>

<p><img src="images/trees.png" alt="<?php _e('tree_management_page_desc'); ?>" /></p>

<p><?php _e('trees_graph_view'); ?></p>

<p><img src="images/tree-view.png" alt="<?php _e('tree_view_desc'); ?>" /></p>

<h2 id="creating-a-tree"><?php _e('creating_tree_title'); ?></h2>

<p><?php _e('creating_tree_intro'); ?></p>

<p><img src="images/tree-options.png" alt="<?php _e('tree_options_desc'); ?>" /></p>

<p><?php _e('tree_device_adding'); ?></p>

<p><img src="images/tree-options-sorting.png" alt="<?php _e('tree_sorting_desc'); ?>" /></p>

<h3 id="table-8-1-tree-sporting-type-definitions"><?php _e('tree_sorting_table_title'); ?></h3>

<table>
<thead>
<tr class="header">
<th><?php _e('tree_field_column'); ?></th>
<th><?php _e('tree_value_column'); ?></th>
<th><?php _e('tree_description_column'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('tree_name_field'); ?></td>
<td><?php _e('tree_name_value'); ?></td>
<td><?php _e('tree_name_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('tree_alphabetical_note'); ?></td>
<td></td>
<td></td>
</tr>
<tr class="odd">
<td><?php _e('tree_sorting_type_field'); ?></td>
<td><?php _e('tree_manual_ordering'); ?></td>
<td><?php _e('tree_manual_ordering_value'); ?></td>
</tr>
<tr class="even">
<td><?php _e('tree_manual_ordering_desc'); ?></td>
<td></td>
<td></td>
</tr>
<tr class="odd">
<td><?php _e('tree_alphabetical_ordering'); ?></td>
<td><?php _e('tree_alphabetical_value'); ?></td>
<td><?php _e('tree_alphabetical_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('tree_alphabetical_note_desc'); ?></td>
<td></td>
<td></td>
</tr>
<tr class="odd">
<td><?php _e('tree_natural_ordering'); ?></td>
<td><?php _e('tree_natural_value'); ?></td>
<td><?php _e('tree_natural_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('tree_numeric_ordering'); ?></td>
<td><?php _e('tree_numeric_value'); ?></td>
<td><?php _e('tree_numeric_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('tree_numeric_note'); ?></td>
<td></td>
<td></td>
</tr>
</tbody>
</table>

<p><?php _e('tree_publishing'); ?></p>

<p><?php _e('tree_drag_drop'); ?></p>

<p><?php _e('tree_site_interaction'); ?></p>

<p><?php _e('tree_unlock_reminder'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
