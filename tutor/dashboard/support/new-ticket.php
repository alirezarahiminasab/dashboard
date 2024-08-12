<?php

use Detection\MobileDetect;

$detect = new MobileDetect();
$profile_url  = apply_filters('edumall_user_profile_url', '');
?>
<div class="new-ticket">
    <div class="new-ticket-title">
        <?php if ($detect->isMobile()) : ?>
            <a href="<?php echo esc_url($profile_url . 'support'); ?>">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
            </a>
        <?php endif; ?>
        <h3><?php esc_html_e('ثبت تیکت جدید', 'edumall-child'); ?></h3>
    </div>

    <form id="new-ticket-form" class="new-ticket-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="submit_ticket">
        <section class="new-ticket-form-group">
            <label for="ticket-subject">موضوع</label>
            <input type="text" id="ticket-subject" name="ticket-subject" placeholder="<?php esc_html_e('موضوع', 'edumall-child'); ?>" required>
        </section>

        <section class="new-ticket-form-group">
            <label for="ticket-priority">انتخاب اولویت</label>
            <select id="ticket-priority" name="ticket-priority" required>
                <option value="" selected hidden>انتخاب کنید</option>
                <option value="high">بالا</option>
                <option value="medium">متوسط</option>
                <option value="low">کم</option>
            </select>
        </section>

        <section class="new-ticket-form-group">
            <label for="ticket-category">انتخاب واحد</label>
            <select id="ticket-category" name="ticket-category" required>
                <option value="" selected hidden>انتخاب کنید</option>
                <option value="support">پشتیبانی</option>
                <option value="sales">فروش</option>
                <option value="billing">صورتحساب</option>
            </select>
        </section>

        <section class="new-ticket-form-group">
            <label for="ticket-description">توضیحات</label>
            <textarea id="ticket-description" name="ticket-description" rows="7" placeholder="<?php esc_html_e('توضیحات خود را اینجا بنوسید....', 'edumall-child'); ?>" required></textarea>
        </section>

        <section class="new-ticket-form-group new-ticket-form-attachment">
            <label for="ticket-attachment" class="ticket-attachment-container" id="ticket-attachment-container">
                <div class="before-upload">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/import.png' ?>" alt="">
                    <p class="title"><?php esc_html_e('برای آپلود فایل ضمیمه اینجا کلیک کنید', 'edumall-child'); ?></p>
                    <p><?php esc_html_e('حجم: حداکثر 20 مگابایت', 'edumall-child'); ?></p>
                    <p><?php esc_html_e('فرمت فرمت مجاز: Mp4, Mp3', 'edumall-child'); ?></p>
                </div>
            </label>
            <div class="after-upload">
                <div class="upload-info">
                    <img class="video-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/video-vertical.png' ?>" alt="">
                    <div class="file-meta">
                        <p id="file-name"></p>
                        <p id="file-size"></p>
                    </div>
                </div>
                <div id="progress-bar">
                    <div class="progress-wrap">
                        <div class="progress"></div>
                    </div>
                    <p class="progress-text">0%</p>
                </div>
            </div>
            <input type="file" id="ticket-attachment" name="ticket-attachment" accept=".mp4,.mp3" hidden>
        </section>

        <section class="new-ticket-form-group new-ticket-form-button">
            <button type="submit" name="submit-ticket">ارسال تیکت</button>
        </section>
    </form>
</div>