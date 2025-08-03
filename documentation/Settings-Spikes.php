<?php
/**
 * Cacti Documentation - Spike Kill Settings
 * 
 * This page explains the Spike Kill Settings configuration in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_spikes', 'settings_spikes', true);
?>

<h1 id="spike-kill"><?php _e('spike_kill_title'); ?></h1>

<p><?php _e('spike_kill_intro'); ?></p>

<p><?php _e('spike_kill_causes'); ?></p>

<p><?php _e('spike_kill_gaps'); ?></p>

<h2 id="spike-kill-settings"><?php _e('spike_kill_settings'); ?></h2>

<p><?php _e('spike_kill_settings_intro'); ?></p>

<p><img src="images/settings-spikekill.png" alt="<?php _e('settings_spike_kill'); ?>" /></p>

<p><?php _e('spike_kill_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('removal_method'); ?></strong> - <?php _e('removal_method_desc'); ?></p></li>

<li><p><strong><?php _e('replacement_method'); ?></strong> - <?php _e('replacement_method_desc'); ?></p></li>

<li><p><strong><?php _e('number_of_standard_deviations'); ?></strong> - <?php _e('number_of_standard_deviations_desc'); ?></p></li>

<li><p><strong><?php _e('variance_percentage'); ?></strong> - <?php _e('variance_percentage_desc'); ?></p></li>

<li><p><strong><?php _e('variance_number_of_outliers'); ?></strong> - <?php _e('variance_number_of_outliers_desc'); ?></p></li>

<li><p><strong><?php _e('max_kills_per_rra'); ?></strong> - <?php _e('max_kills_per_rra_desc'); ?></p></li>

<li><p><strong><?php _e('rrdfile_backup_directory'); ?></strong> - <?php _e('rrdfile_backup_directory_desc'); ?></p></li>
</ul>

<h2 id="batch-spike-kill-settings"><?php _e('batch_spike_kill_settings'); ?></h2>

<p><?php _e('batch_spike_kill_settings_intro'); ?></p>

<p><img src="images/settings-spikekill-batch.png" alt="<?php _e('settings_spike_kill_batch'); ?>" /></p>

<p><?php _e('batch_spike_kill_note'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
