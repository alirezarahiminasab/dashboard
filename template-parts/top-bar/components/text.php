<?php
/**
 * Text on top bar
 *
 * @package Edumall
 * @since   1.3.1
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$text = $args['text'];
?>
<div class="top-bar-text">
	<?php echo wp_kses( $text, 'edumall-default' ); ?>
</div>
