<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Edumall_Course_Layout_Switcher' ) ) {
	class Edumall_Course_Layout_Switcher extends Edumall_Tutor {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'edumall_course_archive_layout', [ $this, 'change_course_archive_layout' ] );

			add_action( 'edumall_before_course_filter_bar_right', [ $this, 'add_switcher_button' ], 30 );

			add_action( 'wp_ajax_course_layout_change', [ $this, 'do_switch_layout' ] );
			add_action( 'wp_ajax_nopriv_course_layout_change', [ $this, 'do_switch_layout' ] );
		}

		public function add_switcher_button() {
			if ( '1' !== Edumall::setting( 'course_archive_layout_switcher' ) ) {
				return;
			}

			$layout = $this->get_course_archive_layout();
			?>
			<form id="archive-layout-switcher" class="archive-layout-switcher">
				<?php
				$switcher_grid_classes = 'switcher-item grid';
				$switcher_list_classes = 'switcher-item list';

				if ( 'grid' === $layout ) {
					$switcher_grid_classes .= ' selected';
				} else {
					$switcher_list_classes .= ' selected';
				}

				$id = uniqid( 'switcher-' );
				?>
				<div class="archive-layout-switcher-label heading"><?php esc_html_e( 'See', 'edumall' ); ?></div>
				<label class="<?php echo esc_attr( $switcher_grid_classes ); ?>"
				       for="<?php echo esc_attr( $id . '-grid' ) ?>">
					<input type="radio" name="layout" value="grid" <?php checked( $layout, 'grid' ); ?> id="<?php echo esc_attr( $id . '-grid' ) ?>">
				</label>
				<label class="<?php echo esc_attr( $switcher_list_classes ); ?>" for="<?php echo esc_attr( $id . '-list' ) ?>">
					<input type="radio" name="layout" value="list" <?php checked( $layout, 'list' ); ?> id="<?php echo esc_attr( $id . '-list' ) ?>">
				</label>
				<input type="hidden" name="action" value="course_layout_change">
			</form>
			<?php
		}

		public function do_switch_layout() {
			$layout = 'grid';

			if ( isset( $_POST['layout'] ) && 'list' === $_POST['layout'] ) {
				$layout = 'list';
			}

			setcookie( 'course_archive_layout', $layout, time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );

			echo wp_json_encode( [
				'success' => 1,
			] );

			wp_die();
		}

		public function change_course_archive_layout( $layout ) {
			if ( '1' === Edumall::setting( 'course_archive_layout_switcher' )
			     && isset( $_COOKIE['course_archive_layout'] )
			     && ! isset( $_GET['course_archive_preset'] )
			) {
				return $_COOKIE['course_archive_layout'];
			}

			return $layout;
		}
	}
}
