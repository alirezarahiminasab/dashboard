<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.2.2
 */

defined('ABSPATH') || exit;

use TUTOR\Input;

get_header();
do_action('tutor_load_template_before', 'dashboard.create-course', null);

$course_id = Input::get('course_ID', 0, Input::TYPE_INT);
$post      = '';
$user_id = get_current_user_id();
$profile_url = apply_filters('edumall_user_profile_url', '');
$course_categories = get_terms(array(
    'taxonomy' => 'course-category',
    'hide_empty' => false,
));
$course_tags = get_terms(array(
    'taxonomy' => 'course-tag',
    'hide_empty' => false,
));

$instructor_status = boolval(get_user_meta($user_id, '_tutor_instructor_status', true));
$is_instructor = boolval(tutor_utils()->is_instructor($user_id, true));

if (!($is_instructor ||  $instructor_status)) :
    $args = array(
        'headline'    => __('Permission Denied', 'edumall-child'),
        'message'     => __('You don\'t have the right to edit this course', 'edumall-child'),
        'description' => __('Please make sure you are logged in to correct account', 'edumall-child'),
        'button'      => array(
            'url'  => get_permalink($course_id),
            'text' => __('View Course', 'edumall-child'),
        ),
    );

    tutor_load_template('permission-denied', $args);

    return;
endif;
?>

<div class="course-create">
    <div class="course-create-title">
        <a href="<?php echo esc_url($profile_url); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
        <h3>
            <?php esc_html_e('ایجاد دوره', 'edumall-child'); ?>
        </h3>
    </div>

    <form action="" id="course-create-form" class="course-create-form" method="post" enctype="multipart/form-data">

        <?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>

        <div id="course-create-topic" class="course-create-section">
            <div class="course-create-section-inner">
                <div class="course-create-section-inner-input">
                    <label for="course-create-title">
                        <?php esc_html_e('عنوان دوره', 'edumall-child'); ?><sup>*</sup>
                    </label>
                    <div class="course-create-section-inner-input-wrap">
                        <span>
                            <p>60</p>
                            <p>/</p>
                            <p class="course-create-counter-limit">0</p>
                        </span>
                        <input type="text" class="course-create-input" name="" id="course-create-title" placeholder="<?php esc_html_e('عنوان دوره', 'edumall-child'); ?>" data-limit="60" required>
                    </div>
                </div>

                <div class="course-create-section-inner-input">
                    <label for="course-create-category">
                        <?php esc_html_e('دسته بندی اصلی', 'edumall-child'); ?><sup>*</sup>
                    </label>
                    <div class="course-create-section-inner-input-wrap">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                        <select type="text" name="" id="course-create-category" required>
                            <option value="" hidden selected><?php esc_html_e('انتخاب کنید', 'edumall-child'); ?></option>
                            <?php foreach ($course_categories as $category) : ?>
                                <option value="<?php echo esc_attr($category->slug) ?>">
                                    <?php echo esc_html($category->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="course-create-section-inner-input course-create-tags">
                    <label for="course-create-tags">
                        <?php esc_html_e('برچسب‌ها', 'edumall-child'); ?><sup>*</sup>
                    </label>
                    <div class="course-create-section-inner-input-wrap">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                        <select type="text" name="" id="course-create-tags-dropdown" class="course-create-tags-dropdown">
                            <option value="" hidden selected><?php esc_html_e('انتخاب کنید (حداکثر 5 برچسب)', 'edumall-child'); ?></option>
                            <?php foreach ($course_tags as $tag) : ?>
                                <option value="<?php echo esc_attr(urldecode($tag->slug)) ?>">
                                    <?php echo esc_html($tag->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="course-create-tags-list"></div>
                </div>

                <div class="course-create-section-inner-input">
                    <p>
                        <?php esc_html_e('کاور دوره', 'edumall-child'); ?><sup>*</sup>
                    </p>
                    <label for="course-create-cover" class="course-create-cover-input active">
                        <span>
                            <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/gallery-export.svg" ?>" alt="">
                            <p>
                                <?php esc_html_e('حجم:حداکثر 20 مگابایت', 'edumall-child'); ?>
                            </p>
                        </span>
                        <a href="#">
                            <?php esc_html_e('آپلود کاور', 'edumall-child'); ?>
                        </a>
                    </label>

                    <div class="course-create-cover-uploaded">
                        <img class="course-create-cover-uploaded-file" src="<?php echo get_stylesheet_directory_uri() . "/assets/images/404-1.png" ?>" alt="">

                        <a href="#">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash-create-course.svg' ?>" alt="">
                            <p>
                                <?php esc_html_e('حذف تصویر', 'edumall-child'); ?>
                            </p>
                        </a>
                    </div>

                    <input type="file" id="course-create-cover" hidden required accept="image/*">
                </div>
            </div>
        </div>

        <div id="course-create-description" class="course-create-section">
            <div class="course-create-section-inner">
                <div class="course-create-section-inner-input">
                    <label for="course-create-description">
                        <?php esc_html_e('شرح دوره', 'edumall-child'); ?><sup>*</sup>
                    </label>
                    <div class="course-create-section-inner-input-wrap course-create-description">
                        <span>
                            <p>250</p>
                            <p>/</p>
                            <p class="course-create-counter-limit">0</p>
                        </span>
                        <textarea name="" class="course-create-input" rows="6" id="course-create-description" placeholder="<?php esc_html_e('شرح دوره را مختصر و مفید اینجا بنوسید....', 'edumall-child'); ?>" data-limit="250" required></textarea>
                    </div>
                </div>

                <div class="course-create-section-inner-input">
                    <label for="course-create-description-extra">
                        <?php esc_html_e('توضیحات بیشتر', 'edumall-child'); ?><sup>*</sup>
                    </label>
                    <textarea name="" rows="6" id="course-create-description-extra" placeholder="<?php esc_html_e('شرح دوره را مختصر و مفید اینجا توضیحات بیشتر درباره دوره را اینجا بنوسید....', 'edumall-child'); ?>" required></textarea>
                </div>
            </div>
        </div>

        <div id="course-create-pre" class="course-create-section">
            <div class="course-create-section-inner">
                <div class="course-create-section-inner-input course-create-goals">
                    <label for="course-create-goals">
                        <?php esc_html_e('آنچه فراگیران می‌آموزند', 'edumall-child'); ?>
                    </label>
                    <div class="course-create-goals-wrap">
                        <input id="course-create-goals" placeholder="<?php esc_html_e('اهداف دوره را اینجا بنویسید...', 'edumall-child'); ?>" data-counter="1">
                    </div>
                    <a href="#">
                        <?php esc_html_e('افزودن موارد بیشتر', 'edumall-child'); ?>
                    </a>
                </div>

                <div class="course-create-section-inner-input course-create-pre">
                    <div class="course-create-pre-wrap">
                        <label for="course-create-pre">
                            <?php esc_html_e('پیش‌نیاز‌ها', 'edumall-child'); ?>
                        </label>
                        <textarea rows="6" id="course-create-pre" placeholder="<?php esc_html_e('پیش‌نیاز‌های مورد نیاز این دوره را اینجا بنویسید...', 'edumall-child'); ?>"></textarea>
                    </div>

                    <div class="course-create-pre-wrap">
                        <label for="course-create-pre">
                            <?php esc_html_e('دوره‌های پیش‌نیاز', 'edumall-child'); ?>
                        </label>
                        <div class="course-create-pre-wrap-input">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                            <input type="text" name="" placeholder="<?php esc_html_e('دوره موردنظر خود را انتخاب کنید', 'edumall-child'); ?>" class="course-create-prerequisites" id="course-create-pre">
                            <div class="course-create-pre-dropdown"></div>
                        </div>
                        <div class="course-create-pre-list"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="course-create-lessons" class="course-create-section">
            <div class="course-create-section-inner course-create-lessons">
                <label for="course-pre-lessons">
                    <?php esc_html_e('فصل‌های آموزشی', 'edumall-child'); ?>
                </label>

                <div class="course-create-chapter" data-chapter="1">

                    <div class="course-create-chapter-counter">
                        <p>فصل 1</p>
                        <span></span>
                    </div>

                    <div class="course-create-chapter-lesson" data-lesson="1">
                        <div class="course-create-chapter-lesson-input">
                            <label for="chapter-title">
                                <?php esc_html_e('عنوان فصل 1', 'edumall-child'); ?><sup>*</sup>
                            </label>
                            <input type="text" id="chapter-title" placeholder="<?php esc_html_e('عنوان فصل', 'edumall-child'); ?>" required>
                        </div>

                        <div class="course-create-chapter-lesson-input">
                            <label for="lesson-title">
                                <?php esc_html_e('عنوان قسمت 1', 'edumall-child'); ?>
                            </label>
                            <div class="course-create-chapter-lesson-input-wrap">
                                <span>
                                    <p>60</p>
                                    <p>/</p>
                                    <p class="course-create-counter-limit">0</p>
                                </span>
                                <input type="text" class="course-create-input" id="lesson-title" placeholder="<?php esc_html_e('عنوان قسمت', 'edumall-child'); ?>" data-limit="60">
                            </div>
                        </div>

                        <div class="course-create-chapter-lesson-input">
                            <label for="lesson-description">
                                <?php esc_html_e('توضیحات متنی قسمت 1', 'edumall-child'); ?>
                            </label>
                            <textarea rows="6" name="" id="lesson-description" placeholder="<?php esc_html_e('توضیحات متنی دوره این قسمت را اینجا بنوسید....', 'edumall-child'); ?>"></textarea>
                        </div>

                        <div class="course-create-chapter-lesson-file">
                            <label for="course-create-video" class="course-create-chapter-lesson-video-input">
                                <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/export.svg" ?>" alt="">
                                <p class="video-input-first">
                                    <?php esc_html_e('برای آپلود ویدئو این قسمت اینجا کلیک کنید', 'edumall-child'); ?>
                                </p>
                                <p>
                                    <?php esc_html_e('حجم: حداکثر 2000 مگابایت', 'edumall-child'); ?>
                                </p>
                                <p>
                                    <?php esc_html_e('فرمت مجاز: Mp4', 'edumall-child'); ?>
                                </p>
                            </label>
                            <input type="file" id="course-create-video" name='' accept="video/mp4" required hidden>
                        </div>
                    </div>

                    <div class="course-create-add-lesson">
                        <a href="#">
                            <p>+</p>
                            <p>
                                <?php esc_html_e('افزودن قسمت جدید', 'edumall-child'); ?>
                            </p>
                        </a>
                    </div>
                </div>

                <div class="course-create-add-chapter">
                    <a href="#">
                        <?php esc_html_e('افزودن فصل', 'edumall-child'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div id="course-create-price" class="course-create-section">
            <div class="course-create-section-inner">
                <div class="course-create-section-inner-input">
                    <label for="course-create-price-input">
                        <?php esc_html_e('قیمت دوره', 'edumall-child'); ?><sup>*</sup>
                    </label>
                    <div class="course-create-section-inner-input-wrap course-create-price">
                        <input type="text" name="" id="course-create-price-input" placeholder="<?php esc_html_e('قیمت دوره را اینجا بنویسید....', 'edumall-child'); ?>" required>
                        <p>
                            <?php esc_html_e('تومان', 'edumall-child'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="course-create-questions" class="course-create-section">
            <div class="course-create-questions">
                <div class="course-create-questions-title">
                    <h4>
                        <?php esc_html_e('سوالات متداول', 'edumall-child'); ?>
                    </h4>
                </div>

                <div class="course-create-questions-input">
                    <input type="text" placeholder="<?php esc_html_e('صورت سوال را اینجا بنویسید....', 'edumall-child'); ?>">
                    <textarea id="" rows="6" placeholder="<?php esc_html_e('جواب سوال بالا را اینجا بنویسید....', 'edumall-child'); ?>"></textarea>
                </div>

                <div class="course-create-questions-add">
                    <a href="#">
                        <p>+</p>
                        <p>
                            <?php esc_html_e('افزودن سوال', 'edumall-child'); ?>
                        </p>
                    </a>
                </div>
            </div>
        </div>

        <div id="course-create-submit" class="course-create-section">
            <div class="course-create-section-inner course-create-submit">
                <div class="course-create-submit-check">
                    <input type="checkbox" />
                    <?php echo sprintf("<span><p>%s</p> <a href='%s'>&nbsp;%s&nbsp;</a> <p>%s</p></span>", "من", "#", "قوانین هانیل", "را خوانده ام و با آنها موافقت می کنم.") ?>
                </div>
                <div class="course-create-submit-btn">
                    <button type="submit" disabled="true">
                        <?php esc_html_e('انتشار', 'edumall-child'); ?>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

<?php do_action('tutor/dashboard_course_builder_after'); ?>

<?php do_action('tutor_load_template_after', 'dashboard.create-course', null); ?>

<?php
get_footer();
