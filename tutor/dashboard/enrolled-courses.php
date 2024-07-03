<?php
/**
 * @package       TutorLMS/Templates
 * @version       1.4.3
 *
 * @theme-since   1.0.0
 * @theme-version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

use TUTOR\Input;

// Pagination.
$per_page = tutor_utils()->get_option( 'pagination_per_page', 10 );
$paged    = max( 1, Input::get( 'current_page', 1, Input::TYPE_INT ) );
$offset   = ( $per_page * $paged ) - $per_page;

$page_tabs = array(
	'enrolled-courses'                   => __( 'Enrolled Courses', 'edumall' ),
	'enrolled-courses/active-courses'    => __( 'Active Courses', 'edumall' ),
	'enrolled-courses/completed-courses' => __( 'Completed Courses', 'edumall' ),
);

// Default tab set.
$active_tab = ( ! isset( $active_tab, $page_tabs[ $active_tab ] ) ) ? 'enrolled-courses' : $active_tab;

// Get Paginated course list.
$courses_list_array = array(
	'enrolled-courses'                   => tutor_utils()->get_enrolled_courses_by_user( get_current_user_id(), [
		'private',
		'publish',
	], $offset, $per_page ),
	'enrolled-courses/active-courses'    => tutor_utils()->get_active_courses_by_user( null, $offset, $per_page ),
	'enrolled-courses/completed-courses' => tutor_utils()->get_courses_by_user( null, $offset, $per_page ),
);

// Get Full course list.
$full_courses_list_array = array(
	'enrolled-courses'                   => tutor_utils()->get_enrolled_courses_by_user( get_current_user_id(), array(
		'private',
		'publish',
	) ),
	'enrolled-courses/active-courses'    => tutor_utils()->get_active_courses_by_user(),
	'enrolled-courses/completed-courses' => tutor_utils()->get_courses_by_user(),
);

// Prepare course list based on page tab.
$courses_list           = $courses_list_array[ $active_tab ];
$paginated_courses_list = $full_courses_list_array[ $active_tab ];
?>

<h3><?php echo $page_tabs[ $active_tab ]; ?></h3>

<div class="tutor-dashboard-content-inner">
	<ul class="tutor-nav" tutor-priority-nav>
		<?php foreach ( $page_tabs as $slug => $tab ) : ?>
			<li class="tutor-nav-item">
				<a class="tutor-nav-link<?php echo $slug == $active_tab ? ' is-active' : ''; ?>" href="<?php echo esc_url( tutor_utils()->get_tutor_dashboard_page_permalink( $slug ) ); ?>">
					<?php
					echo esc_html( $tab );

					$course_count = ( $full_courses_list_array[ $slug ] && $full_courses_list_array[ $slug ]->have_posts() ) ? count( $full_courses_list_array[ $slug ]->posts ) : 0;
					if ( $course_count ) :
						echo esc_html( '&nbsp;(' . $course_count . ')' );
					endif;
					?>
				</a>
			</li>
		<?php endforeach; ?>
		<li class="tutor-nav-item tutor-nav-more tutor-d-none">
			<a class="tutor-nav-link tutor-nav-more-item" href="#"><span class="tutor-mr-4"><?php esc_html_e( 'More', 'edumall' ); ?></span>
				<span class="tutor-nav-more-icon tutor-icon-times"></span></a>
			<ul class="tutor-nav-more-list tutor-dropdown"></ul>
		</li>
	</ul>
	<?php
	$default_thumbnail_src = tutor()->url . 'assets/images/placeholder.svg';

	if ( $courses_list && $courses_list->have_posts() ) : ?>
		<div class="dashboard-enrolled-courses edumall-animation-zoom-in">
			<?php while ( $courses_list->have_posts() ) : $courses_list->the_post();
				$avg_rating = tutor_utils()->get_course_rating()->rating_avg;
				?>
				<a href="<?php the_permalink(); ?>"
				   class="edumall-box link-secret tutor-mycourse-wrap tutor-mycourse-<?php the_ID(); ?>">
					<div class="edumall-image tutor-mycourse-thumbnail">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php Edumall_Image::the_post_thumbnail( [
								'size' => '480x295',
								'alt'  => get_the_title(),
							] ); ?>
						<?php else: ?>
							<?php echo Edumall_Image::build_img_tag( [
								'src' => $default_thumbnail_src,
								'alt' => get_the_title(),
							] ) ?>
						<?php endif; ?>
					</div>
					<div class="tutor-mycourse-content">
						<?php Edumall_Templates::render_rating( $avg_rating, [
							'style'         => '03',
							'wrapper_class' => 'tutor-mycourse-rating',
						] ); ?>

						<h3 class="course-title"><?php the_title(); ?></h3>

						<div class="tutor-meta tutor-course-metadata">
							<?php
							$total_lessons     = tutor_utils()->get_lesson_count_by_course();
							$completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();
							?>
							<ul class="course-meta">
								<li class="course-meta-lesson-count">
									<span class="meta-label"><?php esc_html_e( 'Total Lessons:', 'edumall' ); ?></span>
									<span class="meta-value"><?php echo number_format_i18n( $total_lessons ); ?></span>
								</li>
								<li class="course-meta-completed-lessons">
									<span
										class="meta-label"><?php esc_html_e( 'Completed Lessons:', 'edumall' ); ?></span>
									<span
										class="meta-value"><?php echo number_format_i18n( $completed_lessons ) . '/' . number_format_i18n( $total_lessons ); ?></span>
								</li>
							</ul>
						</div>
						<?php tutor_course_completing_progress_bar(); ?>
					</div>

				</a>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<div class="tutor-mt-20">
			<?php
			if ( $paginated_courses_list->found_posts > $per_page ) :
				$pagination_data = array(
					'total_items' => $paginated_courses_list->found_posts,
					'per_page'    => $per_page,
					'paged'       => $paged,
				);
				tutor_load_template_from_custom_path(
					tutor()->path . 'templates/dashboard/elements/pagination.php',
					$pagination_data
				);
			endif;
			?>
		</div>
	<?php else: ?>
		<?php
		switch ( $active_tab ) {
			case 'enrolled-courses':
				$message = __( 'You didn\'t purchased any courses.', 'edumall' );
				break;
			case 'enrolled-courses/active-courses':
				$message = __( 'You are not enrolled in any courses at this moment.', 'edumall' );
				break;
			case 'enrolled-courses/completed-courses':
				$message = __( 'There\'s no completed courses.', 'edumall' );
				break;
			default:
				$message = tutor_utils()->not_found_text();
				break;
		}
		tutor_utils()->tutor_empty_state( $message );
		?>
	<?php endif; ?>
</div>
