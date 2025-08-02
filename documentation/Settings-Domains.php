<?php
/**
 * Cacti Documentation - Settings Domains
 * 
 * This page provides comprehensive information about Settings Domains in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_domains', 'settings_domains', true);
?>

<h1 id="settings-domains"><?php _e('settings_domains_title'); ?></h1>

<p><?php _e('settings_domains_intro'); ?></p>

<p><?php _e('settings_domains_description'); ?></p>

<p><img src="images/settings-domains.png" alt="<?php _e('settings_domains_title'); ?>" /></p>

<h2 id="domain-configuration"><?php _e('domain_configuration'); ?></h2>

<p><?php _e('domain_configuration_intro'); ?></p>

<ul>
<li><strong><?php _e('domain_name'); ?></strong> - <?php _e('domain_name_desc'); ?></li>
<li><strong><?php _e('domain_type'); ?></strong> - <?php _e('domain_type_desc'); ?></li>
<li><strong><?php _e('domain_enabled'); ?></strong> - <?php _e('domain_enabled_desc'); ?></li>
<li><strong><?php _e('domain_delinked'); ?></strong> - <?php _e('domain_delinked_desc'); ?></li>
</ul>

<h2 id="ldap-domain-settings"><?php _e('ldap_domain_settings'); ?></h2>

<p><?php _e('ldap_domain_settings_intro'); ?></p>

<ul>
<li><strong><?php _e('ldap_domain_server'); ?></strong> - <?php _e('ldap_domain_server_desc'); ?></li>
<li><strong><?php _e('ldap_domain_port'); ?></strong> - <?php _e('ldap_domain_port_desc'); ?></li>
<li><strong><?php _e('ldap_domain_dn'); ?></strong> - <?php _e('ldap_domain_dn_desc'); ?></li>
<li><strong><?php _e('ldap_domain_proto_version'); ?></strong> - <?php _e('ldap_domain_proto_version_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
