<header id="page-header" <?php Edumall_Header::instance()->get_wrapper_class(); ?>>
	<div class="page-header-place-holder"></div>
	<div id="page-header-inner" class="page-header-inner" data-sticky="1">
		<?php Edumall_Top_Bar::instance()->render(); ?>

		<div class="container">
			<div class="header-wrap">
				<?php Edumall_THA::instance()->header_wrap_top(); ?>

				<div class="header-left">
					<div class="header-content-inner">
						<?php edumall_load_template( 'branding' ); ?>

						<?php Edumall_Header::instance()->print_category_menu(); ?>
					</div>
				</div>

				<div class="header-center">
					<div class="header-content-inner">
						<?php edumall_load_template( 'navigation' ); ?>
					</div>
				</div>

				<div class="header-right">
					<div class="header-content-inner">
						<div id="header-right-inner" class="header-right-inner">
							<div class="header-right-inner-content">
								<?php Edumall_THA::instance()->header_right_top(); ?>

								<?php Edumall_Header::instance()->print_search(); ?>

								<?php Edumall_Header::instance()->print_language_switcher(); ?>

								<?php Edumall_Header::instance()->print_social_networks(); ?>

								<?php Edumall_Header::instance()->print_notification(); ?>

								<?php Edumall_Woo::instance()->render_mini_cart(); ?>

								<?php Edumall_Header::instance()->print_user_buttons(); ?>

								<?php Edumall_Header::instance()->print_button( array( 'size' => 'sm' ) ); ?>

								<?php Edumall_THA::instance()->header_right_bottom(); ?>
							</div>
						</div>

						<?php Edumall_Header::instance()->print_open_mobile_menu_button(); ?>

						<?php Edumall_Header::instance()->print_more_tools_button(); ?>
					</div>
				</div>

				<?php Edumall_THA::instance()->header_wrap_bottom(); ?>
			</div>
		</div>
	</div>
</header>
