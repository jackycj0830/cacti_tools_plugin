<?php
/**
 * Cacti Documentation - Data Collectors
 * 
 * This page provides a comprehensive guide on data collectors in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_data_collectors', 'data_collectors', true);
?>

<h1 id="data-collectors"><?php _e('data_collectors_title'); ?></h1>

<h2 id="data-collector-background"><?php _e('data_collector_background_title'); ?></h2>

<p><?php _e('data_collectors_intro'); ?></p>

<ul>
<li><?php _e('main_data_collector'); ?></li>
<li><?php _e('remote_data_collector'); ?></li>
</ul>

<p><?php _e('remote_collector_design'); ?></p>

<p><?php _e('collector_normalization'); ?></p>

<p><?php _e('enterprise_architecture'); ?></p>

<p><?php _e('load_balancing'); ?></p>

<p><?php _e('ha_setup_note'); ?></p>

<p><?php _e('boost_module_requirement'); ?></p>

<p><?php _e('network_requirements'); ?></p>

<h2 id="data-collector-user-interface"><?php _e('data_collector_ui_title'); ?></h2>

<p><?php _e('data_collector_ui_description'); ?></p>

<p><?php _e('full_sync_usage'); ?></p>

<p><img src="images/data-collectors.png" alt="<?php _e('data_collectors_image_desc'); ?>" /></p>

<p><?php _e('main_collector_description'); ?></p>

<p><?php _e('main_collector_edit_description'); ?></p>

<p><img src="images/data-collectors-edit-main.png" alt="<?php _e('data_collectors_edit_main_desc'); ?>" /></p>

<p><?php _e('remote_collector_edit_description'); ?></p>

<p><img src="images/data-collectors-edit-remote1.png" alt="<?php _e('data_collectors_edit_remote_desc'); ?>" /></p>

<p><img src="images/data-collectors-edit-remote2.png" alt="<?php _e('data_collectors_edit_remote_test_desc'); ?>" /></p>

<h2 id="setup-main-data-collector-to-accept-connections-remotes"><?php _e('setup_main_collector_title'); ?></h2>

<p><?php _e('mysql_config_changes'); ?></p>

<pre class="console"><code><?php _e('mysql_grant_commands'); ?>
</code></pre>

<p><?php _e('remote_config_setup'); ?></p>

<pre class="console"><code><?php _e('remote_config_example'); ?>
</code></pre>

<p><?php _e('remote_install_instruction'); ?></p>

<p><img src="images/data-collectors-remote-setup.png" alt="<?php _e('remote_setup_image_desc'); ?>" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
