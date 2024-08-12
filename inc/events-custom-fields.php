<?php
// Create a new class for FAQ fields
class EventFAQ
{
    // Define the meta key for FAQ fields
    private static $meta_key = 'events_faq';

    // Initialize the class
    public static function init()
    {
        add_action('add_meta_boxes', array(__CLASS__, 'add_events_meta_box'));
        add_action('save_post', array(__CLASS__, 'save_faq_fields'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));
    }

    // Enqueue scripts for dynamic question fields
    public static function enqueue_scripts($hook)
    {
        if ('post.php' == $hook || 'post-new.php' == $hook) {
            wp_enqueue_script('events-faq-script', get_stylesheet_directory_uri()  . '/assets/admin/js/events-faq-script.js', array('jquery'), time(), true);
            wp_enqueue_style('events-faq-style', get_stylesheet_directory_uri()  . '/assets/admin/css/events-faq-style.css');
        }
    }

    // Add meta box for FAQ fields
    public static function add_events_meta_box()
    {
        $event_post_type = 'tp_event';
        add_meta_box('events_faq_meta_box', 'Frequently Asked Questions', array(__CLASS__, 'render_meta_box'), $event_post_type, 'normal', 'high');
    }

    // Render meta box content
    public static function render_meta_box($post)
    {
        $faq_data = get_post_meta($post->ID, self::$meta_key, true);
?>
        <div class="form-table">
            <div class="faq-fields-container">
                <?php
                if ($faq_data) {
                    foreach ($faq_data as $index => $faq) {
                        self::render_question_field($index, $faq['question'], $faq['answer']);
                    }
                } else {
                    self::render_question_field(0, '', '');
                }
                ?>
            </div>
        </div>
        <button type="button" class="button button-primary" id="add-faq-field">Add Question</button>
    <?php
        wp_nonce_field('save_events_faq', 'events_faq_nonce');
    }

    // Render individual question field
    private static function render_question_field($index, $question, $answer)
    {
    ?>
        <div class="faq-fields">
            <div class="faq-field">
                <label for="faq_question_<?php echo $index; ?>">Question</label>
                <input type="text" name="faq_question[]" class="faq-question" value="<?php echo esc_attr($question); ?>" style="width: 100%;" />
            </div>
            <div class="faq-field">
                <label for="faq_answer_<?php echo $index; ?>">Answer</label>
                <textarea name="faq_answer[]" class="faq-answer" rows="4" style="width: 100%;"><?php echo esc_textarea($answer); ?></textarea>
                <button type="button" class="button button-secondary delete-faq-field">Delete Question</button>
            </div>
        </div>
    <?php
    }

    // Save FAQ fields
    public static function save_faq_fields($post_id)
    {
        if (!isset($_POST['events_faq_nonce']) || !wp_verify_nonce($_POST['events_faq_nonce'], 'save_events_faq')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ($_POST['post_type'] !== 'tp_event') {
            return;
        }

        if (isset($_POST['faq_question']) && isset($_POST['faq_answer'])) {
            $faq_data = array();

            foreach ($_POST['faq_question'] as $index => $question) {
                $faq_data[] = array(
                    'question' => sanitize_text_field($question),
                    'answer'   => sanitize_text_field($_POST['faq_answer'][$index]),
                );
            }

            update_post_meta($post_id, self::$meta_key, $faq_data);
        }
    }
}

// Separate class to handle FAQ Meta Boxes
class FAQMetaBox
{
    // Define the meta key for FAQ fields
    private static $meta_key = 'tp_events_more_details';

    // Initialize the class
    public static function init()
    {
        add_action('add_meta_boxes', array(__CLASS__, 'add_events_meta_box'));
        add_action('save_post', array(__CLASS__, 'save_details_fields'));
    }

    // Add meta box for FAQ fields
    public static function add_events_meta_box()
    {
        $event_post_type = 'tp_event';
        add_meta_box('events_details_meta_box', __('More Details about Event', 'edumall-child'), array(__CLASS__, 'render_meta_box'), $event_post_type, 'normal', 'high');
    }

    // Render meta box content
    public static function render_meta_box($post)
    {
        $details_data = get_post_meta($post->ID, self::$meta_key, true);
    ?>
        <div class="form-table">
            <div class="details-fields-container">
                <?php
                if ($details_data) {
                    self::render_question_field($details_data);
                } else {
                    self::render_question_field('');
                }
                ?>
            </div>
        </div>
    <?php
        wp_nonce_field('save_events_details', 'events_details_nonce');
    }

    // Render individual question field
    private static function render_question_field($details)
    {
    ?>
        <div class="details-fields">
            <div class="details-field">
                <label for="more_details">More Details</label>
                <textarea name="more_details" class="details-answer" rows="4" style="width: 100%;"><?php echo esc_textarea($details); ?></textarea>
            </div>
        </div>
<?php
    }

    // Save FAQ fields
    public static function save_details_fields($post_id)
    {
        if (!isset($_POST['events_details_nonce']) || !wp_verify_nonce($_POST['events_details_nonce'], 'save_events_details')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ($_POST['post_type'] !== 'tp_event') {
            return;
        }

        if (isset($_POST['more_details'])) {
            $details_data = sanitize_text_field($_POST['more_details']);

            update_post_meta($post_id, self::$meta_key, $details_data);
        }
    }
}

// Initialize both classes
EventFAQ::init();
FAQMetaBox::init();
