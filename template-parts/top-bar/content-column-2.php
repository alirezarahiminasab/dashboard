<?php
/**
 * The template for displaying columns of top bar.
 * one left column + one center column + one right column.
 *
 * This template can be overridden by copying it to yourtheme/template-parts/top-bar/content-column-3.php
 *
 * @author ThemeMove
 * @since  1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="col-md-6 top-bar-left">
	<div class="top-bar-wrap">
		<?php Edumall_Top_Bar::instance()->print_components( 'left' ); ?>
	</div>
</div>
<div class="col-md-6 top-bar-right">
	<div class="top-bar-wrap">
		<?php Edumall_Top_Bar::instance()->print_components( 'right' ); ?>
	</div>
</div>
