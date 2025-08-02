<?php
/**
 * Cacti Documentation - Data Debug
 * 
 * This page provides comprehensive information about Data Debug in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_data_debug', 'data_debug', true);
?>

<h1 id="data-debug"><?php _e('data_debug_title'); ?></h1>

<p><?php _e('data_debug_intro'); ?></p>

<p><?php _e('data_debug_description'); ?></p>

<p><img src="images/data-debug.png" alt="<?php _e('data_debug_title'); ?>" /></p>

<h2 id="debug-data-sources"><?php _e('debug_data_sources'); ?></h2>

<p><?php _e('debug_data_sources_intro'); ?></p>

<ul>
<li><strong><?php _e('data_source_debug'); ?></strong> - <?php _e('data_source_debug_desc'); ?></li>
<li><strong><?php _e('rrd_file_debug'); ?></strong> - <?php _e('rrd_file_debug_desc'); ?></li>
<li><strong><?php _e('poller_output_debug'); ?></strong> - <?php _e('poller_output_debug_desc'); ?></li>
</ul>

<h2 id="debug-graphs"><?php _e('debug_graphs'); ?></h2>

<p><?php _e('debug_graphs_intro'); ?></p>

<ul>
<li><strong><?php _e('graph_debug'); ?></strong> - <?php _e('graph_debug_desc'); ?></li>
<li><strong><?php _e('graph_image_debug'); ?></strong> - <?php _e('graph_image_debug_desc'); ?></li>
<li><strong><?php _e('rrdtool_debug'); ?></strong> - <?php _e('rrdtool_debug_desc'); ?></li>
</ul>

<h2 id="debug-devices"><?php _e('debug_devices'); ?></h2>

<p><?php _e('debug_devices_intro'); ?></p>

<ul>
<li><strong><?php _e('device_debug'); ?></strong> - <?php _e('device_debug_desc'); ?></li>
<li><strong><?php _e('snmp_debug'); ?></strong> - <?php _e('snmp_debug_desc'); ?></li>
<li><strong><?php _e('ping_debug'); ?></strong> - <?php _e('ping_debug_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
