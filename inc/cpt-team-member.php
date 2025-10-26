<?php

/**
 * Register Team member CPT
 *
 * @return void
 */
function argo_register_team_member_cpt(): void
{
    $labels = array(
        'name' => _x('Team Members', 'Post type general name', 'argo-theme'),
        'singular_name' => _x('Team Member', 'Post type singular name', 'argo-theme'),
        'menu_name' => _x('Team Members', 'Admin Menu text', 'argo-theme'),
        'name_admin_bar' => _x('Team Member', 'Add New on Toolbar', 'argo-theme'),
        'add_new' => __('Add New', 'argo-theme'),
        'add_new_item' => __('Add New Team Member', 'argo-theme'),
        'new_item' => __('New Team Member', 'argo-theme'),
        'edit_item' => __('Edit Team Member', 'argo-theme'),
        'view_item' => __('View Team Member', 'argo-theme'),
        'all_items' => __('All Team Members', 'argo-theme'),
        'search_items' => __('Search Team Members', 'argo-theme'),
        'parent_item_colon' => __('Parent Team Members:', 'argo-theme'),
        'not_found' => __('No team members found.', 'argo-theme'),
        'not_found_in_trash' => __('No team members found in Trash.', 'argo-theme'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'team'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    );

    register_post_type('team_member', $args);
}

add_action('init', 'argo_register_team_member_cpt');

/**
 * Register custom ACF blocks
 *
 * @return void
 */
function argo_register_acf_blocks(): void
{
    if (function_exists('acf_register_block_type')) {

        acf_register_block_type(array(
            'name' => 'team-member-detail',
            'title' => __('Team Member Detail'),
            'description' => __('A custom block to display a single team member.'),
            'render_template' => 'template-parts/blocks/team-member-detail.php',
            'category' => 'argo-blocks',
            'icon' => 'admin-users',
            'keywords' => array('team', 'member', 'detail', 'profile'),
        ));

        acf_register_block_type(array(
            'name' => 'team-member-grid',
            'title' => __('Team Member Grid'),
            'description' => __('A custom block to display a grid of team members.'),
            'render_template' => 'template-parts/blocks/team-member-grid.php',
            'category' => 'argo-blocks',
            'icon' => 'layout',
            'keywords' => array('team', 'member', 'grid', 'list'),
        ));
    }
}

add_action('acf/init', 'argo_register_acf_blocks');

/**
 * Register ACF group
 *
 * @return void
 */
function argo_register_acf_field_groups(): void
{
    if (function_exists('acf_add_local_field_group')):

        acf_add_local_field_group(array(
            'key' => 'group_team_member_details',
            'title' => 'Team Member Details',
            'fields' => array(
                array('key' => 'field_position', 'label' => 'Position', 'name' => 'position', 'type' => 'text', 'required' => 1),
                array('key' => 'field_description', 'label' => 'Description', 'name' => 'description', 'type' => 'wysiwyg'),
                array('key' => 'field_profile_image', 'label' => 'Profile Image', 'name' => 'profile_image', 'type' => 'image', 'return_format' => 'array'),
                array('key' => 'field_phone_number', 'label' => 'Phone Number', 'name' => 'phone_number', 'type' => 'text'),
                array('key' => 'field_email', 'label' => 'E-mail', 'name' => 'email', 'type' => 'email', 'required' => 1),
            ),
            'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'team_member'))),
        ));

        acf_add_local_field_group(array(
            'key' => 'group_block_team_detail',
            'title' => 'Block: Team Member Detail',
            'fields' => array(
                array(
                    'key' => 'field_select_team_member',
                    'label' => 'Select Team Member',
                    'name' => 'selected_team_member',
                    'type' => 'post_object',
                    'post_type' => array('team_member'),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'return_format' => 'id',
                    'ui' => 1,
                ),
            ),
            'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/team-member-detail'))),
        ));

        acf_add_local_field_group(array(
            'key' => 'group_block_team_grid',
            'title' => 'Block: Team Member Grid Settings',
            'fields' => array(
                array(
                    'key' => 'field_grid_columns',
                    'label' => 'Number of Columns',
                    'name' => 'grid_columns',
                    'type' => 'select',
                    'choices' => array('2' => '2', '3' => '3', '4' => '4'),
                    'allow_null' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_display_position',
                    'label' => 'Display Position',
                    'name' => 'display_position',
                    'type' => 'true_false',
                    'message' => 'Show the team member\'s position?',
                    'default_value' => 1,
                    'ui' => 1,
                ),
            ),
            'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/team-member-grid'))),
        ));

        acf_add_local_field_group(array(
            'key' => 'group_post_reviewer',
            'title' => 'Reviewer',
            'fields' => array(
                array(
                    'key' => 'field_reviewer',
                    'label' => 'Reviewer',
                    'name' => 'reviewer',
                    'type' => 'post_object',
                    'instructions' => 'Select a team member who reviewed this post.',
                    'post_type' => array('team_member'),
                    'allow_null' => 1,
                    'multiple' => 0,
                    'return_format' => 'id',
                    'ui' => 1,
                ),
            ),
            'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'post'))),
        ));

    endif;
}

add_action('acf/init', 'argo_register_acf_field_groups');