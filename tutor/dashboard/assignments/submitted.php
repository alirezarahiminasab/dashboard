<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

global $wpdb;

$assignment            = sanitize_text_field( $_GET['assignment'] );
$assignments_submitted = $wpdb->get_results( "SELECT * FROM {$wpdb->comments} WHERE comment_type = 'tutor_assignment' AND comment_post_ID = {$assignment}" );
?>
	<h3><?php esc_html_e( 'Assignment Submitted', 'edumall' ); ?></h3>

<?php if ( tutor_utils()->count( $assignments_submitted ) ) : ?>
	<div class="dashboard-table-wrapper dashboard-table-responsive table-assignments">
		<div class="dashboard-table-container">
			<table class="dashboard-table">
				<thead>
				<tr>
					<th><?php esc_html_e( 'Student', 'edumall' ); ?></th>
					<th><?php esc_html_e( 'Date & Time', 'edumall' ); ?></th>
					<th class="col-pass-mark"><?php esc_html_e( 'Pass Mark', 'edumall' ); ?></th>
					<th class="col-total-mark"><?php esc_html_e( 'Total Mark', 'edumall' ); ?></th>
					<th class="col-result"><?php esc_html_e( 'Result', 'edumall' ); ?></th>
					<th class="col-action">&nbsp;</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ( $assignments_submitted as $assignment ) : ?>
					<?php
					$comment_author            = get_user_by( 'login', $assignment->comment_author );
					$is_reviewed_by_instructor = get_comment_meta( $assignment->comment_ID, 'evaluate_time', true );
					$max_mark                  = tutor_utils()->get_assignment_option( $assignment->comment_post_ID, 'total_mark' );
					$pass_mark                 = tutor_utils()->get_assignment_option( $assignment->comment_post_ID, 'pass_mark' );
					$given_mark                = get_comment_meta( $assignment->comment_ID, 'assignment_mark', true );
					$status                    = 'pending';
					if ( ! empty( $given_mark ) ) {
						$status = (int) $given_mark >= (int) $pass_mark ? 'pass' : 'fail';
					}

					$review_url = tutor_utils()->get_tutor_dashboard_page_permalink( 'assignments/review' );
					?>
					<tr>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Student:', 'edumall' ); ?></div>
							<?php echo esc_html( $comment_author->display_name ); ?>
						</td>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Date & Time:', 'edumall' ); ?></div>
							<?php echo wp_date( 'j M, Y. h:i a', strtotime( $assignment->comment_date ) ); ?>
						</td>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Pass Mark:', 'edumall' ); ?></div>
							<?php echo esc_html( $pass_mark ); ?>
						</td>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Total Mark:', 'edumall' ); ?></div>
							<?php echo ! empty( $given_mark ) ? $given_mark . '/' . $max_mark : $max_mark; ?>
						</td>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Result:', 'edumall' ); ?></div>
							<span class="assignment-status <?php echo esc_attr( 'assignment-status-' . $status ); ?>">
								<?php
								switch ( $status ) {
									case 'pass' :
										esc_html_e( 'Pass', 'edumall' );
										break;
									case 'fail' :
										esc_html_e( 'Fail', 'edumall' );
										break;
									case 'pending' :
										esc_html_e( 'Pending', 'edumall' );
										break;
								}
								?>
							</span>
						</td>
						<td>
							<a class="hint--bounce hint--top-left review-assignment-link"
							   aria-label="<?php esc_attr_e( 'Review this assignment', 'edumall' ); ?>"
							   href="<?php echo esc_url( $review_url . '?view_assignment=' . $assignment->comment_ID ); ?>">
								<i class="fa-regular fa-angle-right"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php else : ?>
	<div class="dashboard-no-content-found">
		<?php esc_html_e( 'No assignment has been submitted yet.', 'edumall' ); ?>
	</div>
<?php endif;

