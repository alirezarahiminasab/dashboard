<?php
/**
 * The template for displaying columns of top bar.
 * one left column
 *
 * This template can be overridden by copying it to yourtheme/template-parts/top-bar/content-column-1l.php
 *
 * @author ThemeMove
 * @since  1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="col-md-12 top-bar-left">
	<div class="top-bar-wrap">
		<?php Edumall_Top_Bar::instance()->print_components( 'left' ); ?>
	</div>
</div>
