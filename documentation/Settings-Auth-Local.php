<?php
/**
 * Cacti Documentation - Settings Auth Local
 * 
 * This page provides comprehensive information about Settings Auth Local in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_auth_local', 'settings_auth_local', true);
?>

<h1 id="settings-auth-local"><?php _e('settings_auth_local_title'); ?></h1>

<p><?php _e('settings_auth_local_intro'); ?></p>

<p><?php _e('settings_auth_local_description'); ?></p>

<p><img src="images/settings-auth-local.png" alt="<?php _e('settings_auth_local_title'); ?>" /></p>

<h2 id="local-auth-settings"><?php _e('local_auth_settings'); ?></h2>

<p><?php _e('local_auth_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('guest_user'); ?></strong> - <?php _e('guest_user_desc'); ?></li>
<li><strong><?php _e('user_template'); ?></strong> - <?php _e('user_template_desc'); ?></li>
<li><strong><?php _e('minimum_password_length'); ?></strong> - <?php _e('minimum_password_length_desc'); ?></li>
<li><strong><?php _e('force_password_change'); ?></strong> - <?php _e('force_password_change_desc'); ?></li>
<li><strong><?php _e('password_history'); ?></strong> - <?php _e('password_history_desc'); ?></li>
</ul>

<h2 id="security-settings"><?php _e('security_settings'); ?></h2>

<p><?php _e('security_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('account_lockout'); ?></strong> - <?php _e('account_lockout_desc'); ?></li>
<li><strong><?php _e('lockout_duration'); ?></strong> - <?php _e('lockout_duration_desc'); ?></li>
<li><strong><?php _e('failed_attempts'); ?></strong> - <?php _e('failed_attempts_desc'); ?></li>
<li><strong><?php _e('session_timeout'); ?></strong> - <?php _e('session_timeout_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
