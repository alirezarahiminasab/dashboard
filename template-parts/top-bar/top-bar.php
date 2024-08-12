<?php
$type   = Edumall_Global::instance()->get_top_bar_type();
$layout = Edumall::setting( "top_bar_style_{$type}_layout" );
?>
<div <?php Edumall_Top_Bar::instance()->get_wrapper_class(); ?>>
	<div class="container">
		<div class="row row-eq-height">
			<?php edumall_load_template( 'top-bar/content-column', $layout ); ?>
		</div>
	</div>
</div>
