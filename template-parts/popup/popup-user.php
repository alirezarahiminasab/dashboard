<?php

/**
 * Template part for display account popups.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0.0
 * @version 1.3.1
 */

defined('ABSPATH') || exit;

use Detection\MobileDetect;

$detect = new MobileDetect();
?>
<div class="edumall-popup popup-user-login" id="popup-user-login" data-template="template-parts/popup/popup-content-login">
	<div class="popup-overlay"></div>
	<div class="popup-content">
		<div class="popup-content-wrap">
			<div class="button-close-popup-login button-popup-close">
				<a class="close">
					<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/close-circle.png" ?> alt="">
				</a>
			</div>
			<div class="popup-register-logo">
				<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/logo-hanil-2.png" ?> alt="">
			</div>
			<div class="popup-content-inner"></div>
		</div>
	</div>
</div>

<div class="edumall-popup popup-user-register" id="popup-user-register" data-template="template-parts/popup/popup-content-register">
	<div class="popup-overlay"></div>
	<div class="popup-content">
		<div class="popup-content-wrap">
			<div class="button-close-return-popup button-popup-close">
				<a class="return">
					<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/arrow-circle-right.png" ?> alt="">
					<p><?php esc_html_e('بازگشت', 'edumall-child'); ?></p>
				</a>
				<a class="close">
					<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/close-circle.png" ?> alt="">
				</a>
			</div>
			<?php if ($detect->isMobile()) : ?>
				<div class="popup-register-logo">
					<img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/logo-hanil-2.png" ?> alt="">
				</div>
			<?php endif; ?>
			<div class="popup-content-inner"></div>
		</div>
	</div>
</div>

<div class="edumall-popup popup-lost-password" id="popup-user-lost-password" data-template="template-parts/popup/popup-content-lost-password">
	<div class="popup-overlay"></div>
	<div class="popup-content">
		<div class="button-close-popup"></div>
		<div class="popup-content-wrap">
			<div class="popup-content-inner"></div>
		</div>
	</div>
</div>