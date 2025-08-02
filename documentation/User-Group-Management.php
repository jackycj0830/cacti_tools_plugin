<?php
/**
 * Cacti Documentation - User Group Management
 * 
 * This page provides comprehensive information about User Group Management in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_user_group_management', 'user_group_management', true);
?>

<h1 id="user-group-management"><?php _e('user_group_management_title'); ?></h1>

<p><?php _e('user_group_management_intro'); ?></p>

<p><?php _e('user_group_management_description'); ?></p>

<p><img src="images/user-group-management.png" alt="<?php _e('user_group_management_title'); ?>" /></p>

<h2 id="creating-user-groups"><?php _e('creating_user_groups'); ?></h2>

<p><?php _e('creating_user_groups_intro'); ?></p>

<ul>
<li><strong><?php _e('group_name'); ?></strong> - <?php _e('group_name_desc'); ?></li>
<li><strong><?php _e('group_description'); ?></strong> - <?php _e('group_description_desc'); ?></li>
<li><strong><?php _e('group_enabled'); ?></strong> - <?php _e('group_enabled_desc'); ?></li>
</ul>

<h2 id="group-permissions"><?php _e('group_permissions'); ?></h2>

<p><?php _e('group_permissions_intro'); ?></p>

<ul>
<li><strong><?php _e('general_permissions'); ?></strong> - <?php _e('general_permissions_desc'); ?></li>
<li><strong><?php _e('realm_permissions'); ?></strong> - <?php _e('realm_permissions_desc'); ?></li>
<li><strong><?php _e('graph_permissions'); ?></strong> - <?php _e('graph_permissions_desc'); ?></li>
<li><strong><?php _e('device_permissions'); ?></strong> - <?php _e('device_permissions_desc'); ?></li>
<li><strong><?php _e('template_permissions'); ?></strong> - <?php _e('template_permissions_desc'); ?></li>
</ul>

<h2 id="group-membership"><?php _e('group_membership'); ?></h2>

<p><?php _e('group_membership_intro'); ?></p>

<ul>
<li><strong><?php _e('add_users_to_group'); ?></strong> - <?php _e('add_users_to_group_desc'); ?></li>
<li><strong><?php _e('remove_users_from_group'); ?></strong> - <?php _e('remove_users_from_group_desc'); ?></li>
<li><strong><?php _e('group_inheritance'); ?></strong> - <?php _e('group_inheritance_desc'); ?></li>
</ul>

<h2 id="group-policies"><?php _e('group_policies'); ?></h2>

<p><?php _e('group_policies_intro'); ?></p>

<ul>
<li><strong><?php _e('policy_graphs'); ?></strong> - <?php _e('policy_graphs_desc'); ?></li>
<li><strong><?php _e('policy_trees'); ?></strong> - <?php _e('policy_trees_desc'); ?></li>
<li><strong><?php _e('policy_devices'); ?></strong> - <?php _e('policy_devices_desc'); ?></li>
<li><strong><?php _e('policy_graph_templates'); ?></strong> - <?php _e('policy_graph_templates_desc'); ?></li>
</ul>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
