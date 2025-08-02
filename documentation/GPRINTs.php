<?php
/**
 * Cacti Documentation - GPRINTs
 * 
 * This page provides a comprehensive guide on GPRINTs in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_gprints', 'gprints', true);
?>

<h1 id="gprints"><?php _e('gprints_title'); ?></h1>

<p><?php _e('gprints_intro'); ?></p>

<p><?php _e('gprints_description'); ?></p>

<p><?php _e('gprints_formatting'); ?></p>

<p><?php _e('gprints_presets'); ?></p>

<p><?php _e('gprints_usage'); ?></p>

<p><img src="images/gprints.png" alt="<?php _e('gprints_title'); ?>" /></p>

<p><img src="images/gprints-edit1.png" alt="GPRINTs Edit" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
