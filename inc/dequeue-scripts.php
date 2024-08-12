<?php
function remove_unused_scripts()
{
    wp_dequeue_script('powertip');
}
add_action('wp_enqueue_scripts', 'remove_unused_scripts', 150);
