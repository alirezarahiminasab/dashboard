<?php
/**
 * The template for displaying the footer.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Edumall
 * @since   1.0
 */

?>
</div><!-- /.content-wrapper -->

<?php Edumall_THA::instance()->footer_before(); ?>

<?php edumall_load_template( 'footer/entry' ); ?>

<?php Edumall_THA::instance()->footer_after(); ?>

</div><!-- /.site -->

<?php wp_footer(); ?>
</body>
</html>
