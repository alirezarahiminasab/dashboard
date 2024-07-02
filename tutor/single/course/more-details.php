<?php
$more_details = get_the_excerpt(get_the_ID());
?>

<div class="more-details">
    <div class="title">
        <h4>
            <?php echo esc_html__('More details about the project', 'edumall-child') ?>
        </h4>
    </div>
    <div class="context">
        <p>
            <?php echo $more_details; ?>
        </p>
    </div>
</div>