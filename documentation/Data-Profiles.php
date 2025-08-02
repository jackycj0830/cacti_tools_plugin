<?php
/**
 * Cacti Documentation - Data Source Profiles
 * 
 * This page provides a comprehensive guide on data source profiles in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_data_profiles', 'data_profiles', true);
?>

<h1 id="data-source-profiles"><?php _e('data_profiles_title'); ?></h1>

<p><?php _e('data_profiles_intro'); ?></p>

<p><img src="images/data-source-profiles.png" alt="<?php _e('data_profiles_title'); ?>" /></p>

<p><img src="images/data-source-profiles-edit1.png" alt="Data Source Profiles Edit" /></p>

<p><?php _e('data_profiles_disk_usage'); ?></p>

<table>
<thead>
<tr class="header">
<th style="text-align: right;"><?php _e('data_profiles_polling_time'); ?></th>
<th><?php _e('data_profiles_type'); ?></th>
<th style="text-align: right;"><?php _e('data_profiles_size_per_ds'); ?></th>
<th style="text-align: right;"><?php _e('data_profiles_polling_time'); ?></th>
<th><?php _e('data_profiles_type'); ?></th>
<th style="text-align: right;"><?php _e('data_profiles_size_per_ds'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td style="text-align: right;"><?php _e('data_profiles_30_second'); ?></td>
<td><?php _e('data_profiles_daily'); ?></td>
<td style="text-align: right;"><?php _e('data_profiles_48kb'); ?></td>
<td style="text-align: right;"><?php _e('data_profiles_30_second'); ?></td>
<td><?php _e('data_profiles_weekly'); ?></td>
<td style="text-align: right;"><?php _e('data_profiles_43kb'); ?></td>
</tr>
<tr class="even">
<td style="text-align: right;"><?php _e('data_profiles_30_second'); ?></td>
<td><?php _e('data_profiles_monthly'); ?></td>
<td style="text-align: right;"><?php _e('data_profiles_46kb'); ?></td>
<td style="text-align: right;"><?php _e('data_profiles_30_second'); ?></td>
<td><?php _e('data_profiles_yearly'); ?></td>
<td style="text-align: right;"><?php _e('data_profiles_140kb'); ?></td>
</tr>
</tbody>
</table>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
