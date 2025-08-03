<?php
/**
 * Cacti Documentation - General Settings
 * 
 * This page explains the general settings configuration in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_settings_general', 'settings_general', true);
?>

<h1 id="general-settings"><?php _e('settings_general_title'); ?></h1>

<p><?php _e('settings_general_intro'); ?></p>

<ul>
<li><strong><?php _e('log_settings'); ?></strong> - <?php _e('log_settings_desc'); ?></li>
<li><strong><?php _e('internationalization'); ?></strong> - <?php _e('internationalization_desc'); ?></li>
<li><strong><?php _e('other_settings'); ?></strong> - <?php _e('other_settings_desc'); ?></li>
<li><strong><?php _e('site_security'); ?></strong> - <?php _e('site_security_desc'); ?></li>
<li><strong><?php _e('automation_settings'); ?></strong> - <?php _e('automation_settings_desc'); ?></li>
<li><strong><?php _e('graph_template_defaults'); ?></strong> - <?php _e('graph_template_defaults_desc'); ?></li>
</ul>

<p><?php _e('settings_documented_below'); ?></p>

<h2 id="log-settings"><?php _e('log_settings'); ?></h2>

<p><?php _e('log_settings_intro'); ?></p>

<p><img src="images/settings-general-log-settings.png" alt="<?php _e('log_settings'); ?>" /></p>

<p><?php _e('log_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('log_destination'); ?></strong> - <?php _e('log_destination_desc'); ?></p>
<ul>
<li><strong><?php _e('logfile_only'); ?></strong> - <?php _e('logfile_only_desc'); ?></li>
<li><strong><?php _e('logfile_and_syslog'); ?></strong> - <?php _e('logfile_and_syslog_desc'); ?></li>
<li><strong><?php _e('syslog_only'); ?></strong> - <?php _e('syslog_only_desc'); ?></li>
</ul>
<p><?php _e('log_destination_note'); ?></p></li>

<li><p><strong><?php _e('general_log_level'); ?></strong> - <?php _e('general_log_level_desc'); ?></p>
<ul>
<li><strong><?php _e('log_level_none'); ?></strong> - <?php _e('log_level_none_desc'); ?></li>
<li><strong><?php _e('log_level_low'); ?></strong> - <?php _e('log_level_low_desc'); ?></li>
<li><strong><?php _e('log_level_medium'); ?></strong> - <?php _e('log_level_medium_desc'); ?></li>
<li><strong><?php _e('log_level_high'); ?></strong> - <?php _e('log_level_high_desc'); ?></li>
<li><strong><?php _e('log_level_debug'); ?></strong> - <?php _e('log_level_debug_desc'); ?></li>
<li><strong><?php _e('log_level_devel'); ?></strong> - <?php _e('log_level_devel_desc'); ?></li>
</ul>
<p><?php _e('log_level_advice'); ?></p></li>

<li><p><strong><?php _e('log_input_validation'); ?></strong> - <?php _e('log_input_validation_desc'); ?></p></li>
<li><p><strong><?php _e('data_source_tracing'); ?></strong> - <?php _e('data_source_tracing_desc'); ?></p></li>
<li><p><strong><?php _e('selective_file_debug'); ?></strong> - <?php _e('selective_file_debug_desc'); ?></p></li>
<li><p><strong><?php _e('selective_plugin_debug'); ?></strong> - <?php _e('selective_plugin_debug_desc'); ?></p></li>
<li><p><strong><?php _e('device_debug'); ?></strong> - <?php _e('device_debug_desc'); ?></p></li>
<li><p><strong><?php _e('syslog_eventlog_selection'); ?></strong> - <?php _e('syslog_eventlog_selection_desc'); ?></p></li>
</ul>

<h2 id="internationalization-i18n"><?php _e('internationalization'); ?></h2>

<p><?php _e('internationalization_intro'); ?></p>

<p><img src="images/settings-general-i18n.png" alt="<?php _e('internationalization_settings'); ?>" /></p>

<p><?php _e('i18n_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('language_support'); ?></strong> - <?php _e('language_support_desc'); ?></p></li>
<li><p><strong><?php _e('language'); ?></strong> - <?php _e('language_desc'); ?></p></li>
<li><p><strong><?php _e('auto_language_detection'); ?></strong> - <?php _e('auto_language_detection_desc'); ?></p></li>
<li><p><strong><?php _e('preferred_language_processor'); ?></strong> - <?php _e('preferred_language_processor_desc'); ?></p></li>
<li><p><strong><?php _e('date_display_format'); ?></strong> - <?php _e('date_display_format_desc'); ?></p></li>
<li><p><strong><?php _e('date_separator'); ?></strong> - <?php _e('date_separator_desc'); ?></p></li>
</ul>

<h2 id="other-settings"><?php _e('other_settings'); ?></h2>

<p><?php _e('other_settings_intro'); ?></p>

<p><img src="images/settings-general-other-settings.png" alt="<?php _e('other_settings'); ?>" /></p>

<p><?php _e('other_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('has_graphs_data_sources_checked'); ?></strong> - <?php _e('has_graphs_data_sources_checked_desc'); ?></p></li>
<li><p><strong><?php _e('rrdtool_version'); ?></strong> - <?php _e('rrdtool_version_desc'); ?></p></li>
<li><p><strong><?php _e('graph_permission_method'); ?></strong> - <?php _e('graph_permission_method_desc'); ?></p></li>
<li><p><strong><?php _e('graph_data_source_creation_method'); ?></strong> - <?php _e('graph_data_source_creation_method_desc'); ?></p></li>
<li><p><strong><?php _e('show_form_setting_help_inline'); ?></strong> - <?php _e('show_form_setting_help_inline_desc'); ?></p></li>
<li><p><strong><?php _e('delete_verification'); ?></strong> - <?php _e('delete_verification_desc'); ?></p></li>
<li><p><strong><?php _e('data_source_preservation_preset'); ?></strong> - <?php _e('data_source_preservation_preset_desc'); ?></p></li>
<li><p><strong><?php _e('graph_auto_unlock'); ?></strong> - <?php _e('graph_auto_unlock_desc'); ?></p></li>
<li><p><strong><?php _e('hide_cacti_dashboard'); ?></strong> - <?php _e('hide_cacti_dashboard_desc'); ?></p></li>
<li><p><strong><?php _e('enable_drag_n_drop'); ?></strong> - <?php _e('enable_drag_n_drop_desc'); ?></p></li>
</ul>

<h2 id="site-security"><?php _e('site_security'); ?></h2>

<p><?php _e('site_security_intro'); ?></p>

<p><img src="images/settings-general-site-security.png" alt="<?php _e('site_security'); ?>" /></p>

<p><?php _e('site_security_include'); ?></p>

<ul>
<li><p><strong><?php _e('force_connections_https'); ?></strong> - <?php _e('force_connections_https_desc'); ?></p></li>
<li><p><strong><?php _e('content_security_unsafe_javascript'); ?></strong> - <?php _e('content_security_unsafe_javascript_desc'); ?></p></li>
<li><p><strong><?php _e('content_security_alternate_sources'); ?></strong> - <?php _e('content_security_alternate_sources_desc'); ?></p></li>
</ul>

<h2 id="automation-settings"><?php _e('automation_settings'); ?></h2>

<p><?php _e('automation_settings_intro'); ?></p>

<p><img src="images/settings-general-automation.png" alt="<?php _e('automation_settings'); ?>" /></p>

<p><?php _e('automation_settings_include'); ?></p>

<ul>
<li><p><strong><?php _e('enable_automatic_graph_creation'); ?></strong> - <?php _e('enable_automatic_graph_creation_desc'); ?></p></li>
<li><p><strong><?php _e('enable_automatic_tree_item_creation'); ?></strong> - <?php _e('enable_automatic_tree_item_creation_desc'); ?></p></li>
<li><p><strong><?php _e('automation_notification_to_email'); ?></strong> - <?php _e('automation_notification_to_email_desc'); ?></p></li>
<li><p><strong><?php _e('automation_notification_from_name'); ?></strong> - <?php _e('automation_notification_from_name_desc'); ?></p></li>
<li><p><strong><?php _e('automation_from_email'); ?></strong> - <?php _e('automation_from_email_desc'); ?></p></li>
</ul>

<h2 id="graph-template-defaults"><?php _e('graph_template_defaults'); ?></h2>

<p><?php _e('graph_template_defaults_intro'); ?></p>

<p><img src="images/settings-general-graph-template-defaults.png" alt="<?php _e('graph_template_defaults'); ?>" /></p>

<ul>
<li><p><strong><?php _e('graph_template_image_format'); ?></strong> - <?php _e('graph_template_image_format_desc'); ?></p>
<p><strong><?php _e('svg_format'); ?></strong> - <?php _e('svg_format_desc'); ?> <strong><?php _e('png_format'); ?></strong> - <?php _e('png_format_desc'); ?></p></li>
<li><p><strong><?php _e('graph_template_height'); ?></strong> - <?php _e('graph_template_height_desc'); ?></p></li>
<li><p><strong><?php _e('graph_template_width'); ?></strong> - <?php _e('graph_template_width_desc'); ?></p></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
