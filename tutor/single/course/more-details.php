<?php

use Detection\MobileDetect;

$detect = new MobileDetect();
$more_details = get_the_excerpt(get_the_ID());
?>

<div class="single-course-more-details single-course-item">
    <?php if (!$detect->isMobile()) : ?>
        <div class="single-course-desktop">
        <?php endif; ?>
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
        <?php if (!$detect->isMobile()) : ?>
        </div>
    <?php endif; ?>
</div>