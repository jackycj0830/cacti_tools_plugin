<?php
/**
 * Cacti Documentation - User Management
 * 
 * This page provides comprehensive information about User Management in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_user_management', 'user_management', true);
?>

<h1 id="user-management"><?php _e('user_management_title'); ?></h1>

<p><?php _e('user_management_intro'); ?></p>

<p><?php _e('user_management_description'); ?></p>

<p><img src="images/user-management.png" alt="<?php _e('user_management_title'); ?>" /></p>

<p><?php _e('user_management_note'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
