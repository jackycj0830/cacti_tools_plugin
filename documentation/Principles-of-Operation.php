<?php
/**
 * Cacti Documentation - Principles of Operation
 * 
 * This page explains the principles of operation for Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_principles_operation', 'principles_operation', true);
?>

<h1 id="principles-of-operation"><?php _e('principles_operation_title'); ?></h1>

<p><?php _e('principles_intro'); ?></p>

<h2 id="operational-layers"><?php _e('operational_layers'); ?></h2>

<ul>
<li><?php _e('devices_layer'); ?></li>
<li><?php _e('sites_layer'); ?></li>
<li><?php _e('data_collectors_layer'); ?></li>
<li><?php _e('data_retrieval_layer'); ?></li>
<li><?php _e('data_storage_layer'); ?></li>
<li><?php _e('graphing_layer'); ?></li>
</ul>

<h2 id="devices"><?php _e('devices_title'); ?></h2>

<p><?php _e('devices_desc'); ?></p>

<p><?php _e('devices_center'); ?></p>

<h2 id="sites"><?php _e('sites_title'); ?></h2>

<p><?php _e('sites_desc'); ?></p>

<h2 id="data-collectors"><?php _e('data_collectors_title'); ?></h2>

<p><?php _e('data_collectors_desc'); ?></p>

<p><?php _e('data_collectors_support'); ?></p>

<h2 id="data-retrieval"><?php _e('data_retrieval_title'); ?></h2>

<p><?php _e('data_retrieval_desc'); ?></p>

<p><?php _e('data_flow_desc'); ?></p>

<p><img src="images/data-flow.png" alt="Data Flow" /></p>

<p><?php _e('enterprise_installations'); ?></p>

<p><?php _e('hmib_plugin_desc'); ?></p>

<p><?php _e('rrd_storage_desc'); ?></p>

<h2 id="data-storage"><?php _e('data_storage_title'); ?></h2>

<p><?php _e('data_storage_desc'); ?></p>

<p><?php _e('rrd_acronym'); ?></p>

<p><?php _e('rrd_consolidation'); ?></p>

<h2 id="data-presentation"><?php _e('data_presentation_title'); ?></h2>

<p><?php _e('data_presentation_desc'); ?></p>

<p><?php _e('graphing_engine_desc'); ?></p>

<h2 id="extending-built-in-capabilities"><?php _e('extending_capabilities_title'); ?></h2>

<p><?php _e('extending_capabilities_desc'); ?></p>

<table border="1">
<thead>
<tr>
<th><?php _e('protocol_column'); ?></th>
<th><?php _e('description_column'); ?></th>
</tr>
</thead>
<tbody>
<tr>
<td><?php _e('icmp_protocol'); ?></td>
<td><?php _e('icmp_desc'); ?></td>
</tr>
<tr>
<td><?php _e('telnet_protocol'); ?></td>
<td><?php _e('telnet_desc'); ?></td>
</tr>
<tr>
<td><?php _e('ssh_protocol'); ?></td>
<td><?php _e('ssh_desc'); ?></td>
</tr>
<tr>
<td><?php _e('http_protocol'); ?></td>
<td><?php _e('http_desc'); ?></td>
</tr>
<tr>
<td><?php _e('snmp_protocol'); ?></td>
<td><?php _e('snmp_desc'); ?></td>
</tr>
<tr>
<td><?php _e('ldap_protocol'); ?></td>
<td><?php _e('ldap_desc'); ?></td>
</tr>
<tr>
<td><?php _e('custom_protocol'); ?></td>
<td><?php _e('custom_desc'); ?></td>
</tr>
<tr>
<td colspan="2"><?php _e('and_more'); ?></td>
</tr>
</tbody>
</table>

<p><?php _e('extending_ways'); ?></p>

<ul>
<li><p><strong><?php _e('data_input_methods_desc'); ?></strong></p>
<ul>
<li><?php _e('data_input_examples'); ?></li>
<li><?php _e('cpu_memory_example'); ?></li>
<li><?php _e('users_logged_example'); ?></li>
<li><?php _e('ip_readings_example'); ?></li>
<li><?php _e('tcp_readings_example'); ?></li>
<li><?php _e('udp_readings_example'); ?></li>
</ul></li>

<li><p><strong><?php _e('data_queries_desc'); ?></strong></p>
<ul>
<li><?php _e('network_interfaces_example'); ?></li>
<li><?php _e('snmp_tables_example'); ?></li>
<li><?php _e('data_queries_script_example'); ?></li>
</ul></li>
</ul>

<p><?php _e('export_import_desc'); ?></p>

<h2 id="beyond-graphs"><?php _e('beyond_graphs_title'); ?></h2>

<p><?php _e('beyond_graphs_desc'); ?></p>

<?php
// Generate page footer
generatePageFooter();
?>
