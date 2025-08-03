<?php
/**
 * Cacti Documentation - Mail/Reporting/DNS Settings
 * 
 * This page explains the Mail/Reporting/DNS Settings configuration in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_mail_reporting_dns', 'settings_mail_reporting_dns', true);
?>

<h1 id="mailreportingdns-settings"><?php _e('mail_reporting_dns_settings_title'); ?></h1>

<p><?php _e('mail_reporting_dns_settings_intro'); ?></p>

<h2 id="url-linking"><?php _e('url_linking'); ?></h2>

<p><?php _e('url_linking_intro'); ?></p>

<p><img src="images/settings-mrd-urls.png" alt="<?php _e('url_linking_settings'); ?>" /></p>

<h2 id="mail-settings"><?php _e('mail_settings'); ?></h2>

<p><?php _e('mail_settings_intro'); ?></p>

<ul>
<li><p><strong><?php _e('php_mail_function'); ?></strong> - <?php _e('php_mail_function_desc'); ?></p></li>

<li><p><strong><?php _e('sendmail_binary'); ?></strong> - <?php _e('sendmail_binary_desc'); ?></p></li>

<li><p><strong><?php _e('simple_mail_transfer_protocol_smtp'); ?></strong> - <?php _e('simple_mail_transfer_protocol_smtp_desc'); ?></p></li>
</ul>

<p><?php _e('mail_settings_details'); ?></p>

<h2 id="emailing-options"><?php _e('emailing_options'); ?></h2>

<p><?php _e('emailing_options_intro'); ?></p>

<p><img src="images/settings-mrd-php-mail.png" alt="<?php _e('php_mail_function'); ?>" /></p>

<p><?php _e('emailing_options_include'); ?></p>

<ul>
<li><p><strong><?php _e('notify_primary_admin_of_issues'); ?></strong> - <?php _e('notify_primary_admin_of_issues_desc'); ?></p></li>

<li><p><strong><?php _e('test_email'); ?></strong> - <?php _e('test_email_desc'); ?></p></li>

<li><p><strong><?php _e('mail_services'); ?></strong> - <?php _e('mail_services_desc'); ?></p></li>

<li><p><strong><?php _e('ping_mail_server'); ?></strong> - <?php _e('ping_mail_server_desc'); ?></p></li>

<li><p><strong><?php _e('from_email_address'); ?></strong> - <?php _e('from_email_address_desc'); ?></p></li>

<li><p><strong><?php _e('from_name'); ?></strong> - <?php _e('from_name_desc'); ?></p></li>

<li><p><strong><?php _e('word_wrap'); ?></strong> - <?php _e('word_wrap_desc'); ?></p></li>
</ul>

<p><?php _e('mail_services_documentation'); ?></p>

<h3 id="php-mail-function"><?php _e('php_mail_function'); ?></h3>

<p><?php _e('php_mail_function_settings'); ?></p>

<h3 id="sendmail-binary"><?php _e('sendmail_binary'); ?></h3>

<p><?php _e('sendmail_binary_settings'); ?></p>

<p><img src="images/settings-mrd-sendmail.png" alt="<?php _e('sendmail_binary'); ?>" /></p>

<h3 id="simple-mail-transfer-protocol-smtp"><?php _e('simple_mail_transfer_protocol_smtp'); ?></h3>

<p><?php _e('smtp_settings_intro'); ?></p>

<p><img src="images/settings-mrd-smtp.png" alt="<?php _e('smtp_mail'); ?>" /></p>

<p><?php _e('smtp_options_include'); ?></p>

<ul>
<li><strong><?php _e('smtp_hostname'); ?></strong> - <?php _e('smtp_hostname_desc'); ?></li>
<li><strong><?php _e('smtp_port'); ?></strong> - <?php _e('smtp_port_desc'); ?></li>
<li><strong><?php _e('smtp_username'); ?></strong> - <?php _e('smtp_username_desc'); ?></li>
<li><strong><?php _e('smtp_password'); ?></strong> - <?php _e('smtp_password_desc'); ?></li>
<li><strong><?php _e('smtp_security'); ?></strong> - <?php _e('smtp_security_desc'); ?></li>
<li><strong><?php _e('smtp_timeout'); ?></strong> - <?php _e('smtp_timeout_desc'); ?></li>
</ul>

<h2 id="reporting-presets"><?php _e('reporting_presets'); ?></h2>

<p><?php _e('reporting_presets_intro'); ?></p>

<p><img src="images/settings-mrd-report-presets.png" alt="<?php _e('reporting_presets'); ?>" /></p>

<p><?php _e('reporting_presets_note'); ?></p>

<h2 id="dns-options"><?php _e('dns_options'); ?></h2>

<p><?php _e('dns_options_intro'); ?></p>

<p><?php _e('dns_options_desc'); ?></p>

<p><img src="images/settings-mrd-dns-options.png" alt="<?php _e('dns_options'); ?>" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
