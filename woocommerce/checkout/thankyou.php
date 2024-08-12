<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined('ABSPATH') || exit;

$payment_status = isset($_GET['Status']) ? $_GET['Status'] : '';
$order_id = isset($_GET['wc_order']) ? $_GET['wc_order'] : '';
$courses = isset($_GET['course']) ? json_decode(sanitize_text_field(wp_unslash($_GET['course'])), true) : null;
$thumbnail_size = '87x87';
$course_thumb_placeholder = tutor()->url . 'assets/images/placeholder.svg';

if ($payment_status === 'OK') :
	WC()->cart->empty_cart();
	$order = wc_get_order($order_id);
	$order->set_status('completed');
	$order->save();
	tutor_utils()->change_earning_status($order_id, 'completed');

?>
	<div class="payment">
		<div class="payment-title">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/payment-success.png' ?>" alt="">
			<h3>
				<?php esc_html_e('ثبت‌نام شما موفقیت ‌آمیز بود.', 'edumall-child'); ?>
			</h3>
		</div>
		<div class="payment-content">
			<?php
			foreach ($courses as $course) :
				$user_id = get_current_user_id();
				$enrolled_id = tutor_utils()->do_enroll($course, $order_id, $user_id);
				tutor_utils()->complete_course_enroll($order_id);

				$course_thumb = Edumall_Image::get_the_post_thumbnail_url(array(
					'post_id' => $course,
					'size'    => $thumbnail_size,
				));
				$author_id = get_post_field('post_author', $course);
				$author = get_userdata($author_id);
			?>
				<div class="payment-content-item">
					<div class="payment-content-item-info">
						<div class="payment-content-item-info-img">
							<img src="<?php echo !empty($course_thumb) ? $course_thumb : $course_thumb_placeholder ?>" alt="">
						</div>

						<div class="payment-content-item-info-title">
							<p>
								<?php echo get_the_title($course) ?>
							</p>
							<p>
								<?php echo esc_html($author->display_name); ?>
							</p>
						</div>
					</div>
					<?php echo $landing_page_init->get_the_course_price($course) ?>

					<div class="payment-content-item-link">
						<a href="<?php echo esc_html(get_permalink($course)) ?>">
							<?php esc_html_e('مشاهده دوره', 'edumall-child'); ?>
						</a>
					</div>
				</div>

			<?php endforeach; ?>
		</div>
	</div>
<?php
else :
endif;

get_footer();
