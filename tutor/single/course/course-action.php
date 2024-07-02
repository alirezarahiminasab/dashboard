<?php

/**
 * Template for displaying buy now button
 *
 * @author        Themeum
 * @url https://themeum.com
 * @package       TutorLMS/Templates
 * @since         1.0.0
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 2.6.0
 */
global $edumall_course;

$user_id = get_current_user_id();
$is_administrator      = current_user_can('administrator');
$is_instructor         = tutor_utils()->is_instructor_of_this_course();
$is_enrolled         = apply_filters('tutor_alter_enroll_status', tutor_utils()->is_enrolled());

$price = tutor_utils()->get_raw_course_price(get_the_ID());
$regularPrice = (int)$price->regular_price;
$salePrice = (int)$price->sale_price;
$product_id = tutor_utils()->get_course_product_id(get_the_ID());

?>

<?php if (boolval($is_enrolled)) : ?>
    <?php tutor_load_template('single.course.custom.enrolled-action-buttons'); ?>
<?php elseif ($is_administrator || $is_instructor) : ?>
    <?php tutor_load_template('single.course.custom.enrolled-action-buttons'); ?>
<?php else : ?>
    <?php tutor_load_template('single.course.add-to-cart'); ?>
<?php endif; ?>