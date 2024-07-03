<?php
$footer = Edumall_Global::instance()->get_footer();

if ( 'none' === $footer ) {
	return;
}
?>
<div id="page-footer-wrapper" class="page-footer-wrapper">
	<?php
	if ( function_exists( 'tm_addons_location_exits' ) && tm_addons_location_exits( 'tm_footer', true ) ) {
		edumall_load_template( 'footer/tm-elementor' );
	} elseif ( ! function_exists( 'elementor_location_exits' ) || ! elementor_location_exits( 'footer', true ) ) {
		edumall_load_template( 'footer/simple' );
	} else {
		if ( function_exists( 'elementor_theme_do_location' ) ) :
			edumall_load_template( 'footer/elementor' );
		endif;
	}
	?>
</div>
