<?php
/**
 * Cacti Documentation - Frequently Asked Questions
 * 
 * This page provides comprehensive information about Frequently Asked Questions in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_frequently_asked_questions', 'frequently_asked_questions', true);
?>

<h1 id="frequently-asked-questions"><?php _e('frequently_asked_questions_title'); ?></h1>

<p><?php _e('frequently_asked_questions_intro'); ?></p>

<p><?php _e('frequently_asked_questions_description'); ?></p>

<p><img src="images/faq.png" alt="<?php _e('frequently_asked_questions_title'); ?>" /></p>

<p><?php _e('frequently_asked_questions_note'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
