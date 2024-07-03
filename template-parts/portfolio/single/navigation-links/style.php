<?php
$args = array(
	'prev_text' => esc_html__( 'Prev', 'edumall' ),
	'next_text' => esc_html__( 'Next', 'edumall' ),
);

$args = apply_filters( 'edumall_portfolio_navigation_links_args', $args );
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-list">
				<div class="nav-item prev">
					<div class="inner">
						<?php previous_post_link( '%link', '<div>' . $args['prev_text'] . '</div><h6>%title</h6>' ); ?>
					</div>
				</div>

				<div class="nav-item next">
					<div class="inner">
						<?php next_post_link( '%link', '<div>' . $args['next_text'] . '</div><h6>%title</h6>' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
