<?php
/**
 * Cacti Documentation - Reports Admin
 * 
 * This page provides comprehensive information about Reports Admin in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_reports_admin', 'reports_admin', true);
?>

<h1 id="reports-admin"><?php _e('reports_admin_title'); ?></h1>

<p><?php _e('reports_admin_intro'); ?></p>

<p><?php _e('reports_admin_description'); ?></p>

<p><img src="images/reports-admin.png" alt="<?php _e('reports_admin_title'); ?>" /></p>

<h2 id="report-management"><?php _e('report_management'); ?></h2>

<p><?php _e('report_management_intro'); ?></p>

<ul>
<li><strong><?php _e('create_report'); ?></strong> - <?php _e('create_report_desc'); ?></li>
<li><strong><?php _e('edit_report'); ?></strong> - <?php _e('edit_report_desc'); ?></li>
<li><strong><?php _e('delete_report'); ?></strong> - <?php _e('delete_report_desc'); ?></li>
<li><strong><?php _e('duplicate_report'); ?></strong> - <?php _e('duplicate_report_desc'); ?></li>
</ul>

<h2 id="report-scheduling"><?php _e('report_scheduling'); ?></h2>

<p><?php _e('report_scheduling_intro'); ?></p>

<ul>
<li><strong><?php _e('schedule_frequency'); ?></strong> - <?php _e('schedule_frequency_desc'); ?></li>
<li><strong><?php _e('schedule_time'); ?></strong> - <?php _e('schedule_time_desc'); ?></li>
<li><strong><?php _e('schedule_recipients'); ?></strong> - <?php _e('schedule_recipients_desc'); ?></li>
<li><strong><?php _e('schedule_format'); ?></strong> - <?php _e('schedule_format_desc'); ?></li>
</ul>

<h2 id="report-templates"><?php _e('report_templates'); ?></h2>

<p><?php _e('report_templates_intro'); ?></p>

<ul>
<li><strong><?php _e('template_management'); ?></strong> - <?php _e('template_management_desc'); ?></li>
<li><strong><?php _e('template_customization'); ?></strong> - <?php _e('template_customization_desc'); ?></li>
<li><strong><?php _e('template_sharing'); ?></strong> - <?php _e('template_sharing_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
