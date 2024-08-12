<?php

use Detection\MobileDetect;

$detect = new MobileDetect();
$reverse_scheme = null;
if (isset($args) && isset($args['reverse_scheme'])) {
    $reverse_scheme = $args['reverse_scheme'];
}

Edumall_THA::instance()->footer_before();
?>
</div>
</div>
</div>
</div><!-- /.site -->
<!-- Toast -->
<?php if ($detect->isMobile()) : ?>
    <footer class="footer">
        <?php if (!is_page('dashboard')) : ?>
            <div class="footer-wrapper">
                <div class="footer-wrapper-links">
                    <a href=""><?php esc_html_e('Support', 'edumall-child'); ?></a>
                    <a href=""><?php esc_html_e('Work with us', 'edumall-child'); ?></a>
                    <a href=""><?php esc_html_e('About us', 'edumall-child'); ?></a>
                    <a href=""><?php esc_html_e('Most asked questions', 'edumall-child'); ?></a>
                </div>
                <div class="footer-wrapper-socials">
                    <p>
                        <?php esc_html_e('Follow us on social networks.', 'edumall-child'); ?>
                    </p>
                    <div class="footer-wrapper-socials-icons">
                        <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/instagram-footer.png" ?>" alt="">
                        <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/linkedin.png" ?>" alt="">
                    </div>
                </div>
                <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=489673&Code=ZR4JWWqIanqVHlQnUSlmLyHvVjwMLBl3'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=489673&Code=ZR4JWWqIanqVHlQnUSlmLyHvVjwMLBl3' alt='' style='cursor:pointer' code='ZR4JWWqIanqVHlQnUSlmLyHvVjwMLBl3'></a>
                <div class="footer-wrapper-privacy">
                    <p>
                        <?php esc_html_e('All rights of this website belong to Hanil.', 'edumall-child'); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <div class="footer-menu">
            <div class="footer-menu-items">
                <a id="Home" class="<?php echo is_front_page() ? 'active' : '' ?>" href="<?php echo site_url('/') ?>">
                    <?php if (is_front_page()) : ?>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/home-fill.svg' ?>" alt="">
                    <?php else : ?>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/Home.svg' ?>" alt="">
                    <?php endif; ?>
                    <p><?php esc_html_e('Home', 'edumall-child'); ?></p>
                </a>
                <a id="jik-pik" href="#">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/jikjik.svg' ?>" alt="">
                    <p><?php esc_html_e('Forum', 'edumall-child'); ?></p>
                </a>
                <a id="magazine" href="#">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/magazine.svg' ?>" alt="">
                    <p><?php esc_html_e('Magazine', 'edumall-child'); ?></p>
                </a>
                <?php
                $profile_url  = tutor_utils()->get_tutor_dashboard_page_permalink();
                $profile_text = apply_filters('edumall_user_profile_text', esc_html__('Profile', 'edumall-child'));
                ?>
                <a id="user" class="header-register-link <?php echo !is_user_logged_in() ? 'open-login-popup' : '' ?> <?php echo is_page('dashboard') ? 'active' : '' ?>" href="<?php echo !is_user_logged_in() ? 'javascript:void(0);' : esc_url($profile_url); ?>">
                    <?php if (is_page('dashboard')) : ?>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/user-filled.svg' ?>" alt="">
                    <?php else : ?>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/user.svg' ?>" alt="">
                    <?php endif; ?>
                    <p><?php esc_html_e('My Hanil', 'edumall-child'); ?></p>
                </a>
            </div>
        </div>
    </footer>
<?php else : ?>
    <footer class="footer">
        <section class="footer-wrapper">
            <div class="footer-wrapper-meta">
                <div class="footer-wrapper-meta-info">
                    <div class="footer-wrapper-meta-info-logo">
                        <?php
                        echo Edumall::branding_logo($reverse_scheme);
                        ?>
                        <p>
                            <?php esc_html_e('هانیل، پلتفرمی نوین و جامع برای زنان است که بستری برای ارتقای سبک زندگی، ایفای نقش‌های اجتماعی و اشتغال منعطف را فراهم می‌کند.', 'edumall-child'); ?>
                        </p>
                    </div>

                    <div class="footer-wrapper-meta-info-social">
                        <p>
                            <?php esc_html_e('ما را در شبکه‌های اجتماعی دنبال کنید.', 'edumall-child'); ?>
                        </p>
                        <div class="footer-wrapper-meta-info-social-icons">
                            <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/instagram-footer.png" ?>" alt="">
                            <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/linkedin.png" ?>" alt="">
                        </div>
                    </div>
                </div>

                <div class="footer-wrapper-meta-service">
                    <h3>
                        <?php esc_html_e('خدمات هانیل', 'edumall-child'); ?>
                    </h3>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer_1',
                            'container' => 'nav',
                            'container_class' => 'footer-wrapper-meta-access-nav',
                            'menu_class' => 'footer-wrapper-meta-access-items',
                            'fallback_cb' => false,
                        )
                    );
                    ?>
                </div>

                <div class="footer-wrapper-meta-access">
                    <h3>
                        <?php esc_html_e('دسترسی سریع', 'edumall-child'); ?>
                    </h3>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer_2',
                            'container' => 'nav',
                            'container_class' => 'footer-wrapper-meta-access-nav',
                            'menu_class' => 'footer-wrapper-meta-access-items',
                            'fallback_cb' => false,
                        )
                    );
                    ?>
                </div>

                <div class="footer-wrapper-meta-info-enamad">
                    <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=489673&Code=ZR4JWWqIanqVHlQnUSlmLyHvVjwMLBl3'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=489673&Code=ZR4JWWqIanqVHlQnUSlmLyHvVjwMLBl3' alt='' style='cursor:pointer' code='ZR4JWWqIanqVHlQnUSlmLyHvVjwMLBl3'></a>
                </div>
            </div>

            <hr>

            <div class="footer-wrapper-copyright">
                <p>
                    <?php esc_html_e('کلیه حقوق مادی و معنوی این پلتفرم متعلق به هانیل می‌باشد.', 'edumall-child'); ?>
                </p>
                <span class="footer-wrapper-copyright-year">
                    <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/copyright.svg" ?>" alt="">
                    <p>
                        <?php echo date("Y"); ?>
                    </p>
                </span>
            </div>
        </section>
    </footer>
<?php endif; ?>

<?php Edumall_THA::instance()->footer_after(); ?>

<?php
$toast_success = get_stylesheet_directory_uri() . '/assets/images/success.svg';
$toast_error = get_stylesheet_directory_uri() . '/assets/images/error.svg';
$toast_warning = get_stylesheet_directory_uri() . '/assets/images/warning.svg';
?>
<div id="toast" class="toast">
    <img src="" data-success="<?php echo $toast_success ?>" data-error="<?php echo $toast_error ?>" data-warning="<?php echo $toast_warning ?>" alt="">
    <p></p>
</div>
<?php wp_footer(); ?>

</body>

</html>