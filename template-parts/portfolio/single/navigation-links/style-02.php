<?php
$args = array(
	'prev_text' => esc_html__( 'Prev Project', 'edumall' ),
	'next_text' => esc_html__( 'Next Project', 'edumall' ),
);

$args = apply_filters( 'edumall_portfolio_navigation_links_args', $args );

$prev_post_link = get_previous_post_link();
$next_post_link = get_next_post_link();
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-list">
				<div class="nav-item prev">
					<?php if ( '' !== $prev_post_link ) : ?>
						<?php previous_post_link( '%link', '<div class="hover">' . $args['prev_text'] . '</div><div class="normal">' . $args['prev_text'] . '</div>' ); ?>
					<?php else: ?>
						<div class="disabled"><?php echo esc_html( $args['prev_text'] ); ?></div>
					<?php endif; ?>
				</div>

				<div class="nav-line"></div>

				<div class="nav-item next">
					<?php if ( '' !== $next_post_link ) : ?>
						<?php next_post_link( '%link', '<div class="hover">' . $args['next_text'] . '</div><div class="normal">' . $args['next_text'] . '</div>' ); ?>
					<?php else: ?>
						<div class="disabled"><?php echo esc_html( $args['next_text'] ); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
