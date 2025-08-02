<?php
/**
 * Cacti Documentation - User Domains
 * 
 * This page provides comprehensive information about User Domains in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_user_domains', 'user_domains', true);
?>

<h1 id="user-domains"><?php _e('user_domains_title'); ?></h1>

<p><?php _e('user_domains_intro'); ?></p>

<p><?php _e('user_domains_description'); ?></p>

<p><img src="images/user-domains.png" alt="<?php _e('user_domains_title'); ?>" /></p>

<h2 id="domain-configuration"><?php _e('domain_configuration'); ?></h2>

<p><?php _e('domain_configuration_intro'); ?></p>

<ul>
<li><strong><?php _e('domain_name'); ?></strong> - <?php _e('domain_name_desc'); ?></li>
<li><strong><?php _e('domain_type'); ?></strong> - <?php _e('domain_type_desc'); ?></li>
<li><strong><?php _e('domain_enabled'); ?></strong> - <?php _e('domain_enabled_desc'); ?></li>
<li><strong><?php _e('user_creation'); ?></strong> - <?php _e('user_creation_desc'); ?></li>
</ul>

<h2 id="ldap-settings"><?php _e('ldap_settings'); ?></h2>

<p><?php _e('ldap_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('ldap_server'); ?></strong> - <?php _e('ldap_server_desc'); ?></li>
<li><strong><?php _e('ldap_port'); ?></strong> - <?php _e('ldap_port_desc'); ?></li>
<li><strong><?php _e('ldap_dn'); ?></strong> - <?php _e('ldap_dn_desc'); ?></li>
<li><strong><?php _e('ldap_group_require'); ?></strong> - <?php _e('ldap_group_require_desc'); ?></li>
<li><strong><?php _e('ldap_group_dn'); ?></strong> - <?php _e('ldap_group_dn_desc'); ?></li>
</ul>

<h2 id="domain-mapping"><?php _e('domain_mapping'); ?></h2>

<p><?php _e('domain_mapping_intro'); ?></p>

<ul>
<li><strong><?php _e('default_user_group'); ?></strong> - <?php _e('default_user_group_desc'); ?></li>
<li><strong><?php _e('group_mapping'); ?></strong> - <?php _e('group_mapping_desc'); ?></li>
<li><strong><?php _e('attribute_mapping'); ?></strong> - <?php _e('attribute_mapping_desc'); ?></li>
</ul>

<h2 id="domain-testing"><?php _e('domain_testing'); ?></h2>

<p><?php _e('domain_testing_intro'); ?></p>

<ul>
<li><strong><?php _e('test_connection'); ?></strong> - <?php _e('test_connection_desc'); ?></li>
<li><strong><?php _e('test_authentication'); ?></strong> - <?php _e('test_authentication_desc'); ?></li>
<li><strong><?php _e('debug_mode'); ?></strong> - <?php _e('debug_mode_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
