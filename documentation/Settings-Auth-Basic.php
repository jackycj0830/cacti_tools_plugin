<?php
/**
 * Cacti Documentation - Settings Auth Basic
 * 
 * This page provides comprehensive information about Settings Auth Basic in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_auth_basic', 'settings_auth_basic', true);
?>

<h1 id="settings-auth-basic"><?php _e('settings_auth_basic_title'); ?></h1>

<p><?php _e('settings_auth_basic_intro'); ?></p>

<p><?php _e('settings_auth_basic_description'); ?></p>

<p><img src="images/settings-auth-basic.png" alt="<?php _e('settings_auth_basic_title'); ?>" /></p>

<h2 id="basic-auth-settings"><?php _e('basic_auth_settings'); ?></h2>

<p><?php _e('basic_auth_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('basic_auth_enabled'); ?></strong> - <?php _e('basic_auth_enabled_desc'); ?></li>
<li><strong><?php _e('basic_auth_header'); ?></strong> - <?php _e('basic_auth_header_desc'); ?></li>
<li><strong><?php _e('basic_auth_username'); ?></strong> - <?php _e('basic_auth_username_desc'); ?></li>
<li><strong><?php _e('basic_auth_password'); ?></strong> - <?php _e('basic_auth_password_desc'); ?></li>
</ul>

<h2 id="web-server-config"><?php _e('web_server_config'); ?></h2>

<p><?php _e('web_server_config_intro'); ?></p>

<ul>
<li><strong><?php _e('apache_config'); ?></strong> - <?php _e('apache_config_desc'); ?></li>
<li><strong><?php _e('nginx_config'); ?></strong> - <?php _e('nginx_config_desc'); ?></li>
<li><strong><?php _e('iis_config'); ?></strong> - <?php _e('iis_config_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
