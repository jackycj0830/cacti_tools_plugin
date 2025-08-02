<?php
/**
 * Cacti Documentation - Settings Auth LDAP
 * 
 * This page provides comprehensive information about Settings Auth LDAP in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_auth_ldap', 'settings_auth_ldap', true);
?>

<h1 id="settings-auth-ldap"><?php _e('settings_auth_ldap_title'); ?></h1>

<p><?php _e('settings_auth_ldap_intro'); ?></p>

<p><?php _e('settings_auth_ldap_description'); ?></p>

<p><img src="images/settings-auth-ldap.png" alt="<?php _e('settings_auth_ldap_title'); ?>" /></p>

<h2 id="ldap-server-settings"><?php _e('ldap_server_settings'); ?></h2>

<p><?php _e('ldap_server_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('ldap_server'); ?></strong> - <?php _e('ldap_server_desc'); ?></li>
<li><strong><?php _e('ldap_port'); ?></strong> - <?php _e('ldap_port_desc'); ?></li>
<li><strong><?php _e('ldap_protocol_version'); ?></strong> - <?php _e('ldap_protocol_version_desc'); ?></li>
<li><strong><?php _e('ldap_encryption'); ?></strong> - <?php _e('ldap_encryption_desc'); ?></li>
<li><strong><?php _e('ldap_referrals'); ?></strong> - <?php _e('ldap_referrals_desc'); ?></li>
</ul>

<h2 id="ldap-authentication"><?php _e('ldap_authentication'); ?></h2>

<p><?php _e('ldap_authentication_intro'); ?></p>

<ul>
<li><strong><?php _e('ldap_dn'); ?></strong> - <?php _e('ldap_dn_desc'); ?></li>
<li><strong><?php _e('ldap_group_require'); ?></strong> - <?php _e('ldap_group_require_desc'); ?></li>
<li><strong><?php _e('ldap_group_dn'); ?></strong> - <?php _e('ldap_group_dn_desc'); ?></li>
<li><strong><?php _e('ldap_group_attrib'); ?></strong> - <?php _e('ldap_group_attrib_desc'); ?></li>
<li><strong><?php _e('ldap_group_member_type'); ?></strong> - <?php _e('ldap_group_member_type_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
