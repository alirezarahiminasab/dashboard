<?php
/**
 * Display modal login
 *
 * @theme-since 3.9.0
 * @theme-version 3.9.0
 * @see tutor/views/modal/login.php
 */

defined( 'ABSPATH' ) || exit;

$lost_pass = apply_filters( 'tutor_lostpassword_url', wp_lostpassword_url() );
?>
<div class="tutor-modal tutor-login-modal">
	<div class="tutor-modal-overlay"></div>
	<div class="tutor-modal-window tutor-modal-window-sm">
		<div class="tutor-modal-content tutor-modal-content-white">
			<button class="tutor-iconic-btn tutor-modal-close-o" data-tutor-modal-close>
				<span class="tutor-icon-times" area-hidden="true"></span>
			</button>

			<div class="tutor-modal-body">
				<?php tutor_load_template( 'login-form' ); ?>
			</div>
		</div>
	</div>
</div>
