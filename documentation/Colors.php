<?php
/**
 * Cacti Documentation - Colors
 * 
 * This page provides a comprehensive guide on colors in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_colors', 'colors', true);
?>

<h1 id="colors"><?php _e('colors_title'); ?></h1>

<p><?php _e('colors_intro'); ?></p>

<p><?php _e('colors_description'); ?></p>

<p><?php _e('colors_management'); ?></p>

<p><?php _e('colors_hex_values'); ?></p>

<p><img src="images/colors.png" alt="<?php _e('colors_title'); ?>" /></p>

<p><img src="images/colors-edit1.png" alt="Colors Edit" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
