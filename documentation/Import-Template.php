<?php
/**
 * Cacti Documentation - Template Import
 * 
 * This page provides a comprehensive guide on template import in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_import_template', 'import_template', true);
?>

<h1 id="template-import"><?php _e('import_template_title'); ?></h1>

<p><?php _e('import_template_intro'); ?></p>

<p><?php _e('import_template_description'); ?></p>

<p><?php _e('import_template_process'); ?></p>

<p><img src="images/import-template.png" alt="<?php _e('import_template_title'); ?>" /></p>

<blockquote>
<p><?php _e('import_template_important_note'); ?></p>
</blockquote>

<p><?php _e('import_template_select_file'); ?></p>

<p><?php _e('import_template_remove_orphans'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
