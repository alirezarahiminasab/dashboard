<?php

/**
 * Template part for display register form on popup.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edumall
 * @since   1.0.0
 * @version 2.8.4
 */

defined('ABSPATH') || exit;
?>
<div class="popup-content-header">
	<div class="popup-title">
		<div id="get-phone-title" class="popup-title__text">
			<h3><?php esc_html_e('ورود | ثبت‌نام', 'edumall-child'); ?></h3>
		</div>
		<div id="verify-phone-title" class="popup-title__text">
			<h3><?php esc_html_e('کد تایید را وارد کنید', 'edumall-child'); ?></h3>
		</div>
		<div id="favorites-title" class="popup-title__text">
			<h3><?php esc_html_e('اطلاعات بیشتر برای تجربه‌ی بهتر', 'edumall-child'); ?></h3>
		</div>
		<div id="state-title" class="popup-title__text">
			<h3><?php esc_html_e('گزینه مورد نظر خود را برای ورود به سایت هانیل انتخاب کنید', 'edumall-child'); ?></h3>
		</div>
	</div>
</div>

<div class="popup-content-body">
	<form id="edumall-register-get-phone" class="edumall-register-get-phone" method="post">

		<?php do_action('edumall_popup_register_before_form_fields'); ?>

		<section class="phone-input">
			<label for="ip_reg_phone" class="form-label"><?php esc_html_e('لطفا شماره موبایل خود را وارد کنید', 'edumall-child'); ?></label>
			<input type="text" id="ip_reg_phone" class="form-control form-input" name="phone" placeholder="<?php esc_attr_e('مثال:  ** ** *** *09', 'edumall-child'); ?>" required />
			<p class="error-message"><?php echo esc_html__('Please enter your phone number', 'edumall-child'); ?></p>
		</section>

		<?php
		/**
		 * @since 2.8.4
		 */
		do_action('edumall_popup_register_after_form_field_refer');
		?>

		<?php
		/**
		 * @since 2.8.1
		 */
		$privacy_page_id   = get_option('wp_page_for_privacy_policy', 0);
		$privacy_link_html = esc_html__('Privacy Policy', 'edumall-child');
		if ($privacy_page_id) {
			$privacy_link_html = sprintf(
				'<a href="%1$s" class="edumall-privacy-policy-link" target="_blank">%2$s</a>',
				esc_url(get_permalink($privacy_page_id)),
				$privacy_link_html
			);
		}

		$terms_conditions_page_id   = Edumall::setting('page_for_terms_and_conditions', 0);
		$terms_conditions_link_html = esc_html__('Terms', 'edumall-child');
		if ($terms_conditions_page_id) {
			$terms_conditions_link_html = sprintf(
				'<a href="%1$s" class="edumall-terms-conditions-link" target="_blank">%2$s</a>',
				esc_url(get_permalink($terms_conditions_page_id)),
				$terms_conditions_link_html
			);
		}
		/**
		 * @since 2.8.4
		 */
		?>

		<div class="form-response-messages"></div>

		<section class="verify-button">
			<?php wp_nonce_field('user_register', 'user_register_nonce'); ?>
			<input type="hidden" name="action" value="edumall_user_register">
			<button type="submit" class="button form-submit"><?php esc_html_e('دریافت کد تایید', 'edumall-child'); ?></button>
		</section>

		<section class="popup-content-footer">
			<p class="popup-description">
				<?php printf(esc_html__('ورود شما به معنای پذیرش %s قوانین و مقرارت هانیل %s است.', 'edumall-child'), '<a href="#" class="open-popup-login link-transition-02">', '</a>'); ?>
			</p>
		</section>
	</form>

	<form id="edumall-register-verify-code" class="edumall-register-verify-code">

		<?php do_action('edumall_popup_register_before_form_fields'); ?>

		<section class="verification-input">
			<label for="verification-code" class="form-label"><?php printf(esc_html__('کد تایید ارسال شد به شماره %s %s را وارد کنید', 'edumall-child'), '<p class="phone-number">', '</p>'); ?></label>
			<div class="verification-input-wrap">
				<input type="text" id="verification-code" class="form-control form-input" name="verify" placeholder="<?php esc_attr_e('کد تایید', 'edumall-child'); ?>" />
				<div class="verification-timer">
					<span class="separator"></span>
					<p class="timer">00:05</p>
				</div>
			</div>
		</section>

		<?php
		/**
		 * @since 2.8.4
		 */
		do_action('edumall_popup_register_after_form_field_accept');
		?>

		<?php do_action('edumall_popup_register_after_form_fields'); ?>

		<section class="verification-component">
			<div class="verification-component-edit-phone">
				<a href="#"><?php esc_html_e('ویرایش شماره', 'edumall-child'); ?></a>
			</div>

			<div class="verification-component-send-code">
				<a href="#" class="send-code"><?php esc_html_e('ارسال مجدد کد', 'edumall-child'); ?></a>
			</div>
		</section>

		<section class="verification-button">
			<?php wp_nonce_field('user_register', 'user_register_nonce'); ?>
			<input type="hidden" name="action" value="edumall_user_register">
			<button type="submit" class="button form-submit"><?php esc_html_e('بررسی کد تایید و ادامه', 'edumall-child'); ?></button>
		</section>

		<section class="verification-pass">
			<a href="#">
				<?php esc_html_e('ورود با کلمه عبور', 'edumall-child'); ?>
			</a>
		</section>

	</form>

	<form id="edumall-register-meta" class="edumall-register-meta" method="post">
		<section class="meta-input">
			<div class="meta-input-wrap">
				<label for="meta-name" class="form-label">
					<?php echo esc_html__('نام و نام خانوادگی', 'edumall-child'); ?>
					<sup>*</sup>
				</label>
				<input type="text" id="meta-name" class="form-control form-input" name="meta-name" placeholder="<?php esc_attr_e('نام و نام خانوادگی', 'edumall-child'); ?>" required />
			</div>
			<div class="meta-input-wrap">
				<label for="meta-refer" class="form-label"><?php echo esc_html__('در صورت داشتن کد معرف، آن را وارد کنید', 'edumall-child'); ?></label>
				<input type="text" id="meta-refer" class="form-control form-input" name="meta-refer" placeholder="<?php esc_attr_e('کد معرف', 'edumall-child'); ?>" />
			</div>
		</section>

		<section class="meta-button">
			<?php wp_nonce_field('user_register', 'user_register_nonce'); ?>
			<input type="hidden" name="action" value="edumall_user_register">
			<button type="submit" class="meta-button-check"><?php esc_html_e('بررسی کد معرف', 'edumall-child'); ?></button>
			<button type="submit" class="meta-button-continue"><?php esc_html_e('ادامه', 'edumall-child'); ?></button>
		</section>
	</form>

	<form id="edumall-register-favorites" class="edumall-register-favorites" method="post">
		<div class="fav-caption">
			<p>
				به هانیل کمک کن تا بهترین تجربه آموزشی را برای شما فراهم کند. با انتخاب حداقل
				<strong>3</strong>
				موضوع یا علاقه‌مندی از سوی شما، هانیل قادر خواهد بود دوره‌ها و آموزش‌هایی را معرفی کند که دقیقاً با سلیقه و نیازهای شما هماهنگ باشند. هدف ما ارائه‌ی پیشنهادات دقیق و متناسب با شماست تا شما بتوانید به بهترین شکل ممکن از این تجربه استفاده کنید. (:
			</p>
		</div>

		<div class="fav-cats">
			<a href="#"><?php echo esc_html__('مهارت‌های نرم', 'edumall-child'); ?></a>
			<a href="#"><?php echo esc_html__('مدیریت منزل', 'edumall-child'); ?></a>
			<a href="#"><?php echo esc_html__('گرافیک', 'edumall-child'); ?></a>
			<a href="#"><?php echo esc_html__('برنامه‌نویسی', 'edumall-child'); ?></a>
			<a href="#"><?php echo esc_html__('فروش و بازاریابی', 'edumall-child'); ?></a>
			<a href="#"><?php echo esc_html__('تولید محتوا', 'edumall-child'); ?></a>
		</div>

		<div class="fav-button">
			<button type="submit" class="fav-login"><?php esc_html_e('ادامه', 'edumall-child'); ?></button>
		</div>
	</form>

	<input type="hidden" name="user_id_hidden" id="user_hidden_id">

	<form id="edumall-register-state" class="edumall-register-state">
		<section class="state-wrap">
			<input type="radio" name="user_state" id="" value="tutor">
			<p>
				<?php esc_html_e('ورود به عنوان فراگیر', 'edumall-child'); ?>
			</p>
		</section>

		<section class="state-wrap">
			<input type="radio" name="user_state" id="" value="instructor">
			<p>
				<?php esc_html_e('تکمیل اطلاعات و ورود به عنوان مربی', 'edumall-child'); ?>
			</p>
		</section>

		<section class="state-wrap">
			<input type="radio" name="user_state" id="" value="academy">
			<p>
				<?php esc_html_e('ساخت پروفایل آکادمی', 'edumall-child'); ?>
			</p>
		</section>

		<section class="state-button">
			<button type="submit" class="fav-login"><?php esc_html_e('ورود به عنوان فراگیر', 'edumall-child'); ?></button>
		</section>
	</form>

	<main class="become-instructor" data-user="">
		<div class="become-instructor-wrap">
			<form action="" method="post" enctype="multipart/form-data" class="become-instructor-form">
				<?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
				<input type="hidden" value="instructor_profile_edit" name="instructor_action" />

				<?php
				$errors = apply_filters('instructor_profile_edit_validation_errors', array());
				if (is_array($errors) && count($errors)) {
					echo '<div class="instructor-alert-warning instructor-mb-10"><ul class="instructor-required-fields">';
					foreach ($errors as $error_key => $error_value) {
						echo "<li>{$error_value}</li>";
					}
					echo '</ul></div>';
				}
				?>

				<div class="become-instructor-form-group instructor-profile-pic">
					<label>
						<?php esc_html_e('عکس پروفایل', 'edumall-child'); ?>
						<sup>*</sup>
					</label>
					<div id="instructor_profile_cover_photo_editor">

						<label for="instructor_photo_dialogue_box" id="instructor_profile_area">
							<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/gallery-edit.png' ?>" alt="">
						</label>

						<div class="user-edit-buttons">
							<label for="instructor_photo_dialogue_box" class="user-edit-buttons-edit">ویرایش</label>
							<label class="user-edit-buttons-delete">
								<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.png' ?>" alt="">
							</label>
						</div>
						<input id="instructor_photo_dialogue_box" type="file" accept=".png,.jpg,.jpeg" />
					</div>
				</div>

				<div class="become-instructor-form-group instructor-username">
					<label for="instructor_profile_username">
						<?php esc_html_e('Username', 'edumall-child'); ?>
						<sup>*</sup>
					</label>
					<div class="instructor-username-input">
						<input type="text" id="instructor_profile_username" name="username" placeholder="مانند:" required>
						<svg class="instructor-username-input-accept" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 48 48">
							<path fill="#c8e6c9" d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z"></path>
							<polyline fill="none" stroke="#4caf50" stroke-miterlimit="10" stroke-width="4" points="14,24 21,31 36,16"></polyline>
						</svg>

						<svg class="instructor-username-input-reject" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 48 48">
							<path fill="#f44336" d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z"></path>
							<line x1="16.9" x2="31.1" y1="16.9" y2="31.1" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4"></line>
							<line x1="31.1" x2="16.9" y1="16.9" y2="31.1" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4"></line>
						</svg>
					</div>

				</div>

				<div class="become-instructor-form-group instructor-profession">
					<label for="instructor_profile_profession">
						<?php esc_html_e('تخصص', 'edumall-child'); ?>
						<sup>*</sup>
					</label>
					<input type="text" id="instructor_profile_profession" name="profession" value="" placeholder="مانند: دکتری روانشناسی بالینی" required>
				</div>

				<div class="become-instructor-form-group instructor-story-text">
					<label for="instructor_profile_story">
						<?php esc_html_e('روایت من', 'edumall-child'); ?>
						<sup>*</sup>
					</label>
					<textarea cols="50" rows="7" name="story" id="instructor_story_text" value="" placeholder="روایت خود را اینجا بنوسید...." required></textarea>
					<div class="instructor-story-box-limit">
						<p class="instructor-story-box-limit-end">250</p>
						<p>/</p>
						<p class="instructor-story-box-limit-start">0</p>
					</div>
				</div>

				<div class="become-instructor-form-group instructor-story-video">
					<label for="instructor_profile_story">
						<?php esc_html_e('فیلم روایت', 'edumall-child'); ?>
					</label>
					<p>
						به تصویر کشیدن روایتتان در قالب فیلم میتواند منجر به جذب مخاطب بیشتری شود.
					</p>
					<div class="instructor-story-box story-video">
						<label for="instructor_story_video_file">
							<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/import.png' ?>" alt="">
							<h4>برای آپلود فیلم روایت اینجا کلیک کنید</h4>
							<p>حجم: حداکثر 20 مگابایت</p>
							<p>فرمت مجاز: Mp4</p>
						</label>
					</div>
					<!-- TODO -->
					<!-- Implement Ajax upload file with s3 bucket -->
					<div class="instructor-story-box story-video-upload">
						<img class="story-video-upload-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.png' ?>" alt="">
						<div class="story-video-upload-info">
							<img class="story-video-upload-info-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/video-vertical.png' ?>" alt="">
							<div class="story-video-upload-info-meta">
								<p id="file-name"></p>
								<p id="file-size"></p>
							</div>
						</div>
						<div class="story-video-upload-progress">
							<div class="progress-wrap">
								<div class="progress"></div>
							</div>
							<p class="progress-text">0%</p>
						</div>
					</div>
					<input id="instructor_story_video_file" type="file" accept=".mp4" />
				</div>

				<div class="become-instructor-form-group instructor-tags">
					<label for="instructor_profile_tags">
						<?php esc_html_e('برچسب', 'edumall-child'); ?>
					</label>
					<div class="instructor-tags-input">
						<input type="text" name="tags" value="<?php echo esc_attr(get_user_meta($user->ID, 'tags', true)); ?>" placeholder="برچسب خود را بنویسید">
						<a href="#">افزودن</a>
					</div>
					<div id="instructor_profile_tags" class="instructor-tags-wrap">

					</div>
				</div>


				<div class="become-instructor-form-group instructor-submit-wrap">
					<button type="submit" name="instructor_register_student_btn" value="register" class="instructor-button instructor-profile-settings-save"><?php esc_html_e('ورود', 'edumall-child'); ?></button>
				</div>

			</form>
		</div>
	</main>

	<main class="become-academy" data-user="">
		<div class="become-academy-wrap">
			<form action="" method="post" enctype="multipart/form-data" class="become-academy-form">
				<input type="hidden" id="_tutor_nonce" name="_tutor_nonce" value="<?php echo wp_create_nonce('create_academy_nonce'); ?>">
				<input type="hidden" value="academy_profile_edit" name="academy_action" />

				<?php
				$errors = apply_filters('academy_profile_edit_validation_errors', array());
				if (is_array($errors) && count($errors)) {
					echo '<div class="academy-alert-warning academy-mb-10"><ul class="academy-required-fields">';
					foreach ($errors as $error_key => $error_value) {
						echo "<li>{$error_value}</li>";
					}
					echo '</ul></div>';
				}
				?>

				<div class="become-academy-form-group academy-profile-pic">
					<label>
						<?php esc_html_e('عکس پروفایل', 'edumall-child'); ?>
						<sup>*</sup>
					</label>
					<div id="academy_profile_cover_photo_editor">
						<?php if (empty($profile_photo_id)) : ?>
							<label for="academy_photo_dialogue_box" id="academy_profile_area">
								<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/gallery-edit.png' ?>" alt="">
							</label>
						<?php else : ?>
							<img class="profile-picture" src="<?php echo $profile_photo_id ?>" alt="">
						<?php endif; ?>
						<div class="user-edit-buttons <?php echo empty($profile_photo_id) ? '' : "active" ?>">
							<label for="academy_photo_dialogue_box" class="user-edit-buttons-edit">ویرایش</label>
							<label class="user-edit-buttons-delete">
								<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/trash.png' ?>" alt="">
							</label>
						</div>
						<input id="academy_photo_dialogue_box" type="file" accept=".png,.jpg,.jpeg" />
					</div>
				</div>

				<div class="become-academy-form-group academy-username">
					<label for="academy_profile_username">
						<?php esc_html_e('Username', 'edumall-child'); ?>
						<sup>*</sup>
					</label>
					<div class="academy-username-input">
						<input type="text" id="academy_profile_username" name="username" placeholder="مانند:" value="<?php echo $academy_username ?>" required>
						<svg class="academy-username-input-accept" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 48 48">
							<path fill="#c8e6c9" d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z"></path>
							<polyline fill="none" stroke="#4caf50" stroke-miterlimit="10" stroke-width="4" points="14,24 21,31 36,16"></polyline>
						</svg>

						<svg class="academy-username-input-reject" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 48 48">
							<path fill="#f44336" d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z"></path>
							<line x1="16.9" x2="31.1" y1="16.9" y2="31.1" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4"></line>
							<line x1="31.1" x2="16.9" y1="16.9" y2="31.1" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4"></line>
						</svg>
					</div>

				</div>

				<div class="become-academy-form-group academy-profession">
					<label for="academy_profile_profession">
						<?php esc_html_e('تخصص', 'edumall-child'); ?>
						<sup>*</sup>
					</label>
					<input type="text" id="academy_profile_profession" name="profession" value="<?php echo esc_attr(get_user_meta($user->ID, '_academy_profession', true)); ?>" placeholder="مانند: دکتری روانشناسی بالینی" required>
				</div>

				<div class="become-academy-form-group academy-story-text">
					<label for="academy_profile_story">
						<?php esc_html_e('روایت من', 'edumall-child'); ?>
						<sup>*</sup>
					</label>
					<textarea cols="50" rows="7" name="story" id="academy_story_text" value="<?php echo esc_attr(get_user_meta($user->ID, '_academy_story_text', true)); ?>" placeholder="روایت خود را اینجا بنوسید...." required><?php echo $academy_story_text ?></textarea>
					<div class="academy-story-box-limit">
						<p class="academy-story-box-limit-end">250</p>
						<p>/</p>
						<p class="academy-story-box-limit-start">0</p>
					</div>
				</div>

				<div class="become-academy-form-group academy-story-video">
					<label for="academy_profile_story">
						<?php esc_html_e('فیلم روایت', 'edumall-child'); ?>
					</label>
					<p>
						به تصویر کشیدن روایتتان در قالب فیلم میتواند منجر به جذب مخاطب بیشتری شود.
					</p>
					<div class="academy-story-box story-video">
						<label for="academy_story_video_file">
							<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/import.png' ?>" alt="">
							<h4>برای آپلود فیلم روایت اینجا کلیک کنید</h4>
							<p>حجم: حداکثر 20 مگابایت</p>
							<p>فرمت مجاز: Mp4</p>
						</label>
					</div>
					<!-- TODO -->
					<!-- Implement Ajax upload file with s3 bucket -->
					<div class="academy-story-box story-video-upload">
						<img class="story-video-upload-close" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-circle.png' ?>" alt="">
						<div class="story-video-upload-info">
							<img class="story-video-upload-info-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/video-vertical.png' ?>" alt="">
							<div class="story-video-upload-info-meta">
								<p id="file-name"></p>
								<p id="file-size"></p>
							</div>
						</div>
						<div class="story-video-upload-progress">
							<div class="progress-wrap">
								<div class="progress"></div>
							</div>
							<p class="progress-text">0%</p>
						</div>
					</div>
					<input id="academy_story_video_file" type="file" accept=".mp4" />
				</div>

				<div class="become-academy-form-group academy-tags">
					<label for="academy_profile_tags">
						<?php esc_html_e('برچسب', 'edumall-child'); ?>
					</label>
					<div class="academy-tags-input">
						<input type="text" name="tags" value="<?php echo esc_attr(get_user_meta($user->ID, 'tags', true)); ?>" placeholder="برچسب خود را بنویسید">
						<a href="#">افزودن</a>
					</div>
					<div id="academy_profile_tags" class="academy-tags-wrap">
						<?php
						if (!empty($academy_tags)) :
							foreach ($academy_tags as $index => $tag) :
						?>
								<div class="academy-tags-wrap-value value-<?php echo $tag ?>">
									<p><?php echo esc_html($tag) ?></p>
									<img class="academy-tags-delete" src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgaWQ9InZ1ZXNheC9saW5lYXIvY2xvc2UtY2lyY2xlIj4KPGcgaWQ9ImNsb3NlLWNpcmNsZSI+CjxwYXRoIGlkPSJWZWN0b3IiIGQ9Ik0xMiAyMkMxNy41IDIyIDIyIDE3LjUgMjIgMTJDMjIgNi41IDE3LjUgMiAxMiAyQzYuNSAyIDIgNi41IDIgMTJDMiAxNy41IDYuNSAyMiAxMiAyMloiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMiIgZD0iTTkuMTY5OTIgMTQuODI5OUwxNC44Mjk5IDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGlkPSJWZWN0b3JfMyIgZD0iTTE0LjgyOTkgMTQuODI5OUw5LjE2OTkyIDkuMTY5OTIiIHN0cm9rZT0iIzEyMTIxMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjwvZz4KPC9nPgo8L3N2Zz4K' />
								</div>
						<?php
							endforeach;
						endif;
						?>
					</div>
				</div>


				<div class="become-academy-form-group academy-submit-wrap">
					<button type="submit" name="academy_register_student_btn" value="register" class="academy-button academy-profile-settings-save"><?php esc_html_e('ورود', 'edumall-child'); ?></button>
				</div>

			</form>
		</div>
	</main>
</div>