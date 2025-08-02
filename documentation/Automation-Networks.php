<?php
/**
 * Cacti Documentation - Automation Networks
 * 
 * This page provides a comprehensive guide on automation networks in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_automation_networks', 'automation_networks', true);
?>

<h1 id="automation-networks"><?php _e('automation_networks_title'); ?></h1>

<p><?php _e('automation_networks_intro'); ?></p>

<p><?php _e('automation_networks_adding'); ?></p>

<p><img src="images/automation-networks.png" alt="<?php _e('automation_networks_main_desc'); ?>" /></p>

<p><?php _e('automation_networks_subnet_desc'); ?></p>

<p><img src="images/automation-networks-edit.png" alt="<?php _e('automation_networks_edit_desc'); ?>" /></p>

<p><?php _e('automation_networks_options'); ?></p>

<table>
<thead>
<tr class="header">
<th><?php _e('automation_option_field'); ?></th>
<th><?php _e('automation_description_field'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('schedule_type_option'); ?></td>
<td><?php _e('schedule_type_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('discovery_threads_option'); ?></td>
<td><?php _e('discovery_threads_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('max_runtime_option'); ?></td>
<td><?php _e('max_runtime_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('auto_add_option'); ?></td>
<td><?php _e('auto_add_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('netbios_option'); ?></td>
<td><?php _e('netbios_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('ping_method_option'); ?></td>
<td><?php _e('ping_method_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('ping_port_option'); ?></td>
<td><?php _e('ping_port_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('ping_timeout_option'); ?></td>
<td><?php _e('ping_timeout_desc'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('ping_retries_option'); ?></td>
<td><?php _e('ping_retries_desc'); ?></td>
</tr>
</tbody>
</table>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
