<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

$orders      = tutils()->get_orders_by_user_id();
$monetize_by = tutils()->get_option( 'monetize_by' );
?>
	<h3><?php esc_html_e( 'Purchase History', 'edumall' ); ?></h3>

<?php if ( tutils()->count( $orders ) ) : ?>
	<div class="table-purchase-history dashboard-table-wrapper dashboard-table-responsive">
		<div class="dashboard-table-container">
			<table class="dashboard-table">
				<tr>
					<th><?php esc_html_e( 'ID', 'edumall' ); ?></th>
					<th><?php esc_html_e( 'Courses', 'edumall' ); ?></th>
					<th><?php esc_html_e( 'Amount', 'edumall' ); ?></th>
					<th><?php esc_html_e( 'Status', 'edumall' ); ?></th>
					<th><?php esc_html_e( 'Date', 'edumall' ); ?></th>
				</tr>
				<?php
				foreach ( $orders as $order ) :
					if ( $monetize_by === 'wc' ) {
						$wc_order = wc_get_order( $order->ID );
						$price    = tutils()->tutor_price( $wc_order->get_total() );
						$status   = tutils()->order_status_context( $order->post_status );
					} else if ( $monetize_by === 'edd' ) {
						$edd_order = edd_get_payment( $order->ID );
						$price     = edd_currency_filter( edd_format_amount( $edd_order->total ), edd_get_payment_currency_code( $order->ID ) );
						$status    = $edd_order->status_nicename;
					}
					?>
					<tr>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'ID:', 'edumall' ); ?></div>
							<?php echo "#{$order->ID}"; ?>
						</td>
						<td>
							<div
								class="heading col-heading-mobile col-heading-block"><?php esc_html_e( 'Courses:', 'edumall' ); ?></div>
							<?php
							$courses = tutils()->get_course_enrolled_ids_by_order_id( $order->ID );
							if ( tutils()->count( $courses ) ) {
								foreach ( $courses as $course ) {
									echo '<p>' . get_the_title( $course['course_id'] ) . '</p>';
								}
							}
							?>
						</td>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Amount:', 'edumall' ); ?></div>
							<?php echo '' . $price; ?>
						</td>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Status:', 'edumall' ); ?></div>
							<?php echo '' . $status; ?>
						</td>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Date:', 'edumall' ); ?></div>
							<?php echo wp_date( get_option( 'date_format' ), strtotime( $order->post_date ) ); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
<?php else : ?>
	<div class="dashboard-no-content-found">
		<?php esc_html_e( 'No purchase history available.', 'edumall' ); ?>
	</div>
<?php endif;
