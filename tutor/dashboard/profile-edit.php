<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.7.5
 *
 * @theme-since   1.0.0
 * @theme-version 3.0.0
 */

defined('ABSPATH') || exit;
$profile_url  = apply_filters('edumall_user_profile_url', '');
$user = wp_get_current_user();

$user_favorites = get_user_meta($user->ID, '_instructor_favs', true);


$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
$profile_photo_src   = $profile_placeholder;
$profile_photo_id    = get_user_meta($user->ID, '_instructor_profile_pic', true);

$public_display                     = array();
$public_display['display_nickname'] = $user->nickname;
$public_display['display_username'] = $user->user_login;

if (!empty($user->first_name)) {
    $public_display['display_firstname'] = $user->first_name;
}

if (!empty($user->last_name)) {
    $public_display['display_lastname'] = $user->last_name;
}

if (!empty($user->first_name) && !empty($user->last_name)) {
    $public_display['display_firstlast'] = $user->first_name . ' ' . $user->last_name;
    $public_display['display_lastfirst'] = $user->last_name . ' ' . $user->first_name;
}

if (!in_array($user->display_name, $public_display)) { // Only add this if it isn't duplicated elsewhere
    $public_display = array('display_displayname' => $user->display_name) + $public_display;
}

$public_display = array_map('trim', $public_display);
$public_display = array_unique($public_display);
$max_filesize   = floatval(ini_get('upload_max_filesize')) * (1024 * 1024);
?>

<div class="edit-profile-title">
    <a href="<?php echo esc_url($profile_url . '/?menu=tutor'); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
    </a>
    <h3><?php esc_html_e('ویرایش اطلاعات کاربری', 'edumall-child'); ?></h3>
</div>

<div class="tutor-dashboard-user-setting">

    <?php do_action('tutor_profile_edit_form_before'); ?>

    <form action="" method="post" enctype="multipart/form-data" class="dashboard-settings-form dashboard-settings-profile-form">
        <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
        <input type="hidden" value="tutor_profile_edit" name="tutor_action" />

        <?php
        $errors = apply_filters('tutor_profile_edit_validation_errors', array());
        if (is_array($errors) && count($errors)) {
            echo '<div class="tutor-alert-warning tutor-mb-10"><ul class="tutor-required-fields">';
            foreach ($errors as $error_key => $error_value) {
                echo "<li>{$error_value}</li>";
            }
            echo '</ul></div>';
        }
        ?>

        <?php do_action('tutor_profile_edit_input_before'); ?>

        <div class="dashboard-content-box">
            <div id="user_profile_cover_photo_editor">
                <?php if (empty($profile_photo_id)) : ?>
                    <label for="user_photo_dialogue_box" id="user_profile_area">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/gallery-edit.png' ?>" alt="">
                    </label>
                <?php else : ?>
                    <img class="profile-picture" src="<?php echo $profile_photo_id ?>" alt="">
                <?php endif; ?>
                <div class="user-edit-buttons <?php echo empty($profile_photo_id) ? '' : "active" ?>">
                    <label for="user_photo_dialogue_box" class="user-edit-buttons-edit">ویرایش</label>
                    <label class="user-edit-buttons-delete">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.png' ?>" alt="">
                    </label>
                </div>
                <input id="user_photo_dialogue_box" type="file" accept=".png,.jpg,.jpeg" />
            </div>
        </div>

        <div class="dashboard-content-box">
            <div class="tutor-form-group">
                <label for="tutor_profile_phone_number">
                    <?php esc_html_e('شماره تلفن همراه', 'edumall-child'); ?>
                    <sup>*</sup>
                </label>
                <input type="text" id="tutor_profile_phone_number" name="phone_number" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_phone', true)); ?>" required>
            </div>

            <div class="tutor-form-group">
                <label for="tutor_profile_first_name">
                    <?php esc_html_e('نام و نام خانوادگی', 'edumall-child'); ?>
                    <sup>*</sup>
                </label>
                <input type="text" id="tutor_profile_first_name" name="first_name" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_name', true)); ?>" required>
            </div>

            <div class="tutor-form-group tutor-profile-username">
                <label for="tutor_profile_username">
                    <?php esc_html_e('نام کاربری', 'edumall-child'); ?>
                </label>
                <div class="tutor-profile-username-wrap">
                    <input type="text" id="tutor_profile_username" name="username" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_username', true)); ?>">
                    <svg class="tutor-username-input-accept" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 48 48">
                        <path fill="#c8e6c9" d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z"></path>
                        <polyline fill="none" stroke="#4caf50" stroke-miterlimit="10" stroke-width="4" points="14,24 21,31 36,16"></polyline>
                    </svg>

                    <svg class="tutor-username-input-reject" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 48 48">
                        <path fill="#f44336" d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z"></path>
                        <line x1="16.9" x2="31.1" y1="16.9" y2="31.1" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4"></line>
                        <line x1="31.1" x2="16.9" y1="16.9" y2="31.1" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4"></line>
                    </svg>
                </div>
            </div>

            <div class="tutor-form-group">
                <label for="tutor_profile_national_code">
                    <?php esc_html_e('کد ملی', 'edumall-child'); ?>
                </label>
                <input type="text" id="tutor_profile_national_code" name="national_code" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_national_code', true)); ?>">
            </div>

            <div class="tutor-form-group">
                <label for="tutor_profile_birth_date">
                    <?php esc_html_e('تاریخ تولد', 'edumall-child'); ?>
                </label>
                <input type="text" id="tutor_profile_birth_date" name="birth_date" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_birth_date', true)); ?>">
            </div>

            <div class="tutor-form-group">
                <label for="tutor_profile_education">
                    <?php esc_html_e('تحصیلات', 'edumall-child'); ?>
                </label>
                <input type="text" id="tutor_profile_education" name="education" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_education', true)); ?>">
            </div>

            <div class="tutor-form-group">
                <label for="tutor_profile_city">
                    <?php esc_html_e('شهر محل سکونت', 'edumall-child'); ?>
                </label>
                <input type="text" id="tutor_profile_city" name="city" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_city', true)); ?>">
            </div>

            <div class="tutor-form-group">
                <label for="tutor_profile_marriage">
                    <?php esc_html_e('وضعیت تأهل', 'edumall-child'); ?>
                </label>
                <input type="text" id="tutor_profile_marriage" name="marriage" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_marriage', true)); ?>">
            </div>

            <div class="tutor-form-group">
                <label for="tutor_profile_children">
                    <?php esc_html_e('تعداد فرزند', 'edumall-child'); ?>
                </label>
                <input type="text" id="tutor_profile_children" name="children" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_children', true)); ?>">
            </div>

            <div class="tutor-form-group favorites">
                <label for="tutor_profile_favorites">
                    <?php esc_html_e('دسته‌بندی‌های مورد علاقه', 'edumall-child'); ?><sup>*</sup>
                </label>
                <div class="favorites-items">
                    <p>
                        به هانیل کمک کن تا بهترین تجربه آموزشی را برای شما فراهم کند. با انتخاب حداقل <strong>3</strong> دسته‌بندی از سوی شما، هانیل قادر خواهد بود دوره‌ها و آموزش‌هایی را معرفی کند که دقیقاً با سلیقه و نیازهای شما هماهنگ باشند.
                    </p>

                    <div class="favorites-items-wrap">
                        <a href="#" class="<?php echo is_array($user_favorites) && in_array('مدیریت منزل', $user_favorites)  ? 'active' : '' ?>">
                            <?php esc_html_e('مدیریت منزل', 'edumall-child'); ?>
                        </a>
                        <a href="#" class="<?php echo is_array($user_favorites) && in_array('مهارت های نرم', $user_favorites) && is_array($user_favorites) ? 'active' : '' ?>">
                            <?php esc_html_e('مهارت های نرم', 'edumall-child'); ?>
                        </a>
                        <a href="#" class="<?php echo is_array($user_favorites) && in_array('برنامه نویسی', $user_favorites) && is_array($user_favorites) ? 'active' : '' ?>">
                            <?php esc_html_e('برنامه نویسی', 'edumall-child'); ?>
                        </a>
                        <a href="#" class="<?php echo is_array($user_favorites) && in_array('گرافیک', $user_favorites) ? 'active' : '' ?>">
                            <?php esc_html_e('گرافیک', 'edumall-child'); ?>
                        </a>
                        <a href="#" class="<?php echo is_array($user_favorites) && in_array('تولید محتوا', $user_favorites) && is_array($user_favorites) ? 'active' : '' ?>">
                            <?php esc_html_e('تولید محتوا', 'edumall-child'); ?>
                        </a>
                        <a href="#" class="<?php echo is_array($user_favorites) && in_array('فروش و بازاریابی', $user_favorites) ? 'active' : '' ?>">
                            <?php esc_html_e('فروش و بازاریابی', 'edumall-child'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="tutor-form-group tutor-form-submit">
                <button type="submit" name="tutor_register_student_btn" value="register"><?php esc_html_e('ذخیره تغییرات', 'edumall-child'); ?></button>
            </div>

            <?php do_action('tutor_profile_edit_input_after'); ?>

    </form>

    <?php do_action('tutor_profile_edit_form_after'); ?>

</div>