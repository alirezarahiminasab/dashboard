<?php
/**
 * @package       TutorLMS/Templates
 * @version       1.7.5
 * @theme-version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$settings_url   = tutor_utils()->get_tutor_dashboard_page_permalink( 'settings' );
$reset_password = tutor_utils()->get_tutor_dashboard_page_permalink( 'settings/reset-password' );
$withdraw       = tutor_utils()->get_tutor_dashboard_page_permalink( 'settings/withdraw-settings' );

$setting_menus = array(
	'profile'        => array(
		'url'   => $settings_url,
		'title' => __( 'Profile', 'edumall' ),
		'role'  => false,
	),
	'reset_password' => array(
		'url'   => $reset_password,
		'title' => __( 'Reset Password', 'edumall' ),
		'role'  => false,
	),
	'withdrawal'     => array(
		'url'   => $withdraw,
		'title' => __( 'Withdraw', 'edumall' ),
		'role'  => 'instructor',
	),
);

$setting_menus = apply_filters( 'tutor_dashboard/nav_items/settings/nav_items', $setting_menus );

$GLOBALS['tutor_setting_nav'] = $setting_menus;
?>
<ul class="tutor-nav" tutor-priority-nav>
	<?php
	foreach ( $setting_menus as $menu_key => $menu ) {
		$valid = empty( $menu['role'] ) || ( 'instructor' === $menu['role'] && current_user_can( tutor()->instructor_role ) );

		if ( $valid ) {
			?>
			<li class="tutor-nav-item">
				<a class="tutor-nav-link<?php echo $active_setting_nav == $menu_key ? ' is-active' : ''; ?>" href="<?php echo esc_url( $menu['url'] ); ?>"><?php echo esc_html( $menu['title'] ); ?></a>
			</li>
			<?php
		}
	}
	?>
	<li class="tutor-nav-item tutor-nav-more tutor-d-none">
		<a class="tutor-nav-link tutor-nav-more-item" href="#"><span class="tutor-mr-4"><?php esc_html_e( 'More', 'edumall' ); ?></span>
			<span class="tutor-nav-more-icon tutor-icon-times"></span></a>
		<ul class="tutor-nav-more-list tutor-dropdown"></ul>
	</li>
</ul>
