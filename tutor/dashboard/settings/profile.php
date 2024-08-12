<?php

/**
 * @package       TutorLMS/Templates
 * @version       1.7.5
 *
 * @theme-since   1.0.0
 * @theme-version 3.0.0
 */

defined('ABSPATH') || exit;

$user = wp_get_current_user();

$profile_placeholder = Edumall_Helper::placeholder_avatar_src();
$profile_photo_src   = $profile_placeholder;
$profile_photo_id    = get_user_meta($user->ID, '_instructor_profile_pic', true);
if ($profile_photo_id) {
	$url = wp_get_attachment_image_url($profile_photo_id, 'full');
	!empty($url) ? $profile_photo_src = $url : 0;
}

$cover_placeholder = tutor()->url . 'assets/images/cover-photo.jpg';
$cover_photo_src   = $cover_placeholder;
$cover_photo_id    = get_user_meta($user->ID, '_tutor_cover_photo', true);
if ($cover_photo_id) {
	$url = wp_get_attachment_image_url($cover_photo_id, 'full');
	!empty($url) ? $cover_photo_src = $url : 0;
}

$public_display                     = array();
$public_display['display_nickname'] = $user->nickname;
$public_display['display_username'] = $user->user_login;

if (!empty($user->first_name)) {
	$public_display['display_firstname'] = $user->first_name;
}

if (!empty($user->last_name)) {
	$public_display['display_lastname'] = $user->last_name;
}

if (!empty($user->first_name) && !empty($user->last_name)) {
	$public_display['display_firstlast'] = $user->first_name . ' ' . $user->last_name;
	$public_display['display_lastfirst'] = $user->last_name . ' ' . $user->first_name;
}

if (!in_array($user->display_name, $public_display)) { // Only add this if it isn't duplicated elsewhere
	$public_display = array('display_displayname' => $user->display_name) + $public_display;
}

$public_display = array_map('trim', $public_display);
$public_display = array_unique($public_display);
$max_filesize   = floatval(ini_get('upload_max_filesize')) * (1024 * 1024);
?>
<div class="tutor-dashboard-user-setting">

	<?php do_action('tutor_profile_edit_form_before'); ?>

	<form action="" method="post" enctype="multipart/form-data" class="dashboard-settings-form dashboard-settings-profile-form">
		<?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
		<input type="hidden" value="tutor_profile_edit" name="tutor_action" />

		<?php
		$errors = apply_filters('tutor_profile_edit_validation_errors', array());
		if (is_array($errors) && count($errors)) {
			echo '<div class="tutor-alert-warning tutor-mb-10"><ul class="tutor-required-fields">';
			foreach ($errors as $error_key => $error_value) {
				echo "<li>{$error_value}</li>";
			}
			echo '</ul></div>';
		}
		?>

		<?php do_action('tutor_profile_edit_input_before'); ?>

		<div class="dashboard-content-box">
			<div id="tutor_profile_cover_photo_editor">
				<input id="tutor_photo_dialogue_box" type="file" accept=".png,.jpg,.jpeg" />
				<div id="tutor_profile_area" data-fallback="<?php echo $profile_placeholder; ?>" style="background-image:url(<?php echo $profile_photo_id; ?>)">
				</div>
				<div class="user-edit-buttons">
					<p class="tutor_pp_uploader">
						<?php esc_html_e('ویرایش', 'edumall-child'); ?>
					</p>
					<span class="tutor_pp_deleter">
						<i class="far fa-trash-alt"></i>
					</span>
				</div>
			</div>
		</div>

		<div class="dashboard-content-box">
			<div class="tutor-form-group">
				<label for="tutor_profile_phone_number">
					<?php esc_html_e('Phone Number', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_phone_number" name="phone_number" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone_number', true)); ?>">
			</div>

			<div class="tutor-form-group">
				<label for="tutor_profile_first_name">
					<?php esc_html_e('First Name & Last Name', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_first_name" name="first_name" value="<?php echo esc_attr($user->first_name); ?>">
			</div>

			<div class="tutor-form-group">
				<label for="tutor_profile_username">
					<?php esc_html_e('Username', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_username" name="username" value="<?php echo esc_attr(get_user_meta($user->ID, '_tutor_profile_username', true)); ?>">
			</div>

			<div class="tutor-form-group">
				<label for="tutor_profile_national_code">
					<?php esc_html_e('National Code', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_national_code" name="national_code" value="<?php echo esc_attr(get_user_meta($user->ID, '_tutor_profile_national_code', true)); ?>">
			</div>

			<div class="tutor-form-group">
				<label for="tutor_profile_birth_date">
					<?php esc_html_e('Birth Date', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_birth_date" name="birth_date" value="<?php echo esc_attr(get_user_meta($user->ID, '_tutor_profile_birth_date', true)); ?>">
			</div>

			<div class="tutor-form-group">
				<label for="tutor_profile_education">
					<?php esc_html_e('Education', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_education" name="education" value="<?php echo esc_attr(get_user_meta($user->ID, '_tutor_profile_education', true)); ?>">
			</div>

			<div class="tutor-form-group">
				<label for="tutor_profile_city">
					<?php esc_html_e('City', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_city" name="city" value="<?php echo esc_attr(get_user_meta($user->ID, '_tutor_profile_city', true)); ?>">
			</div>

			<div class="tutor-form-group">
				<label for="tutor_profile_marriage">
					<?php esc_html_e('Marriage', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_marriage" name="marriage" value="<?php echo esc_attr(get_user_meta($user->ID, '_tutor_profile_marriage', true)); ?>">
			</div>

			<div class="tutor-form-group">
				<label for="tutor_profile_children">
					<?php esc_html_e('Children', 'edumall-child'); ?>
				</label>
				<input type="text" id="tutor_profile_children" name="children" value="<?php echo esc_attr(get_user_meta($user->ID, '_tutor_profile_children', true)); ?>">
			</div>

			<div class="tutor-form-group favorites">
				<label for="tutor_profile_favorites">
					<?php esc_html_e('Favorites', 'edumall-child'); ?><sup>*</sup>
				</label>
				<div class="favorites-items">
					<p>
						به هانیل کمک کن تا بهترین تجربه آموزشی را برای شما فراهم کند. با انتخاب حداقل <strong>3</strong> دسته‌بندی از سوی شما، هانیل قادر خواهد بود دوره‌ها و آموزش‌هایی را معرفی کند که دقیقاً با سلیقه و نیازهای شما هماهنگ باشند.
					</p>

					<div class="favorites-items-wrap">
						<a href="">
							<?php esc_html_e('مدیریت منزل', 'edumall-child'); ?>
						</a>
						<a href="">
							<?php esc_html_e('مهارت های نرم', 'edumall-child'); ?>
						</a>
						<a href="">
							<?php esc_html_e('برنامه نویسی', 'edumall-child'); ?>
						</a>
						<a href="">
							<?php esc_html_e('گرافیک', 'edumall-child'); ?>
						</a>
						<a href="">
							<?php esc_html_e('تولید محتوا', 'edumall-child'); ?>
						</a>
						<a href="">
							<?php esc_html_e('فروش و بازاریابی', 'edumall-child'); ?>
						</a>
					</div>
				</div>
			</div>

			<div class="tutor-form-group tutor-profile-form-btn-wrap form-submit-wrap">
				<button type="submit" name="tutor_register_student_btn" value="register" class="tutor-button tutor-profile-settings-save"><?php esc_html_e('ذخیره تغییرات', 'edumall-child'); ?></button>
			</div>

			<?php do_action('tutor_profile_edit_input_after'); ?>

	</form>

	<?php do_action('tutor_profile_edit_form_after'); ?>

</div>