<div class="post-overlay"></div>
<div class="post-overlay-content">
	<div class="post-overlay-content-inner">
		<div class="post-overlay-info">
			<h3 class="portfolio-overlay-title"><?php the_title(); ?></h3>

			<?php
			Edumall_Portfolio::instance()->the_categories_no_link( array(
				'classes' => 'portfolio-overlay-categories',
			) );
			?>
		</div>
	</div>
</div>
