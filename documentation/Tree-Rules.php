<?php
/**
 * Cacti Documentation - Tree Rules
 * 
 * This page provides a comprehensive guide on tree rules in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_tree_rules', 'tree_rules', true);
?>

<h1 id="tree-rules"><?php _e('tree_rules_title'); ?></h1>

<p><?php _e('tree_rules_intro'); ?></p>

<p><?php _e('tree_rules_creation'); ?></p>

<p><?php _e('tree_rules_matching'); ?></p>

<p><?php _e('tree_rules_hierarchy'); ?></p>

<p><img src="images/automation-tree-rules.png" alt="Tree Rules" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
