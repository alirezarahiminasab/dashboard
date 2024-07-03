<?php
$args = array(
	'next_text' => esc_html__( 'Next Project', 'edumall' ),
);

$args = apply_filters( 'edumall_portfolio_navigation_links_args', $args );

$next_post = get_next_post();

if ( empty( $next_post ) ) {
	return;
}
?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<?php
			$link_template = '<div class="nav-item"><h6 class="nav-text text-stroke-01">' . $args['next_text'] . '</h6><h3 class="post-title">%title</h3></div>';

			next_post_link( '%link', $link_template );
			?>
		</div>
	</div>
</div>
