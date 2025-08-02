<?php
/**
 * Cacti Documentation - CDEFs
 * 
 * This page provides a comprehensive guide on CDEFs in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_cdefs', 'cdefs', true);
?>

<h1 id="cdefs"><?php _e('cdefs_title'); ?></h1>

<h2 id="background"><?php _e('cdefs_background_title'); ?></h2>

<p><?php _e('cdefs_background_desc'); ?></p>

<p><?php _e('cdefs_mathematical_formulas'); ?></p>

<p><?php _e('cdefs_rpn_format'); ?></p>

<p><?php _e('cdefs_complexity'); ?></p>

<h2 id="cdef-interface"><?php _e('cdefs_interface_title'); ?></h2>

<p><?php _e('cdefs_interface_desc'); ?></p>

<p><?php _e('cdefs_delete_duplicate'); ?></p>

<p><img src="images/cdefs.png" alt="<?php _e('cdefs_title'); ?>" /></p>

<p><?php _e('cdefs_edit_screen'); ?></p>

<p><?php _e('cdefs_stack_operations'); ?></p>

<p><img src="images/cdefs-edit1.png" alt="CDEFs Edit" /></p>

<p><?php _e('cdefs_data_types'); ?></p>

<table>
<thead>
<tr class="header">
<th>Name</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('cdefs_type_function'); ?></td>
<td><?php _e('cdefs_type_function_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('cdefs_type_operator'); ?></td>
<td><?php _e('cdefs_type_operator_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('cdefs_type_another_cdef'); ?></td>
<td><?php _e('cdefs_type_another_cdef_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('cdefs_type_special_data_source'); ?></td>
<td><?php _e('cdefs_type_special_data_source_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('cdefs_type_custom_string'); ?></td>
<td><?php _e('cdefs_type_custom_string_desc'); ?></td>
</tr>
</tbody>
</table>

<p><img src="images/cdefs-edit2.png" alt="CDEFs Edit Types" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
