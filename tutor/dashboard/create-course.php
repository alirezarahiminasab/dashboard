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

get_tutor_header( true );
do_action( 'tutor_load_template_before', 'dashboard.create-course', null );

$course_id = Input::get( 'course_ID', 0, Input::TYPE_INT );
$post      = get_post( $course_id );

if ( ! $course_id || tutor()->course_post_type != get_post_type( $post ) ) {
	return;
}
setup_postdata( $post );

if ( ! tutor_utils()->is_instructor( get_current_user_id(), true ) || ! tutor_utils()->can_user_edit_course( get_current_user_id(), $course_id ) ) {
	$args = array(
		'headline'    => __( 'Permission Denied', 'edumall' ),
		'message'     => __( 'You don\'t have the right to edit this course', 'edumall' ),
		'description' => __( 'Please make sure you are logged in to correct account', 'edumall' ),
		'button'      => array(
			'url'  => get_permalink( $course_id ),
			'text' => __( 'View Course', 'edumall' ),
		),
	);

	tutor_load_template( 'permission-denied', $args );

	return;
}

$can_publish_course = (bool) tutor_utils()->get_option( 'instructor_can_publish_course' ) || current_user_can( 'administrator' );

$course_slug      = $post->post_name;
$course_permalink = get_the_permalink();
?>

<?php do_action( 'tutor/dashboard_course_builder_before' ); ?>

	<form action="" id="tutor-frontend-course-builder" class="tutor-frontend-course-builder" method="post"
	      enctype="multipart/form-data">

		<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>

		<?php if ( $post->post_status === 'draft' ) : ?>
			<input name="original_publish" type="hidden" id="original_publish" value="Publish">
		<?php endif; ?>

		<header id="page-header" class="page-header header-dark header-sticky-dark-logo">
			<div class="page-header-place-holder"></div>
			<div id="page-header-inner" class="page-header-inner" data-sticky="1">
				<div class="container">
					<div class="header-wrap">
						<div class="header-left">
							<?php
							$branding_args = [
								'reverse_scheme' => true,
							];
							?>
							<?php edumall_load_template( 'branding', null, $branding_args ); ?>

							<?php if ( 'draft' === $post->post_status || 'auto-draft' === $post->post_status ) : ?>
								<?php
								Edumall_Templates::render_button( [
									'link'        => [
										'url' => '#',
									],
									'text'        => esc_html__( 'Save', 'edumall' ),
									'icon'        => 'fa-light fa-save',
									'style'       => 'thick-border',
									'extra_class' => 'tutor-btn bordered-btn tutor-dashboard-builder-draft-btn',
									'id'          => 'tutor-course-save-draft',
									'attributes'  => [
										'name'  => 'course_submit_btn',
										'value' => 'save_course_as_draft',
									],
								] );
								?>
							<?php endif; ?>
						</div>

						<div class="header-right">
							<div class="header-content-inner">
								<div id="header-right-inner" class="header-right-inner">
									<div class="header-right-inner-content">
										<?php Edumall_Templates::render_button( [
											'link'        => [
												'url'         => get_the_permalink( $course_id ),
												'is_external' => true,
											],
											'text'        => esc_html__( 'Preview', 'edumall' ),
											'icon'        => 'fa-light fa-glasses',
											'extra_class' => 'button-grey',
										] ); ?>

										<div class="form-submit">
											<?php if ( $can_publish_course ) : ?>
												<button class="tutor-button" type="submit"
												        name="course_submit_btn"
												        value="publish_course"><?php esc_html_e( 'Publish Course', 'edumall' ); ?></button>
											<?php else: ?>
												<button class="tutor-button" type="submit"
												        name="course_submit_btn"
												        value="submit_for_review"><?php esc_html_e( 'Submit for Review', 'edumall' ); ?></button>
											<?php endif; ?>
										</div>

										<div class="return-dashboard-link">
											<a href="<?php echo tutor_utils()->tutor_dashboard_url(); ?>"> <?php esc_html_e( 'Exit', 'edumall' ); ?></a>
										</div>
									</div>
								</div>

								<?php Edumall_Header::instance()->print_more_tools_button(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div class="tutor-frontend-course-builder-section tm-sticky-parent">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<input type="hidden" value="tutor_add_course_builder" name="tutor_action"/>
						<input type="hidden" name="course_ID" id="course_ID" value="<?php echo get_the_ID(); ?>">
						<input type="hidden" name="post_ID" id="post_ID" value="<?php echo get_the_ID(); ?>">
						<div class="tutor-dashboard-course-builder-wrap tm-sticky-column">

							<!--since 1.8.0 alert message -->
							<?php
							$user_id = get_current_user_id();
							$expires = get_user_meta( $user_id, 'tutor_frontend_course_message_expires', true );
							$message = get_user_meta( $user_id, 'tutor_frontend_course_action_message', true );

							if ( $message && $expires && $expires > time() ) {
								$show_modal = $message['show_modal'];
								$message    = $message['message'];

								if ( ! $show_modal ) {
									?>
									<div class="tutor-alert tutor-alert-info">
										<?php echo $message; ?>
									</div>
								<?php } else { ?>
									<!-- @todo: move to toast -->
									<div id="modal-course-save-feedback" class="tutor-modal tutor-is-active">
										<span class="tutor-modal-overlay"></span>
										<div class="tutor-modal-window tutor-modal-window-md">
											<div class="tutor-modal-content tutor-modal-content-white">
												<button class="tutor-iconic-btn tutor-modal-close-o" data-tutor-modal-close>
													<span class="tutor-icon-times" area-hidden="true"></span>
												</button>

												<div class="tutor-modal-body tutor-text-center">
													<div class="tutor-py-48">
														<img class="tutor-d-inline-block" src="<?php echo tutor()->url; ?>assets/images/icon-cup.svg" />
														<div class="tutor-fs-3 tutor-fw-medium tutor-color-black tutor-mb-12"><?php _e( 'Thank You!', 'edumall' ); ?></div>
														<div class="tutor-fs-6 tutor-color-muted"><?php echo $message; ?></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<script>
										const alertBox = document.getElementById('modal-course-save-feedback');
										setTimeout(() => {
											if (alertBox) alertBox.classList.remove('tutor-is-active');
										}, 5000)
									</script>
									<?php
								}
							}

							if ( $message || $expires ) {
								delete_user_meta( $user_id, 'tutor_frontend_course_message_expires' );
								delete_user_meta( $user_id, 'tutor_frontend_course_action_message' );
							}
							?>
							<!--alert message end -->
							<?php do_action( 'tutor/dashboard_course_builder_form_field_before' ); ?>

							<div class="tutor-course-builder-section tutor-course-builder-info">
								<div class="tutor-course-builder-section-title">
									<span class="tutor-fs-5 tutor-fw-bold tutor-color-secondary">
										<i class="color-text-brand tutor-icon-angle-up tutor-fs-5" area-hidden="true"></i>
										<span><?php esc_html_e( 'Course Info', 'edumall' ); ?></span>
									</span>
								</div>

								<div class="tutor-course-builder-section-content">
									<div class="tutor-frontend-builder-item-scope">
										<div class="tutor-form-group">
											<label><?php esc_html_e( 'Course Title', 'edumall' ); ?></label>
											<input type="text" name="title"
											       value="<?php echo esc_attr( get_the_title() ); ?>"
											       placeholder="<?php esc_attr_e( 'ex. Learn photoshop CS6 from scratch', 'edumall' ); ?>">
										</div>
									</div> <!--.tutor-frontend-builder-item-scope-->

									<div class="tutor-frontend-builder-item-scope">
										<div class="tutor-form-group">
											<label><?php esc_html_e( 'Course Slug', 'edumall' ); ?></label>
											<div id="tutor-course-create-slug-tooltip-wrapper" class="tooltip-wrap tutor-d-block">
												<span class="tooltip-txt tooltip-right tutor-mt-12">
													<?php esc_html_e( '255', 'edumall' ); ?>
												</span>
												<input id="tutor-course-slug" type="text" name="post_name" class="tutor-form-control" placeholder="<?php esc_attr_e( 'Please enter the course page slug here', 'edumall' ); ?>" value="<?php echo esc_html( $course_slug ); ?>" maxlength="255">
												<div class="tutor-fs-7 tutor-has-icon tutor-color-muted tutor-mt-12">
													<?php esc_html_e( 'Permalink: ', 'edumall' ); ?>
													<a href="<?php echo esc_url( $course_permalink ); ?>" target="_blank">
														<?php echo esc_url( $course_permalink ); ?>
													</a>
												</div>
											</div>
										</div>
									</div> <!--.tutor-frontend-builder-item-scope-->

									<div class="tutor-frontend-builder-item-scope">
										<div class="tutor-form-group">
											<label> <?php esc_html_e( 'Description', 'edumall' ); ?></label>
											<?php
											$editor_settings = array(
												'media_buttons' => false,
												'quicktags'     => false,
												'editor_height' => 150,
												'textarea_name' => 'content',
											);
											wp_editor( $post->post_content, 'course_description', $editor_settings );
											?>
										</div>
									</div>  <!--.tutor-frontend-builder-item-scope-->

									<?php do_action( 'tutor/frontend_course_edit/after/description', $post ); ?>

									<div class="tutor-frontend-builder-item-scope">
										<div class="tutor-form-group">
											<label>
												<?php esc_html_e( 'Choose a category', 'edumall' ); ?>
											</label>
											<div class="tutor-form-field-course-categories">
												<?php //echo tutor_course_categories_checkbox($course_id);
												echo tutor_course_categories_dropdown( $course_id, array( 'classes' => 'tutor_select2' ) );
												?>
											</div>
										</div>
									</div>

									<?php do_action( 'tutor/frontend_course_edit/after/category', $post ); ?>

									<?php
									$monetize_by = tutils()->get_option( 'monetize_by' );
									if ( $monetize_by === 'wc' || $monetize_by === 'edd' ) {
										$course_price             = tutor_utils()->get_raw_course_price( get_the_ID() );
										$currency_symbol          = tutor_utils()->currency_symbol();
										$_tutor_course_price_type = tutils()->price_type();
										?>
										<div class="tutor-course-price-wrapper tutor-mb-32 tutor-row tutor-align-center">
											<div class="tutor-mb-20">
												<div class="tutor-course-field-label tutor-fs-6 tutor-mb-3"><?php esc_html_e( 'Course Price', 'edumall' ); ?></div>
												<div class="tutor-d-flex tutor-mt-20 tutor-course-price-toggle">
													<div class="tutor-form-check tutor-align-center">
														<input type="radio" id="tutor_input_price_free" class="tutor-form-check-input tutor-flex-shrink-0" name="tutor_course_price_type" value="free" <?php $_tutor_course_price_type ? checked( $_tutor_course_price_type, 'free' ) : checked( 'true', 'true' ); ?> />
														<label for="tutor_input_price_free" class="tutor-fs-6">
															<?php esc_html_e( 'Free', 'edumall' ); ?>
														</label>
													</div>
													<div class="tutor-form-check tutor-align-center">
														<input type="radio" id="tutor_input_price_paid" class="tutor-form-check-input tutor-flex-shrink-0" name="tutor_course_price_type" value="paid" <?php checked( $_tutor_course_price_type, 'paid' ); ?> />
														<label for="tutor_input_price_paid" class="tutor-fs-6">
															<?php esc_html_e( 'Paid', 'edumall' ); ?>
														</label>
													</div>
												</div>
											</div>
											<div class="tutor-mb-12">
												<div class="tutor-course-price-row tutor-row <?php echo $_tutor_course_price_type === 'paid' ? 'is-paid tutor-mb-20' : null ?>">
													<div class="tutor-col-6 tutor-col-sm-6 tutor-col-lg-4 tutor-course-price-row-regular">
														<div class="tutor-form-label"><?php esc_html_e( 'Regular Price', 'edumall' ); ?></div>
														<div class="tutor-form-check tutor-align-center tutor-d-flex">
															<label for="tutor_price_paid" class="tutor-amount-field">
																<div class="tutor-input-group">
																	<span class="tutor-input-group-addon">
																		<?php echo $currency_symbol; ?>
																	</span>
																	<input type="number" class="tutor-form-number-verify tutor-form-control" name="course_price" value="<?php echo $course_price->regular_price; ?>" placeholder="<?php _e( 'Set course price', 'edumall' ); ?>" step="any" min="0" pattern="^\d*(\.\d{0,2})?$">
																</div>
															</label>
														</div>
													</div>
													<div class="tutor-col-6 tutor-col-sm-6 tutor-col-lg-6 tutor-course-price-paid">
														<div class="tutor-form-label"><?php esc_html_e( 'Discounted Price', 'edumall' ); ?></div>
														<div class="tutor-form-check tutor-align-center tutor-d-flex">
															<label class="tutor-amount-field">
																<div class="tutor-input-group">
																	<span class="tutor-input-group-addon">
																		<?php echo $currency_symbol; ?>
																	</span>
																	<input type="number" class="tutor-form-number-verify tutor-form-control" name="course_sale_price" value="<?php echo $course_price->sale_price; ?>" placeholder="<?php _e( 'Set course sale price', 'edumall' ); ?>" step="any" min="0" pattern="^\d*(\.\d{0,2})?$">
																</div>
															</label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php
									}
									?>

									<div class="tutor-frontend-builder-item-scope">
										<div class="tutor-form-group">
											<label>
												<?php esc_html_e( 'Course Thumbnail', 'edumall' ); ?>
											</label>
											<div
												class="tutor-form-field tutor-form-field-course-thumbnail tutor-thumbnail-wrap">
												<?php
												tutor_load_template_from_custom_path(
													tutor()->path . '/views/fragments/thumbnail-uploader.php',
													array(
														'media_id'    => get_post_thumbnail_id( $course_id ),
														'input_name'  => 'tutor_course_thumbnail_id',
														'placeholder' => tutor()->url . '/assets/images/thumbnail-placeholder.svg',
														'borderless'  => true,
														'background'  => '#E3E6EB',
														'border'      => '#E3E6EB',
													),
													false
												);
												?>
											</div>
										</div>
									</div>
								</div>
							</div>

							<?php do_action( 'tutor/dashboard_course_builder_form_field_after', $post ); ?>

							<div class="tutor-form-row tutor-form-submit">
								<div class="tutor-form-col-12">
									<div class="tutor-form-group">
										<div class="tutor-form-field tutor-course-builder-btn-group">
											<button type="submit" class="tutor-button btn-save-as-draft"
											        name="course_submit_btn"
											        value="save_course_as_draft"><?php esc_html_e( 'Save course as draft', 'edumall' ); ?></button>
											<?php if ( $can_publish_course ) : ?>
												<button class="tutor-button tutor-success" type="submit"
												        name="course_submit_btn"
												        value="publish_course"><?php esc_html_e( 'Publish Course', 'edumall' ); ?></button>
											<?php else : ?>
												<button class="tutor-button tutor-success" type="submit"
												        name="course_submit_btn"
												        value="submit_for_review"><?php esc_html_e( 'Submit for Review', 'edumall' ); ?></button>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="tutor-course-builder-upload-tips tm-sticky-column">
							<h3 class="tutor-course-builder-tips-title">
								<i class="fa-regular fa-lightbulb-on"></i><?php esc_html_e( 'Course Upload Tips', 'edumall' ); ?>
							</h3>
							<ul>
								<li><?php esc_html_e( 'Set the Course Price option or make it free.', 'edumall' ); ?></li>
								<li><?php esc_html_e( 'Standard size for course thumbnail is 700x430.', 'edumall' ); ?></li>
								<li><?php esc_html_e( 'Video section controls the course overview video.', 'edumall' ); ?></li>
								<li><?php esc_html_e( 'Course Builder is where you create & organize a course.', 'edumall' ); ?></li>
								<li><?php esc_html_e( 'Add Topics in the Course Builder section to create lessons, quizzes, and assignments.', 'edumall' ); ?></li>
								<li><?php esc_html_e( 'Prerequisites refers to the fundamental courses to complete before taking this particular course.', 'edumall' ); ?></li>
								<li><?php esc_html_e( 'Information from the Additional Data section shows up on the course single page.', 'edumall' ); ?></li>
								<li><?php esc_html_e( 'Make Announcements to notify any important notes to all enrolled students at once.', 'edumall' ); ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

<?php do_action( 'tutor/dashboard_course_builder_after' ); ?>

<?php do_action( 'tutor_load_template_after', 'dashboard.create-course', null ); ?>

<?php
get_tutor_footer( true );
