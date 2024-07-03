<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( $statements->count ) : ?>

	<div class="dashboard-earning-statement-table dashboard-table-wrapper dashboard-table-responsive">
		<div class="dashboard-table-container">
			<table class="dashboard-table">
				<thead>
				<tr>
					<th><?php esc_html_e( 'Course', 'edumall' ); ?></th>
					<th><?php esc_html_e( 'Earning', 'edumall' ); ?></th>
					<th><?php esc_html_e( 'Deduct', 'edumall' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ( $statements->results as $statement ) : ?>
					<tr>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Course:', 'edumall' ); ?></div>
							<p>
								<a href="<?php echo esc_url( get_the_permalink( $statement->course_id ) ); ?>"
								   target="_blank">
									<?php echo esc_html( $statement->course_title ); ?>
								</a>
							</p>
							<p>
								<?php esc_html_e( 'Price', 'edumall' ); ?>
								<?php echo tutor_utils()->tutor_price( $statement->course_price_total ); ?>
							</p>

							<p class="small-text">
							<span
								class="statement-order-<?php echo esc_attr( $statement->order_status ); ?>"><?php echo esc_html( $statement->order_status ); ?></span> <?php
								esc_html_e( 'Order ID', 'edumall' ); ?> <?php echo "#{$statement->order_id}"; ?>,

								<strong><?php esc_html_e( 'Date:', 'edumall' ) ?></strong>
								<i><?php echo wp_date( get_option( 'date_format', strtotime( $statement->created_at ) ) ) . ' ' . wp_date( get_option( 'time_format', strtotime( $statement->created_at ) ) ) ?></i>
							</p>

							<?php $order = new WC_Order( $statement->order_id ); ?>
							<div class="statement-address">
								<strong><?php esc_html_e( 'Purchaser', 'edumall' ); ?></strong>
								<?php echo '<address>' . $order->get_formatted_billing_address() . '</address>'; ?>
							</div>
						</td>
						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Earning:', 'edumall' ); ?></div>
							<p><?php echo tutor_utils()->tutor_price( $statement->instructor_amount ); ?></p>
							<p class="small-text"> <?php esc_html_e( 'As per', 'edumall' ); ?> <?php echo esc_html( $statement->instructor_rate ); ?>
								(<?php echo esc_html( $statement->commission_type ); ?>) </p>
						</td>

						<td>
							<div class="heading col-heading-mobile"><?php esc_html_e( 'Deduct:', 'edumall' ); ?></div>
							<p><?php esc_html_e( 'Commission', 'edumall' ); ?>
								: <?php echo tutor_utils()->tutor_price( $statement->admin_amount ); ?> </p>
							<p class="small-text"><?php esc_html_e( 'Rate', 'edumall' ); ?>
								: <?php echo esc_html( $statement->admin_rate ); ?> </p>
							<p class="small-text"><?php esc_html_e( 'Type', 'edumall' ); ?>
								: <?php echo esc_html( $statement->commission_type ); ?> </p>

							<p><?php esc_html_e( 'Deducted', 'edumall' ); ?>
								: <?php echo esc_html( $statement->deduct_fees_name ); ?>  <?php echo tutor_utils()->tutor_price
								( $statement->deduct_fees_amount ); ?>
							</p>
							<p class="small-text"><?php esc_html_e( 'Type', 'edumall' ); ?>
								: <?php echo esc_html( $statement->deduct_fees_type ); ?> </p>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php else : ?>
	<?php esc_html_e( 'There is not enough sales data to generate a statement.', 'edumall' ); ?>
<?php endif;
