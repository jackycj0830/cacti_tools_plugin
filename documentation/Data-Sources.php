<?php
/**
 * Cacti Documentation - Data Source Management
 * 
 * This page provides a comprehensive guide on data source management in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_data_sources', 'data_sources', true);
?>

<h1 id="data-source-management"><?php _e('data_sources_title'); ?></h1>

<p><?php _e('data_sources_intro'); ?></p>

<ul>
<li><p><?php _e('data_source_ping_example'); ?></p></li>
<li><p><?php _e('data_source_switch_example'); ?></p></li>
</ul>

<blockquote>
<p><?php _e('data_source_note'); ?></p>
</blockquote>

<p><?php _e('data_source_example_explanation'); ?></p>

<p><?php _e('data_source_resource_importance'); ?></p>

<p><?php _e('data_source_device_view'); ?></p>

<p><img src="images/device-datasource.png" alt="<?php _e('device_datasources_image_desc'); ?>" /></p>

<p><?php _e('data_source_total_view'); ?></p>

<pre class="console"><code><?php _e('data_source_stats_example'); ?>
</code></pre>

<p><?php _e('data_source_stats_explanation'); ?></p>

<h3 id="storage-considerations-and-datasources"><?php _e('storage_considerations_title'); ?></h3>

<p><?php _e('storage_considerations_intro'); ?></p>

<p><?php _e('storage_per_datasource'); ?></p>

<table>
<thead>
<tr class="header">
<th style="text-align: right;"><?php _e('polling_time_column'); ?></th>
<th><?php _e('retention_column'); ?></th>
<th style="text-align: right;"><?php _e('file_size_column'); ?></th>
<th style="text-align: right;"><?php _e('polling_time_column'); ?></th>
<th><?php _e('retention_column'); ?></th>
<th style="text-align: right;"><?php _e('file_size_column'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td style="text-align: right;"><?php _e('thirty_second'); ?></td>
<td><?php _e('daily'); ?></td>
<td style="text-align: right;">48kb</td>
<td style="text-align: right;"><?php _e('thirty_second'); ?></td>
<td><?php _e('weekly'); ?></td>
<td style="text-align: right;">43kb</td>
</tr>
<tr class="even">
<td style="text-align: right;"><?php _e('thirty_second'); ?></td>
<td><?php _e('monthly'); ?></td>
<td style="text-align: right;">46kb</td>
<td style="text-align: right;"><?php _e('thirty_second'); ?></td>
<td><?php _e('yearly'); ?></td>
<td style="text-align: right;">140kb</td>
</tr>
<tr class="odd">
<td style="text-align: right;"><?php _e('one_minute'); ?></td>
<td><?php _e('daily'); ?></td>
<td style="text-align: right;">93kb</td>
<td style="text-align: right;"><?php _e('one_minute'); ?></td>
<td><?php _e('weekly'); ?></td>
<td style="text-align: right;">45kb</td>
</tr>
<tr class="even">
<td style="text-align: right;"><?php _e('one_minute'); ?></td>
<td><?php _e('monthly'); ?></td>
<td style="text-align: right;">47kb</td>
<td style="text-align: right;"><?php _e('one_minute'); ?></td>
<td><?php _e('yearly'); ?></td>
<td style="text-align: right;">140kb</td>
</tr>
<tr class="odd">
<td style="text-align: right;"><?php _e('five_minute'); ?></td>
<td><?php _e('daily'); ?></td>
<td style="text-align: right;">19b</td>
<td style="text-align: right;"><?php _e('five_minute'); ?></td>
<td><?php _e('weekly'); ?></td>
<td style="text-align: right;">22kb</td>
</tr>
<tr class="even">
<td style="text-align: right;"><?php _e('five_minute'); ?></td>
<td><?php _e('monthly'); ?></td>
<td style="text-align: right;">25kb</td>
<td style="text-align: right;"><?php _e('five_minute'); ?></td>
<td><?php _e('yearly'); ?></td>
<td style="text-align: right;">26kb</td>
</tr>
</tbody>
</table>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
