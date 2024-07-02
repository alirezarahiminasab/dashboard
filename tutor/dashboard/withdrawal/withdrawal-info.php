<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.6.0
 */

defined('ABSPATH') || exit;

$user_id         = get_current_user_id();

$currency_symbol = '';
if (function_exists('get_woocommerce_currency_symbol')) {
    $currency_symbol = get_woocommerce_currency_symbol();
} elseif (function_exists('edd_currency_symbol')) {
    $currency_symbol = edd_currency_symbol();
}

$profile_url = apply_filters('edumall_user_profile_url', '');

$summary_data                         = Edumall_Tutor::instance()->get_withdraw_summary($user_id);
$total_income_formatted                         = number_format($summary_data->total_income);
$total_net_income_formatted                         = number_format($summary_data->total_income * 0.8);
$available_for_withdraw_formatted    = number_format($summary_data->available_for_withdraw);
$current_balance_formatted             = number_format($summary_data->current_balance);

?>

<div class="withdrawal">
    <div class="withdrawal-title">
        <a href="<?php echo esc_url($profile_url); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
        <h3>
            <?php esc_html_e('تسویه حساب', 'edumall-child'); ?>
        </h3>
    </div>

    <div class="withdrawal-content">
        <div class="withdrawal-content-notice">
            <div class="withdrawal-content-notice-title">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/notice.svg' ?>" alt="">
                <p>
                    <?php esc_html_e('تسویه حساب', 'edumall-child'); ?>
                </p>
            </div>
            <div class="withdrawal-content-notice-context">
                <p>
                    <?php esc_html_e('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است', 'edumall-child'); ?>
                </p>
            </div>
        </div>

        <div class="withdrawal-content-income">
            <div class="withdrawal-content-income-item">
                <h4>
                    <?php esc_html_e('جمع کل فروش', 'edumall-child'); ?>
                </h4>
            </div>

            <div class="withdrawal-content-income-item item-price">
                <p>
                    <?php echo $total_income_formatted ?>
                </p>
                <p>
                    <?php esc_html_e('تومان', 'edumall-child'); ?>
                </p>
            </div>

            <div class="withdrawal-content-income-item">
                <h4>
                    <?php esc_html_e('سهم شما از فروش', 'edumall-child'); ?>
                </h4>
            </div>

            <div class="withdrawal-content-income-item item-price">
                <p>
                    <?php echo $total_net_income_formatted ?>
                </p>
                <p>
                    <?php esc_html_e('تومان', 'edumall-child'); ?>
                </p>
            </div>

            <div class="withdrawal-content-income-item">
                <h4>
                    <?php esc_html_e('مبلغ تسویه شده تا کنون', 'edumall-child'); ?>
                </h4>
            </div>

            <div class="withdrawal-content-income-item item-price-withdraw">
                <p>
                    <?php echo $available_for_withdraw_formatted ?>
                </p>
                <p>
                    <?php esc_html_e('تومان', 'edumall-child'); ?>
                </p>
            </div>

            <div class="withdrawal-content-income-item">
                <h4>
                    <?php esc_html_e('مبلغ باقی‌مانده', 'edumall-child'); ?>
                </h4>
            </div>

            <div class="withdrawal-content-income-item item-price-balance">
                <p>
                    <?php echo $current_balance_formatted ?>
                </p>
                <p>
                    <?php esc_html_e('تومان', 'edumall-child'); ?>
                </p>
            </div>
        </div>
    </div>
</div>