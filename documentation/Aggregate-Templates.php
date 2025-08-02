<?php
/**
 * Cacti Documentation - Aggregate Templates
 * 
 * This page provides a comprehensive guide on aggregate templates in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_aggregate_templates', 'aggregate_templates', true);
?>

<h1 id="aggregate-templates"><?php _e('aggregate_templates_title'); ?></h1>

<h2 id="aggregate-overview"><?php _e('aggregate_overview_title'); ?></h2>

<p><?php _e('aggregate_templates_intro'); ?></p>

<p><?php _e('aggregate_templates_creation'); ?></p>

<p><?php _e('aggregate_templates_behavior'); ?></p>

<p><?php _e('aggregate_templates_changes'); ?></p>

<h2 id="aggregate-template-interface"><?php _e('aggregate_template_interface_title'); ?></h2>

<p><?php _e('aggregate_template_interface_desc'); ?></p>

<p><img src="images/aggregate-templates.png" alt="Aggregate Templates" /></p>

<p><?php _e('aggregate_template_edit_desc'); ?></p>

<p><?php _e('aggregate_template_prefix'); ?></p>

<p><?php _e('aggregate_graph_types'); ?></p>

<ul>
<li><?php _e('keep_graph_types'); ?></li>
<li><?php _e('keep_type_and_stack'); ?></li>
<li><?php _e('convert_to_area_stack'); ?></li>
<li><?php _e('convert_to_line1'); ?></li>
<li><?php _e('convert_to_line2'); ?></li>
<li><?php _e('convert_to_line3'); ?></li>
<li><?php _e('convert_to_line1_stack'); ?></li>
<li><?php _e('convert_to_line2_stack'); ?></li>
<li><?php _e('convert_to_line3_stack'); ?></li>
</ul>

<p><?php _e('totaling_setting'); ?></p>

<ul>
<li><?php _e('no_totals'); ?></li>
<li><?php _e('print_all_legend_items'); ?></li>
<li><?php _e('print_totaling_legend_items'); ?></li>
</ul>

<p><?php _e('total_type_setting'); ?></p>

<ul>
<li><?php _e('total_similar_data_sources'); ?></li>
<li><?php _e('total_all_data_sources'); ?></li>
</ul>

<p><?php _e('prefix_gprint_totals'); ?></p>

<p><?php _e('reorder_type_setting'); ?></p>

<ul>
<li><?php _e('no_reordering'); ?></li>
<li><?php _e('data_source_graph_order'); ?></li>
<li><?php _e('graph_data_source_order'); ?></li>
<li><?php _e('base_graph_order'); ?></li>
</ul>

<p><img src="images/aggregate-templates-edit1.png" alt="Aggregate Templates Edit General Options" /></p>

<p><?php _e('graph_template_items_section'); ?></p>

<p><?php _e('color_template_option'); ?></p>

<p><img src="images/aggregate-templates-edit2.png" alt="Aggregate Templates Edit Canvas Options" /></p>

<p><?php _e('aggregate_override_sections'); ?></p>

<p><img src="images/aggregate-templates-edit3.png" alt="Aggregate Templates Edit Common Options" /></p>

<p><img src="images/aggregate-templates-edit4.png" alt="Aggregate Templates Edit Scaling Options" /></p>

<p><img src="images/aggregate-templates-edit5.png" alt="Aggregate Templates Edit Grid Options" /></p>

<p><img src="images/aggregate-templates-edit6.png" alt="Aggregate Templates Edit Axis Options" /></p>

<p><img src="images/aggregate-templates-edit7.png" alt="Aggregate Templates Edit Legend Options" /></p>

<h2 id="summary"><?php _e('aggregate_summary_title'); ?></h2>

<p><?php _e('aggregate_summary_desc'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
