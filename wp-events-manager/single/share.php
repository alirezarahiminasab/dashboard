<?php

/**
 * Template part for displaying event share on single page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single/share.php
 *
 * @author        ThemeMove
 * @package       Edumall/WP-Events-Manager/Template
 * @version       1.0.0
 */

defined('ABSPATH') || exit;

$twitter_url = 'https://twitter.com/share?text=';
$whatsapp_url = 'whatsapp://send?text=';
$instagram_url = 'https://www.instagram.com/';
$telegram_url = 'https://t.me/share/url?url=';
$bale_url = 'https://bale.ai/share/url?url=';
$eitaa_url = 'https://eitaa.com/share/url?url=';

?>
<div class="entry-event-share">
	<div class="header">
		<h4><?php esc_attr_e('Share event', 'edumall-child'); ?></h4>
	</div>
	<div class="share-wrap">
		<div class="share-list">
			<a class="social-icons share-button" target="_blank" aria-label="<?php esc_attr_e('Share', 'edumall-child'); ?>" href="<?php echo esc_url($twitter_url); ?>">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/Share_Android.png' ?>" alt="">
			</a>
			<a class="social-icons" target="_blank" aria-label="<?php esc_attr_e('Twitter', 'edumall-child'); ?>" href="<?php echo esc_url($twitter_url); ?>">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/twitter.png' ?>" alt="">
			</a>
			<a class="social-icons" target="_blank" aria-label="<?php esc_attr_e('Whatsapp', 'edumall-child'); ?>" href="<?php echo $whatsapp_url . get_the_permalink(); ?>">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/whatsapp.png' ?>" alt="">
			</a>
			<a class="social-icons" target="_blank" aria-label="<?php esc_attr_e('Instagram', 'edumall-child'); ?>" href="<?php echo esc_url($instagram_url); ?>">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/instagram.png' ?>" alt="">
			</a>
			<a class="social-icons" target="_blank" aria-label="<?php esc_attr_e('Telegram', 'edumall-child'); ?>" href="<?php echo esc_url($telegram_url) . get_the_permalink(); ?>">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/telegram.png' ?>" alt="">
			</a>
			<a class="social-icons" target="_blank" aria-label="<?php esc_attr_e('Bale', 'edumall-child'); ?>" href="<?php echo esc_url($bale_url) . get_the_permalink(); ?>">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/bale-black 1.png' ?>" alt="">
			</a>
			<a class="social-icons" target="_blank" aria-label="<?php esc_attr_e('Eitaa', 'edumall-child'); ?>" href="<?php echo esc_url($eitaa_url) . get_the_permalink(); ?>">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/eitaa-icon-black 1.png' ?>" alt="">
			</a>
		</div>
		<div class="copy-link">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/document-copy.png' ?>" alt="">
			<a target="_blank" aria-label="<?php esc_attr_e('Share Button', 'edumall-child'); ?>" href="#">
				<?php esc_attr_e('Copy event link', 'edumall-child'); ?>
			</a>
		</div>
	</div>
</div>