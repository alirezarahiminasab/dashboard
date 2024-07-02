<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.6.0
 */

defined('ABSPATH') || exit;
$profile_url = apply_filters('edumall_user_profile_url', '');

$user_id = get_current_user_id();
?>
<div class="withdrawal">
    <div class="withdrawal-title">
        <a href="<?php echo esc_url($profile_url); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
        <h3>
            <?php esc_html_e('اطلاعات حساب', 'edumall-child'); ?>
        </h3>
    </div>

    <div class="withdrawal-account">
        <form class="withdrawal-account-form">
            <input type="hidden" id='user-id' data-user-id="<?php echo $user_id ?>">
            <div class="withdrawal-account-form-title">
                <p>
                    <?php esc_html_e('اطلاعات حساب', 'edumall-child'); ?>
                </p>
            </div>

            <div class="withdrawal-account-form-content">
                <div class="form-group">
                    <label for="bank-name">
                        نام بانک<sup>*</sup>
                    </label>
                    <div class="form-group-input">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                        <select id="bank-name" required>
                            <option value="" hidden selected>بانک موردنظر خود را انتخاب کنید</option>
                            <option value="">بانک ملی</option>
                            <option value="">بانک ملت</option>
                            <option value="">بانک رسالت</option>
                            <option value="">بانک تجارت</option>
                            <option value="">بانک مهر</option>
                            <option value="">بانک کشاورزی</option>
                            <option value="">بانک سپه</option>
                            <option value="">بانک سامان</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="account-number">
                        شماره حساب<sup>*</sup>
                    </label>
                    <input id="account-number" type="number" placeholder="<?php esc_html_e('شماره حساب', 'edumall-child'); ?>" required>
                </div>


                <div class=>


                </div>

                <div class="form-group">
                    <label for="account-number">
                        شبا<sup>*</sup>
                    </label>
                    <div class="form-group-input">
                        <p>IR</p>
                        <input id="account-shaba" type="text" placeholder="<?php esc_html_e('XX-XXXX-XXXX-XXXX-XXXX-XXXX-XX', 'edumall-child'); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="account-number">
                        نام دارنده حساب<sup>*</sup>
                    </label>
                    <input id="account-first-name" type="text" placeholder="<?php esc_html_e('نام دارنده حساب', 'edumall-child'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="account-number">
                        نام خانوادگی دارنده حساب<sup>*</sup>
                    </label>
                    <input id="account-last-name" type="text" placeholder="<?php esc_html_e('نام خانوادگی دارنده حساب', 'edumall-child'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="account-number">
                        شناسه واریز مخصوص حساب های دولتی
                    </label>
                    <input id="account-deposit-id" type="number" placeholder="<?php esc_html_e('شناسه واریز مخصوص حساب های دولتی', 'edumall-child'); ?>">
                </div>
            </div>

            <div class="withdrawal-account-form-submit">
                <button type="submit">
                    <?php esc_html_e('ذخیره اطلاعات', 'edumall-child'); ?>
                </button>
            </div>
        </form>
    </div>
</div>