<?php
add_action('init', 'add_custom_roles');

function add_custom_roles()
{
    // Check if the role doesn't exist before adding it
    if (!get_role('student')) {
        add_role(
            'student',
            'Student',
            array(
                'read'         => true,  // Allows a user to read
                'edit_posts'   => true,  // Allows user to edit their own posts
                'delete_posts' => false, // Doesn't allow user to delete their own posts
            )
        );
    }

    if (!get_role('teacher')) {
        add_role(
            'teacher',
            'Teacher',
            array(
                'read'         => true,  // Allows a user to read
                'edit_posts'   => true,  // Allows user to edit their own posts
                'delete_posts' => false, // Doesn't allow user to delete their own posts
            )
        );
    }
}


function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'remove_admin_bar');
