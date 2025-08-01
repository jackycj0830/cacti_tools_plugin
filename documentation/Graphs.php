<?php
/**
 * Cacti Documentation - Graph Management
 * 
 * This page provides a comprehensive guide on graph management in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_graphs', 'graphs', true);
?>

<h1 id="graph-management"><?php _e('graphs_title'); ?></h1>

<p><?php _e('graphs_intro'); ?></p>

<p><?php _e('graphs_console_view'); ?></p>

<p><img src="images/graph-management.png" alt="<?php _e('graph_management_image_desc'); ?>" /></p>

<p><?php _e('graphs_menu_description'); ?></p>

<p><img src="images/graph-management-graph.png" alt="<?php _e('graph_management_click_desc'); ?>" /></p>

<h3 id="modifying-the-graph-template"><?php _e('modifying_graph_template_title'); ?></h3>

<p><?php _e('modifying_graph_template_desc'); ?></p>

<p><img src="images/graph-template-options.png" alt="<?php _e('graph_template_options_desc'); ?>" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
