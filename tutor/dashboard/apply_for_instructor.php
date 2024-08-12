<?php

defined('ABSPATH') || exit;

use Detection\MobileDetect;

$detect = new MobileDetect();
$user_id                   = get_current_user_id();
$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
$profile_photo_src   = $profile_placeholder;
?>

<main class="become-instructor <?php echo !$detect->isMobile() ? "desktop" : '' ?> active" data-user="<?php echo $user_id ?>">
    <?php if ($detect->isMobile()) : ?>
        <div class="become-instructor-link">
            <a href="<?php echo esc_url(site_url()); ?>">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
            </a>
            <h3><?php esc_html_e('تکمیل اطلاعات پروفایل تدریس', 'edumall-child'); ?></h3>
        </div>
    <?php endif; ?>



    <div class="become-instructor-wrap">
        <h3><?php esc_html_e('تکمیل اطلاعات پروفایل تدریس', 'edumall-child'); ?></h3>
        <form action="" method="post" enctype="multipart/form-data" class="become-instructor-form">
            <input type="hidden" name="action" value="save_instructor_metadata">
            <input type="hidden" name="become_instructor" value="true">
            <input type="hidden" id="_instructor_nonce" name="_instructor_nonce" value="<?php echo wp_create_nonce('edit_instructor_nonce'); ?>">

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

            <div class="become-instructor-form-group instructor-profile-pic">
                <label>
                    <?php esc_html_e('عکس پروفایل', 'edumall-child'); ?>
                    <sup>*</sup>
                </label>
                <div id="instructor_profile_cover_photo_editor">
                    <label for="instructor_photo_dialogue_box" id="instructor_profile_area">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/gallery-edit.png' ?>" alt="">
                    </label>
                    <div class="user-edit-buttons">
                        <label for=" instructor_photo_dialogue_box" class="user-edit-buttons-edit">ویرایش</label>
                        <label class="user-edit-buttons-delete">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.png' ?>" alt="">
                        </label>
                    </div>
                    <input id="instructor_photo_dialogue_box" type="file" accept=".png,.jpg,.jpeg" />
                    <input id="instructor-picture" type="hidden" name="instructor_picture">
                </div>
            </div>

            <?php if (!$detect->isMobile()) : ?>
                <div class="become-instructor-form-group-desktop">
                <?php endif; ?>
                <div class="become-instructor-form-group instructor-username">
                    <label for="instructor_profile_username">
                        <?php esc_html_e('Username', 'edumall-child'); ?>
                        <sup>*</sup>
                    </label>
                    <div class="instructor-username-input">
                        <input type="text" id="instructor_profile_username" name="instructor_username" placeholder="مانند:" required>

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

                <div class="become-instructor-form-group instructor-profession">
                    <label for="instructor_profile_profession">
                        <?php esc_html_e('تخصص', 'edumall-child'); ?>
                        <sup>*</sup>
                    </label>

                    <input type="text" id="instructor_profile_profession" name="instructor_profession" placeholder="مانند: دکتری روانشناسی بالینی" required>

                </div>
                <?php if (!$detect->isMobile()) : ?>
                </div>
            <?php endif; ?>

            <div class="become-instructor-form-group instructor-story-text">
                <label for="instructor_profile_story">
                    <?php esc_html_e('روایت من', 'edumall-child'); ?>
                    <sup>*</sup>
                </label>

                <textarea cols="50" rows="7" name="instructor_story" id="instructor_story_text" value="<?php echo esc_attr(get_user_meta($user_id, '_instructor_story_text', true)); ?>" placeholder="روایت خود را اینجا بنوسید...." required></textarea>

                <div class="instructor-story-box-limit">
                    <p class="instructor-story-box-limit-end">250</p>
                    <p>/</p>
                    <p class="instructor-story-box-limit-start">0</p>
                </div>
            </div>

            <div class="become-instructor-form-group instructor-story-video">
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

            <div class="become-instructor-form-group instructor-tags">
                <label for="instructor_profile_tags">
                    <?php esc_html_e('برچسب', 'edumall-child'); ?>
                </label>
                <div class="instructor-tags-input">
                    <input type="text" name="tags" value="<?php echo esc_attr(get_user_meta($user_id, 'tags', true)); ?>" placeholder="برچسب خود را بنویسید">
                    <a href="#">افزودن</a>
                </div>
                <div class="instructor-tags-wrap">
                    <?php
                    if (!empty($instructor_tags)) :
                        foreach ($instructor_tags as $index => $tag) :
                    ?>
                            <div class="instructor-tags-wrap-value value-<?php echo $tag ?>">
                                <p><?php echo esc_html($tag) ?></p>
                                <img class="instructor-tags-delete" src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgaWQ9InZ1ZXNheC9saW5lYXIvY2xvc2UtY2lyY2xlIj4KPGcgaWQ9ImNsb3NlLWNpcmNsZSI+CjxwYXRoIGlkPSJWZWN0b3IiIGQ9Ik0xMiAyMkMxNy41IDIyIDIyIDE3LjUgMjIgMTJDMjIgNi41IDE3LjUgMiAxMiAyQzYuNSAyIDIgNi41IDIgMTJDMiAxNy41IDYuNSAyMiAxMiAyMloiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMiIgZD0iTTkuMTY5OTIgMTQuODI5OUwxNC44Mjk5IDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMyIgZD0iTTE0LjgyOTkgMTQuODI5OUw5LjE2OTkyIDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjwvZz4KPC9nPgo8L3N2Zz4K' />
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>


            <div class="become-instructor-form-group instructor-submit-wrap">
                <button type="submit" value="register" class="instructor-button instructor-profile-settings-save"><?php esc_html_e('شروع تدریس', 'edumall-child'); ?></button>
            </div>

        </form>
    </div>
</main>