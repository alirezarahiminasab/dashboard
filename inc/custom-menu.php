<?php
// Add custom fields to menu item
function my_custom_menu_item($item_id, $item, $depth, $args)
{
    // Create a custom field for the icon class
    $icon_class = get_post_meta($item_id, '_menu_item_icon', true);
    $css_class = get_post_meta($item_id, '_menu_item_css', true);
?>
    <p class="description description-wide">
        <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">
            <?php _e('Icon Class (e.g., fa fa-home)', 'textdomain'); ?><br />
            <input type="text" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($icon_class); ?>" />
        </label>
        <label for="edit-menu-item-css-<?php echo esc_attr($item_id); ?>">
            <?php _e('link Class', 'textdomain'); ?><br />
            <input type="text" id="edit-menu-item-css-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-css[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($css_class); ?>" />
        </label>
    </p>
<?php
}

add_action('wp_nav_menu_item_custom_fields', 'my_custom_menu_item', 10, 4);

// Save custom field value
function my_update_custom_menu_item($menu_id, $menu_item_db_id, $args)
{
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_icon', sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]));
    }

    if (isset($_POST['menu-item-css'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_css', sanitize_text_field($_POST['menu-item-css'][$menu_item_db_id]));
    }
}

add_action('wp_update_nav_menu_item', 'my_update_custom_menu_item', 10, 3);


class Icon_Walker_Nav_Menu extends Walker_Nav_Menu
{
    // Start of an element. Output the icon and title.
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $icon = get_post_meta($item->ID, '_menu_item_icon', true); // Assume we're storing our icon data as post meta
        $css = get_post_meta($item->ID, '_menu_item_css', true);
        $title = $item->title;

        // Check if there is an icon for the menu item
        if ($icon) {
            $icon_html = '<i class="' . esc_attr($icon) . '"></i> ';
        } else {
            $icon_html = '';
        }

        $output .= sprintf(
            '<li><a href="%s" class="%s">%s%s</a></li>',
            esc_url($item->url),
            $css,
            $icon_html,
            esc_html($title)
        );
    }
}
