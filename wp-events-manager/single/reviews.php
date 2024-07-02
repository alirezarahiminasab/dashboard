<?php

/**
 * Template part for displaying event meta on single page.
 *
 * 
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined('ABSPATH') || exit;

use TUTOR\Input;

$author_id = get_post_field('post_author', get_the_ID());
$author_reviews_info = tutor_utils()->get_instructor_ratings($author_id);
$author_total_reviews = $author_reviews_info->rating_count;
$author_rating_avg = $author_reviews_info->rating_avg;
$author_reviews       = tutor_utils()->get_reviews_by_instructor($author_id);

$per_page     = tutor_utils()->get_option('pagination_per_page', 4);
$current_page = max(1, Input::post('current_page', 0, Input::TYPE_INT));

?>

<div class="event-reviews tutor-pagination-wrapper-replaceable">
	<?php if (!empty($author_reviews)) : ?>

		<div class="event-reviews-wrap">
			<h4 class="tutor-segment-title">
				<?php echo esc_html__('User reviews about the author', 'edumall-child'); ?>
			</h4>

			<div class="reviews-rating">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/star.png' ?>" alt="">
				<p>
					<?php
					echo number_format($author_rating_avg, 1);
					?>
				</p>
				<p>
					|
				</p>
				<p>
					<?php echo $author_total_reviews . " " . esc_html__('reviews', 'edumall-child') ?>
				</p>
			</div>

			<div class="tutor-event-reviews-list tutor-pagination-content-appendable">
				<?php wpems_get_template('single/reviews-loop.php', $author_reviews); ?>
			</div>
			<?php
			$pagination_data              = array(
				'total_items' => $author_total_reviews,
				'per_page'    => $per_page,
				'paged'       => $current_page,
				'layout'      => array(
					'type'           => 'load_more',
					'load_more_text' => __('Load More', 'edumall-child'),
				),
				'ajax'        => array(
					'action'    => 'tutor_single_event_reviews_load_more',
				),
			);
			$pagination_template_frontend = tutor()->path . 'templates/dashboard/elements/pagination.php';
			tutor_load_template_from_custom_path($pagination_template_frontend, $pagination_data);
			?>
		</div>

	<?php endif; ?>

</div>