<?php
/**
 * Cacti Documentation - Graph Rules
 * 
 * This page provides a comprehensive guide on graph rules in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_graph_rules', 'graph_rules', true);
?>

<h1 id="graph-rules"><?php _e('graph_rules_title'); ?></h1>

<p><?php _e('graph_rules_intro'); ?></p>

<p><?php _e('graph_rules_creation'); ?></p>

<p><?php _e('graph_rules_matching'); ?></p>

<p><?php _e('graph_rules_types'); ?></p>

<p><img src="images/automation-graph-rules.png" alt="Graph Rules" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
