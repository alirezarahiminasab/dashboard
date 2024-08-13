<?php

require_once get_stylesheet_directory() . '\\inc\\event-module\\util.php' ; 


$fetch_results = EventUtil::callApi('shops/stats', [], 'GET');

// error_log(print_r($fetch_results, true));

$results = [];

$decoded = json_decode($fetch_results, true);
if (json_last_error() === JSON_ERROR_NONE) {
    // error_log(print_r($decoded, true));
    
    if ($decoded['status'] === 'success') {
        $results = $decoded['data']['stats'];
        error_log(print_r($results, true));

    } else {
        error_log(print_r("Response status is not 'success'.",true));
    }

} else {
    error_log(print_r("Error decoding JSON: " . json_last_error_msg(),true));
}



$profile_url  = apply_filters('edumall_user_profile_url', '');
$instructor_id = get_current_user_id();

?>

<div class="instructor-settings-back">
    <a href="<?php echo esc_url($profile_url); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
    </a>
    <h3><?php esc_html_e('آمار رویداد‌ها', 'edumall-child'); ?></h3>
</div>

<div class="event-statistics">
    <div class="event-statistics-wrap">
        <div class="event-statistics-header">
            <a class="event-statistics-sort-btn" href="#">
                <span>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/sort.png' ?>" alt="">
                </span>
                <span>
                    <?php esc_html_e('مرتب سازی بر اساس', 'edumall-child'); ?>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.png' ?>" alt="">
                </span>
            </a>
        </div>

        <div class="event-statistics-footer">
            <div class="event-statistics-footer-title">
                <span>
                    <p>
                        عنوان رویداد
                    </p>
                </span>
                <span>
                    <p>
                        تعداد فراگیران
                    </p>
                </span>
                <span>
                    <p>
                        کل درآمد
                    </p>
                </span>
            </div>
            <div class="event-statistics-footer-wrap">
                <?php if (is_array($results) && count($results)) : 
                    foreach ($results as $event) : 
                    ?>
                        <div class="event-statistics-footer-item" data-students="<?php echo $event['count'] ?>">
                            <span>
                                <p>
                                    <?php echo $event['title'] ?>
                                </p>
                            </span>
                            <span>
                                <p>
                                    <?php echo $event['count'] ?>
                                </p>
                            </span>
                            <span>
                                <p>
                                    <?php echo $event['totalIncome'] ?>
                                </p>
                            </span>
                        </div>
                        <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="event-statistics-sort">
        <div class="event-statistics-sort-bg"></div>
        <div class="event-statistics-sort-wrap">
            <div class="event-statistics-sort-wrap-header">
                <p>مرتب سازی بر اساس</p>
                <img class="sort-header-logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-hanil-2.png' ?>" alt="">
                <img class="sort-header-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
            </div>
            <div class="event-statistics-sort-wrap-radio">
                <span>
                    <input type="radio" name="event-statistics-sort-radio" class="event-statistics-sort-radio" data-sort="count" data-author-id="<?php echo $instructor_id ?>">
                    <p>
                        <?php esc_html_e('تعداد فراگیران', 'edumall-child'); ?>
                    </p>
                </span>
                <span>
                    <input type="radio" name="event-statistics-sort-radio" class="event-statistics-sort-radio" data-sort="totalIncome" data-author-id="<?php echo $instructor_id ?>">
                    <p>
                        <?php esc_html_e('کل درآمد', 'edumall-child'); ?>
                    </p>
                </span>
            </div>
        </div>
    </div>
</div>