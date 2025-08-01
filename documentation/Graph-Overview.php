<?php
/**
 * Cacti Documentation - Graph Overview
 * 
 * This page provides an overview of graphs in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_graph_overview', 'graph_overview', true);
?>

<h1 id="graph-overview"><?php _e('graph_overview_title'); ?></h1>

<p><?php _e('graph_overview_intro'); ?></p>

<p><?php _e('graph_rrdtool_relation'); ?></p>

<p><?php _e('graph_templates_benefit'); ?></p>

<p><?php _e('graph_management_interface'); ?></p>

<p><img src="images/graph-management.png" alt="Graph Management Interface" /></p>

<p><?php _e('graph_management_features'); ?></p>

<p><?php _e('graph_edit_page'); ?></p>

<p><img src="images/graph-edit-templated.png" alt="Templated Graph Edit" /></p>

<p><?php _e('graph_template_limitations'); ?></p>

<p><img src="images/graph-edit-non-templated.png" alt="Non-Templated Graph Edit" /></p>

<p><?php _e('non_templated_graph_control'); ?></p>

<p><img src="images/graph-edit-non-templated-config.png" alt="Non-Templated Graph Configuration" /></p>

<p><?php _e('graph_settings_reference'); ?></p>

<?php
// Generate page footer
generatePageFooter();
?>
