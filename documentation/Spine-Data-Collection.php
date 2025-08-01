<?php
/**
 * Cacti Documentation - Spine Data Collection
 * 
 * This page provides a comprehensive guide on Spine data collection in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_spine', 'spine', true);
?>

<h1 id="spine"><?php _e('spine_title'); ?></h1>

<p><?php _e('spine_intro'); ?></p>

<p><?php _e('spine_warning'); ?></p>

<p><?php _e('spine_activation'); ?></p>

<p><?php _e('spine_testing'); ?></p>

<pre class="console"><code><?php _e('spine_test_command'); ?>
</code></pre>

<p><?php _e('spine_output_note'); ?></p>

<p><?php _e('spine_performance'); ?></p>

<p><?php _e('spine_mysql_connections'); ?></p>

<h6 id="table-15-1-spine-parameters-maintained-at-the-system-level"><?php _e('spine_system_params_title'); ?></h6>

<table>
<thead>
<tr class="header">
<th><?php _e('spine_param_name'); ?></th>
<th><?php _e('spine_param_description'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('spine_script_timeout_name'); ?></td>
<td><?php _e('spine_script_timeout_desc'); ?></td>
</tr>
</tbody>
</table>

<h6 id="table-15-2-spine-parameters-maintained-at-the-data-collector-level"><?php _e('spine_collector_params_title'); ?></h6>

<table>
<thead>
<tr class="header">
<th><?php _e('spine_param_name'); ?></th>
<th><?php _e('spine_param_description'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('spine_max_threads_name'); ?></td>
<td><?php _e('spine_max_threads_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('spine_script_servers_name'); ?></td>
<td><?php _e('spine_script_servers_desc'); ?></td>
</tr>
</tbody>
</table>

<h6 id="table-15-3-spine-parameters-maintained-at-the-device-level"><?php _e('spine_device_params_title'); ?></h6>

<table>
<thead>
<tr class="header">
<th><?php _e('spine_param_name'); ?></th>
<th><?php _e('spine_param_description'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('spine_snmp_oids_name'); ?></td>
<td><?php _e('spine_snmp_oids_desc'); ?></td>
</tr>
<tr class="even">
<td><?php _e('spine_device_threads_name'); ?></td>
<td><?php _e('spine_device_threads_desc'); ?></td>
</tr>
</tbody>
</table>

<h3 id="installing-spine"><?php _e('installing_spine_title'); ?></h3>

<p><?php _e('spine_compile_note'); ?></p>

<h3 id="ubuntu"><?php _e('ubuntu_title'); ?></h3>

<p><?php _e('ubuntu_packages'); ?></p>

<pre class="console"><code><?php _e('ubuntu_install_command'); ?>
</code></pre>

<p><?php _e('spine_download_note'); ?></p>

<pre class="console"><code><?php _e('spine_download_commands'); ?>
</code></pre>

<p><?php _e('spine_compile_note2'); ?></p>

<pre class="console"><code><?php _e('spine_compile_commands'); ?>
</code></pre>

<p><?php _e('spine_config_note'); ?></p>

<pre class="console"><code><?php _e('spine_config_command'); ?>
</code></pre>

<p><?php _e('spine_config_example_note'); ?></p>

<pre class="console"><code><?php _e('spine_config_example'); ?>
</code></pre>

<h3 id="centos"><?php _e('centos_title'); ?></h3>

<p><?php _e('centos_packages'); ?></p>

<pre class="console"><code><?php _e('centos_install_command'); ?>
</code></pre>

<p><?php _e('centos_compile_note'); ?></p>

<pre class="console"><code><?php _e('centos_compile_commands'); ?>
</code></pre>

<h3 id="testingdebugging-spine-via-command-line"><?php _e('testing_debugging_title'); ?></h3>

<p><?php _e('spine_testing_intro'); ?></p>

<h4 id="test-spine-without-writing-results-to-database"><?php _e('test_without_db_title'); ?></h4>

<p><?php _e('test_without_db_desc'); ?></p>

<h4 id="running-spine-for-a-specific-host"><?php _e('test_specific_host_title'); ?></h4>

<p><?php _e('test_specific_host_desc'); ?></p>

<h4 id="spine-debug-via-gui"><?php _e('spine_debug_gui_title'); ?></h4>

<p><?php _e('spine_debug_gui_desc'); ?></p>

<p><?php _e('spine_debug_gui_example'); ?></p>

<p><img src="images/spine-debug-gui.png" alt="<?php _e('spine_debug_image_desc'); ?>" /></p>

<p><?php _e('spine_logging_settings'); ?></p>

<p><?php _e('spine_logging_options'); ?></p>

<p><?php _e('spine_logging_detailed'); ?></p>

<p><?php _e('spine_logging_summary'); ?></p>

<p><img src="images/spine-parameters.png" alt="<?php _e('spine_parameters_image_desc'); ?>" /></p>

<h3 id="common-spine-related-errors"><?php _e('spine_errors_title'); ?></h3>

<pre class="shell"><code><?php _e('spine_error_config_missing'); ?>
</code></pre>

<p><?php _e('spine_error_config_solution'); ?></p>

<pre class="shell"><code><?php _e('spine_error_setuid'); ?>
</code></pre>

<p><?php _e('spine_error_setuid_desc'); ?></p>

<pre class="shell"><code><?php _e('spine_error_setuid_solution'); ?>
</code></pre>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
