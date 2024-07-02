<?php
// Check if the 'courses_faq' meta key exists for the current post
$faq_data = get_post_meta(get_the_ID(), 'courses_faq', true);

if (!empty($faq_data)) :
?>
    <div class="course-faq-wrap">
        <div class="course-faq">
            <div class="faq-title">
                <h4>
                    <?php esc_html_e("Frequently Asked Questions", 'edumall-child') ?>
                </h4>
            </div>
            <ul class="faq-items">
                <?php foreach ($faq_data as $faq) : ?>
                    <li class="faq-item">
                        <div class="question">
                            <p>
                                <?php echo esc_html($faq['question']); ?>
                            </p>
                            <img class="arrow-up" src='<?php echo get_stylesheet_directory_uri() . "/assets/images/arrow-up.png" ?>'>
                            <img class="arrow-down" src='<?php echo get_stylesheet_directory_uri() . "/assets/images/arrow-down-black.png" ?>'>
                        </div>
                        <div class="answer">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>