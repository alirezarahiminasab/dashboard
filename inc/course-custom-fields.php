<?php
// Extend the existing 'courses' post type with FAQ fields
class CoursesFAQ
{

    // Define the meta key for FAQ fields
    private static $meta_key = array('courses_faq', 'courses_more');

    // Initialize the class
    public static function init()
    {
        add_action('add_meta_boxes', array(__CLASS__, 'add_courses_meta_box'));
        add_action('save_post', array(__CLASS__, 'save_faq_fields'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));
        add_filter('register_post_type_args', array(__CLASS__, 'add_to_graphql'), 10, 2);
    }

    // Enqueue scripts for dynamic question fields
    public static function enqueue_scripts($hook)
    {
        if ('post.php' == $hook || 'post-new.php' == $hook) {
            wp_enqueue_script('courses-faq-script', get_stylesheet_directory_uri()  . '/assets/admin/js/courses-faq-script.js', array('jquery'), time(), true);
            wp_enqueue_style('courses-faq-style', get_stylesheet_directory_uri()  . '/assets/admin/css/courses-faq-style.css');
        }
    }

    public static function add_to_graphql($args, $post_type)
    {

        if ($post_type === 'courses') {
            // Change this to the post type you are adding support for
            $args['show_in_graphql'] = true;
            $args['graphql_single_name'] = 'course';
            $args['graphql_plural_name'] = 'courses'; # Don't set, and it will default to `all${graphql_single_name}`, i.e. `allDocument`.
        }

        if ($post_type === 'tp_event') {
            // Change this to the post type you are adding support for
            $args['show_in_graphql'] = true;
            $args['graphql_single_name'] = 'event';
            $args['graphql_plural_name'] = 'events'; # Don't set, and it will default to `all${graphql_single_name}`, i.e. `allDocument`.
        }

        return $args;
    }

    // Add meta box for FAQ fields
    public static function add_courses_meta_box()
    {
        $course_post_type = tutor()->course_post_type;
        add_meta_box('courses_faq_meta_box', 'Frequently Asked Questions', array(__CLASS__, 'render_meta_box'), $course_post_type, 'normal', 'high');
        add_meta_box('courses_more_details_meta_box', 'Course More Details', array(__CLASS__, 'render_meta_box'), $course_post_type, 'normal', 'high');
    }

    // Render meta box content
    public static function render_meta_box($post)
    {
        $faq_data = get_post_meta($post->ID, self::$meta_key[0], true);
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
        wp_nonce_field('save_courses_faq', 'courses_faq_nonce');
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
        if (!isset($_POST['courses_faq_nonce']) || !wp_verify_nonce($_POST['courses_faq_nonce'], 'save_courses_faq')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ($_POST['post_type'] !== 'courses') {
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

// Initialize the class
CoursesFAQ::init();
