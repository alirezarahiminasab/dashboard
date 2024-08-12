<?php
function add_categories_to_custom_post_type()
{
    register_taxonomy_for_object_type('category', 'tp_event');
}
add_action('init', 'add_categories_to_custom_post_type');
