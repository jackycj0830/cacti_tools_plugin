<?php
/**
 * Cacti Documentation - Data Queries
 * 
 * This page provides a comprehensive guide on data queries in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_data_queries', 'data_queries', true);
?>

<h1 id="data-queries"><?php _e('data_queries_title'); ?></h1>

<h2 id="overview"><?php _e('data_queries_overview_title'); ?></h2>

<p><?php _e('data_queries_overview_intro'); ?></p>

<p><?php _e('data_queries_overview_process'); ?></p>

<p><?php _e('data_queries_unique_requirement'); ?></p>

<p><?php _e('data_queries_types'); ?></p>

<h2 id="user-interface"><?php _e('data_queries_ui_title'); ?></h2>

<p><?php _e('data_queries_ui_description'); ?></p>

<p><img src="images/data-queries.png" alt="<?php _e('data_queries_interface_desc'); ?>" /></p>

<p><?php _e('data_queries_edit_description'); ?></p>

<p><img src="images/data-queries-edit.png" alt="<?php _e('data_queries_edit_interface_desc'); ?>" /></p>

<p><?php _e('data_queries_graph_templates'); ?></p>

<p><?php _e('data_queries_template_removal'); ?></p>

<p><?php _e('data_queries_template_click'); ?></p>

<p><img src="images/data-queries-associated-graph-template.png" alt="<?php _e('data_queries_template_edit_desc'); ?>" /></p>

<p><?php _e('data_queries_mapping_description'); ?></p>

<p><?php _e('data_queries_suggested_values'); ?></p>

<p><?php _e('data_queries_replacement_values'); ?></p>

<p><?php _e('data_queries_two_parts'); ?></p>

<h2 id="creating-a-data-query"><?php _e('creating_data_query_title'); ?></h2>

<p><?php _e('creating_data_query_desc'); ?></p>

<h6 id="table-12-1-field-description-data-queries"><?php _e('data_queries_table_title'); ?></h6>

<table>
<thead>
<tr class="header">
<th><?php _e('data_queries_name_field'); ?></th>
<th><?php _e('data_queries_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('data_queries_name_field'); ?></td>
<td><?php _e('data_queries_name_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('data_queries_description_field'); ?></td>
<td><?php _e('data_queries_description_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('data_queries_xml_path_field'); ?></td>
<td><?php _e('data_queries_xml_path_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('data_queries_data_input_method_field'); ?></td>
<td><?php _e('data_queries_data_input_method_desc'); ?></td>
</tr>
</tbody>
</table>

<p><?php _e('data_queries_create_warning'); ?></p>

<h3 id="associated-graph-templates"><?php _e('associated_graph_templates_title'); ?></h3>

<p><?php _e('associated_graph_templates_desc'); ?></p>

<h6 id="table-12-2-field-description-associated-graph-templates"><?php _e('associated_graph_templates_table_title'); ?></h6>

<table>
<thead>
<tr class="header">
<th><?php _e('data_queries_name_field'); ?></th>
<th><?php _e('data_queries_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('data_queries_name_field'); ?></td>
<td><?php _e('associated_graph_templates_name_desc'); ?></td>
</tr>
<tr class="even">
<td>Graph Template</td>
<td><?php _e('associated_graph_templates_template_desc'); ?></td>
</tr>
</tbody>
</table>

<p><?php _e('associated_graph_templates_finish'); ?></p>

<p><?php _e('suggested_values_desc'); ?></p>

<p><?php _e('data_queries_final_save'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
