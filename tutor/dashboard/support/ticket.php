<?php
$ticket_id = sanitize_text_field($_GET['id']);
$profile_url  = apply_filters('edumall_user_profile_url', '');
?>
<div class="single-ticket">
    <div class="single-ticket-title">
        <a href="<?php echo esc_url($profile_url . 'support'); ?>">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arrow-right.png' ?>" alt="">
        </a>
        <h3><?php esc_html_e('جزئیات تیکت', 'edumall-child'); ?></h3>
    </div>

    <div class="single-ticket-messages">
        <?php
        // Display the ticket content
        $post = get_post($ticket_id); // specific post
        $the_content = apply_filters('the_content', $post->post_content);
        // Display comments (chat messages)
        $comments = get_comments(array(
            'post_id' => $ticket_id,
            'status' => 'approve',
            'order' => 'ASC'
        )); ?>

        <div class="single-ticket-messages-wrap">
            <div class="single-ticket-messages-chat user">
                <p><?php echo  $post->post_content; ?> </p>
            </div>

            <?php foreach ($comments as $comment) :
                $is_admin = user_can($comment->user_id, 'administrator'); ?>
                <?php if ($is_admin) : ?>
                    <div class="single-ticket-messages-chat admin">
                        <p><?php echo esc_html($comment->comment_content) ?></p>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo hanil 2.svg' ?>" alt="">
                    </div>
                <?php else : ?>
                    <div class="single-ticket-messages-chat user">
                        <p><?php echo esc_html($comment->comment_content) ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <?php if (is_user_logged_in()) : ?>
            <form id="single-ticket-messages-form" class="single-ticket-messages-form" method="post">
                <input type="text" id="comment" name="comment" required placeholder="سوال خود را اینجا بنویسید">
                <input type="hidden" name="comment_post_ID" value="<?php echo $ticket_id; ?>" />
                <input type="hidden" name="comment_parent" value="0" />
                <button type="submit" name="submit">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/send.svg' ?>" alt="">
                </button>
            </form>
        <?php else : ?>
            <p>لطفا وارد شوید تا بتوانید پیام ارسال کنید.</p>
        <?php endif; ?>
    </div>

</div>