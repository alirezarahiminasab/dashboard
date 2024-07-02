<?php
/**
 * Template for displaying search forms
 *
 * @package  Edumall
 * @since    1.0
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'edumall' ); ?></span>
		<input type="search" class="search-field"
		       placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'edumall' ); ?>"
		       value="<?php echo get_search_query() ?>" name="s"
		       title="<?php echo esc_attr_x( 'Search for:', 'label', 'edumall' ); ?>"/>
	</label>
	<button type="submit" class="search-submit">
		<span class="search-btn-icon fas fa-search"></span>
		<span class="search-btn-text">
			<?php echo esc_html_x( 'Search', 'submit button', 'edumall' ); ?>
		</span>
	</button>
</form>
