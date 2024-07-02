<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.7.5
 * @theme-version 3.0.0
 */

defined('ABSPATH') || exit;
$profile_url  = apply_filters('edumall_user_profile_url', '');
$user = get_userdata(get_current_user_id());

?>
<div class="students-password">
    <div class="edit-profile-title">
        <a href="<?php echo esc_url($profile_url . '/?menu=tutor'); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
        <h3><?php esc_html_e('ثبت رمز عبور', 'edumall-child'); ?></h3>
    </div>

    <div class="user-password-edit">
        <div class="user-dashboard-content-inner">
            <form action="" method="post" enctype="multipart/form-data" class="user-settings-form user-settings-reset-password-form">
                <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
                <input type="hidden" value="tutor_reset_password" name="tutor_action" />

                <?php do_action('tutor_reset_password_input_before') ?>

                <?php if ($user && !empty($user->user_pass)) : ?>
                    <div class="user-form-group">
                        <label> <?php esc_html_e('رمز عبور فعلی', 'edumall-child'); ?> </label>
                        <div class="user-form-group-input">
                            <input type="password" name="previous_password">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/eye.png' ?>" alt="">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="user-form-group">
                    <label><?php esc_html_e('رمز عبور جدید', 'edumall-child'); ?></label>
                    <div class="user-form-group-input">
                        <input type="password" name="new_password">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/eye.png' ?>" alt="">
                    </div>
                    <p>
                        رمز عبور شما باید حداقل ۸ رقم و شامل حروف و اعداد انگلیسی باشد.
                    </p>
                </div>

                <div class="user-form-group">
                    <label><?php esc_html_e('تکرار رمز عبور جدید', 'edumall-child'); ?></label>
                    <div class="user-form-group-input">
                        <input type="password" name="confirm_new_password">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/eye.png' ?>" alt="">
                    </div>

                </div>

                <div class="user-form-group form-submit-wrap">
                    <button type="submit" class="tutor-button tutor-profile-password-reset">
                        <?php esc_html_e('تغییر رمز عبور', 'edumall-child'); ?>
                    </button>
                    <a href="<?php echo esc_url($profile_url . '/?menu=tutor'); ?>" class="tutor-profile-password-cancel">
                        <?php esc_html_e('انصراف', 'edumall-child'); ?>
                    </a>
                </div>

                <?php do_action('tutor_reset_password_input_after') ?>

            </form>
        </div>
    </div>
</div>