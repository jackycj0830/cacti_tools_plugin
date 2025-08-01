<?php
/**
 * Cacti Documentation - Site Management
 * 
 * This page provides a comprehensive guide on site management in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_sites', 'sites', true);
?>

<h1 id="site-management"><?php _e('sites_title'); ?></h1>

<p><?php _e('sites_intro'); ?></p>

<p><?php _e('sites_purpose'); ?></p>

<p><img src="images/sites.png" alt="<?php _e('sites_page_image_desc'); ?>" />.</p>

<p><?php _e('sites_attribute_data'); ?></p>

<p><?php _e('sites_create_instruction'); ?></p>

<p><img src="images/add-site.png" alt="<?php _e('sites_add_image_desc'); ?>" />.</p>

<p><?php _e('sites_device_association'); ?></p>

<p><img src="images/add-device-site.png" alt="<?php _e('sites_device_site_image_desc'); ?>" />.</p>

<p><?php _e('sites_automation_association'); ?></p>

<p><img src="images/site-automation.png" alt="<?php _e('sites_automation_image_desc'); ?>" />.</p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
