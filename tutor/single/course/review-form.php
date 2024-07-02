<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.4.5
 */

defined('ABSPATH') || exit;

use TUTOR\Input;

$isLoggedIn = is_user_logged_in();
$course_id  = Input::post('course_id', get_the_ID(), Input::TYPE_INT);
if (get_post_type() === 'lesson') {
	$course_id         = tutor_utils()->get_course_id_by_subcontent(get_the_ID());
}
$my_rating  = tutor_utils()->get_reviews_by_user(0, 0, 150, false, $course_id, array('approved', 'hold'));
$is_new     = !$my_rating || empty($my_rating->rating) || empty($my_rating->comment_content);
$heading    = $is_new ? __('Login/Register', 'edumall-child') : __('Edit review', 'edumall-child');

$button_args = [
	'link'        => [
		'url' => '#',
	],
	'text'        => $heading,
	'class'        => '',
	'extra_class' => 'btn-write-course-review',
];

if (!$isLoggedIn) {
	$button_args['extra_class'] .= ' open-popup-login';
} else {
	$button_args['attributes'] = [
		'data-edumall-toggle' => 'modal',
		'data-edumall-target' => '#modal-course-review-add',
	];
}

$post_type = get_post_type();
?>

<div class="tutor-course-review-form-wrap">
	<div class="user-wrap">
		<?php if ($post_type === 'lesson') : ?>
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/review profile.png' ?>" alt="">
		<?php endif; ?>
		<input class="open-popup-login" data-edumall-toggle="modal" data-edumall-target="#modal-course-review-add" placeholder="<?php echo esc_html__('نظر خود را درباره ....... بنویسید', 'edumall-child'); ?>">
	</div>
</div>

<?php if ($isLoggedIn) : ?>
	<div class="edumall-modal modal-course-review-add review-modal" id="modal-course-review-add">
		<div class="review-modal-overlay modal-overlay"></div>
		<div class="review-modal-content modal-content">
			<div class="review-modal-header">
				<h3><?php esc_html_e('ثبت ‌نظر', 'edumall-child'); ?></h3>
				<img class="close-modal" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.svg' ?>" alt="">
			</div>

			<div class="review-modal-body">
				<form method="post" class="review-modal-wrap-body-form">
					<input type="hidden" name="tutor_course_id" value="<?php echo $course_id; ?>">
					<div class="tutor-form-group">
						<div class="tutor-ratings tutor-ratings-lg tutor-ratings-selectable" tutor-ratings-selectable>
							<?php tutor_utils()->star_rating_generator(tutor_utils()->get_rating_value($my_rating ? $my_rating->rating : 0)); ?>
						</div>
					</div>
					<div class="tutor-form-group">
						<textarea name="review" placeholder="<?php esc_attr_e('اگر نظر یا پیشنهادی در مورد این ....... دارید با ما در میان بگذارید:', 'edumall-child'); ?>"><?php echo stripslashes($my_rating ? $my_rating->comment_content : ''); ?></textarea>
					</div>

					<div class="tutor-form-group tm-button-wrapper">
						<button type="submit" class="tutor-submit-review-btn"><?php esc_html_e('Submit Review', 'edumall-child'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endif; ?>