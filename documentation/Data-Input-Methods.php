<?php
/**
 * Cacti Documentation - Data Input Methods
 * 
 * This page provides a comprehensive guide on data input methods in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_data_input_methods', 'data_input_methods', true);
?>

<h1 id="data-input-methods"><?php _e('data_input_methods_title'); ?></h1>

<p><?php _e('data_input_methods_intro'); ?></p>

<p><?php _e('data_input_methods_builtin'); ?></p>

<p><?php _e('data_input_methods_custom'); ?></p>

<h2 id="creating-a-data-input-method"><?php _e('creating_data_input_method_title'); ?></h2>

<p><?php _e('creating_data_input_method_desc'); ?></p>

<h6 id="table-11-1-field-description-data-input-methods"><?php _e('data_input_methods_table_title'); ?></h6>

<table>
<thead>
<tr class="header">
<th><?php _e('data_input_methods_name_field'); ?></th>
<th><?php _e('data_input_methods_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('data_input_methods_name_field'); ?></td>
<td><?php _e('data_input_methods_name_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('data_input_methods_input_type_field'); ?></td>
<td><?php _e('data_input_methods_input_type_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('data_input_methods_input_string_field'); ?></td>
<td><?php _e('data_input_methods_input_string_desc'); ?></td>
</tr>
</tbody>
</table>

<p><?php _e('data_input_methods_name_consideration'); ?></p>

<p><?php _e('data_input_methods_input_types'); ?></p>

<p><?php _e('data_input_methods_script_command'); ?></p>

<p><?php _e('data_input_methods_after_create'); ?></p>

<p><?php _e('data_input_methods_input_fields_desc'); ?></p>

<p><?php _e('data_input_methods_output_fields_desc'); ?></p>

<p><em><?php _e('data_input_methods_output_requirement'); ?></em></p>

<h3 id="data-input-fields"><?php _e('data_input_fields_title'); ?></h3>

<p><?php _e('data_input_fields_desc'); ?></p>

<h6 id="table-11-2-field-description-data-input-fields"><?php _e('data_input_fields_table_title'); ?></h6>

<table>
<thead>
<tr class="header">
<th><?php _e('data_input_methods_name_field'); ?></th>
<th><?php _e('data_input_methods_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('data_input_field_name'); ?></td>
<td><?php _e('data_input_field_name_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('data_input_friendly_name'); ?></td>
<td><?php _e('data_input_friendly_name_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('data_input_regex_match'); ?></td>
<td><?php _e('data_input_regex_match_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('data_input_allow_empty'); ?></td>
<td><?php _e('data_input_allow_empty_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('data_input_special_type'); ?></td>
<td><?php _e('data_input_special_type_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('data_input_update_rrd'); ?></td>
<td><?php _e('data_input_update_rrd_desc'); ?></td>
</tr>
</tbody>
</table>

<p><?php _e('data_input_field_name_rules'); ?></p>

<p><?php _e('data_input_regex_rules'); ?></p>

<p><?php _e('data_input_special_type_usage'); ?></p>

<h6 id="table-11-3-special-type-codes"><?php _e('special_type_codes_table_title'); ?></h6>

<table>
<thead>
<tr class="header">
<th><?php _e('special_type_field_name'); ?></th>
<th><?php _e('data_input_methods_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('special_type_hostname'); ?></td>
<td><?php _e('special_type_hostname_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('special_type_management_ip'); ?></td>
<td><?php _e('special_type_management_ip_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('special_type_snmp_community'); ?></td>
<td><?php _e('special_type_snmp_community_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('special_type_snmp_username'); ?></td>
<td><?php _e('special_type_snmp_username_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('special_type_snmp_password'); ?></td>
<td><?php _e('special_type_snmp_password_desc'); ?></td>
</tr>
</tbody>
</table>

<p><?php _e('data_input_update_rrd_note'); ?></p>

<p><?php _e('data_input_create_finish'); ?></p>

<h2 id="making-your-scripts-work-with-cacti"><?php _e('scripts_work_with_cacti_title'); ?></h2>

<p><?php _e('scripts_work_intro'); ?></p>

<p><?php _e('scripts_work_create_method'); ?></p>

<p><?php _e('scripts_output_format'); ?></p>

<pre class="console"><code><?php _e('scripts_single_output_format'); ?>
</code></pre>

<p><?php _e('scripts_single_output_example'); ?></p>

<pre class="console"><code><?php _e('scripts_single_output_value'); ?>
</code></pre>

<p><?php _e('scripts_multiple_output_desc'); ?></p>

<pre class="console"><code><?php _e('scripts_multiple_output_format'); ?>
</code></pre>

<p><?php _e('scripts_multiple_output_example'); ?></p>

<p><code><?php _e('scripts_load_average_example'); ?></code></p>

<p><?php _e('scripts_permissions_note'); ?></p>

<h2 id="walkthough"><?php _e('walkthrough_title'); ?></h2>

<p><?php _e('walkthrough_desc'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
