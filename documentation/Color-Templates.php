<?php
/**
 * Cacti Documentation - Color Templates
 * 
 * This page provides a comprehensive guide on color templates in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_color_templates', 'color_templates', true);
?>

<h1 id="color-templates"><?php _e('color_templates_title'); ?></h1>

<p><?php _e('color_templates_intro'); ?></p>

<p><?php _e('color_templates_example'); ?></p>

<p><?php _e('color_templates_standard'); ?></p>

<p><img src="images/color-templates.png" alt="Color Templates" /></p>

<p><?php _e('color_templates_edit_screen'); ?></p>

<p><img src="images/color-templates-edit1.png" alt="Color Templates Edit" /></p>

<p><?php _e('color_templates_cacti_colors'); ?></p>

<p><img src="images/color-templates-edit2.png" alt="Color Templates Item Edit" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
