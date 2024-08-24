<?php
defined('ABSPATH') || exit;
require_once get_stylesheet_directory() . '\\inc\\event-module\\util.php' ; 
$profile_url = apply_filters('edumall_user_profile_url', '');
use TUTOR\Input;
get_header();
?>

<?php
class EventManager {
    private $event_id;
    private $event_data = [];
    private $tickets = [];

    public function __construct($event_id) {
        $this->event_id = $event_id;
    }

    public function fetchEventData() {
        try {
            if (empty($this->event_id)) {
                throw new Exception('No event ID provided in the URL.');
            }

            // Fetch the event data from the API using the event ID
            $event_response = EventUtil::callApi('events/' . $this->event_id, [], 'GET');
            $decoded_response = json_decode($event_response, true);

            if (!$decoded_response || $decoded_response['status'] !== 'success') {
                throw new Exception('Failed to retrieve event data for event ID: ' . $this->event_id);
            }

            $this->event_data = $decoded_response['data']['event'];
            return $this->event_data;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function fetchTickets() {
        try {
            if (empty($this->event_data)) {
                throw new Exception('Cannot fetch tickets without event data.');
            }

            // Fetch the tickets data for the event
            $tickets_response = EventUtil::callApi('tickets/' . $this->event_id, [], 'GET');
            $decoded_response = json_decode($tickets_response, true);

            if (!$decoded_response || $decoded_response['status'] !== 'success') {
                throw new Exception('Failed to retrieve tickets data for event ID: ' . $this->event_id);
            }

            $this->tickets = $decoded_response['data']['tickets'];
            return $this->tickets;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function isEdit() {
        return !empty($this->event_data);
    }
}

// Usage
$event_id = Input::get('event_id', '', Input::TYPE_STRING);
$event_data = [];
$tickets = [];
$is_edit = false;

if ($event_id) {
    $eventManager = new EventManager($event_id);
    $event_data = $eventManager->fetchEventData();
    $tickets = $eventManager->fetchTickets();
    $is_edit = $eventManager->isEdit();

    error_log(print_r($event_data, true));
    error_log(print_r($tickets, true));
}
?>

<!-- //////////////////////////////////////////////////// UI ///////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div class="event-create">
        <div class="flex justify-center bg-white">SIDEBAR</div>
        <div class="event-create-title">
            <a href="profile_url">
                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-right.png'?>" alt="">
            </a>
            <h3><?php echo $is_edit ? 'ویرایش رویداد' : 'ایجاد رویداد'; ?></h3>
        </div>

        <form action="" id="event-create-form" class="event-create-form" method="post" enctype="multipart/form-data">

            <!-- SECTION -->
            <div id="event-create-topic" class="event-create-section ">
                <div class="event-create-section-inner event-create-topic">
                    <h1><?php echo $is_edit ? 'ویرایش رویداد' : 'ایجاد رویداد'; ?></h1>


                    <h2 for="event-create-topic">مشخصات رویداد</h2>


                    <div class="event-create-section-inner-input">
                        <label for="event-create-title">
                            عنوان رویداد <sup>*</sup>
                        </label>
                        <div class="event-create-section-inner-input-wrap">
                            <span>
                                <p>60</p>
                                <p>/</p>
                                <p class="event-create-counter-limit"><?php echo $is_edit ? strlen($event_data['title']) : '0'; ?></p>
                            </span>
                            <input type="text" class="event-create-input" name="event-create-title" id="event-create-title"
                                placeholder="عنوان رویداد" data-limit="60" _require value="<?php echo esc_attr($is_edit ? $event_data['title'] : ''); ?>">
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
                                <option value="برچسب اول" <?php echo $is_edit && $event_data['category'] === 'برچسب اول' ? 'selected' : ''; ?>>برچسب اول</option>
                                <option value="برچسب دوم" <?php echo $is_edit && $event_data['category'] === 'برچسب دوم' ? 'selected' : ''; ?>>برچسب دوم</option>
                                <option value="برچسب سوم" <?php echo $is_edit && $event_data['category'] === 'برچسب سوم' ? 'selected' : ''; ?>>برچسب سوم</option>
                                <option value="برچسب چهارم" <?php echo $is_edit && $event_data['category'] === 'برچسب چهارم' ? 'selected' : ''; ?>>برچسب چهارم</option>
                            
                            </select>
                        </div>
                    </div>

                    <?php
                    $allTags = ["برچسب اول", "برچسب دوم", "برچسب سوم", "برچسب چهارم"];
                    // If it's edit mode, remove selected tags from all tags for the dropdown options
                    if ($is_edit) {
                        $selectedTags = $event_data['tags'];
                        $unselectedTags = array_diff($allTags, $selectedTags);
                    } else {
                        $unselectedTags = $allTags; // If not in edit mode, show all tags
                    }
                    ?>

                    <div class="event-create-section-inner-input event-create-tags">
                        <label for="event-create-tags">
                            برچسب‌ها <sup>*</sup>
                        </label>
                        <div class="event-create-section-inner-input-wrap">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                            <select type="text" name="event-create-tags" id="event-create-tags-dropdown"
                                class=" event-create-tags-dropdown">
                                <option value="" hidden>
                                    انتخاب کنید (حداکثر 5 برچسب)
                                </option>
                                <?php foreach ($unselectedTags as $tag): ?>
                                    <option value="<?php echo $tag; ?>"><?php echo $tag; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="event-create-tags-list">
                            <?php if ($is_edit): ?>
                                <?php foreach ($selectedTags as $tag): ?>
                                    <span>
                                        <p><?php echo $tag; ?></p>
                                        <svg class='event-create-tag-delete' width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path id="Vector" d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path id="Vector_2" d="M9.16992 14.8299L14.8299 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path id="Vector_3" d="M14.8299 14.8299L9.16992 9.16992" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="event-create-section-inner-input">
                        <p>
                            کاور رویداد<sup>*</sup>
                        </p>

                        <label for="event-create-cover" class="event-create-cover-input <?php echo $is_edit ? '' : 'active'; ?>">
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/gallery-export.svg'?>" alt="">
                                <p>حجم: حداکثر 20 مگابایت
                                </p>
                            </span>
                            <a>
                                آپلود کاور</a>
                        </label>

                        <div class="event-create-cover-uploaded <?php echo $is_edit ? 'active' : ''; ?>">
                            <img class="event-create-cover-uploaded-file" src="<?php echo esc_attr($is_edit ? $event_data['imageURL'] : 'empty'); ?>" fileName="<?php echo $is_edit ? "from_database" : "empty"; ?>" alt="">
                       
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
                        <textarea name="event-create-description" rows="6" id="event-create-description-extra" placeholder="توضیحات خود را درباره رویداد اینجا بنویسید..." _require><?php echo esc_textarea($is_edit ? $event_data['description'] : ''); ?></textarea>
                    </div>


                    <h2 for="date-time">زمان و مکان رویداد</h2>

                    <div class="event-create-column-2fr-1fr">


                        <div class="event-create-section-inner-input">
                            <label for="start-date">
                                تاریخ شروع <sup>*</sup>
                            </label>
                            <div class="event-create-section-inner-input-wrap">
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                                <input name="event-create-start-date" data-jdp data-jdp-only-date type="text" 
                                    placeholder="تاریخ شروع" _require value="<?php echo $is_edit ? jdate('Y/m/d', $event_data['startDateTime'], 'none', 'Asia/Tehran', 'en') : ''; ?>">
                            </div>
                        </div>

                        <div class="event-create-section-inner-input">
                            <label for="start-time">
                                ساعت شروع <sup>*</sup>
                            </label>
                            <input name="event-create-start-time" data-jdp data-jdp-only-time type="text" placeholder="00:00" class="event-create-input-time" _require value="<?php echo $is_edit ? jdate('H:i', $event_data['startDateTime'], 'none', 'Asia/Tehran', 'en') : ''; ?>">
                        </div>

                        <div class="event-create-section-inner-input">
                            <label for="start-date">
                                تاریخ پایان <sup>*</sup>
                            </label>
                            <div class="event-create-section-inner-input-wrap">
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrow-down.svg'?>" alt="">
                                <input name="event-create-finish-date" data-jdp data-jdp-only-date type="text" 
                                    placeholder="تاریخ پایان" _require value="<?php echo $is_edit ? jdate('Y/m/d', $event_data['finishDateTime'], 'none', 'Asia/Tehran', 'en') : ''; ?>">
                            </div>
                        </div>

                        <div class="event-create-section-inner-input">
                            <label for="start-time">
                                ساعت پایان <sup>*</sup>
                            </label>
                            <input name="event-create-finish-time" data-jdp data-jdp-only-time type="text" placeholder="00:00" class="event-create-input-time" _require value="<?php echo $is_edit ? jdate('H:i', $event_data['finishDateTime'], 'none', 'Asia/Tehran', 'en') : ''; ?>">
                            <!-- <input  maxlength="5" type="text" placeholder="00:00"> -->
                        </div>


                    </div>
                </div>
            </div>

            <p id="create_online_event_edit_mode" style="display:none;"><?php echo $is_edit ? 'true' : 'false'; ?></p>
            <p id="create_online_event_data" style="display:none;"><?php echo htmlspecialchars(json_encode($event_data), ENT_QUOTES, 'UTF-8'); ?></p>
            <p id="create_online_event_tickets" style="display:none;"><?php echo htmlspecialchars(json_encode($tickets), ENT_QUOTES, 'UTF-8'); ?></p>

            <!-- SECTION -->

            <div id="event-create-sessions" class="event-create-section ">

                <div class="event-create-section-inner event-create-sessions <?php echo empty($event_data['sessions']) ? 'active' : ''; ?>">

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

                    <div class="event-create-column-2fr-1fr-1fr">
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

                            <input name="event-create-session-start-time" data-jdp data-jdp-only-time type="text" placeholder="00:00" class="event-create-input-time" _require>

                        </div>
                        <div class="event-create-section-inner-input">
                            <label for="start-time">
                                ساعت پایان <sup>*</sup>
                            </label>
                            <input name="event-create-session-finish-time" data-jdp data-jdp-only-time type="text" placeholder="00:00" class="event-create-input-time" _require>
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
                    <div class="event-create-column-1fr-1fr mt-4">
                        <a class="event-create-btn-pink-fill event-create-btn-submit">
                            ذخیره</a>

                        <a class="event-create-btn-pink-outline event-create-btn-cancel ">
                            انصراف</a>
                    </div>
                </div>


                <div class="event-create-section-inner event-create-sessions-full <?php echo empty($event_data['sessions']) ? '' : 'active'; ?>">
                    <h2>
                        جلسات رویداد
                    </h2>

                    <a class="event-create-btn-pink-fill event-create-add-content">
                        + ایجاد جلسه</a>

                    <span class="event-create-dash-line"></span>


                    <div id="base-card-template" class="event-create-card-type1" style="display: none;">
                        <div class="flex justify-between p-3">
                            <p ref="event-create-session-title"></p>
                            <span>
                            <img class="h-fit event-create-edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                            <img class="h-fit event-create-delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                            </span>
                        </div>
                        <div class="event-create-more">
                            <div class="event-create-column">
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/3d-cube-scan.png'?>" alt="">
                                <p ref="event-create-session-platform"></p>
                            </span>
                            <span>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/toggle-off-circle.png'?>" alt="">
                                <p>فعال</p>
                            </span>
                            </div>
                            <div class="event-create-column">
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

                    <!-- Pre-filled session cards -->
                    <?php 
                    if($is_edit){                    
                    $session_counter = 1; // Initialize counter for sessions
                    foreach ($event_data['sessions'] as $session): ?>
                        <div class="event-create-card-type1" data-id="<?php echo $session_counter; ?>">
                            <div class="flex justify-between p-3">
                                <p ref="event-create-session-title"><?php echo esc_html($session['title']); ?></p>
                                <span>
                                    <img class="h-fit event-create-edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                                    <img class="h-fit event-create-delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                                </span>
                            </div>
                            <div class="event-create-more">
                                <div class="event-create-column">
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/3d-cube-scan.png'?>" alt="">
                                        <p ref="event-create-session-platform"><?php echo esc_html($session['platform']); ?></p>
                                    </span>
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/toggle-off-circle.png'?>" alt="">
                                        <p>فعال</p>
                                    </span>
                                </div>
                                <div class="event-create-column">
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                        <p ref="event-create-session-start-date"><?php echo jdate('Y/m/d - H:i', $session['startDateTime'], 'none', 'Asia/Tehran', 'en'); ?></p>
                                    </span>
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                        <p ref="event-create-session-finish-date"><?php echo jdate('Y/m/d - H:i', $session['finishDateTime'], 'none', 'Asia/Tehran', 'en'); ?></p>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php 
                        $session_counter++; // Increment the counter
                        endforeach;} 
                        ?>
        
                </div>

            </div>

            <!-- SECTION -->

            <div id="event-create-tickets" class="event-create-section ">
                <div class="event-create-section-inner event-create-tickets <?php echo empty($tickets) ? 'active' : ''; ?>">


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

                    <p class="event-create-free-ticket-description">برای تعریف بلیط رایگان، مبلغ 0 را وارد کنید</p>

                    <div class="event-create-column-1fr-1fr">
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

                        <a class="event-create-btn-pink-fill event-create-btn-submit">
                            ذخیره بلیط</a>

                        <a class="event-create-btn-pink-outline event-create-btn-cancel event-create-disabled">
                            انصراف</a>
                    </div>
                </div>


                <div class="event-create-section-inner event-create-tickets-full <?php echo empty($tickets) ? '' : 'active'; ?> ">
                    <h2>
                        بلیط ها
                    </h2>

                    <a class="event-create-btn-pink-fill event-create-add-content">
                        + افزودن بلیط</a>

                    <span class="event-create-dash-line"></span>

                    <div id="base-ticket-card-template" class="event-create-card-type1" style="display: none;">
                        <div class="flex justify-between p-3">
                            <p ref="event-create-ticket-title"></p>
                            <span>
                                <img class="h-fit event-create-edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                                <img class="h-fit event-create-delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                            </span>
                        </div>
                        <div class="event-create-more">
                            <div class="event-create-column">
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/profile-2user.png'?>" alt="">
                                    <p ref="event-create-ticket-number"></p>
                                </span>
                                <span>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/money.png'?>" alt="">
                                    <p ref="event-create-ticket-price"></p>
                                </span>
                            </div>
                            <div class="event-create-column">
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

                    <!-- Pre-filled ticket cards -->
                    <?php 
                    if($is_edit){                    

                    $ticket_counter = 1; // Initialize counter for tickets
                    foreach ($tickets as $ticket): ?>
                        <div class="event-create-card-type1 " data-id="<?php echo $ticket_counter; ?>">
                            <div class="flex justify-between p-3">
                                <p ref="event-create-ticket-title"><?php echo esc_html($ticket['title']); ?></p>
                                <span>
                                    <img class="h-fit event-create-edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                                    <img class="h-fit event-create-delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                                </span>
                            </div>
                            <div class="event-create-more">
                                <div class="event-create-column">
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/profile-2user.png'?>" alt="">
                                        <p ref="event-create-ticket-number"><?php echo esc_html($ticket['count']); ?></p>
                                    </span>
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/money.png'?>" alt="">
                                        <p ref="event-create-ticket-price"><?php echo esc_html(number_format($ticket['price'])); ?> تومان</p>
                                    </span>
                                </div>
                                <div class="event-create-column">
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                        <p ref="event-create-sale-start-date"><?php echo jdate('Y/m/d - H:i', $ticket['startDateTime'], 'none', 'Asia/Tehran', 'en'); ?></p>
                                    </span>
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/calendar-2.png'?>" alt="">
                                        <p ref="event-create-sale-finish-date"><?php echo jdate('Y/m/d - H:i', $ticket['finishDateTime'], 'none', 'Asia/Tehran', 'en'); ?></p>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php 
                    $ticket_counter++; // Increment the counter
                    endforeach; }
                    ?>

                </div>
            </div>

            <!-- SECTION -->

            <div id="event-create-companions" class="event-create-section ">
                <div class="event-create-section-inner event-create-companions <?php echo empty($event_data['companions']) ? 'active' : ''; ?>">

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

                        <label for="event-create-logo" class="event-create-logo-input event-create-logo active">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/export.svg'?>" alt="">
                            <p>برای آپلود لوگو اینجا کلیک کنید
                            </p>
                            <p class="event-create-small">حجم: حداکثر 2 مگابایت</p>
                        </label>

                        <div class="event-create-logo-uploaded ">
                            <img class="event-create-logo-uploaded-file" src="<?php echo tutor()->url . 'assets/images/placeholder.svg'?>" fileName="" alt="">

                            <a>
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash-create-course.svg'?>" alt="">
                                <p>
                                    حذف تصویر</p>
                            </a>
                        </div>

                        <input type="file" name="event-create-companion-logo" id="event-create-logo" hidden  accept="image/*">
                    </div>



                    <div class="event-create-column-1fr-1fr mt-4">
                        <a class="event-create-btn-pink-fill event-create-btn-submit">
                            ذخیره</a>

                        <a class="event-create-btn-pink-outline event-create-btn-cancel ">
                            انصراف</a>
                    </div>

                </div>


                <div class="event-create-section-inner event-create-companions-full <?php echo empty($event_data['companions']) ? '' : 'active'; ?> ">
                    <h2>
                        همراهان
                    </h2>

                    <a class="event-create-btn-pink-fill event-create-add-content">
                        + افزودن همراه</a>

                    <span class="event-create-dash-line"></span>

                    <div id="base-companion-card-template" class="event-create-card-type2" style="display: none;">
                        <div class="flex justify-between p-3">
                            <span>
                                <img src="<?php echo tutor()->url . 'assets/images/placeholder.svg'?>" class="rounded-full" ref="event-create-companion-logo">
                                <p ref="event-create-companion-name"></p>
                            </span>
                            <span>
                                <img class="event-create-with-black-border event-create-edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                                <img class="event-create-with-pink-border event-create-delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                            </span>
                        </div>
                    </div>

                    <!-- Pre-filled companion cards -->
                    <?php 
                    if($is_edit){                    
                    $companion_counter = 1; // Initialize counter for companions
                    foreach ($event_data['companions'] as $companion): ?>
                        <div class="event-create-card-type2 " data-id="<?php echo $companion_counter; ?>">
                            <div class="flex justify-between p-3">
                                <span>
                                    <img src="<?php echo esc_attr(!empty($companion['logoURL'])?$companion['logoURL']:tutor()->url . 'assets/images/placeholder.svg'); ?>" class="rounded-full" ref="event-create-companion-logo">
                                    <p ref="event-create-companion-name"><?php echo esc_html($companion['name']); ?></p>
                                </span>
                                <span>
                                    <img class="event-create-with-black-border event-create-edit-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/edit-2.png'?>" alt="">
                                    <img class="event-create-with-pink-border event-create-delete-card" src="<?php echo get_stylesheet_directory_uri().'/assets/images/trash.png'?>" alt="">
                                </span>
                            </div>
                        </div>
                    <?php 
                    $companion_counter++; // Increment the counter
                    endforeach; }
                    ?>

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
                        <?php echo $is_edit ? 'ثبت تغییرات' : 'انتشار'; ?></button>
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