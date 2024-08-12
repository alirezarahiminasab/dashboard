<?php
/**
 * Event Loop Start
 *
 * @author  ThemeMove
 * @package Edumall/WP-Events-Manager/Templates
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$style = Edumall::setting( 'event_archive_style' );

$wrapper_classes = [
	'edumall-main-post',
	'edumall-grid-wrapper',
	'edumall-event',
	'edumall-animation-zoom-in',
	'style-' . $style,
];

$grid_classes = [ 'edumall-grid' ];

if ( 'list' === $style ) {
	$grid_classes[] = 'grid-sm-1';

	$grid_options = [
		'type'    => 'grid',
		'columns' => 1,
		'gutter'  => 30,
	];
} else {
	$lg_columns = Edumall::setting( 'event_archive_lg_columns', 4 );
	$md_columns = 2;
	$sm_columns = 1;

	if ( 'none' !== Edumall_Global::instance()->get_sidebar_status() ) {
		$lg_columns--;
	}

	$grid_classes[] = "grid-lg-{$lg_columns} grid-md-{$md_columns} grid-sm-{$sm_columns}";

	$grid_options = [
		'type'          => 'grid',
		'columns'       => $lg_columns,
		'columnsTablet' => $md_columns,
		'columnsMobile' => $sm_columns,
		'gutter'        => 30,
	];
}

?>
<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
     data-grid="<?php echo esc_attr( wp_json_encode( $grid_options ) ); ?>"
>
	<div class="<?php echo esc_attr( implode( ' ', $grid_classes ) ); ?>">
		<div class="grid-sizer"></div>
