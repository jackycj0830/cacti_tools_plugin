<?php
/**
 * Cacti Documentation - Template Export
 * 
 * This page provides a comprehensive guide on template export in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_export_template', 'export_template', true);
?>

<h1 id="template-exporting"><?php _e('export_template_title'); ?></h1>

<p><?php _e('export_template_intro'); ?></p>

<p><img src="images/export-template.png" alt="<?php _e('import_template_title'); ?>" /></p>

<p><?php _e('export_template_guid'); ?></p>

<p><?php _e('export_template_components'); ?></p>

<ol>
<li><?php _e('export_template_component_1'); ?></li>
<li><?php _e('export_template_component_2'); ?></li>
<li><?php _e('export_template_component_3'); ?></li>
<li><?php _e('export_template_component_4'); ?></li>
<li><?php _e('export_template_component_5'); ?></li>
<li><?php _e('export_template_component_6'); ?></li>
<li><?php _e('export_template_component_7'); ?></li>
<li><?php _e('export_template_component_8'); ?></li>
</ol>

<p><?php _e('export_template_encoding'); ?></p>

<p><?php _e('export_template_format'); ?></p>

<div class="sourceCode" id="cb1"><pre class="sourceCode xml"><code class="sourceCode xml">
<a class="sourceLine" id="cb1-1" title="1"><span class="kw">&lt;cacti&gt;</span></a>
<a class="sourceLine" id="cb1-2" title="2">    <span class="kw">&lt;hash_0201022d3e47f416738c2d22c87c40218cc55e&gt;</span></a>
<a class="sourceLine" id="cb1-3" title="3">        <span class="kw">&lt;name&gt;</span>Local Linux Machine<span class="kw">&lt;/name&gt;</span></a>
<a class="sourceLine" id="cb1-4" title="4">        <span class="kw">&lt;graph_templates&gt;</span>hash_0001029fe8b4da353689d376b99b2ea526cc6b|hash_000102fe5edd777a76d48fc48c11aded5211ef|hash_00010263610139d44d52b195cc375636653ebd|hash_0001026992ed4df4b44f3d5595386b8298f0ec<span class="kw">&lt;/graph_templates&gt;</span></a>
<a class="sourceLine" id="cb1-5" title="5">        <span class="kw">&lt;data_queries&gt;</span>hash_0401028ffa36c1864124b38bcda2ae9bd61f46<span class="kw">&lt;/data_queries&gt;</span></a>
<a class="sourceLine" id="cb1-6" title="6">    <span class="kw">&lt;/hash_0201022d3e47f416738c2d22c87c40218cc55e&gt;</span></a>
<a class="sourceLine" id="cb1-7" title="7">    <span class="kw">&lt;hash_0001029fe8b4da353689d376b99b2ea526cc6b&gt;</span></a>
<a class="sourceLine" id="cb1-8" title="8">        <span class="kw">&lt;name&gt;</span>Unix - Processes<span class="kw">&lt;/name&gt;</span></a>
<a class="sourceLine" id="cb1-9" title="9">        <span class="kw">&lt;graph&gt;</span></a>
<a class="sourceLine" id="cb1-10" title="10">            <span class="kw">&lt;t_title&gt;&lt;/t_title&gt;</span></a>
<a class="sourceLine" id="cb1-11" title="11">            <span class="kw">&lt;title&gt;</span>|host_description| - Processes<span class="kw">&lt;/title&gt;</span></a>
<a class="sourceLine" id="cb1-12" title="12">            <span class="kw">&lt;t_vertical_label&gt;&lt;/t_vertical_label&gt;</span></a>
<a class="sourceLine" id="cb1-13" title="13">            <span class="kw">&lt;vertical_label&gt;</span>processes<span class="kw">&lt;/vertical_label&gt;</span></a>
</code></pre></div>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
