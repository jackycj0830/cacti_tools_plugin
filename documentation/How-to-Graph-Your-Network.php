<?php
/**
 * Cacti Documentation - How to Graph Your Network
 * 
 * This page provides a comprehensive guide on how to graph your network
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_how_to_graph', 'how_to_graph', true);
?>

<h1 id="how-to-graph-your-network"><?php _e('how_to_graph_title'); ?></h1>

<p><?php _e('how_to_graph_intro'); ?></p>

<p><?php _e('basic_steps_intro'); ?></p>

<blockquote>
<p><?php _e('automation_note'); ?></p>
</blockquote>

<h2 id="creating-a-device"><?php _e('creating_device_title'); ?></h2>

<p><?php _e('creating_device_intro'); ?></p>

<p><?php _e('device_management_intro'); ?></p>

<p><img src="images/new-device.png" alt="Adding a New Device" /></p>

<h3 id="device-field-definitions"><?php _e('device_field_definitions'); ?></h3>

<ul>
<li><p><strong><?php _e('description_field'); ?></strong> - <?php _e('description_field_desc'); ?></p></li>
<li><p><strong><?php _e('hostname_field'); ?></strong> - <?php _e('hostname_field_desc'); ?></p></li>
<li><p><strong><?php _e('host_template_field'); ?></strong> - <?php _e('host_template_field_desc'); ?></p></li>
<li><p><strong><?php _e('notes_field'); ?></strong> - <?php _e('notes_field_desc'); ?></p></li>
<li><p><strong><?php _e('disable_host_field'); ?></strong> - <?php _e('disable_host_field_desc'); ?></p></li>
</ul>

<h3 id="availability-reachability-options"><?php _e('availability_reachability_options'); ?></h3>

<ul>
<li><p><strong><?php _e('downed_device_detection'); ?></strong></p>
<ul>
<li><em><strong><?php _e('detection_none'); ?></strong></em> - <?php _e('detection_none_desc'); ?></li>
<li><em><strong><?php _e('detection_ping_snmp'); ?></strong></em> - <?php _e('detection_ping_snmp_desc'); ?></li>
<li><em><strong><?php _e('detection_ping_or_snmp'); ?></strong></em> - <?php _e('detection_ping_or_snmp_desc'); ?></li>
<li><em><strong><?php _e('detection_snmp_uptime'); ?></strong></em> - <?php _e('detection_snmp_uptime_desc'); ?></li>
<li><em><strong><?php _e('detection_snmp_desc'); ?></strong></em> - <?php _e('detection_snmp_desc_desc'); ?></li>
<li><em><strong><?php _e('detection_snmp_getnext'); ?></strong></em> - <?php _e('detection_snmp_getnext_desc'); ?></li>
<li><em><strong><?php _e('detection_ping'); ?></strong></em> - <?php _e('detection_ping_desc'); ?></li>
</ul></li>

<li><p><strong><?php _e('ping_method'); ?></strong> - <?php _e('ping_method_desc'); ?></p>
<ul>
<li><em><strong><?php _e('ping_icmp'); ?></strong></em> - <?php _e('ping_icmp_desc'); ?></li>
<li><em><strong><?php _e('ping_udp'); ?></strong></em> - <?php _e('ping_udp_desc'); ?></li>
<li><em><strong><?php _e('ping_tcp'); ?></strong></em> - <?php _e('ping_tcp_desc'); ?></li>
</ul></li>

<li><p><strong><?php _e('ping_port'); ?></strong> - <?php _e('ping_port_desc'); ?></p></li>
<li><p><strong><?php _e('timeout_value'); ?></strong> - <?php _e('timeout_value_desc'); ?></p></li>
<li><p><strong><?php _e('ping_retry_count'); ?></strong> - <?php _e('ping_retry_count_desc'); ?></p></li>
</ul>

<h3 id="snmp-options"><?php _e('snmp_options_title'); ?></h3>

<ul>
<li><p><strong><?php _e('snmp_version'); ?></strong></p>
<ul>
<li><em><strong><?php _e('snmp_version_1'); ?></strong></em> - <?php _e('snmp_version_1_desc'); ?></li>
<li><em><strong><?php _e('snmp_version_2'); ?></strong></em> - <?php _e('snmp_version_2_desc'); ?></li>
<li><em><strong><?php _e('snmp_version_3'); ?></strong></em> - <?php _e('snmp_version_3_desc'); ?></li>
</ul></li>

<li><p><strong><?php _e('snmp_community'); ?></strong> - <?php _e('snmp_community_desc'); ?></p></li>
<li><p><strong><?php _e('snmp_port'); ?></strong> - <?php _e('snmp_port_desc'); ?></p></li>
<li><p><strong><?php _e('snmp_timeout'); ?></strong> - <?php _e('snmp_timeout_desc'); ?></p></li>
<li><p><strong><?php _e('max_oids_per_request'); ?></strong> - <?php _e('max_oids_per_request_desc'); ?></p></li>
</ul>

<h3 id="security-options-for-snmp-v3"><?php _e('snmp_v3_security_options'); ?></h3>

<ul>
<li><p><em><strong><?php _e('snmp_username'); ?></strong></em> - <?php _e('snmp_username_desc'); ?></p></li>
<li><p><em><strong><?php _e('snmp_password'); ?></strong></em> - <?php _e('snmp_password_desc'); ?></p></li>
<li><p><em><strong><?php _e('snmp_auth_protocol'); ?></strong></em> - <?php _e('snmp_auth_protocol_desc'); ?></p></li>
<li><p><em><strong><?php _e('snmp_privacy_passphrase'); ?></strong></em> - <?php _e('snmp_privacy_passphrase_desc'); ?></p></li>
<li><p><em><strong><?php _e('snmp_privacy_protocol'); ?></strong></em> - <?php _e('snmp_privacy_protocol_desc'); ?></p>
<p><?php _e('snmp_privacy_protocol_note'); ?></p></li>
<li><p><em><strong><?php _e('snmp_context'); ?></strong></em> - <?php _e('snmp_context_desc'); ?></p></li>
</ul>

<p><?php _e('device_creation_results'); ?></p>

<p><?php _e('associated_queries_templates'); ?></p>

<h3 id="a-word-about-snmp"><?php _e('word_about_snmp'); ?></h3>

<p><?php _e('snmp_version_choice'); ?></p>

<p><?php _e('snmp_retrieval_methods'); ?></p>

<h4 id="snmp-retrieval-types"><?php _e('snmp_retrieval_types'); ?></h4>

<table>
<thead>
<tr class="header">
<th><?php _e('snmp_type_column'); ?></th>
<th><?php _e('snmp_description_column'); ?></th>
<th><?php _e('snmp_supported_options_column'); ?></th>
<th><?php _e('snmp_where_used_column'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><?php _e('external_snmp'); ?></td>
<td><?php _e('external_snmp_desc'); ?></td>
<td><?php _e('external_snmp_options'); ?></td>
<td><?php _e('external_snmp_usage'); ?></td>
</tr>
<tr class="even">
<td><?php _e('internal_snmp'); ?></td>
<td><?php _e('internal_snmp_desc'); ?></td>
<td><?php _e('internal_snmp_options'); ?></td>
<td><?php _e('internal_snmp_usage'); ?></td>
</tr>
<tr class="odd">
<td><?php _e('spine_snmp'); ?></td>
<td><?php _e('spine_snmp_desc'); ?></td>
<td><?php _e('spine_snmp_options'); ?></td>
<td><?php _e('spine_snmp_usage'); ?></td>
</tr>
</tbody>
</table>

<h3 id="snmp-v3-options-explained"><?php _e('snmp_v3_options_explained'); ?></h3>

<p><?php _e('snmp_v3_intro'); ?></p>

<div class="sourceCode" id="cb1"><pre class="sourceCode sh"><code class="sourceCode bash">
<a class="sourceLine" id="cb1-1" title="1"><?php _e('snmp_v3_users_title'); ?></a>
<a class="sourceLine" id="cb1-2" title="2">    <?php _e('snmp_v3_createuser_syntax'); ?></a>
<a class="sourceLine" id="cb1-3" title="3"></a>
<a class="sourceLine" id="cb1-4" title="4">           <?php _e('snmp_v3_auth_types'); ?></a>
<a class="sourceLine" id="cb1-5" title="5"></a>
<a class="sourceLine" id="cb1-6" title="6">           <?php _e('snmp_v3_openssl_note'); ?></a>
<a class="sourceLine" id="cb1-7" title="7"></a>
<a class="sourceLine" id="cb1-8" title="8">           <?php _e('snmp_v3_passphrase_warning'); ?></a>
</code></pre></div>

<p><?php _e('vacm_intro'); ?></p>

<div class="sourceCode" id="cb2"><pre class="sourceCode sh"><code class="sourceCode bash">
<a class="sourceLine" id="cb2-1" title="1"><?php _e('vacm_configuration'); ?></a>
<a class="sourceLine" id="cb2-2" title="2">    <?php _e('vacm_intro'); ?></a>
<a class="sourceLine" id="cb2-3" title="3"></a>
<a class="sourceLine" id="cb2-4" title="4">    <?php _e('vacm_com2sec'); ?></a>
<a class="sourceLine" id="cb2-5" title="5">           <?php _e('vacm_com2sec_desc'); ?></a>
</code></pre></div>

<h2 id="creating-the-graphs"><?php _e('creating_graphs_title'); ?></h2>

<p><?php _e('creating_graphs_intro'); ?></p>

<p><img src="images/new-graphs.png" alt="Creating New Graphs" /></p>

<p><?php _e('new_graphs_concept'); ?></p>

<p><?php _e('data_query_considerations'); ?></p>

<p><?php _e('graph_creation_final_step'); ?></p>

<p><?php _e('graph_management_note'); ?></p>

<?php
// Generate page footer
generatePageFooter();
?>
