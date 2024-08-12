<?php

/**
 * @package TutorLMS/Templates
 * @version 1.7.5
 */

defined('ABSPATH') || exit;

use Detection\MobileDetect;

$detect = new MobileDetect();
$profile_url  = apply_filters('edumall_user_profile_url', '');
?>
<?php if ($detect->isMobile()) : ?>
	<div class="edit-profile-title">
		<a href="<?php echo esc_url($profile_url); ?>">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
		</a>
		<h3><?php esc_html_e('ویرایش اطلاعات کاربری', 'edumall-child'); ?></h3>
	</div>
<?php endif; ?>


<?php
if (isset($GLOBALS['tutor_setting_nav']['profile'])) {
	tutor_load_template('dashboard.settings.profile');
} else {
	foreach ($GLOBALS['tutor_setting_nav'] as $page) {
		echo '<script>window.location.replace("', $page['url'], '");</script>';
		break;
	}
}
