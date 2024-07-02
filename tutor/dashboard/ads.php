<?php

?>
<?php if (!current_user_can(tutor()->instructor_role)) :  ?>
    <div class="dashboard-ads">
        <div class="ads-container">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/become-instructor.png' ?>" alt="">
            <p><?php echo esc_html__('Become instructor banner!', 'edumall-child') ?></p>
        </div>
    </div>
<?php endif; ?>