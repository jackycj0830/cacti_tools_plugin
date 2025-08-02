<?php
/**
 * Cacti Documentation - Reports User
 * 
 * This page provides comprehensive information about Reports User in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_reports_user', 'reports_user', true);
?>

<h1 id="reports-user"><?php _e('reports_user_title'); ?></h1>

<p><?php _e('reports_user_intro'); ?></p>

<p><?php _e('reports_user_description'); ?></p>

<p><img src="images/reports-user.png" alt="<?php _e('reports_user_title'); ?>" /></p>

<h2 id="viewing-reports"><?php _e('viewing_reports'); ?></h2>

<p><?php _e('viewing_reports_intro'); ?></p>

<ul>
<li><strong><?php _e('report_list'); ?></strong> - <?php _e('report_list_desc'); ?></li>
<li><strong><?php _e('report_preview'); ?></strong> - <?php _e('report_preview_desc'); ?></li>
<li><strong><?php _e('report_download'); ?></strong> - <?php _e('report_download_desc'); ?></li>
<li><strong><?php _e('report_email'); ?></strong> - <?php _e('report_email_desc'); ?></li>
</ul>

<h2 id="report-subscriptions"><?php _e('report_subscriptions'); ?></h2>

<p><?php _e('report_subscriptions_intro'); ?></p>

<ul>
<li><strong><?php _e('subscribe_report'); ?></strong> - <?php _e('subscribe_report_desc'); ?></li>
<li><strong><?php _e('unsubscribe_report'); ?></strong> - <?php _e('unsubscribe_report_desc'); ?></li>
<li><strong><?php _e('subscription_preferences'); ?></strong> - <?php _e('subscription_preferences_desc'); ?></li>
</ul>

<h2 id="report-history"><?php _e('report_history'); ?></h2>

<p><?php _e('report_history_intro'); ?></p>

<ul>
<li><strong><?php _e('historical_reports'); ?></strong> - <?php _e('historical_reports_desc'); ?></li>
<li><strong><?php _e('report_archive'); ?></strong> - <?php _e('report_archive_desc'); ?></li>
<li><strong><?php _e('report_search'); ?></strong> - <?php _e('report_search_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
