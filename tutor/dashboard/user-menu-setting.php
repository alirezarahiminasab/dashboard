<?php

global $wp_query;

$dashboard_page_slug = '';
$dashboard_page_name = '';
if (isset($wp_query->query_vars['tutor_dashboard_page']) && $wp_query->query_vars['tutor_dashboard_page']) {
    $dashboard_page_slug = $wp_query->query_vars['tutor_dashboard_page'];
    $dashboard_page_name = $wp_query->query_vars['tutor_dashboard_page'];
}
/**
 * Getting dashboard sub pages
 */
if (isset($wp_query->query_vars['tutor_dashboard_sub_page']) && $wp_query->query_vars['tutor_dashboard_sub_page']) {
    $dashboard_page_name = $wp_query->query_vars['tutor_dashboard_sub_page'];
    if ($dashboard_page_slug) {
        $dashboard_page_name = $dashboard_page_slug . '/' . $dashboard_page_name;
    }
}
?>

<div class="user-setting-content">
    <ul class="user-setting-permalinks">
        <?php
        $dashboard_pages = add_items_to_menu();

        foreach ($dashboard_pages as $dashboard_key => $dashboard_page) :
            if (isset($dashboard_page['auth_cap'])) :
                continue;
            endif;
            $menu_title = $dashboard_page['title'];
            $menu_icon = $dashboard_page['icon'];
            $menu_activation = $dashboard_page['active'];

            $sub_menu = !empty($dashboard_page['sub_menu']) ? $dashboard_page['sub_menu'] : '';
            if (empty($sub_menu)) {
                $menu_link  = $dashboard_key !== "logout" ? tutils()->get_tutor_dashboard_page_permalink($dashboard_key) : wp_logout_url(home_url());
            }

            $separator  = false;
            if (is_array($dashboard_page)) {
                $menu_title = tutils()->array_get('title', $dashboard_page);

                /**
                 * Add new menu item property "url" for custom link
                 *
                 * @since v 1.5.5
                 */
                if (isset($dashboard_page['url'])) {
                    $menu_link = $dashboard_page['url'];
                }

                if (isset($dashboard_page['type']) && $dashboard_page['type'] == 'separator') {
                    $separator = true;
                }
            }

            if ($separator) {
                echo '<li class="tutor-dashboard-menu-divider"></li>';
                if ($menu_title) {
                    echo '<li class="tutor-dashboard-menu-divider-header">' . esc_html($menu_title) . '</li>';
                }
            } else {
                $li_class = "tutor-dashboard-menu-{$dashboard_key}";
                if ($dashboard_key === 'index') {
                    $dashboard_key = '';
                }
                $active_class = $dashboard_key == $dashboard_page_slug ? 'active' : '';
        ?>
                <?php if ($menu_activation) : ?>
                    <?php if (empty($sub_menu)) : ?>
                        <li class="<?php echo esc_attr($li_class . ' ' . $active_class) ?>">
                            <a href="<?php echo esc_url($menu_link); ?>" data-link="<?php echo $dashboard_key ?>" data-type="user">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/' . $menu_icon . '.png' ?>" alt="">
                                <?php echo esc_html($menu_title); ?>
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="<?php echo esc_attr($li_class . ' ' . $active_class) ?> submenu">
                            <div class="submenu-header">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/' . $menu_icon . '.png' ?>" alt="">
                                <P>
                                    <?php echo esc_html($menu_title); ?>
                                </P>
                                <img class="submenu-arrow" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-tutor.png' ?>" alt="">
                            </div>
                            <ul class="tutor-dashboard-sub-menu">
                                <?php
                                foreach ($sub_menu as $sub_menu_key => $sub_menu_item) {
                                    $sub_menu_title = $sub_menu_item['title'];
                                    $sub_menu_link = tutils()->get_tutor_dashboard_page_permalink($dashboard_key . '/' . $sub_menu_key);
                                    $sub_menu_icon = $sub_menu_item['icon'];
                                    $sub_menu_title = $sub_menu_item['title'];
                                ?>
                                    <li>
                                        <a href="<?php echo esc_url($sub_menu_link); ?>" data-link="<?php echo $dashboard_key ?>" data-type="user">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/' . $sub_menu_icon . '.png' ?>" alt="<?php echo $sub_menu_title ?>">
                                            <?php echo esc_html($sub_menu_title); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
        <?php
            }
        endforeach;
        ?>
    </ul>
</div>