<?php
/**
 * Cacti Documentation - Device Templates
 * 
 * This page provides a comprehensive guide on device templates in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_device_templates', 'device_templates', true);
?>

<h1 id="device-templates"><?php _e('device_templates_title'); ?></h1>

<p><?php _e('device_templates_intro'); ?></p>

<p><?php _e('device_templates_purpose'); ?></p>

<p><?php _e('device_templates_main_screen'); ?></p>

<p><img src="images/device-templates.png" alt="<?php _e('device_templates_page_desc'); ?>" /></p>

<p><?php _e('device_templates_page_info'); ?></p>

<p><?php _e('device_templates_dropdown_options'); ?></p>

<table>
<thead>
<tr class="header">
<th><?php _e('device_templates_option_field'); ?></th>
<th><?php _e('device_templates_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('device_templates_delete_option'); ?></td>
<td><?php _e('device_templates_delete_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('device_templates_duplicate_option'); ?></td>
<td><?php _e('device_templates_duplicate_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('device_templates_sync_option'); ?></td>
<td><?php _e('device_templates_sync_desc'); ?></td>
</tr>
</tbody>
</table>

<p><?php _e('device_templates_edit_intro'); ?></p>

<p><img src="images/device-templates-edit.png" alt="<?php _e('device_templates_edit_page_desc'); ?>" /></p>

<p><?php _e('device_templates_add_remove'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
