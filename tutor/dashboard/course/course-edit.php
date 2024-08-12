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
$course      = get_post($course_id);

if (!$course_id || tutor()->course_post_type != get_post_type($course)) {
    return;
}
setup_postdata($course);

$user_id = get_current_user_id();

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

$course_slug      = $course->post_name;
$course_permalink = get_the_permalink();

$course_price = number_format(get_post_meta($course_id, '_course_price', true));

$course_categories = get_terms(array(
    'taxonomy' => 'course-category',
    'hide_empty' => false,
));

$course_tags = get_terms(array(
    'taxonomy' => 'course-tag',
    'hide_empty' => false,
));

$course_category = get_the_terms($course_id, 'course-category');
$course_tags_arr = get_the_terms($course_id, 'course-tag');

$course_topics = get_posts([
    'post_type' => 'topics',
    'post_parent' => $course_id,
    'posts_per_page' => -1
]);

$thumbnail_size = '327x210';

$course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
    'post_id' => $course_id,
    'size'    => $thumbnail_size,
));
$course_thumb_placeholder = tutor()->url . 'assets/images/placeholder.svg';

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

        <input type="hidden" name="action" value="create_course">
        <input type="hidden" name="course_id" value="<?php echo $course_id ?>">
        <input type="hidden" id="_tutor_nonce" name="_tutor_nonce" value="<?php echo wp_create_nonce('course_create_nonce'); ?>">
        <input type="hidden" name="author_id" value="<?php echo get_current_user_id(); ?>">

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
                        <input type="text" class="course-create-input" name="course-create-title" id="course-create-title" placeholder="<?php esc_html_e('عنوان دوره', 'edumall-child'); ?>" value="<?php echo $course->post_title ?>" data-limit="60" required>
                    </div>
                </div>

                <div class="course-create-section-inner-input">
                    <label for="course-create-category">
                        <?php esc_html_e('دسته بندی اصلی', 'edumall-child'); ?><sup>*</sup>
                    </label>
                    <div class="course-create-section-inner-input-wrap">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                        <select type="text" name="course-create-category" id="course-create-category" required>
                            <option value="<?php echo esc_html($course_category[0]->name); ?>" hidden selected><?php echo esc_html($course_category[0]->name); ?></option>
                            <?php foreach ($course_categories as $category) : ?>
                                <option value="<?php echo esc_attr($category->term_id) ?>">
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
                                <option value="<?php echo esc_attr($tag->term_id) ?>" data-name="<?php echo esc_attr(urldecode($tag->name)) ?>">
                                    <?php echo esc_html($tag->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="course-create-tags-list">
                        <?php foreach ($course_tags_arr as $tag) : ?>
                            <span>
                                <input type="hidden" name='course-create-tags[]' value="<?php echo $tag->name ?>">
                                <p><?php echo $tag->name ?></p>
                                <svg class='course-create-tag-delete' width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path id="Vector" d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" />
                                    <path id="Vector_2" d="M9.16992 14.8299L14.8299 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" />
                                    <path id="Vector_3" d="M14.8299 14.8299L9.16992 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="course-create-section-inner-input">
                    <p>
                        <?php esc_html_e('کاور دوره', 'edumall-child'); ?><sup>*</sup>
                    </p>
                    <label for="course-create-cover" class="course-create-cover-input">
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

                    <div class="course-create-cover-uploaded active">
                        <img class="course-create-cover-uploaded-file" src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">

                        <a href="#">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash-create-course.svg' ?>" alt="">
                            <p>
                                <?php esc_html_e('حذف تصویر', 'edumall-child'); ?>
                            </p>
                        </a>
                    </div>

                    <input type="file" id="course-create-cover" name="course-create-cover" hidden accept="image/*">
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
                        <textarea name="" class="course-create-input" rows="6" id="course-create-description" name="course-create-description" placeholder="<?php esc_html_e('شرح دوره را مختصر و مفید اینجا بنوسید....', 'edumall-child'); ?>" data-limit="250" required> description new</textarea>
                    </div>
                </div>

                <div class="course-create-section-inner-input">
                    <label for="course-create-description-extra">
                        <?php esc_html_e('توضیحات بیشتر', 'edumall-child'); ?><sup>*</sup>
                    </label>
                    <textarea name="" rows="6" id="course-create-description-extra" name="course-create-description-extra" placeholder="<?php esc_html_e('شرح دوره را مختصر و مفید اینجا توضیحات بیشتر درباره دوره را اینجا بنوسید....', 'edumall-child'); ?>" required> description new extra</textarea>
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
                        <input id="course-create-goals" name="course-create-goals[]" placeholder="<?php esc_html_e('اهداف دوره را اینجا بنویسید...', 'edumall-child'); ?>" data-counter="1">
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
                        <textarea rows="6" id="course-create-pre" name="course-create-pre" placeholder="<?php esc_html_e('پیش‌نیاز‌های مورد نیاز این دوره را اینجا بنویسید...', 'edumall-child'); ?>"></textarea>
                    </div>

                    <div class="course-create-pre-wrap">
                        <label for="course-create-pre">
                            <?php esc_html_e('دوره‌های پیش‌نیاز', 'edumall-child'); ?>
                        </label>
                        <div class="course-create-pre-wrap-input">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                            <input type="text" name="course-create-prerequisites" placeholder="<?php esc_html_e('دوره موردنظر خود را انتخاب کنید', 'edumall-child'); ?>" class="course-create-prerequisites" id="course-create-pre">
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

                <?php foreach ($course_topics as $topic_index => $topic) : ?>
                    <div class="course-create-chapter" data-chapter="<?php echo $topic_index + 1 ?>">

                        <div class="course-create-chapter-counter">
                            <p>فصل <?php echo $topic_index + 1 ?></p>
                            <span></span>
                        </div>

                        <div class="course-create-chapter-input">
                            <label for="chapter-title">
                                <?php echo 'عنوان فصل ' . $topic_index + 1 ?><sup>*</sup>
                            </label>
                            <input type="text" name="chapter-title[]" id="chapter-title" placeholder="<?php esc_html_e('عنوان فصل', 'edumall-child'); ?>" value="<?php echo $topic->post_title ?>" required>
                        </div>

                        <?php
                        $course_lessons = get_posts([
                            'post_type' => 'lesson',
                            'post_parent' => $topic->ID,
                            'posts_per_page' => -1
                        ]);

                        foreach ($course_lessons as $lesson_topic => $lesson) :
                            try {
                                $lesson_video_meta = get_post_meta($lesson->ID, '_video', true);

                                if ($lesson_video_meta === false) {
                                    throw new Exception('Error retrieving post meta');
                                }

                                $lesson_video_meta = unserialize($lesson_video_meta);

                                if ($lesson_video_meta === false) {
                                    throw new Exception('Error unserializing post meta');
                                }

                                $lesson_video_source = !empty($lesson_video_meta['source_video_id']) ? wp_get_attachment_url($lesson_video_meta['source_video_id']) : '';
                            } catch (Exception $e) {
                                // Handle the error appropriately, e.g., log the error, show a user-friendly message, etc.
                                error_log($e->getMessage());
                                $lesson_video_source = '';
                            }
                        ?>

                            <div class="course-create-chapter-lesson" data-lesson="<?php echo $lesson_topic + 1 ?>">
                                <div class="course-create-chapter-lesson-input">
                                    <label for="lesson-title">
                                        <?php echo 'عنوان قسمت ' . $lesson_topic + 1 ?>
                                    </label>
                                    <div class="course-create-chapter-lesson-input-wrap">
                                        <span>
                                            <p>60</p>
                                            <p>/</p>
                                            <p class="course-create-counter-limit">0</p>
                                        </span>
                                        <input type="text" name="lesson-title[]" class="course-create-input" id="lesson-title" placeholder="<?php esc_html_e('عنوان قسمت', 'edumall-child'); ?>" value="<?php echo $lesson->post_title ?>" data-limit="60">
                                    </div>
                                </div>

                                <div class="course-create-chapter-lesson-input">
                                    <label for="lesson-description">
                                        <?php 'توضیحات متنی قسمت ' . $lesson_topic + 1 ?>
                                    </label>
                                    <textarea rows="6" name="" id="lesson-description[]" name="lesson-description[]" placeholder="<?php esc_html_e('توضیحات متنی دوره این قسمت را اینجا بنوسید....', 'edumall-child'); ?>"></textarea>
                                </div>

                                <div class="course-create-chapter-lesson-file">
                                    <label for="course-create-video-1-1" class="course-create-chapter-lesson-video-input <?php echo !empty($lesson_video_source) ? '' : 'active' ?>">
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

                                    <div class="course-create-video-uploaded <?php echo !empty($lesson_video_source) ? 'active' : '' ?>">
                                        <video src="<?php echo !empty($lesson_video_source) ? $lesson_video_source : '' ?>" controls></video>
                                        <a href="#">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash-create-course.svg' ?>" alt="">
                                            <p>
                                                <?php esc_html_e('حذف فیلم', 'edumall-child'); ?>
                                            </p>
                                        </a>
                                    </div>

                                    <div id="course-create-video-progress" class="course-create-video-progress">
                                        <div class="course-create-video-progress-close">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
                                        </div>
                                        <div class="course-create-video-progress-info">
                                            <div class="course-create-video-progress-info-image">
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/video-vertical.svg' ?>" alt="">
                                            </div>
                                            <div class="course-create-video-progress-info-meta">
                                                <p class="video-name"></p>
                                                <p class="video-size"></p>
                                            </div>
                                        </div>
                                        <div class="course-create-video-progress-bar">
                                            <div class="progress-bar-ribbon">
                                                <div class="progress-bar-ribbon-complete"></div>
                                            </div>
                                            <div class="progress-bar-percentage">
                                                <p>
                                                    0%
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="file" id="course-create-video-1-1" class="course-create-video" accept="video/mp4" hidden>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="course-create-add-lesson">
                            <a href="#">
                                <p>+</p>
                                <p>
                                    <?php esc_html_e('افزودن قسمت جدید', 'edumall-child'); ?>
                                </p>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

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
                        <input type="text" name="course-create-price" id="course-create-price-input" placeholder="<?php esc_html_e('قیمت دوره را اینجا بنویسید....', 'edumall-child'); ?>" value="<?php echo $course_price ?>" required>
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
                    <input type="text" placeholder="<?php esc_html_e('صورت سوال را اینجا بنویسید....', 'edumall-child'); ?>" name="course-create-question[]">
                    <textarea id="" rows="6" placeholder="<?php esc_html_e('جواب سوال بالا را اینجا بنویسید....', 'edumall-child'); ?>" name="course-create-answer[]"></textarea>
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
