<?php
/**
 * Cacti Documentation - Data Source Templates
 * 
 * This page provides a comprehensive guide on data source templates in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_data_source_templates', 'data_source_templates', true);
?>

<h1 id="data-source-templates"><?php _e('data_source_templates_title'); ?></h1>

<p><?php _e('data_source_templates_intro'); ?></p>

<p><?php _e('data_source_templates_poller'); ?></p>

<p><?php _e('data_source_templates_graph'); ?></p>

<p><?php _e('data_source_templates_association'); ?></p>

<p><?php _e('data_source_templates_examples'); ?></p>

<p><?php _e('data_source_templates_creation'); ?></p>

<p><?php _e('data_source_templates_indexed'); ?></p>

<p><?php _e('data_source_templates_types'); ?> <a href="https://oss.oetiker.ch/rrdtool/doc/rrdcreate.en.html"><?php _e('rrd_tool_create_function'); ?></a></p>

<h2 id="gauge"><?php _e('gauge_title'); ?></h2>

<p><?php _e('gauge_desc'); ?></p>

<h2 id="counter"><?php _e('counter_title'); ?></h2>

<p><?php _e('counter_desc'); ?></p>

<p><?php _e('counter_storage'); ?></p>

<h2 id="dcounter"><?php _e('dcounter_title'); ?></h2>

<p><?php _e('dcounter_desc'); ?></p>

<p><?php _e('dcounter_direction'); ?></p>

<h2 id="derive"><?php _e('derive_title'); ?></h2>

<p><?php _e('derive_desc'); ?></p>

<h2 id="dderive"><?php _e('dderive_title'); ?></h2>

<p><?php _e('dderive_desc'); ?></p>

<blockquote>
<p><strong><?php _e('counter_vs_derive_note'); ?></strong></p>
<p><?php _e('counter_vs_derive_author'); ?></p>
<p><?php _e('counter_vs_derive_advice'); ?></p>
<p><?php _e('counter_vs_derive_probability'); ?></p>
</blockquote>

<h2 id="absolute"><?php _e('absolute_title'); ?></h2>

<p><?php _e('absolute_desc'); ?></p>

<h2 id="compute"><?php _e('compute_title'); ?></h2>

<p><?php _e('compute_desc'); ?></p>

<p><img src="images/datasource-template-create.png" alt="Data-Source-Templates" /></p>

<p><?php _e('data_source_templates_variables'); ?> <a href="https://github.com/Cacti/documentation/blob/develop/Variables.html"><?php _e('variables_documentation'); ?></a> <?php _e('data_source_templates_variables_page'); ?></p>

<p><img src="images/datasource-template.png" alt="Data-Source-Templates" /></p>

<p><?php _e('data_source_templates_internal_name'); ?></p>

<p><img src="images/datasource-template2.png" alt="Data-Source-Templates" /></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
