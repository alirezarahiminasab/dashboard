<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.6.0
 */

defined('ABSPATH') || exit;

use Detection\MobileDetect;

$detect = new MobileDetect();

$profile_url = apply_filters('edumall_user_profile_url', '');

$instructor_id = get_current_user_id();

$instructor_bank_name = get_user_meta($instructor_id, '_instructor_bank_name', true);
$instructor_account_number = get_user_meta($instructor_id, '_instructor_account_number', true);
$instructor_account_IBAN = substr(get_user_meta($instructor_id, '_instructor_account_IBAN', true), 3);
$instructor_first_name = get_user_meta($instructor_id, '_instructor_first_name', true);
$instructor_last_name = get_user_meta($instructor_id, '_instructor_last_name', true);
$instructor_deposit_id = get_user_meta($instructor_id, '_instructor_deposit_id', true);

?>
<?php if ($detect->isMobile()) : ?>
    <div class="instructor-settings-back">
        <a href="<?php echo esc_url($profile_url); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
        <h3><?php esc_html_e('اطلاعات حساب', 'edumall-child'); ?></h3>
    </div>
<?php endif; ?>

<div class="withdrawal">
    <div class="withdrawal-account">
        <form class="withdrawal-account-form">
            <input type="hidden" id='user-id' name='user-id' data-user-id="<?php echo $instructor_id ?>">
            <input type="hidden" id="_tutor_nonce" name="_tutor_nonce" value="<?php echo wp_create_nonce('save_account_nonce'); ?>">
            <input type="hidden" name="_wp_http_referer" value="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="action" value="save_user_accountant">

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
                        <select id="bank-name" required name='bank-name'>
                            <option value="<?php echo !empty($instructor_bank_name) ? esc_html($instructor_bank_name) : '' ?>" hidden selected>
                                <?php echo !empty($instructor_bank_name) ? esc_html($instructor_bank_name) : 'بانک موردنظر خود را انتخاب کنید' ?>
                            </option>
                            <option value="بانک ملی">بانک ملی</option>
                            <option value="بانک ملت">بانک ملت</option>
                            <option value="بانک رسالت">بانک رسالت</option>
                            <option value="بانک تجارت">بانک تجارت</option>
                            <option value="بانک مهر">بانک مهر</option>
                            <option value="بانک کشاورزی">بانک کشاورزی</option>
                            <option value="بانک سپه">بانک سپه</option>
                            <option value="بانک سامان">بانک سامان</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="account-number">
                        شماره حساب<sup>*</sup>
                    </label>
                    <div class="form-group-input">
                        <input id="account-number" name="account-number" type="number" placeholder="<?php esc_html_e('شماره حساب', 'edumall-child'); ?>" value="<?php echo !empty($instructor_account_number) ? esc_html($instructor_account_number) : '' ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="account-IBAN">
                        شبا<sup>*</sup>
                    </label>
                    <div class="form-group-input">
                        <input id="account-IBAN" name="account-IBAN" type="text" placeholder="XX-XXXX-XXXX-XXXX-XXXX-XXXX-XX" value="IR-<?php echo !empty($instructor_account_IBAN) ? esc_html($instructor_account_IBAN) : '' ?>" maxlength="33">
                    </div>
                </div>

                <div class="form-group">
                    <label for="account-first-name">
                        نام دارنده حساب<sup>*</sup>
                    </label>
                    <input id="account-first-name" name="account-first-name" type="text" placeholder="<?php esc_html_e('نام دارنده حساب', 'edumall-child'); ?>" value="<?php echo !empty($instructor_first_name) ? esc_html($instructor_first_name) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="account-last-name">
                        نام خانوادگی دارنده حساب<sup>*</sup>
                    </label>
                    <input id="account-last-name" name="account-last-name" type="text" placeholder="<?php esc_html_e('نام خانوادگی دارنده حساب', 'edumall-child'); ?>" value="<?php echo !empty($instructor_last_name) ? esc_html($instructor_last_name) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="account-deposit-id">
                        شناسه واریز مخصوص حساب های دولتی
                    </label>
                    <input id="account-deposit-id" name="account-deposit-id" type="number" placeholder="<?php esc_html_e('شناسه واریز مخصوص حساب های دولتی', 'edumall-child'); ?>" value="<?php echo !empty($instructor_deposit_id) ? esc_html($instructor_deposit_id) : '' ?>">
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