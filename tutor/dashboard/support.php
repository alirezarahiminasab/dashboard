<?php
// $enrolled_courses_action = tutor_utils()->get_tutor_dashboard_page_permalink('my-students/enrolled-courses/?student_id=' . $student->ID);
use Detection\MobileDetect;

$detect = new MobileDetect();
$new_ticket_url = tutor_utils()->get_tutor_dashboard_page_permalink('support/new-ticket');
$profile_url  = apply_filters('edumall_user_profile_url', '');
?>

<?php if ($detect->isMobile()) : ?>
    <div class="edit-profile-title">
        <a href="<?php echo esc_url($profile_url . '/?menu=tutor'); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
        <h3><?php esc_html_e('تیکت ها', 'edumall-child'); ?></h3>
    </div>
<?php endif; ?>

<div class="support">
    <div class="support-wrap">
        <?php if (is_user_logged_in()) :
            $current_user = wp_get_current_user();
            $args = array(
                'post_type' => 'ticket',
                'author'    => $current_user->ID,
            );
            $tickets = new WP_Query($args);

            if ($tickets->have_posts()) : ?>
                <div class="support-wrap-tickets">
                    <div class="support-wrap-tickets-buttons">
                        <?php if (!$detect->isMobile()) : ?>
                            <div class="support-wrap-tickets-title">
                                <h3><?php esc_html_e('تیکت ها', 'edumall-child'); ?></h3>
                            </div>
                        <?php endif; ?>

                        <?php if (!$detect->isMobile()) : ?>
                            <div class="support-buttons-wrap">
                            <?php endif ?>
                            <div class="support-wrap-new">
                                <a href="<?php echo esc_url($new_ticket_url); ?>" class="new-ticket-button tickets-items"><?php esc_html_e('ثبت تیکت جدید', 'edumall-child'); ?></a>
                            </div>

                            <div class="support-wrap-filter">
                                <a href="#">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/filter.svg' ?>" alt="">
                                    <?php esc_html_e('فیلترها', 'edumall-child'); ?>
                                </a>
                            </div>

                            <?php if (!$detect->isMobile()) : ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="support-wrap-tickets-content">
                        <div class="support-wrap-tickets-content-header">
                            <div class="support-wrap-tickets-content-title">
                                <p>
                                    <?php esc_html_e('لیست تیکت ها', 'edumall-child'); ?>
                                </p>
                            </div>

                            <div class="support-wrap-tickets-content-sort">
                                <a href="#">
                                    <?php esc_html_e('مرتب سازی بر اساس', 'edumall-child'); ?>
                                </a>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-down.svg' ?>" alt="">
                            </div>
                        </div>

                        <div class="support-wrap-tickets-content-footer">
                            <?php
                            while ($tickets->have_posts()) : $tickets->the_post();
                                $ticket_status = get_post_meta(get_the_ID(), '_ticket_status', true);
                                $ticket_new_comment = get_post_meta(get_the_ID(), '_new_admin_comment', true);
                                $ticket_value = '';
                                $ticket_class = '';

                                switch (true):
                                    case ($ticket_status === 'wait'):
                                        $ticket_value = 'در انتظار پاسخ';
                                        break;
                                    case ($ticket_status === 'check'):
                                        $ticket_value = 'در حال بررسی';
                                        break;
                                    case ($ticket_status === 'replied'):
                                        $ticket_value = 'پاسخ داده شده';
                                        break;
                                    case ($ticket_status === 'closed'):
                                        $ticket_value = 'بسته شده';
                                        break;
                                endswitch;
                            ?>
                                <div class="support-wrap-tickets-content-footer-item<?php echo $ticket_new_comment ? ' active' : '' ?>">
                                    <div class="support-wrap-tickets-content-footer-title">
                                        <a href="<?php echo  tutor_utils()->get_tutor_dashboard_page_permalink('support/ticket?id=' . get_the_ID()) ?>">
                                            <?php echo get_the_title() ?>
                                        </a>
                                    </div>
                                    <div class="support-wrap-tickets-content-footer-meta">
                                        <span class="support-wrap-tickets-content-footer-meta-status">
                                            <p><?php esc_html_e('وضعیت: ', 'edumall-child'); ?></p>
                                            <p class="<?php echo 'ticket-status-' . $ticket_status ?>"><?php echo $ticket_value ?></p>
                                        </span>
                                        <span class="support-wrap-tickets-content-footer-meta-date">
                                            <p>
                                                <?php echo get_the_date('Y/m/d')  ?>
                                            </p>
                                        </span>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="support-wrap-empty">
                    <div class="support-wrap-empty-placeholder">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/ticket.svg' ?>" alt="">
                        <p>تا به حال تیکتی ثبت نکرده‌اید</p>
                    </div>
                    <div class="support-wrap-new">
                        <a href="<?php echo esc_url($new_ticket_url) . '/?menu=tutor'; ?>" class="new-ticket-button"><?php esc_html_e('ثبت تیکت جدید', 'edumall-child'); ?></a>
                    </div>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <p>لطفا وارد شوید تا بتوانید تیکت های خود را ببینید</p>
        <?php endif;     ?>
    </div>
</div>