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

$instructor_username = get_user_meta($user->ID, '_instructor_username', true);
$instructor_tags    = get_user_meta($user->ID, '_instructor_tags', true);
$instructor_story_text    = get_user_meta($user->ID, '_instructor_story_text', true);

$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
$profile_photo_src   = $profile_placeholder;
$profile_photo_id    = get_user_meta($user->ID, '_instructor_profile_pic', true);


$cover_placeholder = tutor()->url . 'assets/images/cover-photo.jpg';
$cover_photo_src   = $cover_placeholder;
$cover_photo_id    = get_user_meta($user->ID, '_tutor_cover_photo', true);
if ($cover_photo_id) {
    $url = wp_get_attachment_image_url($cover_photo_id, 'full');
    !empty($url) ? $cover_photo_src = $url : 0;
}

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
$instructor_story = get_user_meta($user->ID, '_instructor_story_text', true);
?>

<div class="instructor-settings-back">
    <a href="<?php echo esc_url($profile_url); ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
    </a>
    <h3><?php esc_html_e('ویرایش اطلاعات پروفایل تدریس', 'edumall-child'); ?></h3>
</div>

<main class="instructor-settings" data-user="<?php echo $user->ID ?>">
    <div class="instructor-settings-wrap">
        <form action="" method="post" enctype="multipart/form-data" class="instructor-settings-form">
            <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
            <input type="hidden" value="instructor_profile_edit" name="instructor_action" />

            <?php
            $errors = apply_filters('instructor_profile_edit_validation_errors', array());
            if (is_array($errors) && count($errors)) {
                echo '<div class="instructor-alert-warning instructor-mb-10"><ul class="instructor-required-fields">';
                foreach ($errors as $error_key => $error_value) {
                    echo "<li>{$error_value}</li>";
                }
                echo '</ul></div>';
            }
            ?>

            <div class="instructor-settings-form-group instructor-profile-pic">
                <label>
                    <?php esc_html_e('عکس پروفایل', 'edumall-child'); ?>
                    <sup>*</sup>
                </label>
                <div id="instructor_profile_cover_photo_editor">
                    <?php if (empty($profile_photo_id)) : ?>
                        <label for="instructor_photo_dialogue_box" id="instructor_profile_area">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/gallery-edit.png' ?>" alt="">
                        </label>
                    <?php else : ?>
                        <img class="profile-picture" src="<?php echo $profile_photo_id ?>" alt="">
                    <?php endif; ?>
                    <div class="user-edit-buttons <?php echo empty($profile_photo_id) ? '' : "active" ?>">
                        <label for="instructor_photo_dialogue_box" class="user-edit-buttons-edit">ویرایش</label>
                        <label class="user-edit-buttons-delete">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.png' ?>" alt="">
                        </label>
                    </div>
                    <input id="instructor_photo_dialogue_box" type="file" accept=".png,.jpg,.jpeg" />
                </div>
            </div>

            <div class="instructor-settings-form-group instructor-username">
                <label for="instructor_profile_username">
                    <?php esc_html_e('Username', 'edumall-child'); ?>
                    <sup>*</sup>
                </label>
                <div class="instructor-username-input">
                    <input type="text" id="instructor_profile_username" name="username" placeholder="مانند:" value="<?php echo $instructor_username ?>" required>
                    <svg class="instructor-username-input-accept" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 48 48">
                        <path fill="#c8e6c9" d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z"></path>
                        <polyline fill="none" stroke="#4caf50" stroke-miterlimit="10" stroke-width="4" points="14,24 21,31 36,16"></polyline>
                    </svg>

                    <svg class="instructor-username-input-reject" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 48 48">
                        <path fill="#f44336" d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z"></path>
                        <line x1="16.9" x2="31.1" y1="16.9" y2="31.1" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4"></line>
                        <line x1="31.1" x2="16.9" y1="16.9" y2="31.1" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4"></line>
                    </svg>
                </div>

            </div>

            <div class="instructor-settings-form-group instructor-profession">
                <label for="instructor_profile_profession">
                    <?php esc_html_e('تخصص', 'edumall-child'); ?>
                    <sup>*</sup>
                </label>
                <input type="text" id="instructor_profile_profession" name="profession" value="<?php echo esc_attr(get_user_meta($user->ID, '_instructor_profession', true)); ?>" placeholder="مانند: دکتری روانشناسی بالینی" required>
            </div>

            <div class="instructor-settings-form-group instructor-story-text">
                <label for="instructor_profile_story">
                    <?php esc_html_e('روایت من', 'edumall-child'); ?>
                    <sup>*</sup>
                </label>
                <textarea cols="50" rows="5" name="story" id="instructor_story_text" value="<?php echo esc_attr($instructor_story); ?>" placeholder="روایت خود را اینجا بنوسید...." required><?php echo $instructor_story_text ?></textarea>
                <div class="instructor-story-box-limit">
                    <p class="instructor-story-box-limit-end">250</p>
                    <p>/</p>
                    <p class="instructor-story-box-limit-start"><?php echo mb_strlen($instructor_story) ?></p>
                </div>
            </div>

            <div class="instructor-settings-form-group instructor-story-video">
                <label for="instructor_profile_story">
                    <?php esc_html_e('فیلم روایت', 'edumall-child'); ?>
                </label>
                <p>
                    به تصویر کشیدن روایتتان در قالب فیلم میتواند منجر به جذب مخاطب بیشتری شود.
                </p>
                <div class="instructor-story-box story-video">
                    <label for="instructor_story_video_file">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/import.png' ?>" alt="">
                        <h4>برای آپلود فیلم روایت اینجا کلیک کنید</h4>
                        <p>حجم: حداکثر 200 مگابایت</p>
                        <p>فرمت مجاز: Mp4</p>
                    </label>
                </div>
                <!-- TODO -->
                <!-- Implement Ajax upload file with s3 bucket -->
                <div class="instructor-story-box story-video-upload">
                    <img class="story-video-upload-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.png' ?>" alt="">
                    <div class="story-video-upload-info">
                        <img class="story-video-upload-info-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/video-vertical.png' ?>" alt="">
                        <div class="story-video-upload-info-meta">
                            <p id="file-name"></p>
                            <p id="file-size"></p>
                        </div>
                    </div>
                    <div class="story-video-upload-progress">
                        <div class="progress-wrap">
                            <div class="progress"></div>
                        </div>
                        <p class="progress-text">0%</p>
                    </div>
                </div>
                <input id="instructor_story_video_file" type="file" accept=".mp4" />
            </div>

            <div class="instructor-settings-form-group instructor-tags">
                <label for="instructor_profile_tags">
                    <?php esc_html_e('برچسب', 'edumall-child'); ?>
                </label>
                <div class="instructor-tags-input">
                    <input type="text" name="tags" value="<?php echo esc_attr(get_user_meta($user->ID, 'tags', true)); ?>" placeholder="برچسب خود را بنویسید">
                    <a href="#">افزودن</a>
                </div>
                <div id="instructor_profile_tags" class="instructor-tags-wrap">
                    <?php
                    if (!empty($instructor_tags)) :
                        foreach ($instructor_tags as $index => $tag) :
                    ?>
                            <div class="instructor-tags-wrap-value value-<?php echo $tag ?>">
                                <p><?php echo  esc_html($tag) ?></p>
                                <img class="instructor-tags-delete" src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgaWQ9InZ1ZXNheC9saW5lYXIvY2xvc2UtY2lyY2xlIj4KPGcgaWQ9ImNsb3NlLWNpcmNsZSI+CjxwYXRoIGlkPSJWZWN0b3IiIGQ9Ik0xMiAyMkMxNy41IDIyIDIyIDE3LjUgMjIgMTJDMjIgNi41IDE3LjUgMiAxMiAyQzYuNSAyIDIgNi41IDIgMTJDMiAxNy41IDYuNSAyMiAxMiAyMloiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMiIgZD0iTTkuMTY5OTIgMTQuODI5OUwxNC44Mjk5IDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMyIgZD0iTTE0LjgyOTkgMTQuODI5OUw5LjE2OTkyIDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjwvZz4KPC9nPgo8L3N2Zz4K' />
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>


            <div class="instructor-settings-form-group instructor-submit-wrap">
                <button type="submit" name="instructor_register_student_btn" value="register" class="instructor-button instructor-profile-settings-save"><?php esc_html_e('ذخیره تغییرات', 'edumall-child'); ?></button>
            </div>

        </form>
    </div>
</main>