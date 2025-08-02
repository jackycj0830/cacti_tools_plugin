<?php
/**
 * Cacti Documentation - External Links
 * 
 * This page provides comprehensive information about External Links in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_external_links', 'external_links', true);
?>

<h1 id="external-links"><?php _e('external_links_title'); ?></h1>

<p><?php _e('external_links_intro'); ?></p>

<p><?php _e('external_links_description'); ?></p>

<p><img src="images/external-links.png" alt="<?php _e('external_links_title'); ?>" /></p>

<h2 id="link-management"><?php _e('link_management'); ?></h2>

<p><?php _e('link_management_intro'); ?></p>

<ul>
<li><strong><?php _e('add_external_link'); ?></strong> - <?php _e('add_external_link_desc'); ?></li>
<li><strong><?php _e('edit_external_link'); ?></strong> - <?php _e('edit_external_link_desc'); ?></li>
<li><strong><?php _e('delete_external_link'); ?></strong> - <?php _e('delete_external_link_desc'); ?></li>
</ul>

<h2 id="link-configuration"><?php _e('link_configuration'); ?></h2>

<p><?php _e('link_configuration_intro'); ?></p>

<ul>
<li><strong><?php _e('link_title'); ?></strong> - <?php _e('link_title_desc'); ?></li>
<li><strong><?php _e('link_url'); ?></strong> - <?php _e('link_url_desc'); ?></li>
<li><strong><?php _e('link_style'); ?></strong> - <?php _e('link_style_desc'); ?></li>
<li><strong><?php _e('link_enabled'); ?></strong> - <?php _e('link_enabled_desc'); ?></li>
</ul>

<h2 id="link-categories"><?php _e('link_categories'); ?></h2>

<p><?php _e('link_categories_intro'); ?></p>

<ul>
<li><strong><?php _e('console_links'); ?></strong> - <?php _e('console_links_desc'); ?></li>
<li><strong><?php _e('graph_links'); ?></strong> - <?php _e('graph_links_desc'); ?></li>
<li><strong><?php _e('device_links'); ?></strong> - <?php _e('device_links_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
