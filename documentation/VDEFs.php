<?php
/**
 * Cacti Documentation - VDEFs
 * 
 * This page provides a comprehensive guide on VDEFs in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_vdefs', 'vdefs', true);
?>

<h1 id="vdefs"><?php _e('vdefs_title'); ?></h1>

<p><?php _e('vdefs_intro'); ?></p>

<p><?php _e('vdefs_description'); ?></p>

<p><?php _e('vdefs_usage'); ?></p>

<p><img src="images/vdefs.png" alt="<?php _e('vdefs_title'); ?>" /></p>

<p><img src="images/vdefs-edit1.png" alt="VDEFs Edit" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
