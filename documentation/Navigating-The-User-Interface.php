<?php
/**
 * Cacti Documentation - Navigating the User Interface
 * 
 * This page explains how to navigate the Cacti user interface
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_navigating_ui', 'navigating_ui', true);
?>

<h1 id="navigating-the-cacti-user-interface"><?php _e('navigating_ui_title'); ?></h1>

<p><?php _e('ui_intro'); ?></p>

<ul>
<li><strong><?php _e('top_tabs'); ?></strong> - <?php _e('top_tabs_desc'); ?></li>
<li><strong><?php _e('navigation_area'); ?></strong> - <?php _e('navigation_area_desc'); ?></li>
<li><strong><?php _e('breadcrumb_bar'); ?></strong> - <?php _e('breadcrumb_bar_desc'); ?></li>
<li><strong><?php _e('content_area'); ?></strong> - <?php _e('content_area_desc'); ?></li>
<li><strong><?php _e('footer'); ?></strong> - <?php _e('footer_desc'); ?></li>
</ul>

<p><?php _e('default_layout_desc'); ?></p>

<p><img src="images/navigation-layout.png" alt="Cacti Layout" /></p>

<p><?php _e('top_tabs_navigation'); ?></p>

<p><?php _e('sub_panels_desc'); ?></p>

<p><?php _e('device_page_example'); ?></p>

<p><img src="images/navigation-layout-subpanel.png" alt="Cacti Layout Subpanels" /></p>

<p><?php _e('content_control'); ?></p>

<p><?php _e('theme_requirements'); ?></p>

<p><?php _e('understanding_sections'); ?></p>

<h2 id="cacti-core-panels-and-sub-panels"><?php _e('core_panels_title'); ?></h2>

<ul>
<li><p><strong><?php _e('top_tabs'); ?></strong></p>
<p><?php _e('top_tabs_detail'); ?></p></li>

<li><p><strong><?php _e('breadcrumbs'); ?></strong></p>
<p><?php _e('breadcrumbs_detail'); ?></p></li>

<li><p><strong><?php _e('cacti_content_area'); ?></strong></p>
<p><?php _e('content_area_detail'); ?></p></li>

<li><p><strong><?php _e('navigation_menu'); ?></strong></p>
<p><?php _e('navigation_menu_detail'); ?></p></li>

<li><p><strong><?php _e('cacti_tables'); ?></strong></p>
<p><?php _e('cacti_tables_detail'); ?></p></li>

<li><p><strong><?php _e('table_filters'); ?></strong></p>
<p><?php _e('table_filters_detail'); ?></p></li>

<li><p><strong><?php _e('actions_dropdown'); ?></strong></p>
<p><?php _e('actions_dropdown_detail'); ?></p></li>

<li><p><strong><?php _e('user_profile_menu'); ?></strong></p>
<p><?php _e('user_profile_menu_detail'); ?></p></li>
</ul>

<p><?php _e('non_admin_access'); ?></p>

<h2 id="the-cacti-graphs-top-tab"><?php _e('graphs_top_tab_title'); ?></h2>

<p><?php _e('graphs_top_tab_desc'); ?></p>

<ul>
<li><p><strong><?php _e('tree_view'); ?></strong></p>
<p><?php _e('tree_view_desc'); ?></p></li>

<li><p><strong><?php _e('preview_view'); ?></strong></p>
<p><?php _e('preview_view_desc'); ?></p></li>

<li><p><strong><?php _e('list_view'); ?></strong></p>
<p><?php _e('list_view_desc'); ?></p></li>
</ul>

<p><?php _e('tree_view_example'); ?></p>

<p><img src="images/tree-view-page.png" alt="Cacti Tree View Page" /></p>

<h2 id="the-cacti-console"><?php _e('console_title'); ?></h2>

<p><?php _e('console_intro'); ?></p>

<p><img src="images/navigation-console.png" alt="Cacti Console" /></p>

<ul>
<li><strong><?php _e('main_console'); ?></strong> - <?php _e('main_console_desc'); ?></li>
<li><strong><?php _e('create'); ?></strong> - <?php _e('create_desc'); ?></li>
<li><strong><?php _e('management'); ?></strong> - <?php _e('management_desc'); ?></li>
<li><strong><?php _e('data_collection'); ?></strong> - <?php _e('data_collection_desc'); ?></li>
<li><strong><?php _e('templates'); ?></strong> - <?php _e('templates_desc'); ?></li>
<li><strong><?php _e('automation'); ?></strong> - <?php _e('automation_desc'); ?></li>
<li><strong><?php _e('presets'); ?></strong> - <?php _e('presets_desc'); ?></li>
<li><strong><?php _e('import_export'); ?></strong> - <?php _e('import_export_desc'); ?></li>
<li><strong><?php _e('configuration'); ?></strong> - <?php _e('configuration_desc'); ?></li>
<li><strong><?php _e('utilities'); ?></strong> - <?php _e('utilities_desc'); ?></li>
<li><strong><?php _e('troubleshooting'); ?></strong> - <?php _e('troubleshooting_desc'); ?></li>
</ul>

<p><?php _e('objects_explanation'); ?></p>

<?php
// Generate page footer
generatePageFooter();
?>
