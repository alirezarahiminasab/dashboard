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

<div class="event-create">
        <div class="flex justify-center bg-white">SIDEBAR</div>
        <div class="event-create-title">
            <a href="profile_url">
                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-right.png'?>" alt="">
            </a>
            <h3>
                ایجاد رویداد
            </h3>
        </div>

        <form action="" id="event-create-form" class="event-create-form" method="post" enctype="multipart/form-data">

            <!-- SECTION -->
            <div id="event-create-topic" class="event-create-section ">
                <div class="event-create-section-inner event-create-topic">
                    <h1>ایجاد رویداد</h1>


                    <h2 for="event-create-topic">مشخصات رویداد</h2>


                    <div class="event-create-section-inner-input">
                        <label for="event-create-title">
                            عنوان رویداد <sup>*</sup>
                        </label>
                        <div class="event-create-section-inner-input-wrap">
                            <span>
                                <p>60</p>
                                <p>/</p>
                                <p class="event-create-counter-limit">0</p>
                            </span>
                            <input type="text" class="event-create-input" name="event-create-title" id="event-create-title"
                                placeholder="عنوان رویداد" data-limit="60" _require >
                        </div>
                    </div>

                    
                    <div class="event-create-section-inner-input">
                        <label for="event-create-category">
                            دسته بندی اصلی <sup>*</sup>
                        </label>
                        <div class="event-create-section-inner-input-wrap">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                            <select type="text" name="event-create-category" id="event-create-category" _require>
                                <option value="" hidden selected>
                                    انتخاب کنید</option>
                                <option value="برچسب اول">برچسب اول</option>
                                <option value="برچسب دوم">برچسب دوم</option>
                                <option value="برچسب سوم">برچسب سوم</option>
                                <option value="برچسب چهارم">برچسب چهارم</option>
                            </select>
                        </div>
                    </div>

                    <div class="event-create-section-inner-input event-create-tags">
                        <label for="event-create-tags">
                            برچسب‌ها <sup>*</sup>
                        </label>
                        <div class="event-create-section-inner-input-wrap">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                            <select type="text" name="event-create-tags" id="event-create-tags-dropdown"
                                class=" event-create-tags-dropdown">
                                <option value="" hidden selected>
                                    انتخاب کنید (حداکثر 5 برچسب)
                                </option>
                                <option value="برچسب اول">برچسب اول</option>
                                <option value="برچسب دوم">برچسب دوم</option>
                                <option value="برچسب سوم">برچسب سوم</option>
                                <option value="برچسب چهارم">برچسب چهارم</option>
                            </select>
                        </div>

                        <div class="event-create-tags-list"></div>
                    </div>

                    <div class="event-create-section-inner-input">
                        <p>
                            کاور رویداد<sup>*</sup>
                        </p>

                        <label for="event-create-cover" class="event-create-cover-input active">
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/gallery-export.svg'?>" alt="">
                                <p>حجم: حداکثر 20 مگابایت
                                </p>
                            </span>
                            <a>
                                آپلود کاور</a>
                        </label>

                        <div class="event-create-cover-uploaded">
                            <img class="event-create-cover-uploaded-file" src="<?php echo get_stylesheet_directory_uri().'/assets/images/404-1.png'?>" alt="">

                            <a>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash-create-course.svg'?>" alt="">
                                <p>
                                    حذف تصویر</p>
                            </a>
                        </div>

                        <input type="file" id="event-create-cover" name="event-create-cover" hidden  accept="image/*" _require>
                    </div>



                    <div class="event-create-section-inner-input">
                        <label for="event-create-description-extra">
                            توضیحات رویداد<sup>*</sup>
                        </label>
                        <textarea name="event-create-description" rows="6" id="event-create-description-extra"
                            placeholder="توضیحات خود را درباره رویداد اینجا بنویسید..." _require></textarea>
                    </div>


                    <h2 for="date-time">زمان و مکان رویداد</h2>

                    <div class="column-2fr-1fr">


                        <div class="event-create-section-inner-input">
                            <label for="start-date">
                                تاریخ شروع <sup>*</sup>
                            </label>
                            <div class="event-create-section-inner-input-wrap">
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                                <input name="event-create-start-date" data-jdp data-jdp-only-date type="text" class="input-time"
                                    placeholder="تاریخ شروع" _require>
                            </div>
                        </div>

                        <div class="event-create-section-inner-input">
                            <label for="start-time">
                                ساعت شروع <sup>*</sup>
                            </label>
                            <input name="event-create-start-time" data-jdp data-jdp-only-time type="text" placeholder="00:00" class="input-time" _require>
                        </div>

                        <div class="event-create-section-inner-input">
                            <label for="start-date">
                                تاریخ پایان <sup>*</sup>
                            </label>
                            <div class="event-create-section-inner-input-wrap">
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                                <input name="event-create-finish-date" data-jdp data-jdp-only-date type="text" class="input-time"
                                    placeholder="تاریخ پایان" _require>
                            </div>
                        </div>

                        <div class="event-create-section-inner-input">
                            <label for="start-time">
                                ساعت پایان <sup>*</sup>
                            </label>
                            <input name="event-create-finish-time" data-jdp data-jdp-only-time type="text" placeholder="00:00" class="input-time" _require>
                            <!-- <input class="input-time" maxlength="5" type="text" placeholder="00:00"> -->
                        </div>


                    </div>
                </div>
            </div>

            <!-- SECTION -->

            <div id="event-create-sessions" class="event-create-section ">

                <div class="event-create-section-inner event-create-sessions active">

                    <div class="event-create-section-inner-input">
                        <h2>
                            جلسات رویداد
                        </h2>

                        <label for="event-create-emtpy-sessions" class="event-create-empty-section active">
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/empty-box 1.png'?>" alt="">
                                <p>هنوز جلسه ای ایجاد نکرده اید. </p>
                            </span>

                            <a class="event-create-extract-content">
                                + ایجاد جلسه</a>
                        </label>

                    </div>
                </div>


                <div class="event-create-section-inner event-create-sessions-form">

                    <h2>
                        جلسات رویداد
                    </h2>


                    <div class="event-create-section-inner-input">
                        <label for="event-create-session-title">
                            عنوان جلسه <sup>*</sup>
                        </label>
                        <div class="event-create-section-inner-input-wrap">
                            <span>
                                <p>60</p>
                                <p>/</p>
                                <p class="event-create-counter-limit">0</p>
                            </span>

                            <!-- TODO -->
                            <input type="text" class="event-create-input" name="event-create-session-title"                                 placeholder="عنوان جلسه" data-limit="60" _require>
                        </div>
                    </div>

                    <div class="event-create-section-inner-input">
                        <label for="event-create-description-extra">
                            توضیحات </label>
                        <textarea name="event-create-session-description" id="event-create-description-extra" rows="6"></textarea>
                    </div>

                    <div class="column-2fr-1fr-1fr">
                        <div class="event-create-section-inner-input">
                            <label for="start-date">
                                تاریخ جلسه <sup>*</sup>
                            </label>
                            <div class="event-create-section-inner-input-wrap">
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">

                                <input name="event-create-session-date" data-jdp data-jdp-only-date type="text" placeholder="تاریخ جلسه" _require>

                            </div>
                        </div>

                        <div class="event-create-section-inner-input">
                            <label for="start-time">
                                ساعت شروع <sup>*</sup>
                            </label>

                            <input name="event-create-session-start-time" data-jdp data-jdp-only-time type="text" placeholder="00:00" class="input-time" _require>

                        </div>
                        <div class="event-create-section-inner-input">
                            <label for="start-time">
                                ساعت پایان <sup>*</sup>
                            </label>
                            <input name="event-create-session-finish-time" data-jdp data-jdp-only-time type="text" placeholder="00:00" class="input-time" _require>
                        </div>
                    </div>

                    <div class="event-create-section-inner-input">
                        <label for="event-create-platform">
                            پلتفرم برگزاری <sup>*</sup>
                        </label>
                        <div class="event-create-section-inner-input-wrap">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                            <select type="text" name="event-create-platform" id="event-create-platform"  _require>
                                <option value="" hidden selected >
                                    پلتفرم برگزاری</option>
                                <option value="پلتفرم هانیل (قدرت گرفته از اسکای روم)">پلتفرم هانیل (قدرت گرفته از اسکای روم)</option>
                                <option value="آپارات">آپارات</option>
                                <option value="بیگ بلو باتن">بیگ بلو باتن</option>
                                <option value="گوگل میت">گوگل میت</option>
                            </select>
                        </div>
                    </div>

                    <div class="event-create-section-inner-input">
                        <label for="event-create-platform-link">
                            لینک پلتفرم <sup>*</sup>
                        </label>
                        <input type="text" name="event-create-platform-link" placeholder="لینک پلتفرم" _require>
                    </div>
                    <div class="column-1fr-1fr mt-4">
                        <a class="btn-pink-fill btn-submit">
                            ذخیره</a>

                        <a class="btn-pink-outline btn-cancel ">
                            انصراف</a>
                    </div>
                </div>


                <div class="event-create-section-inner event-create-sessions-full ">
                    <h2>
                        جلسات رویداد
                    </h2>

                    <a class="btn-pink-fill event-create-add-content">
                        + ایجاد جلسه</a>

                    <span class="dash-line"></span>


                    <div id="base-card-template" class="card-type1" style="display: none;">
                        <div class="flex justify-between p-3">
                            <p ref="event-create-session-title"></p>
                            <span>
                            <img class="h-fit edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                            <img class="h-fit delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                            </span>
                        </div>
                        <div class="more">
                            <div class="column">
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/3d-cube-scan.png'?>" alt="">
                                <p ref="event-create-session-platform"></p>
                            </span>
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/toggle-off-circle.png'?>" alt="">
                                <p>فعال</p>
                            </span>
                            </div>
                            <div class="column">
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                <p ref="event-create-session-start-date"></p>
                            </span>
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                <p ref="event-create-session-finish-date"></p>
                            </span>
                            </div>
                        </div>
                    </div>

                    
                </div>

            </div>

            <!-- SECTION -->

            <div id="event-create-tickets" class="event-create-section ">
                <div class="event-create-section-inner event-create-tickets active">


                    <h2 for="event-create-topic">بلیط ها</h2>


                    <div class="event-create-section-inner-input">
                        <label for="event-create-ticket-title">
                            عنوان بلیط <sup>*</sup>
                        </label>
                        <div class="event-create-section-inner-input-wrap">
                            <span>
                                <p>60</p>
                                <p>/</p>
                                <p class="event-create-counter-limit">0</p>
                            </span>
                            <input type="text" class=" event-create-input" name="event-create-ticket-title" id="event-create-ticket-title"
                                placeholder="عنوان بلیط" data-limit="60" >
                        </div>
                    </div>

                    <div class="event-create-section-inner-input">
                        <label for="event-create-category_____">
                            تعداد <sup>*</sup>
                        </label>
                        <input type="number" name="event-create-ticket-number" placeholder="تعداد">
                    </div>
                    <div class="event-create-section-inner-input">
                        <label for="event-create-category_____">
                            مبلغ <sup>*</sup>
                        </label>
                        <input type="number" name="event-create-ticket-price" placeholder="مبلغ بلیط">
                    </div>

                    <p class="free-ticket-description">برای تعریف بلیط رایگان، مبلغ 0 را وارد کنید</p>

                    <div class="column-1fr-1fr">
                        <div class="event-create-section-inner-input">
                            <label for="start-date">
                                تاریخ شروع فروش <sup>*</sup>
                            </label>
                            <div class="event-create-section-inner-input-wrap">
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                                <input name="event-create-sale-start-date" data-jdp  type="text" placeholder="تاریخ شروع">
                            </div>
                        </div>

                        <div class="event-create-section-inner-input">
                            <label for="start-date">
                                تاریخ پایان فروش <sup>*</sup>
                            </label>
                            <div class="event-create-section-inner-input-wrap">
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">

                                <input data-jdp  name="event-create-sale-finish-date" type="text" placeholder="تاریخ پایان">

                            </div>
                        </div>

                        <a class="btn-pink-fill btn-submit">
                            ذخیره بلیط</a>

                        <a class="btn-pink-outline btn-cancel disabled">
                            انصراف</a>
                    </div>
                    <!-- <a class="btn-pink-fill event-create-extract-content">
                        ذخیره بلیط</a> -->
                </div>


                <div class="event-create-section-inner event-create-tickets-full ">
                    <h2>
                        بلیط ها
                    </h2>

                    <a class="btn-pink-fill event-create-add-content">
                        + افزودن بلیط</a>

                    <span class="dash-line"></span>

                    <!-- <div class="card-type1">

                        <div class="flex justify-between p-3">
                            <p>
                                بلیط زود هنگام برای 10 نفر اول
                            </p>
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                            </span>
                        </div>

                        <div class="more  ">
                            <div class="column">
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/profile-2user.png'?>" alt="">
                                    <p>120</p>
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/money.png'?>" alt="">
                                    <p>1،200،000 تومان</p>
                                </span>

                            </div>
                            <div class="column">

                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                    <p>1402/08/14 - 18:00</p>
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                    <p>1402/05/12 - 11:00</p>
                                </span>
                            </div>
                        </div>

                    </div> -->


                    <div id="base-ticket-card-template" class="card-type1" style="display: none;">
                        <div class="flex justify-between p-3">
                            <p ref="event-create-ticket-title"></p>
                            <span>
                                <img class="h-fit edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                                <img class="h-fit delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                            </span>
                        </div>
                        <div class="more">
                            <div class="column">
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/profile-2user.png'?>" alt="">
                                    <p ref="event-create-ticket-number"></p>
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/money.png'?>" alt="">
                                    <p ref="event-create-ticket-price"></p>
                                </span>
                            </div>
                            <div class="column">
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                    <p ref="event-create-sale-start-date"></p>
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                    <p ref="event-create-sale-finish-date"></p>
                                </span>
                            </div>
                        </div>
                    </div>




                </div>
            </div>

            <!-- SECTION -->

            <div id="event-create-companions" class="event-create-section ">
                <div class="event-create-section-inner event-create-companions active">

                    <div class="event-create-section-inner-input">
                        <h2>
                            همراهان
                        </h2>

                        <label for="event-create-empty-companions" class="event-create-empty-section active">
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/empty-box 1.png'?>" alt="">
                                <p>هنوز همراهی ایجاد نکرده اید. </p>
                            </span>
                            <a class="event-create-extract-content">
                                + همراه جدید</a>
                        </label>


                    </div>
                </div>

                <div class="event-create-section-inner event-create-companions-form  ">

                    <h2 for="event-create-topic">همراهان</h2>

                    <div class="event-create-section-inner-input">
                        <label for="event-create-category____">
                            نام
                        </label>
                        <input type="text" name="event-create-companion-name" placeholder="نام">
                    </div>



                    <div class="event-create-section-inner-input ">
                        <p>
                            لوگو
                        </p>

                        <label for="event-create-logo" class="event-create-logo-input logo active">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/export.svg'?>" alt="">
                            <p>برای آپلود لوگو اینجا کلیک کنید
                            </p>
                            <p class="small">حجم: حداکثر 2 مگابایت</p>
                        </label>

                        <div class="event-create-logo-uploaded ">
                            <img class="event-create-logo-uploaded-file" src="<?php echo get_stylesheet_directory_uri().'/assets/images/404-1.png'?>" alt="">

                            <a>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash-create-course.svg'?>" alt="">
                                <p>
                                    حذف تصویر</p>
                            </a>
                        </div>

                        <input type="file" name="event-create-companion-logo" id="event-create-logo" hidden  accept="image/*">
                    </div>



                    <div class="column-1fr-1fr mt-4">
                        <a class="btn-pink-fill btn-submit">
                            ذخیره</a>

                        <a class="btn-pink-outline btn-cancel ">
                            انصراف</a>
                    </div>

                </div>


                <div class="event-create-section-inner event-create-companions-full  ">
                    <h2>
                        همراهان
                    </h2>

                    <a class="btn-pink-fill event-create-add-content">
                        + افزودن همراه</a>

                    <span class="dash-line"></span>

                    <div id="base-companion-card-template" class="card-type2" style="display: none;">
                        <div class="flex justify-between p-3">
                            <span>
                                <img src="<?php echo tutor()->url . 'assets/images/placeholder.svg'?>" class="rounded-full" ref="event-create-companion-logo">
                                <p ref="event-create-companion-name"></p>
                            </span>
                            <span>
                                <img class="with-black-border edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                                <img class="with-pink-border delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                            </span>
                        </div>
                    </div>


                </div>

            </div>


            <!-- SECTION -->

            <div id="event-create-submit" class="event-create-section ">
                <div class="event-create-section-inner event-create-submit">
                    <div class="event-create-submit-check">
                        <input type="checkbox" />
                        <span>
                            <p>

                                من قوانین هانیل را خوانده ام و با آنها موافقت می کنم.
                            </p>
                        </span>


                    </div>
                    <div class="event-create-submit-btn">
                        <input type="text" name="action" value="create_event" hidden/>

                        <button type="submit" disabled="true">
                            انتشار</button>
                    </div>
                </div>
            </div>
    </div>

    </form>
    </div>




<?php do_action('tutor/dashboard_course_builder_after'); ?>

<?php do_action('tutor_load_template_after', 'dashboard.create-course', null); ?>

<?php get_footer();?>

<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>