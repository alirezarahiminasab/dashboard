<?php

/**
 * The Template for displaying author in single event page.
 *
 * new 
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined('ABSPATH') || exit();

$author_id = get_post_field('post_author', get_the_ID());
$author_first_name = get_user_meta($author_id, 'first_name');
$author_last_name = get_user_meta($author_id, 'last_name');
$author_job_title = get_user_meta($author_id, '_tutor_profile_job_title');
$author_img = edumall_get_avatar($author_id, 32);

if (empty($author_img)) {
    ob_start();
    edumall_get_avatar($author_id, 32); // Assuming this function prints the avatar
    $author_img = ob_get_clean();
}
?>

<div class="author-wrap">
    <h4 class="author-title">
        <?php echo esc_html__('Speakers', 'edumall-child') ?>
    </h4>

    <div class="author-info-wrap">
        <?php echo $author_img ?>
        <div class="author-info">
            <p class="name">
                <?php echo $author_first_name[0] . ' ' . $author_last_name[0] ?>
            </p>
            <p class="job_title">
                <?php echo $author_job_title[0] ?>
            </p>
        </div>
    </div>
</div>