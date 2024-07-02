<?php
// DON'T render breadcrumb if the current page is the front latest posts.
if ( ( is_home() && is_front_page() ) || ! function_exists( 'insight_core_breadcrumb' ) ) {
	return;
}

$breadcrumb_on  = Edumall::setting( 'title_bar_breadcrumb_enable', '1' );
$title_bar_type = Edumall_Global::instance()->get_title_bar_type();

// These title bar show both heading + breadcrumb.
// Other title bar don't need disable instead of using other type.
$full_title_bars = [
	'01',
	'02',
	'06',
	'08',
];

if ( '1' !== $breadcrumb_on && in_array( $title_bar_type, $full_title_bars, true ) ) {
	return;
}
?>
	<div id="page-breadcrumb" class="page-breadcrumb">
		<div class="page-breadcrumb-inner container">
			<?php echo insight_core_breadcrumb(); ?>
		</div>
	</div>
<?php
